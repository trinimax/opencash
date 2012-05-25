<?php

class Lista extends Master {
	
	function __construct() {
		parent::__construct();
	}
	
	
	# traer listas de precios
	function Traer_listas(){
		$this->db->from('clases_ventas');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_info_listas($criterio){
		$this->db->from('clases_ventas');
		if($criterio != '') {
			$like = "(clases_ventas.nombre LIKE '%".$this->db->escape_str($criterio)."%')";
			$this->db->where($like);
		}
		
		$query = $this->db->get();
		return $this->get_array($query);
	} 
	
	function Registrar_lista($datos) {
		$this->db->insert('clases_ventas', $datos);
		return $this->db->insert_id();
	}
	
	function Modificar_lista($id_clase_venta, $datos) {
		$this->db->where('id_clase_venta', $id_clase_venta);
		$this->db->update('clases_ventas', $datos);
	}
	
	function Traer_lista($datos) {
		$this->db->from('clases_ventas');
		$this->db->where($datos);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Traer_productos_disponibles($id_clase_venta, $buscar, $id_clase_producto) {
		$this->db->from('productos');
		$this->db->join('productos_clases_ventas', 'productos.id_producto = productos_clases_ventas.id_producto', 'inner');
		if($buscar != '') {
			$like = "(codigo LIKE CONCAT('%', ".$this->db->escape($buscar).", '%') ";
			$like.= "or nombre LIKE CONCAT('%', ".$this->db->escape($buscar).", '%') ";
			$like.= "or descripcion LIKE CONCAT('%', ".$this->db->escape($buscar).", '%'))";
			$this->db->where($like);
		}
		if($id_clase_producto > 0) {
			$this->db->where('id_clase_producto', $id_clase_producto);
		}
		$this->db->where('id_clase_venta', $id_clase_venta);
		$this->db->order_by('nombre', 'asc');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_producto($datos) {
		$this->db->from('productos');
		$this->db->where($datos);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	
	function Traer_producto_precio($id_producto, $id_clase_venta) {
		$this->db->from('productos');
		$this->db->join('productos_clases_ventas', 'productos.id_producto = productos_clases_ventas.id_producto', 'inner');
		$this->db->where('id_clase_venta', $id_clase_venta);
		$this->db->where('productos.id_producto', $id_producto);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	// registrar un nuevo producto
	function Registrar_producto($datos) {
		$this->db->insert('productos', $datos);
		return $this->db->insert_id();
	}
	// modificar producto existente
	function Modificar_producto($id_producto, $datos) {
		$this->db->where('id_producto', $id_producto);
		$this->db->update('productos', $datos);
	}
	
	// Traer los diferentes precios del producto
	function Traer_precios_producto($id_producto) {
		$this->db->from('clases_ventas');
		$this->db->join('productos_clases_ventas',
			'clases_ventas.id_clase_venta=productos_clases_ventas.id_clase_venta AND productos_clases_ventas.id_producto='.$this->db->escape_str($id_producto), 'left');
		$query = $this->db->get();
		return $this->get_array($query);
	}

	function Eliminar_lista($id_clase_venta) {
		$this->db->where('id_clase_venta', $id_clase_venta);
		$this->db->delete('clases_ventas');
	}
	
	function Limpiar_lista_ventas($id_clase_venta) {
		$datos = array('id_clase_venta'=>'0');
		$this->db->where('id_clase_venta', $id_clase_venta);
		$this->db->update('ventas', $datos);
	}
}

/* Fin del archivo: listas.php */
/* Ubicación: ./application/models/listas.php */
