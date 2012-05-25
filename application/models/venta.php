<?php

class Venta extends Master {
	
	function __construct() {
		parent::__construct();
	}
	
	function Registrar_venta($datos) {
		$this->db->insert('ventas', $datos);
		return $this->db->insert_id();
	}
	
	function Registrar_producto_venta($datos) {
		$this->db->insert('ventas_productos', $datos);
		return $this->db->insert_id();
	}
	
	function Modificar_venta($id_venta, $datos) {
		$this->db->where('id_venta', $id_venta);
		$this->db->update('ventas', $datos);
	}
	
	function Modificar_producto_venta($id_venta, $id_producto, $datos) {
		$this->db->where('id_venta', $id_venta);
		$this->db->where('id_producto', $id_producto);
		$this->db->update('ventas_productos', $datos);
	}
	
	function Remover_producto_venta($id_venta, $id_producto) {
		$this->db->where('id_venta', $id_venta);
		$this->db->where('id_producto', $id_producto);
		$this->db->delete('ventas_productos');
	}
	
	function Traer_venta($datos) {
		$this->db->from('ventas');
		$this->db->where($datos);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Traer_ventas($datos, $criterio) {
		$this->db->from('ventas');
		$this->db->where($datos);
		if($criterio != '') {
			$this->db->like('folio', $criterio);
		}
		$this->db->order_by('fecha_registro', 'desc');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_productos_venta($datos) {
		$this->db->from('ventas_productos');
		$this->db->where($datos);
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_producto_venta($id_venta, $id_producto) {
		$this->db->from('ventas_productos');
		$this->db->where('id_venta', $id_venta);
		$this->db->where('id_producto', $id_producto);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Traer_tipos_venta() {
		$this->db->from('clases_ventas');
		$this->db->order_by('nombre', 'desc');
		$query = $this->db->get();
		return $this->get_array($query);
	}

	function Traer_tipos_venta_estatus($estatus) {
		$this->db->from('clases_ventas');
		$this->db->where('estatus', $estatus);
		$this->db->order_by('nombre', 'desc');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	
	function Traer_tipo_venta($datos) {
		$this->db->from('clases_ventas');
		$this->db->where($datos);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Traer_clases_reducciones() {
		$this->db->from('clases_reducciones');
		$this->db->order_by('id_clase_reduccion', 'asc');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Insertar_reduccion($datos) {
		$this->db->insert('ventas_reducciones', $datos);
		return $this->db->insert_id();
	}

	function Traer_reporte_ventas($fechaI, $fechaF, $forma_pago, $id_clase_venta) {
		$this->db->from('ventas');
		$this->db->join('ventas_pagos', 'ventas.id_venta=ventas_pagos.id_venta', 'inner');
		if($fechaI != '') {
			$this->db->where('ventas.fecha_cierre >=', $fechaI);
		}
		if($fechaF != '') {
			$this->db->where('ventas.fecha_cierre <=', $fechaF);
		}
		if($id_clase_venta != '') {
			$this->db->where('ventas.id_clase_venta', $id_clase_venta);
		}
		if($forma_pago != '') {
			$this->db->where('ventas_pagos.forma_pago', $forma_pago);
		}
		$this->db->where('ventas.estatus', 'PAGADA');
		$this->db->order_by('ventas.fecha_cierre', 'asc');
		$query = $this->db->get();
		return $this->get_array($query); 
	}
	
	function Registrar_pago($id_venta, $tipo_pago, $monto) {
		$datos = array('forma_pago'=>$tipo_pago,
				'monto'=>$monto, 'id_venta'=>$id_venta);
		$this->db->insert('ventas_pagos', $datos);
		return $this->db->insert_id();
	}
	
	function Traer_pago($id_venta, $tipo_pago) {
		$this->db->from('ventas_pagos');
		if($tipo_pago != NULL)
			$this->db->where('forma_pago', $tipo_pago);
		$this->db->where('id_venta', $id_venta);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Traer_pagos($id_venta) {
		$this->db->from('ventas_pagos');
		$this->db->where('id_venta', $id_venta);
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	/* CORTES DE CAJA */
	
	function Traer_corte($id_corte) {
		$this->db->from('corte_caja');
		$this->db->where('id_corte_caja', $id_corte);
		$query = $this->db->get();
		return $this->get_row($query);
	}
	
	function Traer_corte_caja_efectivo($id_corte) {
		$this->db->from('ventas');
		$this->db->join('ventas_pagos', 'ventas.id_venta=ventas_pagos.id_venta', 'INNER');
		$this->db->where('ventas.id_corte_caja', $id_corte);
		$this->db->where('ventas_pagos.forma_pago', 'Efectivo');
		$this->db->where('ventas.estatus', 'PAGADA');
		$query = $this->db->get();
		return $this->get_array($query);
	}

	function Traer_corte_caja_tdc($id_corte) {
		$this->db->from('ventas');
		$this->db->join('ventas_pagos', 'ventas.id_venta=ventas_pagos.id_venta', 'INNER');
		$this->db->where('ventas.id_corte_caja', $id_corte);
		$tdc = "(ventas_pagos.forma_pago='Visa/MasterCard C' OR ventas_pagos.forma_pago='Visa/MasterCard H' OR ventas_pagos.forma_pago='American Express')";
		$this->db->where($tdc);
		$this->db->where('ventas.estatus', 'PAGADA');
		$query = $this->db->get();
		return $this->get_array($query);
	}
	
	function Traer_corte_caja_vales($id_corte) {
		$this->db->from('ventas');
		$this->db->join('ventas_pagos', 'ventas.id_venta=ventas_pagos.id_venta', 'INNER');
		$this->db->where('ventas.id_corte_caja', $id_corte);
		$this->db->where('ventas_pagos.forma_pago', 'Vale');
		$this->db->where('ventas.estatus', 'PAGADA');
		$query = $this->db->get();
		return $this->get_array($query);
	}	
	
	function Traer_corte_caja_propinas($id_corte, $id_usuario) {
		$this->db->from('ventas');
		$this->db->where('ventas.id_corte_caja', $id_corte);
		$this->db->where('ventas.id_usuario', $id_usuario);
		$this->db->where('ventas.estatus', 'PAGADA');
		$query = $this->db->get();
		return $this->get_array($query);
	}

	function Insertar_corte($datos) {
		$this->db->insert('corte_caja', $datos);
		return $this->db->insert_id();
	}

	function Actualizar_corte_caja_ventas($id_corte_caja, $id_usuario) {
		$datos = array('id_corte_caja' => $id_corte_caja);
		$this->db->where('id_corte_caja', 0);
		$this->db->where('estatus', 'PAGADA');
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('ventas', $datos);
	}
}

/* Fin del archivo: venta.php */
/* Ubicación: ./application/models/venta.php */
