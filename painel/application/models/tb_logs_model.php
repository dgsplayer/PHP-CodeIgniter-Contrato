<?php

class Tb_logs_model extends CI_Model {

	private $_table = "tb_logs";
	
	public function insert_history_cliente()
	{	
		$user = $this->session->userdata('contrato_user');

		$data = array( 'id_pessoa_principal' => $this->input->post('id_cliente'),
						 'acao' => 'Informação sobre cliente: ' . $this->input->post('historico'),
						 'id_pessoa_pai' => $user['id_pessoa'],
						 'id_usuario' => $user['id_usuario'] );
						 
		if( $this->db->insert( $this->_table, $data) ) {
			return true;
		}
		return false;
	}

    public function insert_history( $acao  = null)
    {
        $user = $this->session->userdata('contrato_user');

        $data = array(
            'acao'                  => $acao,
            'id_pessoa_pai'         => $user['id_pessoa'],
            'id_usuario'              => $user['id_usuario'] );

        $this->db->insert( $this->_table, $data);

    }

    public function fetch_noticias()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('*, r.email as admin');
        $this->db->where('t.id_pessoa_pai', $user["id_pessoa"] );
        $this->db->join('tb_usuarios as r', 'r.id_usuario = t.id_usuario', 'left');
        $this->db->order_by('t.id', 'DESC');

        $q = $this->db->get( $this->_table . ' as t');
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }



}