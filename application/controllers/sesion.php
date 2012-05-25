<?php

class Sesion extends CI_Controller {
	
	public $usr;
	
	function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('usuario');
	}
	
	function index() {
		if($this->session->userdata('Cash-id') == '') {
			$this->login();
		} else {
			$this->logout();
		}
	}
	
	function login() {
        
        $this->form_validation->set_rules('txtUsuario', 'Nombre de usuario', 'required|trim|xss_clean|callback_validar_usuario');
        $this->form_validation->set_rules('txtClave', 'Clave de acceso', 'required|trim|xss_clean|callback_validar_clave');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('sesion/login');
        } else {
            $perfil = $this->usuario->Traer_perfil(array('id_perfil'=>$this->usr->id_perfil));
            
            $this->usuario->Modificar_usuario($this->usr->id_usuario, array('intentos'=>0));
			
            //print $this->usr->nombre_persona;
            $sesion = array('Cash-id' => $this->usr->id_usuario, 'Cash-username' => $this->usr->nombre_usuario,
                	'Cash-person' => $this->usr->nombre_persona, 'Cash-email' => $this->usr->correo,
                	'Cash-profileid' => $perfil->id_perfil, 'Cash-profile' => $perfil->nombre);
            
            $this->session->set_userdata($sesion);
            
            redirect(base_url().'principal/index');
        }
	}
	
	function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'login/index');
	}

	function recuperar() {
		
		$this->form_validation->set_rules('txtCorreo', 'Nombre de usuario', 'trim|required|xss_clean|callback_validar_correo_recuperacion');
		$this->form_validation->set_rules('txtCorreo2', 'Repetir nombre de usuario', 'trim|required|xss_clean|matches[txtCorreo]');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('sesion/recuperar_clave');
		} else {
				
			$user = $this->usuario->Traer_usuario(array('nombre_usuario'=>$this->input->post('txtCorreo')));
			
			$mail['nombre'] = $user->nombre_persona;
			$mail['correo'] = $user->correo;
			$mail['usuario'] = $user->nombre_usuario;
			
			$mensaje = $this->load->view('mail/recuperar_clave', $mail, TRUE);
			
			$administradores = $this->usuario->Buscar_usuarios('', 2);
			
			$this->load->library('email');
			
			for($i=0; $i<count($administradores); $i++) {
				$this->email->from(CORREO, "Sistema ".NOMBRE_APP);
				$this->email->to( $administradores[$i]->correo );
				$this->email->bcc(CORREO);
				$this->email->subject("Recuperación de clave de acceso al sistema ".NOMBRE_APP);
				$this->email->message($mensaje);
				$this->email->send();
			}
    		
    		redirect( base_url() . 'sesion/recuperar?send=ok');
		}
	}
	
	//------------------------------------ FUNCIONES CALLBACK ---------------------------------//
    
    function validar_usuario($value) {
        $this->usr = $this->usuario->Traer_usuario(array('nombre_usuario'=>$value));
        if($this->usr == NULL) {
            $this->form_validation->set_message('validar_usuario', 'El usuario ingresado no se encuentra registrado en el sistema.');
            return FALSE;
        } else {
            if($this->usr->estatus != 1) {
                $this->form_validation->set_message('validar_usuario', 'El usuario ingresado se encuentra desactivado.');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    
    function validar_clave($value) {
        if($this->usr == NULL) {
            $this->form_validation->set_message('validar_clave', 'No se puede validar la clave de acceso');
            return FALSE;
        } else {
            if($this->usr->clave != $this->encrypt->sha1($value)) {
                $mensaje = '';
                $intentos = $this->usr->intentos + 1;
                $this->usuario->Modificar_usuario($this->usr->id_usuario, array('intentos'=>$intentos));
                if($intentos >= 5) {
                    $this->usuario->Modificar_usuario($this->usr->id_usuario, array('estatus'=>0));
                    $mensaje = 'La clave de acceso es incorrecta. Por motivos de seguridad, el usuario ha sido desactivado.';
                } else {
                    $restantes = 5 - $intentos;
                    $mensaje = 'La clave de acceso es incorrecta. Le restan '.$restantes.' intentos para iniciar sesión.';
                }
				
                $this->form_validation->set_message('validar_clave', $mensaje);
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
	
	function validar_captcha($str)
    {
    	// Cargamos el helper para el re-captcha
    	$this->load->helper('recaptcha');
    	$privatekey = "6LdDOs8SAAAAAJlzUj3rNepOl8eseyUMVyp0l4Be";
    	//$resp = recaptcha_check_answer ($privatekey, $address, $challenge_field, $response_field);
    	$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $this->input->post("recaptcha_challenge_field"), $this->input->post("recaptcha_response_field"));
    
    	if (!$resp->is_valid)
    	{
    		// What happens when the CAPTCHA was entered incorrectly
    		$this->form_validation->set_message('validar_captcha', 'El valor ingresado en el Texto de seguridad es incorrecto. Por favor vuelva a intentarlo.');
    		return FALSE;
    	}
    	else
    	{
    		// Your code here to handle a successful verification
    		return TRUE;
    	}
    }
	
	function validar_correo_recuperacion($str) {
		$usuario = $this->usuario->Traer_usuario(array('nombre_usuario'=>$str));
		if($usuario == NULL) {
			$this->form_validation->set_message('validar_correo_recuperacion', 'El nombre de usuario ingresado no se encuentra registrado.');
    		return FALSE;
		} else {
			if($usuario->estatus == 0) {
				$this->form_validation->set_message('validar_correo_recuperacion', 'La cuenta de usuario se encuentra desactivada.');
    			return FALSE;
			} else {
				return TRUE;
			}
		}
	}
}

/* Fin del archivo: sesion.php */
/* Ubicación: ./application/controllers/sesion.php */