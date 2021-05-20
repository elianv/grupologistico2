<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! function_exists('get_text_ocr')){
    function get_text_ocr($files) {

      $CI = & get_instance();
      $session_data   = $CI->session->userdata('logged_in');
      $ruta = '/'.$session_data['rut_usuario'] .'_'.date('s_u');
      if (!is_dir(sys_get_temp_dir().$ruta)){
          mkdir(sys_get_temp_dir().$ruta, 01777);
      }


      $i = 0;

      foreach ($files['orden_file']['tmp_name'] as $f) {

          try{
              $file_name = str_replace(' ', '_', $files['orden_file']['name'][$i]);
              //print(file_get_contents($f));

              /* PDF TEMP A JPG */
              $destino = sys_get_temp_dir() . $ruta. '/' . $file_name . '.jpg';
              $command = 'convert -append -density 800 ' . $f . '[0-2] ' . $destino;
              shell_exec($command);

              /* JPG A TEXTO */
              $origen = sys_get_temp_dir() . $ruta . '/' . $file_name . '.jpg';
              $destino = sys_get_temp_dir() . $ruta . '/' . $file_name;

              $command = 'tesseract ' . $origen . ' ' .$destino;
              shell_exec($command);

              // LEO EL TXT
              /*
              echo '<pre>';
              echo file_get_contents($destino.'.txt');
              echo '</pre>';
              */

              $f_text = fopen($destino.'.txt', 'r');
              $texto = fread($f_text, filesize($destino.'.txt'));
              fclose($f_text);

              // ELIMINO TODOS LOS ARCHIVOS EN RUTA TEMPORAL
              $command = 'rm ' . sys_get_temp_dir().$ruta . '/*.*';
              shell_exec($command);

              //SALIDA FUE OK, PASO AL SIGUIENTE
              $salida = true;

          }
          catch ( Exception $e){

              $texto = $e;
              $salida = false;

          }

          $a[$i]['nombre'] = $file_name;
          $a[$i]['status'] = $salida;
          $a[$i]['texto'] = $texto;
          $i++;

      }

      try{
          rmdir(sys_get_temp_dir().$ruta);
      } catch (Exception $ex) {

      }

      return $a;


    }
}

if ( ! function_exists('get_text_curl')){
    function get_text_curl($files){
        //error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $CI = & get_instance();
      
        $CI->load->model('utils/Web_service_model');
      
        $session_data   = $CI->session->userdata('logged_in');
        $ruta = '/'.$session_data['rut_usuario'] .'_'.date('s_u');
        if (!is_dir(sys_get_temp_dir().$ruta)){
            mkdir(sys_get_temp_dir().$ruta, 01777);
        }

        $i = 0;

        foreach ($files['orden_file']['tmp_name'] as $f) {
          
          try{
            $ch = curl_init();

            shell_exec('cp ' . $f . ' ' . $f . '.pdf');
            if (function_exists('curl_file_create')) { // php 5.5+
              $cFile = curl_file_create($f.'.pdf');
            }
            else {
              $cFile = '@' . realpath($f.'.pdf');
            }

            $postData = array(

                'File' => $cFile,
                'StoreFile' => 'true',
            );

            $ws_data = $CI->Web_service_model->get('name','convertapi');
            //print_r($ws_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL,$ws_data[0]['url'].$ws_data[0]['action']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            curl_close ($ch);

            $data = json_decode($server_output, true);

            $curl_handle=curl_init();

            if( !isset($data['Code'])){
                curl_setopt($curl_handle, CURLOPT_URL, $data['Files'][0]['Url']);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_USERAGENT, 'SCT');
                $query = curl_exec($curl_handle);
                curl_close($curl_handle);
            }
            else 
                $query = FALSE;

            $file_name = $f;
            $texto = $query;
            $salida = 1;

        }
        catch ( Exception $e){

            $texto = $e;
            $salida = false;

        }

        $a[$i]['nombre'] = $file_name;
        $a[$i]['status'] = $salida;
        $a[$i]['texto'] = $texto;
        $i++;

      }

      return $a;

    }
}

if ( !function_exists('test_txt')){
    function test_txt(){

        for ($i=0; $i<1; $i++){
            $f_text = fopen('/tmp/out.jpg.txt', 'r');
            $texto = fread($f_text, filesize('/tmp/out.jpg.txt'));

            $a[$i] = array(
                'nombre'=>'nombre',
                'status'=> true,
                'texto'=>$texto,
                );
        }

        return $a;
    }
}

if ( !function_exists('lee_texto_curl') ){
    function lee_texto_curl($textos, $cliente){
        $CI = & get_instance();    
        $CI->load->model('utils/Generica');
        $ordenes = array();
        
        $campos = $CI->Generica->SqlSelect('*', 'ocr_configuracion', array('id_cliente'=>$cliente), False);

        $datos = array();
        $i = 0;

        foreach ($textos as $tx) {
            //echo '<pre>'; print_r($tx); echo '</pre>';
            if ($tx['texto']){
                foreach($campos as $cp){
                    if ($cp['configuracion'] == 'orden'){
                        if (is_null($cp['valor_fijo']) ){

                            //ELIMINO EL CAMPO ANTERIOR A LO QUE BUSCO
                            $tx_ant = explode($cp['ant'], $tx['texto']);
                            $tx_ant[1] = trim($tx_ant[1]);
                            if (!isset($tx_ant[1]) &&  !is_null($cp['ant_2'])){
                                $tx_ant = explode($cp['ant_2'], $tx['texto']);
                            }

                            //NO ENCONTRO NADA
                            if (!isset($tx_ant[1])){
                                $busqueda[0] = 'DATO NO ENCONTRADO';
                            }
                            //SI ENCUENTRA CORTO POR EL TAG QUE SIGUE
                            else{

                                if (isset($tx_ant[1])){
                                    $busqueda = explode($cp['suc'], $tx_ant[1]);
                                        if (strlen($busqueda[0]) <= 1){
                                            $busqueda[0] = 'DATO NO ENCONTRADO';
                                        }
                                    }
                                else{
                                    $busqueda[0] = 'DATO NO ENCONTRADO';
                                }

                                if (!is_null($cp['suc_2'])){
                                    $busqueda_2 = explode($cp['suc_2'], $tx_ant[1]);

                                    if (strlen($busqueda[0]) >= 15){
                                        $busqueda = $busqueda_2;
                                    }
                                }
                            }

                            //SE BUSCA EXP REGULAR
                            if (!is_null($cp['regex']) && $busqueda[0] != 'DATO NO ENCONTRADO'){
                                preg_match($cp['regex'], $busqueda[0], $matches);
                                if (count($matches) > 0){
                                    if (!array_key_exists(0, $matches) && !is_null($cp['replace']) && !is_null($cp['regex'])){
                                        $cp['regex'] = str_replace($cp['needle'], $cp['replace'], $cp['regex']);
                                        preg_match($cp['regex'], $busqueda[0], $matches);

                                    }

                                    if($cp['regex_encontrado'] == 'CEN'){

                                        $busqueda = $matches;

                                    }
                                    else if($cp['regex_encontrado'] == 'IZQ'){

                                        $busqueda = explode(trim($matches[0]),$busqueda[0]);

                                    }
                                    else if($cp['regex_encontrado'] == 'DER'){

                                        $busqueda = explode(trim($matches[0]), $busqueda[0]);
                                        $b_aux = $busqueda;
                                        $busqueda = explode($cp['suc'], $busqueda[1]);

                                        if (!is_null($cp['suc_2'])){
                                            $busqueda_2 = explode($cp['suc_2'], $b_aux[1]);
                                            if (strlen($busqueda[0]) >= 15)
                                                $busqueda = $busqueda_2;
                                        }
                                    }

                                    //VEO SI TENGO QUE CAMBIAR EL FORMATO DEL TEXTO
                                    if( $cp['formato_tipo'] == 'date'){
                                        $formato = $cp['formato'];
                                        $time = preg_replace('/[^A-Za-z0-9\-\.\s]/', '', trim($busqueda[0]));
                                        $time = str_replace('.', '-', $time);
                                        $time = strtotime($time);
                                        $busqueda[0] = date($formato, $time);
                                    }
                                }
                                else{
                                    if( $cp['formato_tipo'] == 'date'){
                                        $time = strtotime('01-01-1999');
                                        $busqueda[0] = date('Y-m-d', $time);
                                    }
                                    else
                                        $busqueda[0] = 'DATO NO ENCONTRADO';
                                }
                            }                            

                            //LIMPIO TODO LO ENCONTRADO, MENOS LAS FECHAS
                            if( $cp['formato_tipo'] != 'date')
                                $busqueda[0] = str_replace(":", "", $busqueda[0]);
                            $busqueda[0] = trim($busqueda[0]);

                            //SE DEBE BUSCAR EL CODIGO DE LO QUE ENCONTRE O O LA ASIGNACION ES UN TEXTO PLANO
                            if($cp['buscar']){
                                $r = $CI->Generica->SqlSelect('*', $cp['busqueda_tabla'], array('UPPER('.$cp['busqueda_campo'].')'=> strtoupper(trim($busqueda[0]))), False);

                                //SI exsite lo asigno
                                if (count($r)){
                                    $result = trim($r[0][$cp['busqueda_pk']]);
                                }
                                //NO EXISTE CREO EL DATO
                                else{

                                    $ins_id = $CI->Generica->SqlInsert($cp['busqueda_tabla'], array($cp['busqueda_campo'] => strtoupper(trim($busqueda[0]))));

                                    if ($ins_id){
                                        $result = $ins_id;
                                    }
                                    else{
                                        //ERROR pensar como sacar de todo
                                    }
                                }
                            }
                            //NO REQUIERO BUSCAR, ASIGNO
                            else if (!is_null($busqueda))
                                $result = trim($busqueda[0]);

                        }
                        else if (!is_null($cp['valor_fijo']) ) {
                            $result = trim($cp['valor_fijo']);
                        }

                        //ASIGNO EL DATO A PARA GUARDAR
                        $datos[$i][$cp['configuracion']][$cp['campo_tabla']] = $result;

                    }
                    else{
                        if (!is_null($cp['valor_fijo'])) {
                            $datos[$i][$cp['configuracion']][$cp['campo_tabla']] = trim($cp['valor_fijo']);
                        }
                    }

                    if ($cp['fk']){
                        $ordenes[$datos[$i][$cp['configuracion']][$cp['campo_tabla']]] = null;
                    }
                }
            }
            else
                $datos[$i] = FALSE;
            
            $i++;
        }

        //CARGAR LOS DATOS A LAS ORDENES
        foreach ($datos as $d){
            if ($d){
                try{

                    $d['orden']['cliente_rut_cliente'] = $cliente;

                    $id_viaje = $CI->Viaje->crear_viaje($d['viaje']);
                    $d['orden']['viaje_id_viaje'] = $id_viaje;

                    $id_orden = $CI->Orden_model->insert_orden($d['orden']);
                    if (!$id_orden)
                        throw new Exception("Error al ingresar.");

                    if (isset($d['orden']['referencia_2']))
                        $ordenes['result'][$d['orden']['referencia_2']] = $id_orden;
                    else
                        $ordenes['result'][$d['orden']['referencia']] = $id_orden;


                } catch (Exception $ex) {
                    $ordenes[$d['orden']['referencia_2']] = False;
                }
            }
        }

        $data['result'] = $CI->load->view('transaccion/orden/resultado_carga', $ordenes, TRUE);
        return $data;
    }
}
        
if ( !function_exists('getTexto') ){
    function getTexto($files, $cliente, $opc){
        
        if ($opc == 'curl'){
            $textos = get_text_curl($files);
            $datos = lee_texto_curl($textos, $cliente);
        }
        
        return $datos;
        
    }
        
        
}

