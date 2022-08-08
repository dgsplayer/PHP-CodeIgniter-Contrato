<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl_permissao extends CI_Model {

	private $_table = "acl_permissao";

	public function getPermissaoPorGrupo( $id_grupo )
	{	
		$this->db->select('r.regra, p.ativo');
		$this->db->where('id_grupo', $id_grupo);
		$this->db->join('acl_regras as r', 'r.id = p.id_regra');
		$q = $this->db->get( $this->_table . ' as p');
		$data = array();
		if($q->num_rows> 0) {
			foreach( $q->result() as $row) {
				if( $row->ativo ) {
					$data[] = $row->regra;
				}
			}
		}
		return $data;
	}

}