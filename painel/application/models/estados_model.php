<?php

class Estados_model extends CI_Model {
	
	public $_table = "estados";
	
	function form_all() {

		$q = $this->db->get($this->_table);
		$data=array('' => 'Selecione uma opção');
		if($q->num_rows > 0) {
			foreach ($q->result() as $row) {
				$data[ $row->uf ] = $row->nome;
			}
		}
		return $data;
	}
	
}