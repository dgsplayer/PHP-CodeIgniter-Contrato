<?php

class Tb_admin_model extends CI_Model {

	private $_table = "tb_admin";

	function valida_usuario() {
		$this->db->where( 'login', $this->input->post('login') );
		$this->db->where( 'senha', md5( $this->input->post('senha') ) );
		$q = $this->db->get( $this->_table );
		
		if($q->num_rows > 0 ) {
			$this->set_session( $q->row() );
			return true;
		}
		return false;
	}

	function set_session( $usuario ) {

		$this->db->select('contratos_disponiveis, tem_boletos, tem_gestao');
		$this->db->where('id_pessoa', $usuario->id_pessoa);
		$q = $this->db->get( "tb_pessoas" );
		$usuario_info = $q->row();

        $datas = array('nome_empresa' => $usuario->nome,
						'id_usuario' => $usuario->id ,
						'first_login' => $usuario->first_login,
						'check_parcial'=> $usuario->check_parcial,
						'check_rating'=> $usuario->check_rating,
						'login'=> $usuario->login,
						'id_pessoa'=> $usuario->id_pessoa,
						'nivel'=> $usuario->nivel,
						'color_menu'=> $usuario->color_menu,
						'id_pessoa' => $usuario->id_pessoa,
						'tipo_usuario' => (int) $usuario->id_tipo_usuario,
						'sistema_session' => true,
						'is_logged_in' => true );
        if( $usuario_info ) {
        	$t = array('contratos_disponiveis'=> $usuario_info->contratos_disponiveis,
						'tem_boletos'=> $usuario_info->tem_boletos,
						'tem_gestao'=> $usuario_info->tem_gestao);
        	array_push($usuario_info, $t);
        }

		$this->session->set_userdata( $datas );
	}

	public function get_admin_contato()
	{
		$this->db->select('id, login');
		$this->db->where('id_pessoa', $this->session->userdata('id_pessoa') );
		$this->db->where('id <>', $this->session->userdata('id_usuario') );
		$this->db->where('ativo', 'S' );
		$this->db->order_by('login');

		$data = array('Selecione uma opção de E-mail');
		$q = $this->db->get( $this->_table );
		if($q->num_rows > 0 ) {
			foreach($q->result() as $row) {
				$data[ $row->id ] = $row->login;
			}
		}
		return $data;
	}

    public function fetch_select_admin()
    {
        $this->db->select('id, login');
        $this->db->where('id_pessoa', $this->session->userdata('id_pessoa') );

        $q = $this->db->get($this->_table);
        $data = array();
        if($q->num_rows > 0) {
            foreach( $q->result() as $row ) {
                $data[$row->id] = $row->login;
            }
            return $data;
        }
        return $data;
    }

}