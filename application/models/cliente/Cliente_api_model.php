<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_api_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_all()
    {
        $result = $this->db->select('*')
            ->from('cliente')
            ->join('grupos_cliente', 'grupos_cliente.id_grupos_cliente=cliente.grupo_id')
            ->join('ciudades c', 'c.ciudad_id=cliente.ciudad_id', 'left')
            ->where('cliente_status', 1)
            ->get()->result();

        return $result;
    }
}