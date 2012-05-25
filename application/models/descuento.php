<?php

class Descuento extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function Traer_descuentos() {
		$this->db->from('clases_reducciones');
		$this->db->order_by('nombre');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_descuento($array) {
		$this->db->from('clases_reducciones');
		$this->db->where($array);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Registrar_descuento($array) {
		$this->db->insert('clases_reducciones', $array);
		return $this->db->insert_id();
	}
	
	function Modificar_descuento($id_descuento, $array) {
		$this->db->where('id_clase_reduccion', $id_descuento);
		$this->db->update('clases_reducciones', $array);
	}
	
	function Eliminar_descuento($id_descuento) {
		$this->db->where('id_clase_reduccion', $id_descuento);
		$this->db->delete('clases_reducciones');
	}
	
	function Limpiar_descuento_venta($id_descuento) {
		$array = array('id_clase_reduccion'=>0);
		$this->db->where('id_clase_reduccion', $id_descuento);
		$this->db->update('ventas', $array);
	}
	
}

/* Fin del archivo: descuento.php */
/* Ubicación: ./applications/models/descuento.php */
