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

                $session_data = $this->session->userdata('logged_in');
                if( !isset($_POST['id']) ){
                
                    $this->load->model('mantencion/Clientes_model');
                    $data['clientes'] = $this->Clientes_model->listar_clientes();
                    $data['tipo']     = 0;
                    $this->load->view('include/head',$session_data);
                    $this->load->view('consultas/por_cliente',$data);
                    $this->load->view('include/script');

                }
                else{

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
                            $data['tipo']     = 0;
                            
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

                            $data['clientes_'] = $this->consultas_model->ordenes_clientes($id, $desde, $hasta, '');
                        }
                        else{
                            $data['clientes_'] = $this->consultas_model->ordenes_clientes($id, '' , '' ,1);
                        }

                        if($salida == 'pantalla'){
                            $this->load->model('mantencion/Clientes_model');
                            $data['clientes'] = $this->Clientes_model->listar_clientes();
                            $data['tipo']     = 1;
                            $data['titulo']   = $this->input->post('cliente');

                            $this->load->view('include/head',$session_data);
                            $this->load->view('consultas/por_cliente',$data);
                            $this->load->view('include/script');
                        }
                        else{
                                        $this->load->library('excel');
                                        $this->excel->setActiveSheetIndex(0);
                                        $this->excel->getActiveSheet()->setTitle('Ordenes por Cliente');

                                        $this->excel->getActiveSheet()->setCellValue('A1', 'Cliente');
                                        $this->excel->getActiveSheet()->setCellValue('B1', $this->input->post('cliente'));

                                        $this->excel->getActiveSheet()->setCellValue('A2', 'N°');
                                        $this->excel->getActiveSheet()->setCellValue('B2', 'Tipo Orden');
                                        $this->excel->getActiveSheet()->setCellValue('C2', 'Estado');
                                        $this->excel->getActiveSheet()->setCellValue('D2', 'Fecha');

                                        $this->excel->getActiveSheet()->getStyle('A2:D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);                        
                                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

                                        foreach(range('A','D') as $columnID) {
                                            $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                                ->setAutoSize(true);
                                        }                           

                                        $i = 3;                        
                                        foreach ($data['clientes_'] as $orden) {

                                                    $this->excel->getActiveSheet()->setCellValue('A'.$i,$orden['id_orden']);
                                                    $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['tipo_orden']);
                                                    $this->excel->getActiveSheet()->setCellValue('C'.$i,$orden['estado']);
                                                    $fecha = new DateTime($orden['fecha']);
                                                    $this->excel->getActiveSheet()->setCellValue('D'.$i,$fecha->format('d-m-Y'));
                                                    $i++;
                                         
                                        }

                                        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                                        $filename='ordenes_cliente.xlsx'; //save our workbook as this file name
                                        header('Content-Type: application/vnd.ms-excel'); //mime type
                                        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                                        header('Cache-Control: max-age=0'); //no cache
                                                    
                                        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                                        //if you want to save it as .XLSX Excel 2007 format
                                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                                        //$objWriter->save("/temp/test1.xls");  
                                        //force user to download the Excel file without writing it to server's HD
                                        $objWriter->save('php://output');
                        }

                        
                    }
                } 
            }
            else{
                redirect('home','refresh');
            }
        }

        function por_conductor(){
            if($this->session->userdata('logged_in')){
                $session_data = $this->session->userdata('logged_in');
                if( !isset($_POST['id']) ){
                    $this->load->model('mantencion/Conductores_model');

                    $data['conductores'] = $this->Conductores_model->listar_conductores();
                    $data['tipo']        = 0;
                    $this->load->view('include/head',$session_data);
                    $this->load->view('consultas/por_conductor',$data);
                    $this->load->view('include/script'); 
                }
                else{

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
                            $data['conductores']  = $this->Conductores_model->listar_conductores();
                            $data['tipo']         = 0;
                            
                            $this->load->view('include/head',$session_data);
                            $this->load->view('consultas/por_conductor',$data);
                            $this->load->view('include/script');
                    }
                    else{
                        $id        = $this->input->post('id');
                        $salida    = $this->input->post('salida');

                        if ($time == 'fechas'){
                            $desde = $this->input->post('desde');
                            $hasta = $this->input->post('hasta');

                            $data['conductores_'] = $this->consultas_model->ordenes_conductor($id, $desde, $hasta, '');
                        }
                        else{
                            $data['conductores_'] = $this->consultas_model->ordenes_conductor($id, '' , '' ,1);
                        }

                        if($salida == 'pantalla'){
                            $this->load->model('mantencion/Conductores_model');
                            $data['titulo']       = $this->input->post('conductor');
                            $data['conductores']  = $this->Conductores_model->listar_conductores();
                            $data['tipo']         = 1;

                            $this->load->view('include/head',$session_data);
                            $this->load->view('consultas/por_conductor',$data);
                            $this->load->view('include/script');
                        }
                        else{
                                        $this->load->library('excel');
                                        $this->excel->setActiveSheetIndex(0);
                                        $this->excel->getActiveSheet()->setTitle('Ordenes por Conductor');

                                        $this->excel->getActiveSheet()->setCellValue('A1', 'Conductor');
                                        $this->excel->getActiveSheet()->setCellValue('B1', $this->input->post('conductor'));

                                        $this->excel->getActiveSheet()->setCellValue('A2', 'N°');
                                        $this->excel->getActiveSheet()->setCellValue('B2', 'Tipo Orden');
                                        $this->excel->getActiveSheet()->setCellValue('C2', 'Estado');
                                        $this->excel->getActiveSheet()->setCellValue('D2', 'Fecha');

                                        $this->excel->getActiveSheet()->getStyle('A2:D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);                        
                                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

                                        foreach(range('A','D') as $columnID) {
                                            $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                                ->setAutoSize(true);
                                        }                           

                                        $i = 3;                        
                                        foreach ($data['conductores_'] as $orden) {

                                                    $this->excel->getActiveSheet()->setCellValue('A'.$i,$orden['id_orden']);
                                                    $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['tipo_orden']);
                                                    $this->excel->getActiveSheet()->setCellValue('C'.$i,$orden['estado']);
                                                    $fecha = new DateTime($orden['fecha']);
                                                    $this->excel->getActiveSheet()->setCellValue('D'.$i,$fecha->format('d-m-Y'));
                                                    $i++;
                                         
                                        }

                                        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                                        $filename='ordenes_conductor.xlsx'; //save our workbook as this file name
                                        header('Content-Type: application/vnd.ms-excel'); //mime type
                                        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                                        header('Cache-Control: max-age=0'); //no cache
                                                    
                                        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                                        //if you want to save it as .XLSX Excel 2007 format
                                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                                        //$objWriter->save("/temp/test1.xls");  
                                        //force user to download the Excel file without writing it to server's HD
                                        $objWriter->save('php://output');                            
                        }

                        
                    }
                } 

            }
            else{
                redirec('home','refresh');
            }
        }      

        function por_proveedor(){
                $session_data = $this->session->userdata('logged_in');

                if($this->session->userdata('logged_in')){
                        $this->load->model('mantencion/Proveedores_model');
                        if( isset($_POST['id']) ){
                            
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

                                    $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
                                    $data['tipo']        = 0;
                                    $this->load->view('include/head',$session_data);
                                    $this->load->view('consultas/por_proveedor',$data);
                                    $this->load->view('include/script');
                            }
                            else{
                                $id        = $this->input->post('id');
                                $salida    = $this->input->post('salida');

                                if ($time == 'fechas'){
                                    $desde = $this->input->post('desde');
                                    $hasta = $this->input->post('hasta');

                                    $data['proveedores_'] = $this->consultas_model->ordenes_proveedor($id, $desde, $hasta, '');
                                }
                                else{
                                    $data['proveedores_'] = $this->consultas_model->ordenes_proveedor($id, '' , '' ,1);
                                }
                                
                                if($salida == 'pantalla'){
                                    
                                    $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
                                    $data['titulo']      = $this->input->post('proveedor');
                                    $data['tipo']        = 1;

                                    $this->load->view('include/head',$session_data);
                                    $this->load->view('consultas/por_proveedor',$data);
                                    $this->load->view('include/script');
                                    
                       
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

                                        $this->excel->getActiveSheet()->getStyle('A2:D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);                        
                                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(8);
                                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

                                        foreach(range('A','D') as $columnID) {
                                            $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                                ->setAutoSize(true);
                                        }                           

                                        $i = 3;                        
                                        foreach ($data['proveedores_'] as $orden) {

                                                    $this->excel->getActiveSheet()->setCellValue('A'.$i,$orden['id_orden']);
                                                    $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['tipo_orden']);
                                                    $this->excel->getActiveSheet()->setCellValue('C'.$i,$orden['estado']);
                                                    $fecha = new DateTime($orden['fecha']);
                                                    $this->excel->getActiveSheet()->setCellValue('D'.$i,$fecha->format('d-m-Y'));
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
                                        //$objWriter->save("/temp/test1.xls");  
                                        //force user to download the Excel file without writing it to server's HD
                                        $objWriter->save('php://output');
                                }
                            }
                        }
                        else{
                            
                            $this->load->model('mantencion/Proveedores_model');

                            $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
                            $data['tipo']        = 0;
                            $this->load->view('include/head',$session_data);
                            $this->load->view('consultas/por_proveedor',$data);
                            $this->load->view('include/script');                            
                        }
                }
                else{
                    redirec('home','refresh');
                }
        }  

        function master(){
            $session_data = $this->session->userdata('logged_in');

            if($this->session->userdata('logged_in')){
                $data['tipo'] = 0;
                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/master',$data);
                $this->load->view('include/script');
            }
            else{
                redirect('home','refresh');
            }
        }

        function resumen(){
            $session_data = $this->session->userdata('logged_in');

            if($this->session->userdata('logged_in')){
                $data['tipo'] = 0;
                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/resumen',$data);
                $this->load->view('include/script');
            }
            else{
                redirec('home','refresh');
            }
        }

        function generar_master(){
            $session_data = $this->session->userdata('logged_in');

            if($this->session->userdata('logged_in')){
                
                $data['tipo'] = 1;
                
                if(isset($_POST['salida'])){
                    $salida         = $this->input->post('salida');
                    $factura        = $this->input->post('factura');
                    $cliente        = $this->input->post('id-cliente');
                    $time           = $this->input->post('time');
                    $desde          = $this->input->post('desde');
                    $hasta          = $this->input->post('hasta');
                    $nave           = $this->input->post('id-nave');
                    $puerto         = $this->input->post('id-puerto');
                    $contenedor     = $this->input->post('contenedor');
                    $orden          = $this->input->post('n_orden');

                    //print_r($_POST);

                    if(isset($_POST['check_orden'])){
                        echo "sin orden";
                        if($orden == '')
                            $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                        else
                            $data['facturas'] = $this->consultas_model->facturas('', $orden, '', '', '', '', '', '');    
                    }
                    else if(isset($_POST['check_factura'])) {
                        if($factura == '')
                            $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->facturas($factura, '', '', '', '', '', '', '');    
                    }
                    else if(isset($_POST['check_cliente'])){
                        if($cliente == '')
                            $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->facturas('', '', $cliente,'', '', '', '', '');    
                    }
                    else if(isset($_POST['check_nave'])){
                        if($nave == '')
                            $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->facturas( '', '', '', $nave, '', '', '', '');       
                    }
                    else if(isset($_POST['check_puerto'])){
                        if($puerto == '')
                            $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->facturas( '', '', '', '', $puerto, '', '', '');       
                    }                    
                    else if(isset($_POST['check_contenedor'])){
                        if($contenedor == '')
                            $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->facturas( '', '', '', '', '', $contenedor, '', '');       
                    }
                    else if(isset($_POST['desde']) && isset($_POST['hasta'])){
                        if($desde == '' && $hasta == '')
                            $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->facturas( '', '', '', '', '', '', $desde, $hasta);       
                    }                                                           
                    else{
                        $data['facturas'] = $this->consultas_model->facturas('', '', '', '', '', '', '', '');
                    }

                    $i = 0;
                    $this->load->model('utils/Detalle');
                    $this->load->model('mantencion/Proveedores_model');

                    foreach ($data['facturas'] as $factura) {
                        $data['facturas'][$i]['otros_servicios'] = $this->Detalle->detalle_orden($factura['id_orden']);
                        $os                                      = $data['facturas'][$i]['otros_servicios'];
                        
                       
                        foreach ($os as $o) {
                            
                            $detalles                                        = $this->consultas_model->getServicioOrdenFacturaByIdDetalle($o['id_detalle']);
                            $data['facturas'][$i]['otros_servicios']         = $detalles;
                            
                            $j = 0;
                            foreach ($detalles as $detalle) {
                                
                                $proveedor                                                      = $this->Proveedores_model->datos_proveedor($detalle['proveedor_rut_proveedor']);
                                $detalle_os                                                     = $this->consultas_model->getDetalleByIdDetalle($detalle['detalle_id_detalle']);
                                $data['facturas'][$i]['otros_servicios'][$j]['valor_costo']     = $detalle_os[0]['valor_costo'];
                                $data['facturas'][$i]['otros_servicios'][$j]['proveedor']       = $proveedor[0]['razon_social'];

                                $j++;
                    
                            }
                            
                        }
                        $i++;
                    }


                    if($salida == 'pantalla'){
                        $this->load->view('include/head',$session_data);
                        $this->load->view('consultas/master',$data);
                        $this->load->view('include/script');
                    }
                    else{
                                $this->load->library('excel');
                                $this->excel->setActiveSheetIndex(0);
                                $this->excel->getActiveSheet()->setTitle('Master');

                                $this->excel->getActiveSheet()->setCellValue('A1', 'N°');
                                $this->excel->getActiveSheet()->setCellValue('B1', 'Cliente');
                                $this->excel->getActiveSheet()->setCellValue('C1', 'Nave');
                                $this->excel->getActiveSheet()->setCellValue('D1', 'Referencia');
                                $this->excel->getActiveSheet()->setCellValue('E1', 'Referencia 2');
                                $this->excel->getActiveSheet()->setCellValue('F1', 'Mercadería');
                                $this->excel->getActiveSheet()->setCellValue('G1', 'Contenedor');
                                $this->excel->getActiveSheet()->setCellValue('H1', 'Guias de Despacho');
                                $this->excel->getActiveSheet()->setCellValue('I1', 'Bodega');
                                $this->excel->getActiveSheet()->setCellValue('J1', 'Tramo');
                                $this->excel->getActiveSheet()->setCellValue('K1', 'Fecha Presentación');
                                $this->excel->getActiveSheet()->setCellValue('L1', 'Proveedor');
                                $this->excel->getActiveSheet()->setCellValue('M1', 'Factura Proveedor');
                                $this->excel->getActiveSheet()->setCellValue('N1', 'Precio Costo');
                                $this->excel->getActiveSheet()->setCellValue('O1', 'Factura G. Log.');
                                $this->excel->getActiveSheet()->setCellValue('P1', 'Precio Venta');
                                $this->excel->getActiveSheet()->setCellValue('Q1', 'Observación');
                                $this->excel->getActiveSheet()->setCellValue('R1', 'Margen');
                                $this->excel->getActiveSheet()->setCellValue('S1', 'Porcentaje');


                                $this->excel->getActiveSheet()->getStyle('A1:S1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);                        
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);                                
                                $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);                                
                                $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('N1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('O1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('P1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('R1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('S1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);


                                foreach(range('A','S') as $columnID) {
                                    $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                        ->setAutoSize(true);
                                }                           

                                $i = 2;                        
                                foreach ($data['facturas'] as $factura) {

                                            $this->excel->getActiveSheet()->setCellValue('A'.$i,$factura['id_orden']);
                                            $this->excel->getActiveSheet()->setCellValue('B'.$i,$factura['razon_social']);
                                            $this->excel->getActiveSheet()->setCellValue('C'.$i,$factura['nombre_nave']);
                                            $this->excel->getActiveSheet()->setCellValue('D'.$i,$factura['referencia']);
                                            $this->excel->getActiveSheet()->setCellValue('E'.$i,$factura['referencia_2']);
                                            $this->excel->getActiveSheet()->setCellValue('F'.$i,$factura['mercaderia']);
                                            $this->excel->getActiveSheet()->setCellValue('G'.$i,$factura['contenedor']);
                                            $this->excel->getActiveSheet()->setCellValue('H'.$i,$factura['guia_despacho']);
                                            $this->excel->getActiveSheet()->setCellValue('I'.$i,$factura['nombre_bodega']);
                                            $this->excel->getActiveSheet()->setCellValue('J'.$i,$factura['tramo']);
                                            $fecha = new DateTime($factura['fecha_presentacion']);
                                            $this->excel->getActiveSheet()->setCellValue('K'.$i,$fecha->format('d-m-Y'));
                                            $this->excel->getActiveSheet()->setCellValue('L'.$i,$factura['proveedor']);
                                            $this->excel->getActiveSheet()->setCellValue('M'.$i,$factura['factura_proveedor']);
                                            $this->excel->getActiveSheet()->setCellValue('N'.$i,$factura['precio_costo']);
                                            $this->excel->getActiveSheet()->setCellValue('O'.$i,$factura['factura_log']);
                                            $this->excel->getActiveSheet()->setCellValue('P'.$i,$factura['precio_venta']);
                                            $this->excel->getActiveSheet()->setCellValue('Q'.$i,$factura['observacion']);
                                            $this->excel->getActiveSheet()->setCellValue('R'.$i,$factura['margen']);
                                            $this->excel->getActiveSheet()->setCellValue('S'.$i,$factura['porcentaje']);
                                            

                                            $i++;
                                            $j = $i;
                                            foreach ($factura['otros_servicios'] as $otro_servicio) {
                                                $this->excel->getActiveSheet()->setCellValue('A'.$j,$factura['id_orden']);
                                                $fecha = new DateTime($factura['fecha_presentacion']);
                                                $this->excel->getActiveSheet()->setCellValue('K'.$j,$fecha->format('d-m-Y'));  
                                                $this->excel->getActiveSheet()->setCellValue('M'.$j,$otro_servicio['factura_numero_factura']);  
                                                $this->excel->getActiveSheet()->setCellValue('N'.$j,$otro_servicio['valor_costo']);  
                                                $this->excel->getActiveSheet()->setCellValue('O'.$j,$factura['factura_log']);                                          
                                                $j++;
                                            }
                                            $i = $j;
                                 
                                }

                                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                                $filename='master.xlsx'; //save our workbook as this file name
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
                else
                    redirect('home','refresh');
            }
            else{
                redirect('home','refresh');
            }
        }

        function generar_resumen(){
            $session_data = $this->session->userdata('logged_in');

            if($this->session->userdata('logged_in')){
                
                $data['tipo'] = 1;
                
                if(isset($_POST['salida'])){
                    $salida         = $this->input->post('salida');
                    $cliente        = $this->input->post('id-cliente');
                    $time           = $this->input->post('time');
                    $desde          = $this->input->post('desde');
                    $hasta          = $this->input->post('hasta');
                    $nave           = $this->input->post('id-nave');
                    $puerto         = $this->input->post('id-puerto');
                    $contenedor     = $this->input->post('contenedor');
                    $orden          = $this->input->post('n_orden');

                    //print_r($_POST);

                    if(isset($_POST['check_orden'])){
                        //echo "sin orden";
                        if($orden == '')
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', '', '');
                        else
                            $data['facturas'] = $this->consultas_model->ordenes_procesos($orden, '', '', '', '', '', '');    
                    }
                    else if(isset($_POST['check_cliente'])){
                        if($cliente == '')
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', $cliente,'', '', '', '', '');    
                    }
                    else if(isset($_POST['check_nave'])){
                        if($nave == '')
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', $nave, '', '', '', '');       
                    }
                    else if(isset($_POST['check_puerto'])){
                        if($puerto == '')
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', $puerto, '', '', '');       
                    }                    
                    else if(isset($_POST['check_contenedor'])){
                        if($contenedor == '')
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', $contenedor, '', '');       
                    }
                    else if(isset($_POST['desde']) && isset($_POST['hasta'])){
                        if($desde == '' && $hasta == '')
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', '', '');
                        else                        
                            $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', $desde, $hasta);       
                    }                                                           
                    else{
                        $data['facturas'] = $this->consultas_model->ordenes_procesos('', '', '', '', '', '', '');
                    }
                    
                    //print_r($data['facturas']);
                    $i = 0;
                    $this->load->model('utils/Detalle');
                    $this->load->model('mantencion/Proveedores_model');

                    foreach ($data['facturas'] as $factura) {

                        $data['facturas'][$i]['otros_servicios'] = $this->Detalle->detalle_orden($factura['id_orden']);
                        $os                                      = $data['facturas'][$i]['otros_servicios'];
                        $i++;
                    }

                    
                    if($salida == 'pantalla'){
                        $this->load->view('include/head',$session_data);
                        $this->load->view('consultas/resumen',$data);
                        $this->load->view('include/script');
                    }
                    else{
                                $this->load->library('excel');
                                $this->excel->setActiveSheetIndex(0);
                                $this->excel->getActiveSheet()->setTitle('Master');

                                $this->excel->getActiveSheet()->setCellValue('A1', 'N°');
                                $this->excel->getActiveSheet()->setCellValue('B1', 'Cliente');
                                $this->excel->getActiveSheet()->setCellValue('C1', 'Nave');
                                $this->excel->getActiveSheet()->setCellValue('D1', 'Referencia');
                                $this->excel->getActiveSheet()->setCellValue('E1', 'Referencia 2');
                                $this->excel->getActiveSheet()->setCellValue('F1', 'Mercadería');
                                $this->excel->getActiveSheet()->setCellValue('G1', 'Contenedor');
                                $this->excel->getActiveSheet()->setCellValue('H1', 'Bodega');
                                $this->excel->getActiveSheet()->setCellValue('I1', 'Tramo');
                                $this->excel->getActiveSheet()->setCellValue('J1', 'Fecha Presentación');
                                $this->excel->getActiveSheet()->setCellValue('K1', 'Proveedor');
                                $this->excel->getActiveSheet()->setCellValue('L1', 'Precio Costo');
                                $this->excel->getActiveSheet()->setCellValue('M1', 'Precio Venta');
                                $this->excel->getActiveSheet()->setCellValue('N1', 'Observación');


                                $this->excel->getActiveSheet()->getStyle('A1:N1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);                        
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);                                
                                $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);                                
                                $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
                                $this->excel->getActiveSheet()->getStyle('N1')->getFont()->setSize(8);
                                $this->excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);


                                foreach(range('A','N') as $columnID) {
                                    $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                        ->setAutoSize(true);
                                }                           

                                $i = 2;                        
                                foreach ($data['facturas'] as $factura) {

                                            $this->excel->getActiveSheet()->setCellValue('A'.$i,$factura['id_orden']);
                                            $this->excel->getActiveSheet()->setCellValue('B'.$i,$factura['razon_social']);
                                            $this->excel->getActiveSheet()->setCellValue('C'.$i,$factura['nombre_nave']);
                                            $this->excel->getActiveSheet()->setCellValue('D'.$i,$factura['referencia']);
                                            $this->excel->getActiveSheet()->setCellValue('E'.$i,$factura['referencia_2']);
                                            $this->excel->getActiveSheet()->setCellValue('F'.$i,$factura['mercaderia']);
                                            $this->excel->getActiveSheet()->setCellValue('G'.$i,$factura['contenedor']);
                                            $this->excel->getActiveSheet()->setCellValue('H'.$i,$factura['nombre_bodega']);
                                            $this->excel->getActiveSheet()->setCellValue('I'.$i,$factura['tramo']);
                                            $fecha = new DateTime($factura['fecha_presentacion']);
                                            $this->excel->getActiveSheet()->setCellValue('J'.$i,$fecha->format('d-m-Y'));
                                            $this->excel->getActiveSheet()->setCellValue('K'.$i,$factura['proveedor']);
                                            $this->excel->getActiveSheet()->setCellValue('L'.$i,$factura['precio_costo']);
                                            $this->excel->getActiveSheet()->setCellValue('M'.$i,$factura['precio_venta']);
                                            $this->excel->getActiveSheet()->setCellValue('N'.$i,$factura['observacion']);
                                            
                                            

                                            $i++;
                                            $j = $i;
                                            foreach ($factura['otros_servicios'] as $otro_servicio) {
                                                $this->excel->getActiveSheet()->setCellValue('A'.$j,$factura['id_orden']);
                                                $fecha = new DateTime($factura['fecha_presentacion']);
                                                $this->excel->getActiveSheet()->setCellValue('J'.$j,$fecha->format('d-m-Y'));  
                                                $this->excel->getActiveSheet()->setCellValue('L'.$j,$otro_servicio['valor_costo']);  
                                                $j++;
                                            }
                                            $i = $j;
                                 
                                }

                                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                                $filename='RESUMEN.xlsx'; //save our workbook as this file name
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
                else
                    redirect('home','refresh');
            }
            else{
                redirect('home','refresh');
            }
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

        function tabla_ordenes_ajax(){
            if($this->session->userdata('logged_in')){
                $this->load->model('transacciones/orden_model');
                $data['ordenes'] = $this->orden_model->listar_ordenes();
            
                $this->load->view('consultas/ajax/modal_ordenes',$data);
            }
            else
                redirect('home','refresh');            
        }

        function tabla_ordenes_proceso_ajax(){
            if($this->session->userdata('logged_in')){
                $this->load->model('transacciones/orden_model');
                $data['ordenes'] = $this->orden_model->listar_ordenes();
            
                $this->load->view('consultas/ajax/modal_ordenes_proceso',$data);
            }
            else
                redirect('home','refresh');            
        }        

        function tabla_clientes_ajax(){
            if($this->session->userdata('logged_in')){
                $this->load->model('mantencion/Clientes_model');
                $data['clientes']       = $this->Clientes_model->listar_clientes();
            
                $this->load->view('consultas/ajax/modal_clientes',$data);
            }
            else
                redirect('home','refresh');            
        }  

        function tabla_naves_ajax(){
            if($this->session->userdata('logged_in')){
                $this->load->model('mantencion/Naves_model');
                $data['naves']          = $this->Naves_model->listar_naves();
            
                $this->load->view('consultas/ajax/modal_naves',$data);
            }
            else
                redirect('home','refresh');            
        }         

        function tabla_puertos_ajax(){
            if($this->session->userdata('logged_in')){
                $this->load->model('mantencion/Puertos_model');
                $data['puertos']        = $this->Puertos_model->listar_puertos();
            
                $this->load->view('consultas/ajax/modal_puertos',$data);
            }
            else
                redirect('home','refresh');            
        }               

        function tabla_facturas_ajax(){
            if($this->session->userdata('logged_in')){
                $this->load->model('transacciones/facturacion_model');
                $data['facturas']        = $this->facturacion_model->listar_facturas();
            
                $this->load->view('consultas/ajax/modal_facturas',$data);
            }
            else
                redirect('home','refresh');              
        }

    }

?>