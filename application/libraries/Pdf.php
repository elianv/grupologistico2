<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct($dato,$nombre) {
            $this->Numero = $dato;
            $this->Nombre = $nombre;
            parent::__construct();
        }
		
        // El encabezado del PDF
        
        public function Header(){
            
            //global $orden;
            $this->Image('img/logo.png',10,8,45);
            $this->SetFont('Arial','B',16);
            $this->Cell(30);
            $this->Cell(120,10,'Orden de Servicio '.  utf8_decode(N°).''.$this->Numero,0,0,'C');
            $this->Ln('5');
            $this->SetFont('Arial','B',8);
            $this->Cell(30);
           // $this->Cell(120,10,'INFORMACION DE CONTACTO',0,0,'C');
            $this->Ln(20);
       }
       // El pie del pdf
       public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Arial','I',8);
           $this->Cell(0,6,$this->Nombre,0,1,'C');
           $this->Cell(0,6,'Grupo Logistico GLC Chile y Cia Ltda.',0,0,'C');
      }
	
    }
?>;