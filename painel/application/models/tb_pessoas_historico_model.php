<?php

class Tb_pessoas_historico_model extends CI_Model {

    private $_table = "tb_pessoas_historico";

    public function fetch_historicos( $id_pessoa = null)
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('t.*, r.email as admin');
        $this->db->where('t.id_pessoa_pai', $user["id_pessoa"] );
        $this->db->where('t.id_pessoa', $id_pessoa );
        $this->db->join('tb_usuarios as r', 'r.id_usuario = t.id_usuario');
        $this->db->order_by('t.id', 'DESC');

        $q = $this->db->get( $this->_table . ' as t');
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }

    public function fetch_row_historico( $id_historico )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id' , $id_historico);
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
        $data['id_usuario']       = $user['id_usuario'];

        if( $this->db->insert( $this->_table, $data) ) {
            return true;
        }
        return false;
    }

    public function delete( $id )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where( 'id', $id );
        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );

     
        if( $this->db->delete( $this->_table ) ) {
                //Grava Log
               $this->load->model('tb_logs_model');
        $this->tb_logs_model->insert_history('Removeu um histórico do cliente');


            return true;
        }
        return false;
    }
}