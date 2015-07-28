<?php

    class Facturadas extends CI_Controller{
        
        function __construct() {
            parent::__construct();
            $this->load->model('transacciones/orden_model');
            $this->load->model('consultas/consultas_model');
            date_default_timezone_set('America/Santiago');
        }
                
        function index(){
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
        
        function generar_ordenes(){
            if($this->session->userdata('logged_in')){
                $session_data = $this->session->userdata('logged_in');
                
                $estado = $this->input->post('estado_os');
                $salida = $this->input->post('salida');
                $time   = $this->input->post('time');

                
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
                        $this->excel->getActiveSheet()->setCellValue('D1', 'Referencia');
                        $this->excel->getActiveSheet()->setCellValue('E1', 'Booking');
                        $this->excel->getActiveSheet()->setCellValue('F1', 'Número');
                        $this->excel->getActiveSheet()->setCellValue('G1', 'Peso');
                        $this->excel->getActiveSheet()->setCellValue('H1', 'Set Point');
                        $this->excel->getActiveSheet()->setCellValue('I1', 'Fecha Presentación');
                        $this->excel->getActiveSheet()->setCellValue('J1', 'Ref. 2');
                        $this->excel->getActiveSheet()->setCellValue('K1', 'Mercadería');
                        $this->excel->getActiveSheet()->setCellValue('L1', 'Lugar Retiro');
                        $this->excel->getActiveSheet()->setCellValue('M1', 'Puerto Destino');
                        $this->excel->getActiveSheet()->setCellValue('N1', 'Aduana');
                        $this->excel->getActiveSheet()->setCellValue('O1', 'Bodega');
                        $this->excel->getActiveSheet()->setCellValue('P1', 'Rut Cliente');
                        $this->excel->getActiveSheet()->setCellValue('Q1', 'Razón Social');
                        $this->excel->getActiveSheet()->setCellValue('R1', 'Deposito');
                        $this->excel->getActiveSheet()->setCellValue('S1', 'Nombre Nave');
                        $this->excel->getActiveSheet()->setCellValue('T1', 'Rut Proveedor');
                        $this->excel->getActiveSheet()->setCellValue('U1', 'Proveedor');
                        $this->excel->getActiveSheet()->setCellValue('V1', 'Giro');
                        $this->excel->getActiveSheet()->setCellValue('W1', 'Puerto');
                        $this->excel->getActiveSheet()->setCellValue('X1', 'Carga');
                        $this->excel->getActiveSheet()->setCellValue('Y1', 'Tramo');
                        $this->excel->getActiveSheet()->setCellValue('Z1', 'Naviera');

                        $this->excel->getActiveSheet()->getStyle('A1:Z1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);                        
                        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(8);
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
                        $this->excel->getActiveSheet()->getStyle('T1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('T1')->getFont()->setBold(true); 
                        $this->excel->getActiveSheet()->getStyle('U1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('U1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('V1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('V1')->getFont()->setBold(true);                        
                        $this->excel->getActiveSheet()->getStyle('W1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('W1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('X1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('X1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('Y1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('Y1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('Z1')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('Z1')->getFont()->setBold(true); 

                        foreach(range('A','Z') as $columnID) {
                            $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                ->setAutoSize(true);
                        }                           
                            
                        $i = 2;                        
                        foreach ($data['ordenes'] as $orden) {

                                    $this->excel->getActiveSheet()->setCellValue('A'.$i,$orden['id_orden']);
                                    $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['tipo_orden']);
                                    $fecha = new DateTime($orden['fecha']);
                                    $this->excel->getActiveSheet()->setCellValue('C'.$i,$fecha->format('d-m-Y'));
                                    $this->excel->getActiveSheet()->setCellValue('D'.$i,$orden['referencia']);
                                    $this->excel->getActiveSheet()->setCellValue('E'.$i,$orden['booking']);
                                    $this->excel->getActiveSheet()->setCellValue('F'.$i,$orden['numero']);
                                    $this->excel->getActiveSheet()->setCellValue('G'.$i,$orden['peso']);
                                    $this->excel->getActiveSheet()->setCellValue('H'.$i,$orden['set_point']);
                                    $this->excel->getActiveSheet()->setCellValue('I'.$i,$orden['fecha_presentacion']);
                                    $this->excel->getActiveSheet()->setCellValue('J'.$i,$orden['referencia_2']);
                                    $this->excel->getActiveSheet()->setCellValue('K'.$i,$orden['mercaderia']);
                                    $this->excel->getActiveSheet()->setCellValue('L'.$i,$orden['lugar_retiro']);
                                    $this->excel->getActiveSheet()->setCellValue('M'.$i,$orden['nombre_puerto_destino']);
                                    $this->excel->getActiveSheet()->setCellValue('N'.$i,$orden['nombre_aduana']);
                                    $this->excel->getActiveSheet()->setCellValue('O'.$i,$orden['nombre_bodega']);
                                    $this->excel->getActiveSheet()->setCellValue('P'.$i,$orden['rut_cliente']);
                                    $this->excel->getActiveSheet()->setCellValue('Q'.$i,$orden['razon_social']);
                                    $this->excel->getActiveSheet()->setCellValue('R'.$i,$orden['deposito']);
                                    $this->excel->getActiveSheet()->setCellValue('S'.$i,$orden['nombre_nave']);
                                    $this->excel->getActiveSheet()->setCellValue('T'.$i,$orden['rut_proveedor']);
                                    $this->excel->getActiveSheet()->setCellValue('U'.$i,$orden['rs_proveedor']);
                                    $this->excel->getActiveSheet()->setCellValue('V'.$i,$orden['rs_giro']);
                                    $this->excel->getActiveSheet()->setCellValue('W'.$i,$orden['prto_nombre']);
                                    $this->excel->getActiveSheet()->setCellValue('X'.$i,$orden['carga']);
                                    $this->excel->getActiveSheet()->setCellValue('Y'.$i,$orden['descripcion']);
                                    $this->excel->getActiveSheet()->setCellValue('Z'.$i,$orden['naviera']);
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
            else{
                redirect('home','refresh');
            }
        }
        
    }

?>