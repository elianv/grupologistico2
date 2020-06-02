<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! function_exists('get_text')){
    function get_text($files) {
        
        $CI = & get_instance();
        $session_data   = $CI->session->userdata('logged_in');
        $ruta = '/'.$session_data['rut_usuario'] .'_'.date('s_u');
        mkdir(sys_get_temp_dir().$ruta, 01777) ;

        $i = 0;
        
        foreach ($files['orden_file']['tmp_name'] as $f) {
            
            try{
                $file_name = str_replace(' ', '_', $files['orden_file']['name'][$i]);

                /* PDF TEMP A JPG */
                $destino = sys_get_temp_dir() . $ruta. '/' . $file_name . '.jpg';
                $command = 'convert -append -density 800 ' . $f . ' ' . $destino;
                shell_exec($command);

                /* JPG A TEXTO */
                $origen = sys_get_temp_dir() . $ruta . '/' . $file_name . '.jpg';
                $destino = sys_get_temp_dir() . $ruta . '/' . $file_name;

                $command = 'tesseract ' . $origen . ' ' .$destino;
                shell_exec($command);

                // LEO EL TXT
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
/* COMANDO PARA CONVERTIR
 * 
 * convert -append -density 1000 ZLE_FM45A_20191210165924.pdf out.jpg
 * tesseract out-0.jpg out.txt
 * 
 * 
 * 
 */