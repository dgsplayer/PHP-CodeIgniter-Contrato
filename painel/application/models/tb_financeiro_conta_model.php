<?php

class Tb_financeiro_conta_model extends CI_Model {

    private $_table = "tb_financeiro_conta";

	public function list_conta()
	{
		$user = $this->session->userdata('contrato_user');
		$this->db->select('id, nome');
		$this->db->where('id_pessoa_pai', $user['id_pessoa']);
		$this->db->order_by('nome');

		$data = array('' => 'Selecione uma opção');
		$q = $this->db->get( $this->_table );
		if($q->num_rows > 0 ) {
			foreach ($q->result() as $key => $row) {
				$data[$row->nome] = $row->nome;
			}
		}
		return $data;
	}

}