<?php

class Familias extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
		$this->load->model('familia');
	}
	
	function index() {
		
		$datos['criterio'] = $this->input->post('txtCriterio');
		$datos['familia'] = $this->input->post('cmbFamilias') == '' ? 0 : $this->input->post('cmbFamilias');
//		$datos['nombre'] = $this->producto->Traer_info_productos($datos['criterio'], $datos['familia']);
		$datos['familias'] = $this->familia->Traer_familias();
		
		$this->load->view('familias/listado', $datos);
		
	}
	
	function registrar() {
		
		//$datos['perfiles'] = $this->usuario->Buscar_perfiles();
		// traer familias para el llenado del combo
	//	$datos['familia'] = $this->input->post('cmbFamilias') == '' ? 0 : $this->input->post('cmbFamilias');
		//$datos['familias'] = $this->producto->Traer_familias();
		// Inicializar las variables del producto, sin valores
	//	$datos['producto']->codigo = '';
		$datos['familia']->nombre = '';
		$datos['familia']->descripcion = '';
		$datos['familia']->estatus = 1;
	//	$datos['producto']->id_clase_producto = 0;
	//	$datos['producto']->precio = 0;
	
		
		$datos['opcion'] = 'Registrar';
	/*	
		$this->form_validation->set_rules('txtUsuario', 'Nombre de usuario', 'required|trim|xss_clean|callback_existe_usuario');
		$this->form_validation->set_rules('txtClave', 'Clave de acceso', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtClave2', 'Repetir clave de acceso', 'required|trim|xss_clean|matches[txtClave]');
		$this->form_validation->set_rules('txtNombre', 'Nombre de persona', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtCorreo', 'Correo electrónico', 'required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('cmbPerfil', 'Perfil de usuario', 'required|trim|is_natural|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		*/
	//	$this->form_validation->set_rules('txtCodigo', 'Codigo', 'required|trim|xss_clean|callback_validar_codigo');
		$this->form_validation->set_rules('txtFamilia', 'Familia', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
	//	$this->form_validation->set_rules('txtPrecio', 'Precio', 'required|trim|numeric|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('familias/formulario', $datos);
			//$this->load->view('familias/formulario');
		} else {
			$this->load->library('encrypt');
			$id_clase_producto = 0;
			$info = array('nombre' => $this->input->post('txtFamilia'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'estatus' => $this->input->post('cmbEstatus'));
					
			$id__clase_producto = $this->familia->Registrar_familia($info);
			
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'familias/modificar/'.$id__clase_producto.'?save=ok');
		}
		
	}
	
	function modificar($id_clase_producto) {
		
	//	$datos['perfiles'] = $this->usuario->Buscar_perfiles();
		//$datos['familia'] = $this->input->post('cmbFamilias') == '' ? 0 : $this->input->post('cmbFamilias');
		$datos['familia'] = $this->familia->Traer_info_familia($id_clase_producto);
		
		// Inicializar las variables del usuario, sin valores
		//$datos['producto'] = $this->producto->Traer_producto(array('id_producto'=>$id_producto));
		
		$datos['opcion'] = 'Modificar';
		
		//$this->form_validation->set_rules('txtCodigo', 'Codigo', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtFamilia', 'Familia', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
		//$this->form_validation->set_rules('txtPrecio', 'Precio', 'required|trim|numeric|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('familias/formulario', $datos);
		} else {
				$info = array('nombre' => $this->input->post('txtFamilia'),
					//'codigo' => $this->input->post('txtCodigo'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'estatus' => $this->input->post('cmbEstatus'));
					
			$this->familia->Modificar_familia($id_clase_producto, $info);
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'familias/modificar/'.$id_clase_producto.'?save=ok');
		}
	}
	
	function eliminar($id_familia) {
		$this->familia->Eliminar_familia($id_familia);
		$this->familia->Limpiar_familia_productos($id_familia);
		
		redirect( base_url() . 'familias/index' );
	}
	
	/******************************* CALLBACK *****************************/
	
	function validar_codigo($value) {
        $producto = $this->producto->Traer_producto(array('codigo'=>$value));
		if($producto == NULL) {
			return TRUE;
		} else {
			$this->form_validation->set_message('validar_codigo', 'El código de producto ya se encuentra registrado en el sistema.');
			return FALSE;
		}
    }
	
}

/* Fin del archivo: usuarios.php */
/* Ubicación: ./application/controllers/usuarios.php */