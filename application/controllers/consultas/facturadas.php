<?php

    class Facturadas extends CI_Controller{
        
        function __construct() {
            parent::__construct();
            $this->load->model('transacciones/orden_model');
            $this->load->model('consultas/consultas_model');
            

            date_default_timezone_set('America/Santiago');
        }
                
        function por_estado(){
            if($this->session->userdata('logged_in')){
                $session_data = $this->session->userdata('logged_in');

                $data['estados'] = $this->orden_model->estados_orden();
                $data['salida']  = 0;
                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/facturadas',$data);
                $this->load->view('include/script');
                $this->load->view('include/calendario');
                       
            }
            else{
                redirect('home','refresh');
            }
        }

        function por_cliente(){
            if($this->session->userdata('logged_in')){
                $this->load->model('mantencion/Clientes_model');
                
                $session_data = $this->session->userdata('logged_in');
                $data['clientes'] = $this->Clientes_model->listar_clientes();

                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/por_cliente',$data);
                $this->load->view('include/script');
                       
            }
            else{
                redirect('home','refresh');
            }
        }

        function por_conductor(){
                $session_data = $this->session->userdata('logged_in');
                $this->load->model('mantencion/Conductores_model');
                $data['conductores'] = $this->Conductores_model->listar_conductores();
                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/por_conductor',$data);
                $this->load->view('include/script');            
        }      

        function por_proveedor(){
                $session_data = $this->session->userdata('logged_in');
                $this->load->model('mantencion/Proveedores_model');

                $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/por_proveedor',$data);
                $this->load->view('include/script');
        }  

        function master(){
                $session_data = $this->session->userdata('logged_in');

                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/master');
                $this->load->view('include/script');
        }
        
        function generar_ordenes(){
            if($this->session->userdata('logged_in')){
                $time   = $this->input->post('time');

                $this->load->library('form_validation');
                $this->form_validation->set_rules('salida', 'Formato de Salida','trim|xss_clean|required');
                $this->form_validation->set_rules('time', 'Periodo de Tiempo','trim|xss_clean|required');
                $this->form_validation->set_rules('estado_os', 'Estado Factura','trim|xss_clean|required');

                if($time == 'fechas'){
                $this->form_validation->set_rules('desde', 'Fecha de Inicio','trim|xss_clean|required');
                $this->form_validation->set_rules('hasta', 'Fecha de Fin','trim|xss_clean|required');                    
                }

                $session_data = $this->session->userdata('logged_in');

                if($this->form_validation->run() == FALSE){ 
                        $data['estados'] = $this->orden_model->estados_orden();
                        $data['salida']  = 0;
                        $this->load->view('include/head',$session_data);
                        $this->load->view('consultas/facturadas',$data);
                        $this->load->view('include/script');
                        $this->load->view('include/calendario');                    
                }
                else{
                        
                        $estado = $this->input->post('estado_os');
                        $salida = $this->input->post('salida');
                        
                        if($time == 'fechas'){
                            
                            $desde           = str_replace("/", "-", $this->input->post('desde'));
                            $hasta           = str_replace("/", "-", $this->input->post('hasta'));
                            $desde           = new DateTime($desde);
                            $hasta           = new DateTime($hasta);
                            $data['ordenes'] = $this->consultas_model->generar_ordenes($estado, $desde->format('Y-m-d'), $hasta->format('Y-m-d'), '');
                        }
                        else{
                            
                            $data['ordenes'] = $this->consultas_model->generar_ordenes($estado, '' , '' , 1);
                        }
                        
                        if($salida == 'pantalla'){

                            $data['salida']  = 1;
                            $data['estados'] = $this->orden_model->estados_orden();
                            $this->load->view('include/head',$session_data);
                            $this->load->view('consultas/facturadas',$data);
                            $this->load->view('include/script');
                            $this->load->view('include/calendario');
                          
                        }
                        else{
                                $this->load->library('excel');
                                $this->excel->setActiveSheetIndex(0);
                                $this->excel->getActiveSheet()->setTitle('Ordenes');

                                $this->excel->getActiveSheet()->setCellValue('A1', 'N°');
                                $this->excel->getActiveSheet()->setCellValue('B1', 'Tipo Orden');
                                $this->excel->getActiveSheet()->setCellValue('C1', 'Fecha');

                                $this->excel->getActiveSheet()->getStyle('A1:C1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);                        
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

                                foreach(range('A','C') as $columnID) {
                                    $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                        ->setAutoSize(true);
                                }                           

                                $i = 2;                        
                                foreach ($data['ordenes'] as $orden) {

                                            $this->excel->getActiveSheet()->setCellValue('A'.$i,$orden['id_orden']);
                                            $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['tipo_orden']);
                                            $fecha = new DateTime($orden['fecha']);
                                            $this->excel->getActiveSheet()->setCellValue('C'.$i,$fecha->format('d-m-Y'));
                                            $i++;
                                 
                                }

                                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                                $filename='ordenes.xlsx'; //save our workbook as this file name
                                header('Content-Type: application/vnd.ms-excel'); //mime type
                                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                                header('Cache-Control: max-age=0'); //no cache
                                            
                                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                                //if you want to save it as .XLSX Excel 2007 format
                                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
                                //force user to download the Excel file without writing it to server's HD
                                $objWriter->save('php://output');
                        }
                }


                     
            }
            else{
                redirect('home','refresh');
            }
        }

        function generar_ordenes_por_proveedor(){
            if($this->session->userdata('logged_in')){
                if( isset($_POST['id']) ){
                    $session_data = $this->session->userdata('logged_in');

                    $time   = $this->input->post('time');

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('salida', 'Formato de Salida','trim|xss_clean|required');
                    $this->form_validation->set_rules('time', 'Periodo de Tiempo','trim|xss_clean|required');
                    $this->form_validation->set_rules('id', 'Proveedor','trim|xss_clean|required|callback_check_proveedor');

                    if($time == 'fechas'){
                        $this->form_validation->set_rules('desde', 'Fecha de Inicio','trim|xss_clean|required');
                        $this->form_validation->set_rules('hasta', 'Fecha de Fin','trim|xss_clean|required');                    
                    }

                    if($this->form_validation->run() == FALSE){      
                            $this->load->view('include/head',$session_data);
                            $this->load->model('mantencion/Proveedores_model');
                            $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
                            $this->load->view('consultas/por_proveedor',$data);
                            $this->load->view('include/script');
                    }
                    else{
                        $id        = $this->input->post('id');
                        $salida    = $this->input->post('salida');

                        if ($time == 'fechas'){
                            $desde = $this->input->post('desde');
                            $hasta = $this->input->post('hasta');

                            $proveedores['proveedores'] = $this->consultas_model->ordenes_proveedor($id, $desde, $hasta, '');
                        }
                        else{
                            $proveedores['proveedores'] = $this->consultas_model->ordenes_proveedor($id, '' , '' ,1);
                        }
                        
                        if($salida == 'pantalla'){
                            $theHTMLResponse['html'] = $this->load->view('consultas/ajax/ordenes_proveedor_pantalla',$proveedores, true);
                            $theHTMLResponse['tipo'] = 1;
                            $this->output->set_content_type('application/json');
                            $this->output->set_output(json_encode($theHTMLResponse));                         
                        }
                        if($salida == 'excel'){
                                $this->load->library('excel');
                                $this->excel->setActiveSheetIndex(0);
                                $this->excel->getActiveSheet()->setTitle('Ordenes por Proveedor');

                                $this->excel->getActiveSheet()->setCellValue('A1', 'Proveedor');
                                $this->excel->getActiveSheet()->setCellValue('B1', $this->input->post('proveedor'));

                                $this->excel->getActiveSheet()->setCellValue('A2', 'N°');
                                $this->excel->getActiveSheet()->setCellValue('B2', 'Tipo Orden');
                                $this->excel->getActiveSheet()->setCellValue('C2', 'Estado');
                                $this->excel->getActiveSheet()->setCellValue('D2', 'Fecha');

                                $this->excel->getActiveSheet()->getStyle('A1:C1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);                        
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

                                foreach(range('A','C') as $columnID) {
                                    $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                        ->setAutoSize(true);
                                }                           

                                $i = 2;                        
                                foreach ($proveedores['proveedores'] as $orden) {

                                            $this->excel->getActiveSheet()->setCellValue('A'.$i,$orden['id_orden']);
                                            $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['tipo_orden']);
                                            $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['estado']);
                                            $fecha = new DateTime($orden['fecha']);
                                            $this->excel->getActiveSheet()->setCellValue('C'.$i,$fecha->format('d-m-Y'));
                                            $i++;
                                 
                                }

                                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                                $filename='ordenes_proveedor.xlsx'; //save our workbook as this file name
                                header('Content-Type: application/vnd.ms-excel'); //mime type
                                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                                header('Cache-Control: max-age=0'); //no cache
                                            
                                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                                //if you want to save it as .XLSX Excel 2007 format
                                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
                                //force user to download the Excel file without writing it to server's HD
                                $objWriter->save('php://output');
                        }
                        
                        
                    }
                }
                else
                    redirect('main','refresh');

            }
            else
                redirec('home','refresh');
        }

        function generar_ordenes_por_cliente(){
            if($this->session->userdata('logged_in')){
                if( isset($_POST['id']) ){
                    $session_data = $this->session->userdata('logged_in');

                    $time   = $this->input->post('time');

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('salida', 'Formato de Salida','trim|xss_clean|required');
                    $this->form_validation->set_rules('time', 'Periodo de Tiempo','trim|xss_clean|required');
                    $this->form_validation->set_rules('id', 'Cliente','trim|xss_clean|required|callback_check_proveedor');

                    if($time == 'fechas'){
                        $this->form_validation->set_rules('desde', 'Fecha de Inicio','trim|xss_clean|required');
                        $this->form_validation->set_rules('hasta', 'Fecha de Fin','trim|xss_clean|required');                    
                    }

                    if($this->form_validation->run() == FALSE){      
                            $this->load->model('mantencion/Clientes_model');
                            $data['clientes'] = $this->Clientes_model->listar_clientes();
                            $this->load->view('include/head',$session_data);
                            $this->load->view('consultas/por_cliente',$data);
                            $this->load->view('include/script');
                    }
                    else{
                        $id        = $this->input->post('id');
                        $salida    = $this->input->post('salida');

                        if ($time == 'fechas'){
                            $desde = $this->input->post('desde');
                            $hasta = $this->input->post('hasta');

                            $data['clientes'] = $this->consultas_model->ordenes_clientes($id, $desde, $hasta, '');
                        }
                        else{
                            $data['clientes'] = $this->consultas_model->ordenes_clientes($id, '' , '' ,1);
                        }
                        
                        $theHTMLResponse['html'] = $this->load->view('consultas/ajax/ordenes_clientes_pantalla',$data, true);
                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode($theHTMLResponse));                         
                        
                    }
                }
                else
                    redirect('main','refresh');

            }
            else
                redirec('home','refresh');
        }

        function generar_ordenes_por_conductor(){
            if($this->session->userdata('logged_in')){
                if( isset($_POST['id']) ){
                    $session_data = $this->session->userdata('logged_in');

                    $time   = $this->input->post('time');

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('salida', 'Formato de Salida','trim|xss_clean|required');
                    $this->form_validation->set_rules('time', 'Periodo de Tiempo','trim|xss_clean|required');
                    $this->form_validation->set_rules('id', 'Conductor','trim|xss_clean|required|callback_check_proveedor');

                    if($time == 'fechas'){
                        $this->form_validation->set_rules('desde', 'Fecha de Inicio','trim|xss_clean|required');
                        $this->form_validation->set_rules('hasta', 'Fecha de Fin','trim|xss_clean|required');                    
                    }

                    if($this->form_validation->run() == FALSE){      
                            $this->load->model('mantencion/Conductores_model');
                            $data['conductores'] = $this->Conductores_model->listar_conductores();
                            $this->load->view('include/head',$session_data);
                            $this->load->view('consultas/por_cliente',$data);
                            $this->load->view('include/script');
                    }
                    else{
                        $id        = $this->input->post('id');
                        $salida    = $this->input->post('salida');

                        if ($time == 'fechas'){
                            $desde = $this->input->post('desde');
                            $hasta = $this->input->post('hasta');

                            $data['conductores'] = $this->consultas_model->ordenes_conductor($id, $desde, $hasta, '');
                        }
                        else{
                            $data['conductores'] = $this->consultas_model->ordenes_conductor($id, '' , '' ,1);
                        }
                        
                        $theHTMLResponse['html'] = $this->load->view('consultas/ajax/ordenes_conductor_pantalla',$data, true);
                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode($theHTMLResponse));                         
                        
                    }
                }
                else
                    redirect('main','refresh');

            }
            else
                redirec('home','refresh');
        }        
        
    }

?>