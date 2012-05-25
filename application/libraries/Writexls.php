<?php

#####################################################################################
#																					#
#	Nombre: WriteXLS																#
#	Funcionalidad: Crea archivos XLS												#
#	Archivos dependientes: PHPExcel.php, IOFactory.php								#
#	Creado por: Jesus Cortes, Marcos Cotonieto										#
#	Fecha: 26 de marzo de 2010														#
#	Modificado por:																	#
#	Fecha:																			#
#	Motivo:																			#
#	Licencia: GNU - GPL																#
#																					#
#####################################################################################

/** PHPExcel */
require_once 'PHPExcel.php';

/** PHPExcel_IOFactory */
require_once 'PHPExcel/IOFactory.php';

class Writexls
{
	var $objPHPExcel;					//propiedad que contendrá al objeto PHPExcel
	var $nombreArchivo = 'Archivo.xls';					//propiedad que almacena el nombre del archivo a guardar
    var $propietario = 'CinemaOpen.com';
	var $objWriter;						//propiedad que almacena el objeto que contiene la impresion del archivo xls
	var $letraDefault='Arial';		//propiedad que almacena la letra predefinida
	var $tamanoDefault=10;				//propiedad que almacena el tamano predefinido
	var $colorLetraDefault='000000';	//propiedad que almacena el color de la letra predefinido
	var $colorBordeDefault='D6D7E7';	//propiedad que almacena el color del borde predefinido
	var $colorRellenoDefault='FFFFFF';	//propiedad que almacena el color del fondo predefinido


	/* 	Constructor, crea el objeto PHPExcel y le asigna parametros iniciales.
		Parametros:
		- $name: Nombre del archivo
		- $creador: Creador del archivo
	*/
	function __construct($props = array())
	{
            if (count($props) > 0)
            {
                    $this->initialize($props);
            }
            $this->objPHPExcel = new PHPExcel();
            $this->objPHPExcel->getProperties()->setCreator('CinemaOpen.com')
                                                                     ->setLastModifiedBy('CinemaOpen.com')
                                                                     ->setTitle($this->nombreArchivo)
                                                                     ->setSubject("")
                                                                     ->setDescription("")
                                                                     ->setKeywords("")
                                                                     ->setCategory("");
            $this->objPHPExcel->getDefaultStyle()->getFont()->setName($this->letraDefault);
            $this->objPHPExcel->getDefaultStyle()->getFont()->setSize($this->tamanoDefault);
	}

        /*
         *
         */

        function initialize($props = array())
	{
            /*
             * Convert array elements into class variables
             */
            if (count($props) > 0)
            {
                    foreach ($props as $key => $val)
                    {
                            $this->$key = $val;
                    }
            }
        }


	/* 	Metodo que crea una nueva hoja
		Parametros: ninguno
	*/
	function NuevaHoja()
	{
		$this->objPHPExcel->createSheet();
	}


	/* 	Metodo que cambia la hoja activa
		Parametros:
		- $hoja: el numero de la hoja a activar, de izquierda a derecha y empezando en 0
	*/
	function ActivarHoja($hoja)
	{
		$this->objPHPExcel->setActiveSheetIndex($hoja);
	}


	/* 	Metodo que cambia el tipo de letra
		Parametros:
		- $letra: El nombre de la letra a utilizar
	*/
	function CambiarTipoLetra($letra)
	{
		$this->letraDefault=$letra;
		$this->objPHPExcel->getDefaultStyle()->getFont()->setName($this->letraDefault);
	}


	/* 	Metodo que cambia el tamano de la letra
		Parametros:
		- $tamano: El tamano de la letra a utilizar
	*/
	function CambiarTamanoLetra($tamano)
	{
		$this->tamanoDefault=$tamano;
		$this->objPHPExcel->getDefaultStyle()->getFont()->setSize($this->tamanoDefault);
	}


	/* 	Metodo que pone negritas en una celda
		Parametros:
		- $celda: la celda a cambiar de formato
		- $opcion: true=negrita, false=no negrita
	*/
	function CambiarLetraNegrita($celda, $opcion)
	{
		$this->objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setBold($opcion);
	}


	/* 	Metodo que renombra la hoja activa
		Parametros:
		- $nombre: nombre deseado a asignar a la hoja activa
	*/
	function RenombrarHoja($nombre)
	{
		$this->objPHPExcel->getActiveSheet()->setTitle($nombre);
	}


	/*	Metodo que ajusta automaticamente el ancho de una columna
		Parametros:
		- $columna: la columna a la que se le ajustara el ancho
	*/
	function AutoAjustarAncho($columna)
	{
		$this->objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);
	}



	/* 	Metodo que modifica el ancho de una columna
		Parametros:
		- $columna: la columna a la que se le cambiara el ancho (A, B, C, ....)
		- $Ancho: el valor del ancho a utilizar
	*/
	function CambiarAnchoColumna($columna, $ancho)
	{
		$this->objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($ancho);
	}


	/* 	Metodo que cambia el formato de una celda a fecha
		Parametros:
		- $celda: la celda a modificar (p.e. 'A1')
	*/
	function CambiarFormatoCeldaFecha($celda)
	{
		$this->objPHPExcel->getActiveSheet()->getStyle($celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
	}


	/* 	Metodo que escribe en el contenido de una celda
		Parametros:
		- $celda: La celda a escribir
		- $contenido: el contenido a escribir en la celda
	*/
	function EscribirCelda($celda, $contenido)
	{
		$this->objPHPExcel->getActiveSheet()->setCellValue($celda, $contenido);
	}


	/*	Metodo que combina celdas
		Parametros:
		- $celdaInicio: Celda inicial para realizar la combinacion
		- $celdaFin: Celda final para realizar la combinacion
	*/
	function CombinarCeldas($celdaInicio, $celdaFin)
	{
		$cellRange = $celdaInicio.":".$celdaFin;
		$this->objPHPExcel->getActiveSheet()->mergeCells($cellRange);
	}


	/* 	Metodo que centra el text de una celda
		Parametros:
		- $celda: La celda o rango al que se va a centrar
	*/
	function AlinearCeldaCentro($celda)
	{
		$this->objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}


	/* 	Metodo que alinea el text de una celda a la derecha
		Parametros:
		- $celda: La celda o rango al que se va a centrar
	*/
	function AlinearCeldaDerecha($celda)
	{
		$this->objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	}


	/* 	Metodo que alinea el text de una celda a la izquierda
		Parametros:
		- $celda: La celda o rango al que se va a centrar
	*/
	function AlinearCeldaIzquierda($celda)
	{
		$this->objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	}


	/*	Metodo para cambiar el formato de una celda
		Parametros:
		- $celda: La celda o rango a modificar ('A1', 'A1:D1')
		- $letra: el nombre del tipo de letra a modificar ('Arial', 'Century')
		- $tamano: el tamaño de la letra (10, 15)
		- $colorLetra: el color de la letra ('FFFFFF')
		- $negritas: si se desea presentar la letra en negritas (true, false)
		- $colorBordeArriba: el color hexadecimal del borde superior ('000000')
		- $colorBordeAbajo: el color hexadecimal del borde inferior ('000000')
		- $colorBordeIzquierda: el color hexadecimal del borde lateral izquierdo ('000000')
		- $colorBordeDerecha: el color hexadecimal del borde lateral derecho ('000000')
		- $colorRelleno: el color hexadecimal del relleno de la celda ('000000')
	*/
	function CambiarFormatoCelda($celda, $letra, $tamano, $colorLetra, $negritas, $colorBordeArriba, $colorBordeAbajo, $colorBordeIzquierda, $colorBordeDerecha, $colorRelleno)
	{
		//si no se envia letra, se carga la predefinida
		if($letra==='' || $letra===0)
			$letra=$this->letraDefault;
		//si no se envia tamano, se carga el predefinido
		if($tamano==='' || $tamano===0)
			$tamano=$this->tamanoDefault;
		//si no se envia color de letra, se carga el predefinido
		if($colorLetra==='' || $colorLetra===0)
			$colorLetra=$this->colorLetraDefault;
		//si no se envia parametro de negridas, se carga false
		if($negritas==='' || $negritas===0 || !$negritas)
			$negritas=false;
		//si no se carga color de borde superior, se carga el predefinido
		if($colorBordeArriba==='' || $colorBordeArriba===0)
			$colorBordeArriba=$this->colorBordeDefault;
		//si no se carga color de borde inferior, se carga el predefinido
		if($colorBordeAbajo==='' || $colorBordeAbajo===0)
			$colorBordeAbajo=$this->colorBordeDefault;
		//si no se carga color de borde izquierdo, se carga el predefinido
		if($colorBordeIzquierda==='' || $colorBordeIzquierda===0)
			$colorBordeIzquierda=$this->colorBordeDefault;
		//si no se carga color de borde derecho, se carga el predefinido
		if($colorBordeDerecha==='' || $colorBordeDerecha===0)
			$colorBordeDerecha=$this->colorBordeDefault;
		//si no se envia color de relleno, se carga el predefinido
		if($colorRelleno==='' || $colorRelleno===0)
			$colorRelleno=$this->colorRellenoDefault;

		$title = array(
			'font' => array(
				'name' => $letra,
				'size' => $tamano,
				'bold' => $negritas,
				'color' => array(
					'rgb' => $colorLetra
				),
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => $colorBordeAbajo
					)
				),
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => $colorBordeArriba
					)
				),
				'left' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => $colorBordeIzquierda
					)
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => $colorBordeDerecha
					)
				)
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					'rgb' => $colorRelleno,
				),
			),
		);
		$this->objPHPExcel->getActiveSheet()->getStyle($celda)->applyFromArray($title);
	}

	/* Destructor, guarda el archivo generado y se lo envia al usuario */
	function DescargarArchivo()
	{
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$this->nombreArchivo.'.xls"');
		header('Cache-Control: max-age=0');

		$this->objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
		$this->objWriter->save('php://output');
	}

	function GuardarArchivo($ruta, $titulo)
	{
		$this->objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
		$this->objWriter->save($ruta . $titulo . ".xls");
		return $ruta . $titulo . ".xls";
	}
}