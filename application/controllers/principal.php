<?php

/**
 * Clase principal. Creado por jcortes234 el 28/02/12 01:23 hrs
 * Controlador de inicio
 */
class Principal extends CI_Controller {
	
	/**
	 * Constructor de la clase Principal
	 */
	function __construct() {
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
	}
	
	/**
	 * Método index
	 * Muestra la pantalla principal de la aplicación.
	 */
	function index() {
		$this->load->view('principal/inicio');
	}
	
	/**
	 * Método not_found
	 * Muestra una pantalla de error personalizada al no encontrar una ruta correcta
	 */
	function not_found() {
		$this->load->view('principal/construccion');
	}
}

/* End of file: principal.php */
/* Location: ./application/controllers/principal.php */
