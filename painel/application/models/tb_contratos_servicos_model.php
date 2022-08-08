<?php

class Tb_contratos_servicos_model extends CI_Model {

    private $_table = "tb_contratos_servicos";

    public function fetch_servicos()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('tb_contratos_servicos.*');
        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );
        $this->db->order_by('id', 'DESC');

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }

    public function fetch_row_servicos( $id_servico )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id' , $id_servico);
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
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

    public function update()
    {
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['id_pessoa_pai'] = $user['id_pessoa'];

        $this->db->where( 'id', $this->input->post('id') );
        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }
}