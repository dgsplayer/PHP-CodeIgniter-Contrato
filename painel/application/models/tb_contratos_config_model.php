<?php

class Tb_contratos_config_model extends CI_Model {

    private $_table = "tb_contratos_config";

    public function fetch_row(  )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function update()
    {

        $user           = $this->session->userdata('contrato_user');
        $data           = $this->input->post();

        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function insert()
    {
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['id_pessoa_pai']  = $user['id_pessoa'];

        if( $this->db->insert( $this->_table, $data) ) {
            return true;
        }
        return false;
    }
}