<?php

class Usuarios extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
		$this->load->model('usuario');
	}
	
	function index() {
		
		$datos['criterio'] = $this->input->post('txtCriterio');
		$datos['id_perfil'] = $this->input->post('cmbPerfil') == '' ? 0 : $this->input->post('cmbPerfil');
		$datos['perfiles'] = $this->usuario->Buscar_perfiles();
		
		$datos['usuarios'] = $this->usuario->Buscar_usuarios($datos['criterio'], $datos['id_perfil']);
		for($i=0; $i<count($datos['usuarios']); $i++) {
			$perfil = $this->usuario->Traer_perfil(array('id_perfil'=>$datos['usuarios'][$i]->id_perfil));
			$datos['usuarios'][$i]->perfil = $perfil->nombre;
		}
		
		$this->form_validation->set_rules('txtCriterio', 'Criterio de búsqueda', 'trim|xss_clean');
		$this->form_validation->set_rules('cmbPerfil', 'Perfil de usuario', 'trim|is_natural|xss_clean');
		
		$this->load->view('usuarios/listado', $datos);
		
	}
	
	function registrar() {
		
		$datos['perfiles'] = $this->usuario->Buscar_perfiles();
		
		// Inicializar las variables del usuario, sin valores
		$datos['usuario']->id_usuario = 0;
		$datos['usuario']->id_perfil = 0;
		$datos['usuario']->nombre_usuario = '';
		$datos['usuario']->nombre_persona = '';
		$datos['usuario']->correo = '';
		$datos['usuario']->estatus = 0;
		
		$datos['opcion'] = 'Registrar';
		
		$this->form_validation->set_rules('txtUsuario', 'Nombre de usuario', 'required|trim|xss_clean|callback_existe_usuario');
		$this->form_validation->set_rules('txtClave', 'Clave de acceso', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtClave2', 'Repetir clave de acceso', 'required|trim|xss_clean|matches[txtClave]');
		$this->form_validation->set_rules('txtNombre', 'Nombre de persona', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtCorreo', 'Correo electrónico', 'required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('cmbPerfil', 'Perfil de usuario', 'required|trim|is_natural|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('usuarios/formulario', $datos);
		} else {
			$this->load->library('encrypt');
			
			$info = array('nombre_usuario' => $this->input->post('txtUsuario'),
					'clave' => $this->encrypt->sha1($this->input->post('txtClave')),
					'nombre_persona' => $this->input->post('txtNombre'),
					'correo' => $this->input->post('txtCorreo'),
					'id_perfil' => $this->input->post('cmbPerfil'),
					'estatus' => $this->input->post('cmbEstatus'));
			$id_usuario = $this->usuario->Registrar_usuario($info);
			
			$mail['nombre_persona'] = $this->input->post('txtNombre');
			$mail['nombre_usuario'] = $this->input->post('txtUsuario');
			$mail['clave'] = $this->input->post('txtClave');
			
			$mensaje = $this->load->view('mail/nuevo_usuario', $mail, TRUE);
			
			$this->load->library('email');
			$this->email->from(CORREO, "Sistema de Control de Gastos");
			$this->email->to( $this->input->post('txtCorreo') );
			$this->email->bcc(CORREO);
			$this->email->subject("Información para ingresar al sistema CashCtrl");
			$this->email->message($mensaje);
			//$this->email->send();
			
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'usuarios/modificar/'.$id_usuario.'?save=ok');
		}
		
	}
	
	function modificar($id_usuario) {
		
		$datos['perfiles'] = $this->usuario->Buscar_perfiles();
		
		// Inicializar las variables del usuario, sin valores
		$datos['usuario'] = $this->usuario->Traer_usuario(array('id_usuario'=>$id_usuario));
		
		$datos['opcion'] = 'Modificar';
		
		$this->form_validation->set_rules('txtNombre', 'Nombre de persona', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txtCorreo', 'Correo electrónico', 'required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('cmbPerfil', 'Perfil de usuario', 'required|trim|is_natural|xss_clean');
		$this->form_validation->set_rules('cmbEstatus', 'Estatus', 'required|trim|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('usuarios/formulario', $datos);
		} else {
			$info = array('nombre_persona' => $this->input->post('txtNombre'),
					'correo' => $this->input->post('txtCorreo'),
					'id_perfil' => $this->input->post('cmbPerfil'),
					'estatus' => $this->input->post('cmbEstatus'));
			$this->usuario->Modificar_usuario($id_usuario, $info);
			// Redireccionar a la pantalla de actualización, con un mensaje de guardado
			redirect( base_url() . 'usuarios/modificar/'.$id_usuario.'?save=ok');
		}
	}

	function eliminar($id_usuario) {
		$this->usuario->Eliminar_usuario($id_usuario);
		$this->usuario->Limpiar_ventas($id_usuario);
		
		redirect( base_url() . 'usuarios/index' );
	}
	
	function clave($id_usuario) {
		
		$this->form_validation->set_rules('txtClave', 'Nueva clave de acceso', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txtClave2', 'Repetir nueva clave de acceso', 'trim|required|xss_clean|matches[txtClave]');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('usuarios/clave');
		} else {
			
			$user = $this->usuario->Traer_usuario(array('id_usuario'=>$id_usuario));
			
			$array = array('clave'=>$this->encrypt->sha1($this->input->post('txtClave')));
			$this->usuario->Modificar_usuario($id_usuario, $array);
			
			$mail['nombre'] = $user->nombre_persona;
			$mail['correo'] = $user->correo;
			$mail['usuario'] = $user->nombre_usuario;
			$mail['clave'] = $this->input->post('txtClave');
			
			$mensaje = $this->load->view('mail/modificar_clave', $mail, TRUE);
			
			$this->load->library('email');
			$this->email->from(CORREO, "Sistema ".NOMBRE_APP);
			$this->email->to( $mail['correo'] );
			$this->email->bcc(CORREO);
			$this->email->subject("Modificación de clave de acceso al sistema ".NOMBRE_APP);
			$this->email->message($mensaje);
			$this->email->send();
			
			redirect( base_url() . 'usuarios/clave/'.$id_usuario.'?save=ok');
		}
		
	}
	
	/******************************* CALLBACK *****************************/
	
	function existe_usuario($value) {
        $usr = $this->usuario->Traer_usuario(array('nombre_usuario'=>$value));
        if($usr != NULL) {
            $this->form_validation->set_message('existe_usuario', 'El usuario ingresado ya se encuentra registrado en el sistema.');
            return FALSE;
        } else {
            RETURN TRUE;
        }
    }
	
}

/* Fin del archivo: usuarios.php */
/* Ubicación: ./application/controllers/usuarios.php */