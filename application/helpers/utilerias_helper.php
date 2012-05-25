<?php

	function texto_aleatorio ($long = 5, $letras_min = true, $letras_max = true, $num = true) {
		$salt = $letras_min?'abchefghknpqrstuvwxyz':'';
		$salt .= $letras_max?'ACDEFHKNPRSTUVWXYZ':'';
		$salt .= $num?(strlen($salt)?'2345679':'0123456789'):'';
 
		if (strlen($salt) == 0) {
			return '';
		}
 
		$i = 0;
		$str = '';
		 
		srand((double)microtime()*1000000);
 
		while ($i < $long) {
			$num = rand(0, strlen($salt)-1);
			$str .= substr($salt, $num, 1);
			$i++;
		}
		 
		return $str;
	}
	
	function es_entero($valor)
	{
		try
		{
			$valor = (int)$valor;
			return TRUE;
		}
		catch(Exception $ex)
		{
			return FALSE;
		}
		
	}
	
	function es_fecha($fecha)
	{
		$entero = str_replace("/", "", $fecha);
		if(es_entero($entero))
		{
			$explode = explode("/", $fecha);
			if(count($explode) == 3)
			{
				$anio = (string)$explode[2];
				$mes = (string)$explode[1];
				$dia = (string)$explode[0];
				if(strlen($anio) == 4 && strlen($mes)==2 && strlen($dia)==2)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	function diferencia_fechas($fecha1, $fecha2)
	{
		$fecha1 = str_replace("-","",$fecha1);
		$fecha1 = str_replace("/","",$fecha1);
		$fecha2 = str_replace("-","",$fecha2);
		$fecha2 = str_replace("/","",$fecha2);
		
		preg_match( "/([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})/", $fecha1, $aFecIni);
		preg_match( "/([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})/", $fecha2, $aFecFin);
		
		$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
		$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
		
		return round(($date2 - $date1) / (60 * 60 * 24));
	}
	
	function sumar_fecha($anio, $mes, $dia, $dias){
		$ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
		  $dias_adelanto = $dias;
		  $siguiente = $dia + $dias_adelanto;
		  if ($ultimo_dia < $siguiente)
		  {
		     $dia_final = $siguiente - $ultimo_dia;
		     $mes++;
		     if ($mes == '13')
		 {
		    $anio++;
		    $mes = '01';
		 }
		 $fecha_final = $anio.'-'.agregar_cero_fecha($mes).'-'.agregar_cero_fecha($dia_final);         
		  }
		  else
		  {
		     $fecha_final = $anio .'-'.agregar_cero_fecha($mes).'-'.agregar_cero_fecha($siguiente);         
		  }
		  return $fecha_final;
	}
	
	function agregar_cero_fecha($numero) {
		$numero = (int)$numero;
		if($numero < 10) {
			return '0'.$numero;
		} else {
			return $numero;
		}
	}
        
	function edad($fecha)
	{
		list($anio,$mes,$dia) = explode("-",$fecha);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($mes_dif < 0) {
			$anio_dif--;
		} else if($mes_dif == 0 && $dia_dif < 0 ) {
			$anio_dif--;
		}
		return $anio_dif;
	}
	
	function formato_fecha_ddmmaaaa($fecha)
	{
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[2] . "/" . $array[1] . "/" . $array[0];
		else
			return '';
	}
	
	function formato_fecha_texto($fecha)
	{
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[2] . " de " . nombre_mes($array[1]) . " de " . $array[0];
		else
			return '';
	}
	
	function formato_fecha_texto_abr($fecha)
	{
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[2] . "/" . nombre_mes_abr($array[1]) . "/" . $array[0];
		else
			return '';
	}	
	
	function separar_fecha_hora($fecha_hora)
	{
		$array = explode(" ", $fecha_hora);
		return $array;
	}
	
	function nombre_mes($mes)
	{
		if($mes==1) {
			return "enero";
		} else if($mes==2) {
			return "febrero";
		} else if($mes==3) {
			return "marzo";
		} else if($mes==4) {
			return "abril";
		} else if($mes==5) {
			return "mayo";
		} else if($mes==6) {
			return "junio";
		} else if($mes==7) {
			return "julio";
		} else if($mes==8) {
			return "agosto";
		} else if($mes==9) {
			return "septiembre";
		} else if($mes==10) {
			return "octubre";
		} else if($mes==11) {
			return "noviembre";
		} else if($mes==12) {
			return "diciembre";
		} else {
			return "";
		}
	}
	
	function nombre_mes_abr($mes)
	{
		if($mes==1) {
			return "ENE";
		} else if($mes==2) {
			return "FEB";
		} else if($mes==3) {
			return "MAR";
		} else if($mes==4) {
			return "ABR";
		} else if($mes==5) {
			return "MAY";
		} else if($mes==6) {
			return "JUN";
		} else if($mes==7) {
			return "JUL";
		} else if($mes==8) {
			return "AGO";
		} else if($mes==9) {
			return "SEP";
		} else if($mes==10) {
			return "OCT";
		} else if($mes==11) {
			return "NOV";
		} else if($mes==12) {
			return "DIC";
		} else {
			return "";
		}
	}
	
	function extension_archivo($str) {
		return strtolower(end(explode(".", $str)));
	}

/* Fin del archivo: utilerias_helper.php */
/* Ubicación: ./application/helpers/utilerias_helper.php */