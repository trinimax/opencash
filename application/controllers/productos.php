<?php

class Productos extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
		$this->load->model('producto');
	}
	
	function index() {
		
		$datos['criterio'] = $this->input->post('txtCriterio');
		$datos['familia'] = $this->input->post('cmbFamilias') == '' ? 0 : $this->input->post('cmbFamilias');
		$datos['nombre'] = $this->producto->Traer_info_productos($datos['criterio'], $datos['familia']);
		$datos['familias'] = $this->producto->Traer_familias();
		
		$this->load->view('productos/listado', $datos);
		
	}
	
	function registrar() {
		
		//$datos['perfiles'] = $this->usuario->Buscar_perfiles();
		// traer familias para el llenado del combo
		$datos['familia'] = $this->input->post('cmbFamilias') == '' ? 0 : $this->input->post('cmbFamilias');
		$datos['familias'] = $this->producto->Traer_familias();
		// Inicializar las variables del producto, sin valores
		$datos['producto']->codigo = '';
		$datos['producto']->nombre = '';
		$datos['producto']->descripcion = '';
		$datos['producto']->id_clase_producto = 0;
		$datos['producto']->precio = 0;
		$datos['producto']->estatus = 1;
	
		
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
		$this->form_validation->set_rules('cmbFamilias', 'Familia', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtCodigo', 'Codigo', 'required|trim|xss_clean|callback_validar_codigo');
		$this->form_validation->set_rules('txtProducto', 'Producto', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
		$this->form_validation->set_rules('txtPrecio', 'Precio', 'required|trim|numeric|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('productos/formulario', $datos);
		} else {
			$this->load->library('encrypt');
			$id_producto = 0;
			$info = array('nombre' => $this->input->post('txtProducto'),
					'codigo' => $this->input->post('txtCodigo'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'precio' => $this->input->post('txtPrecio'),
					'id_clase_producto' => $this->input->post('cmbFamilias'),
					'estatus' => $this->input->post('cmbEstatus'));
					
			$id_producto = $this->producto->Registrar_producto($info);
			
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'productos/modificar/'.$id_producto.'?save=ok');
		}
		
	}
	
	function modificar($id_producto) {
		
	//	$datos['perfiles'] = $this->usuario->Buscar_perfiles();
		//$datos['familia'] = $this->input->post('cmbFamilias') == '' ? 0 : $this->input->post('cmbFamilias');
		$datos['familias'] = $this->producto->Traer_familias();
		
		// Inicializar las variables del usuario, sin valores
		$datos['producto'] = $this->producto->Traer_producto(array('id_producto'=>$id_producto));
		
		$datos['opcion'] = 'Modificar';
		
		$this->form_validation->set_rules('txtCodigo', 'Codigo', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtProducto', 'Producto', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtDescripcion', 'Descripcion', 'trim|xss_clean');
		$this->form_validation->set_rules('txtPrecio', 'Precio', 'required|trim|numeric|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('productos/formulario', $datos);
		} else {
				$info = array('nombre' => $this->input->post('txtProducto'),
					//'codigo' => $this->input->post('txtCodigo'),
					'descripcion' => $this->input->post('txtDescripcion'),
					'precio' => $this->input->post('txtPrecio'),
					'id_clase_producto' => $this->input->post('cmbFamilias'),
					'estatus' => $this->input->post('cmbEstatus'));
					
			$this->producto->Modificar_producto($id_producto, $info);
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'productos/modificar/'.$id_producto.'?save=ok');
		}
	}
	
	function eliminar($id_producto) {
		$this->producto->Eliminar_producto($id_producto);
		$this->producto->Limpiar_ventas($id_producto);
		
		redirect( base_url() . 'productos/index' );
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