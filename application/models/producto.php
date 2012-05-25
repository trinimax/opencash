<?php

class Producto extends Master {
	
	function __construct() {
		parent::__construct();
	}
	
	
	# traer familias de productos
	function Traer_familias(){
		$this->db->from('clases_productos');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_familias_estatus($estatus){
		$this->db->from('clases_productos');
		$this->db->where('estatus', $estatus);
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_info_productos($criterio, $id_clase_producto){
		$this->db->select('id_producto,productos.nombre,clases_productos.nombre as familia,codigo,precio,productos.estatus');
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
	
	function Traer_productos_disponibles($buscar, $id_clase_producto) {
		$this->db->from('productos');
		if($buscar != '') {
			$like = "(codigo LIKE CONCAT('%', ".$this->db->escape($buscar).", '%') ";
			$like.= "or nombre LIKE CONCAT('%', ".$this->db->escape($buscar).", '%') ";
			$like.= "or descripcion LIKE CONCAT('%', ".$this->db->escape($buscar).", '%'))";
			$this->db->where($like);
		}
		if($id_clase_producto > 0) {
			$this->db->where('id_clase_producto', $id_clase_producto);
		}
		$this->db->where('estatus', 1);
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

	function Eliminar_producto($id_producto) {
		$this->db->where('id_producto', $id_producto);
		$this->db->delete('productos');
	}
	
	function Limpiar_ventas($id_producto) {
		$datos = array('id_producto'=>'0');
		$this->db->where('id_producto', $id_producto);
		$this->db->update('ventas_productos', $datos);
	}
}

/* Fin del archivo: producto.php */
/* Ubicación: ./application/models/producto.php */
