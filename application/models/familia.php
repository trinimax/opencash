<?php

class Familia extends Master {
	
	function __construct() {
		parent::__construct();
	}
	
	
	# traer familias de productos
	function Traer_familias(){
		$this->db->from('clases_productos');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	# function family info
	function Traer_info_familia($id_clase_producto){
			$this->db->from('clases_productos');
			$this->db->where('id_clase_producto', $id_clase_producto);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Traer_info_productos($criterio, $id_clase_producto){
		$this->db->select('id_producto,productos.nombre,clases_productos.nombre as familia,codigo,precio');
		$this->db->from('productos');
		$this->db->join('clases_productos', 'productos.id_clase_producto = clases_productos.id_clase_producto', 'inner');
		if($criterio != '') {
			$like = "(productos.nombre LIKE '%".$this->db->escape_str($criterio)."%' OR ";
			$like.= "clases_productos.nombre LIKE '%".$this->db->escape_str($criterio)."%' OR ";
			$like.= "productos.descripcion LIKE '%".$this->db->escape_str($criterio)."%' OR ";
			$like.= "clases_productos.descripcion LIKE '%".$this->db->escape_str($criterio)."%')";
			$this->db->where($like);
		}
		if($id_clase_producto != 0) {
			$this->db->where('productos.id_clase_producto', $id_clase_producto);
		}
		$query = $this->db->get();
		return $this->get_array($query);
	} 
	
	// registrar una nueva familia
	function Registrar_familia($datos) {
		$this->db->insert('clases_productos', $datos);
		return $this->db->insert_id();
	}
	// modificar familia existente
	function Modificar_familia($id_clase_producto, $datos) {
		$this->db->where('id_clase_producto', $id_clase_producto);
		$this->db->update('clases_productos', $datos);
	}
	
	// Traer los diferentes precios del producto
	function Traer_precios_producto($id_producto) {
		$this->db->from('clases_ventas');
		$this->db->join('productos_clases_ventas',
			'clases_ventas.id_clase_venta=productos_clases_ventas.id_clase_venta AND productos_clases_ventas.id_producto='.$this->db->escape_str($id_producto), 'left');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Eliminar_familia($id_clase_producto) {
		$this->db->where('id_clase_producto', $id_clase_producto);
		$this->db->delete('clases_productos');
	}
	
	function Limpiar_familia_productos($id_clase_producto) {
		$datos = array('id_clase_producto'=>'0');
		$this->db->where('id_clase_producto', $id_clase_producto);
		$this->db->update('productos', $datos);
	}
}

/* Fin del archivo: producto.php */
/* Ubicación: ./application/models/producto.php */
