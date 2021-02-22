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
                else { //
                  $cFile = '@' . realpath($f.'.pdf');
                }

                $postData = array(

                    'File' => $cFile,
                    'StoreFile' => 'true',
                );

                //curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL,"https://v2.convertapi.com/convert/pdf/to/txt?Secret=82WC01CaY1kkxI71");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $server_output = curl_exec($ch);
                curl_close ($ch);

                $data = json_decode($server_output, true);

                $curl_handle=curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $data['Files'][0]['Url']);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_USERAGENT, 'SCT');
                $query = curl_exec($curl_handle);
                curl_close($curl_handle);

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

        try{
            //rmdir(sys_get_temp_dir().$ruta);
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
