<?php

/**
 * Modelo maestro de conectividad a base de datos
 * Todas las clases deberán heredar de esta
 *
 * @author Jesus Abraham Cortes (jcortes234@gmail.com)
 */
class Master extends CI_Model {
	
	function __construct() {
        parent::__construct();
    }
    
    function getArray($query) {
        $array = null;
        $i = 0;
        foreach($query->result() as $row) {
            /*$vars = get_object_vars($row);
            foreach($vars as $propiedad => $valor) {
                $row->$propiedad = utf8_encode($row->$propiedad);
            }*/
            $array[$i] = $row;
            $i++;
        }
        return $array;
    }
    
    function getRow($query) {
        $row = null;
        if($query->num_rows() > 0) {
            $row = $query->row();
            /*$vars = get_object_vars($row);
            foreach($vars as $propiedad => $valor) {
                $row->$propiedad = utf8_encode($row->$propiedad);
            }*/
        }
        return $row;
    }
	
}

/* Fin del archivo: master.php */
/* Ubicación: ./application/models/master.php */