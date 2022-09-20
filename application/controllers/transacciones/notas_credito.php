<?php
class notas_credito extends CI_Controller{

    public $dtNota;

    function __construct() {
        
        parent::__construct();
        $this->load->library('Data_tables');
        $this->dtNota = new Data_tables();
        $this->load->model('transacciones/notas_credito_model');
        error_reporting(0);
    }

    function index(){
        	
        if($this->session->userdata('logged_in')){    
            $session_data = $this->session->userdata('logged_in');
            $data['result'] = False;

            if ($this->input->server('REQUEST_METHOD') === 'POST'){
                $fechas = $this->input->post('fechas');
                $desde = $this->input->post('desde');
                $hasta = $this->input->post('hasta');
                $output = $this->input->post('salida');

                $this->load->library('form_validation');
                $this->form_validation->set_rules('salida', 'Formato salida','trim|required|xss_clean');
                if ($fechas == 'rango'){
                    $this->form_validation->set_rules('desde', 'Fecha desde','trim|required|xss_clean');
                    $this->form_validation->set_rules('hasta', 'Fecha hasta','trim|required|xss_clean');
                }

                if($this->form_validation->run() == TRUE){
                                        
                    if ($output == 'excel'){
                        $out = $this->informe_nc($desde, $hasta);
                    }
                    elseif ($output == 'pantalla'){
                        if ($fechas = 'rango'){
                            $ajax_url = 'notas_credito/listar_ajax/'.$desde.'/'.$hasta;
                        }
                        else
                            $ajax_url = 'notas_credito/listar_ajax';
    
                        $params = array('titulos'   => array('Numero','Rut Cliente','Razon social','Monto','Factura', 'OS', 'Codigo sistema','Fecha'),
                                        'titulo'    => 'Notas de crédito',
                                        'columns'   => array('Numero','Rut Cliente','Razon social','Monto','Factura','OS', 'Codigo sistema','Fecha'),
                                        'clase'     => 'ncredito',
                                        'ajax'      => $ajax_url,
                                        'botones'   => null,
                                        'vista'     => 'tabla',
                                        );
            
                        $this->dtNota->setData($params);
            
                        $data['notas'] = $this->dtNota->render();
                        $data['result'] = True;
                    }
                }
            }

            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/notas_credito', $data);
            $this->load->view('include/script');
           
        }
        else{
            redirect('home','refresh');
        }
    }

    function informe_nc($desde=NULL, $hasta=NULL){
        if($this->session->userdata('logged_in')){    
            
            if (!is_null($desde) && !is_null($hasta) && $hasta != "" && $desde != ""){
                $datos = $this->notas_credito_model->GetNotas($desde, $hasta);
            }
            else
                $datos = $this->notas_credito_model->GetNotas();
            
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Notas de credito');

            $this->excel->getActiveSheet()->setCellValue('A1', 'N°');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Rut cliente');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Razón social');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Monto');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Factura');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Código sistema');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Fecha');
            
            $this->excel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

            $i = 2;
            foreach($datos as $d){
                $this->excel->getActiveSheet()->setCellValue('A'.$i, $d['numero_nota']);
                $this->excel->getActiveSheet()->setCellValue('B'.$i, $d['rut_cliente']);
                $this->excel->getActiveSheet()->setCellValue('C'.$i, $d['razon_social']);
                $this->excel->getActiveSheet()->setCellValue('D'.$i, $d['monto']);
                $this->excel->getActiveSheet()->setCellValue('E'.$i, $d['numero_factura']);
                $this->excel->getActiveSheet()->setCellValue('F'.$i, $d['codigo_sistema']);

                $fecha = new DateTime($d['fecha']);
                $this->excel->getActiveSheet()->setCellValue('G'.$i, $fecha->format('d-m-Y'));
                $i++;         
            }

            foreach(range('A','G') as $columnID) {
                $this->excel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
            $filename='notas_credito.xlsx'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //xaches

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
            $objWriter->save('php://output');
        }
        else 
            redirect('home','refresh');
    }

    function listar_ajax($desde=NULL,$hasta=NULL ){

        if($this->session->userdata('logged_in')){
            $data_post = $_POST;

            if (!is_null($desde)  && !is_null($hasta)){
                $opc['desde'] = $desde;
                $opc['hasta'] = $hasta;
                $opc['operador'] = ' AND ';
                $datos = $this->dtNota->dTables_ajax('transacciones','notas_credito_model','getData',$data_post, $opc);
            }
            else
                $datos = $this->dtNota->dTables_ajax('transacciones','notas_credito_model','getData',$data_post);
            
            echo json_encode($datos);
        }
        else
            echo json_encode(array('response'=>'error'));
    }
}
