<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cajas_api_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_cuenta($id)
    {
        return $this->db->get_where('caja_desglose', array('id' => $id))->row();
    }

    function update_saldo($id, $saldo, $ingreso = TRUE)
    {
        $cuenta = $this->get_cuenta($id);

        if ($ingreso == TRUE) {
            $new_saldo = $cuenta->saldo + $saldo;
        } elseif ($ingreso == FALSE) {
            $new_saldo = $cuenta->saldo - $saldo;
        }

        if ($new_saldo >= 0) {
            $this->db->where('id', $id);
            $this->db->update('caja_desglose', array('saldo' => $new_saldo));
        }
    }

    function save_pendiente($data, $id_usuario){

        $this->db->insert('caja_pendiente', array(
            'caja_desglose_id'=>$this->get_valid_cuenta_id($data['moneda_id'], $data['local_id']),
            'usuario_id'=>$id_usuario,
            'tipo'=>$data['tipo'],
            'monto'=> $data['monto'],
            'estado'=>0,
            'IO'=>$data['IO'],
            'ref_id'=>$data['ref_id']
        ));
    }
}
