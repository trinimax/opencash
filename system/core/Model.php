<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
	
	/**
     * Devuelve un array con la información de una consulta
     * 
     * @param string $query Consulta SQL
     * @return array filas y columnas con la informaci‚àö‚â•n de la consulta
    */
    function get_array($query) {
    	$array = null;
        $i = 0;
        foreach($query->result() as $row) {
            $array[$i] = $row;
            $i++;
        }
        return $array;
    }
        
    /**
     * Devuelve un row con la información de una consulta
     * 
     * @param string $query Consulta SQL
     * @return Object fila con la informaci‚àö‚â•n de la consulta
     */
    function get_row($query) {
        $row = null;
        if($query->num_rows() > 0) {
            $row = $query->row();
        }
        return $row;
    }
	
	/**
	 * Devuelve el número de filas en la consulta
	 * @param string $query Consulta SQL
	 * @return int número de consultas
	 */
	function get_row_num($query) {
		return $query->num_rows();
	}
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */