<?php

class Listas extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
		$this->load->model('lista');
	}
	
	function index() {
		
		$datos['criterio'] = $this->input->post('txtCriterio');
		$datos['lista'] = $this->input->post('cmbListas') == '' ? 0 : $this->input->post('cmbListas');
		$datos['listas'] = $this->lista->Traer_info_listas($datos['criterio']);
		//$datos['listas'] = $this->lista->Traer_listas();
		$this->load->view('listas/listado', $datos);
		
	}
	
	function registrar() {
		
		$datos['lista']->nombre = '';
		$datos['lista']->descripcion = '';
		$datos['lista']->descuento = 0;
		$datos['lista']->estatus = 1;
	
		$datos['opcion'] = 'Registrar';
		
		$this->form_validation->set_rules('txtNombre', 'Clase de venta', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
		$this->form_validation->set_rules('txtDescuento', 'Descuento', 'required|trim|numeric|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('listas/formulario', $datos);
		} else {
			
			$datos = array('nombre' => $this->input->post('txtNombre'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'descuento' => $this->input->post('txtDescuento'),
					'estatus' => $this->input->post('cmbEstatus'));
			$id_clase = $this->lista->Registrar_lista($datos);
			
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'listas/modificar/'.$id_clase.'?save=ok');
		}
		
	}
	
	function modificar($id_clase_venta) {
		
		$datos['lista'] = $this->lista->Traer_lista(array('id_clase_venta'=>$id_clase_venta));
		
		$datos['opcion'] = 'Modificar';
		
		$this->form_validation->set_rules('txtNombre', 'Clase de venta', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
		$this->form_validation->set_rules('txtDescuento', 'Descuento', 'required|trim|numeric|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('listas/formulario', $datos);
		} else {
			
			$datos = array('nombre' => $this->input->post('txtNombre'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'descuento' => $this->input->post('txtDescuento'),
					'estatus' => $this->input->post('cmbEstatus'));
			
			$this->lista->Modificar_lista($id_clase_venta, $datos);
			
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'listas/modificar/'.$id_clase_venta.'?save=ok');
		}
	}

	function eliminar($id_lista) {
		$this->lista->Eliminar_lista($id_lista);
		$this->lista->Limpiar_lista_ventas($id_lista);
		
		redirect( base_url() . 'listas/index' );
	}
	
}

/* Fin del archivo: usuarios.php */
/* Ubicación: ./application/controllers/usuarios.php */