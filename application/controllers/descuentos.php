<?php

class Descuentos extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
		$this->load->model('descuento');
	}
	
	function index() {
		
		$datos['descuentos'] = $this->descuento->Traer_descuentos();
		$this->load->view('descuentos/listado', $datos);
		
	}
	
	function registrar() {
		
		$datos['descuento']->nombre = '';
		$datos['descuento']->descripcion = '';
		$datos['descuento']->estatus = 1;
	
		$datos['opcion'] = 'Registrar';

		$this->form_validation->set_rules('txtNombre', 'Nombre', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('descuentos/formulario', $datos);
			//$this->load->view('familias/formulario');
		} else {
			$id_clase_producto = 0;
			
			$info = array('nombre' => $this->input->post('txtNombre'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'estatus' => $this->input->post('cmbEstatus'));
					
			$id_descuento = $this->descuento->Registrar_descuento($info);
			
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'descuentos/modificar/'.$id_descuento.'?save=ok');
		}
		
	}

	function modificar($id_descuento) {
		
		$datos['descuento'] = $this->descuento->Traer_descuento( array('id_clase_reduccion'=>$id_descuento));
		$datos['opcion'] = 'Modificar';
		
		$this->form_validation->set_rules('txtNombre', 'Nombre', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('descuentos/formulario', $datos);
		} else {
				$info = array('nombre' => $this->input->post('txtNombre'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'estatus' => $this->input->post('cmbEstatus'));
					
			$this->descuento->Modificar_descuento($id_descuento, $info);
			
			redirect( base_url() . 'descuentos/modificar/'.$id_descuento.'?save=ok');
		}
	}
	
	function eliminar($id_descuento) {
		$this->descuento->Eliminar_descuento($id_descuento);
		$this->descuento->Limpiar_descuento_venta($id_descuento);
		
		redirect( base_url() . 'descuentos/index' );
	}
	
}

/* Fin del archivo: descuentos.php */
/* Ubicación: ./application/controllers/descuentos.php */