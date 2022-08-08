<?php

class Tb_bancos_model extends CI_Model {

    private $_table = "tb_pessoas_bancos";

    public function fetch_bancos()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );
        $this->db->order_by('id', 'DESC');

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }


    public function fetch_row( $banco = null)
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );
        if(!empty($banco))
            $this->db->where('banco', $banco );
        $this->db->order_by('id', 'DESC');

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return $data;
    }
}