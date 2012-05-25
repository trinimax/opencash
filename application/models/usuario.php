<?php

/**
 * Clase usuario
 * @author Jesús A. Cortés (@jcortesm)
 * @copyright Velatorios Funeza
 */
class Usuario extends Master {
	
	/**
	 * Constructor del objeto Usuario
	 */
	function __construct() {
		parent::__construct();
	}
	
	/******************************* SECCIÓN DE USUARIOS ***************************/
	
	/**
	 * Buscar usurios en la base de datos
	 * @param string $criterio Criterios de búsqueda para la consulta
	 * @param int $id_perfil ID del perfil del usuario
	 * @return array[object] Resultado de la consulta 
	 */
	function Buscar_usuarios($criterio = '', $id_perfil = 0) {
		// Seleccionar la tabla
		$this->db->from('usuarios');
		
		// Si el criterio no está vacío, se buscará con LIKE la palabra enviada
		if($criterio != '') {
			$like = "(nombre_usuario LIKE '%".$criterio."%' ";
			$like.= "OR nombre_persona LIKE '%".$criterio."%' ";
			$like.= "OR correo LIKE '%".$criterio."%' )";
			$this->db->where($like);
		}
		
		// Si el perfil es diferente a 0, se buscarán a los usuarios con ese ID
		if($id_perfil != 0) {
			$this->db->where('id_perfil', $id_perfil);
		}
		
		// Ordenar la consulta ascendentemente
		$this->db->order_by('nombre_usuario', 'asc');
		
		// Solicitar los datos
		$query = $this->db->get();
		
		// Guardar y regresar la información en un array multidimensional
		return $this->getArray($query);
	}
	
	/**
	 * Devuelve un usuario
	 * @param array $datos Campos que determinan el resultado de la búsqueda
	 * @return object Resultado de la consulta 
	 */
	function Traer_usuario($datos) {
		// Seleccionar tabla
		$this->db->from('usuarios');
		
		// Asignar los campos a comparar
		$this->db->where($datos);
		
		// Solicitar la consulta
		$query = $this->db->get();
		
		// Guardar y regresar la información en un array unidimensional
		$row = $this->getRow($query);
		return $this->getRow($query);
	}
	
	/**
	 * Registra un nuevo usuario
	 * @param array $datos Campos que se registrarán
	 * @return int ID autonumérico asignado al nuevo registro 
	 */
	function Registrar_usuario($datos) {
		$this->db->insert('usuarios', $datos);
		return $this->db->insert_id();
	}
	
	/**
	 * Modifica un usuario existente
	 * @param int $id_usuario ID del usuario
	 * @param $datos Campos que se modificarán
	 */
	function Modificar_usuario($id_usuario, $datos) {
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuarios', $datos);
	}
	
	function Eliminar_usuario($id_usuario) {
		$this->db->where('id_usuario', $id_usuario);
		$this->db->delete('usuarios');
	}
	
	function Limpiar_ventas($id_usuario) {
		$datos = array('id_usuario'=>'0');
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('ventas', $datos);
	}
	
	/****************************** SECCIÓN DE PERFILES ******************************/
	
	/**
	 * Buscar perfiles en la base de datos
	 * @param string $criterio Criterios de búsqueda para la consulta
	 * @return array[object] Resultado de la consulta 
	 */
	function Buscar_perfiles($criterio = '') {
		$this->db->from('perfiles');
		if($criterio != '') {
			$this->db->like('nombre', $criterio);
		}
		$this->db->order_by('nombre', 'asc');
		$query = $this->db->get();
		return $this->getArray($query);
	}
	
	/**
	 * Trae un perfil que cumpla con los parámetros enviados
	 * @param array $datos Campos que se desean comparar
	 * @return object Información del perfil
	 */
	function Traer_perfil($datos) {
		$this->db->from('perfiles');
		$this->db->where($datos);
		$query = $this->db->get();
		return $this->getRow($query);
	}
	
	/**
	 * Registra un perfil de usuario
	 * @param array $datos Campos que se desean insertar
	 * @return int ID autonumérico asignado al perfil
	 */
	function Registrar_perfil($datos) {
		$this->db->insert('perfiles', $datos);
		return $this->db->insert_id();
	}
	
	/**
	 * Modifica un perfil existente
	 * @param int $id_perfil ID del perfil a modificar
	 * @param array $datos Campos que se desean modificar
	 */
	function Modificar_perfil($id_perfil, $datos) {
		$this->db->where('id_perfil', $id_perfil);
		$this->db->update('perfiles', $datos);
	}
}

/* Fin del archivo: usuario.php */
/* Ubicación: ./application/controllers/usuario.php */
