<?php

class Tb_avisos_model extends CI_Model {

    private $_table = "tb_avisos";


    public function fetch_all()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id_pessoa_pai', $user['id_usuario'] );
        $this->db->where('lido', 'f');

        $q = $this->db->get($this->_table);
        return $q->result();
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

        $data['id_usuario']  = $user['id_usuario'];

        if( $this->db->insert( $this->_table, $data) ) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['id_usuario'] = $user['id_usuario'];

        $this->db->where( 'id', $this->input->post('id') );
        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function updateLido( $id )
    {
        $user = $this->session->userdata('contrato_user');

        $data['lido']       = 't';
        $data['id_pessoa_pai']   = $user['id_pessoa'];

        $this->db->where( 'id', $id );
        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function custon_insert($data)
    {
        $user = $this->session->userdata('contrato_user');
        $data['id_pessoa_pai']  = $user['id_usuario'];
        if( $this->db->insert( $this->_table, $data) ) {
            return true;
        }
        return false;
    }
}