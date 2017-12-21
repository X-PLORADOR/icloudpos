<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_api_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function verificar_usuario($data) {

        $query = $this->db->where('username', $data['username']);
        $query = $this->db->where('var_usuario_clave', $data['password']);
        $query = $this->db->where('usuario.activo', 1);
        $query = $this->db->where('usuario.deleted', 0);
        $query = $this->db->join('local', 'local.int_local_id=usuario.id_local', 'left');
        $query = $this->db->join('grupos_usuarios', 'grupos_usuarios.id_grupos_usuarios=usuario.grupo', 'left');
        $query = $this->db->get('usuario');

        return $query->row_array();
    }
}
