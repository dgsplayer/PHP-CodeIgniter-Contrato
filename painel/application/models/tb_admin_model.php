<?php

class Tb_admin_model extends CI_Model {

	private $_table = "tb_admin";

	function valida_usuario() {

        $this->db->select('ta.*, tp.login_temporario');
        $this->db->join('tb_pessoas as tp', 'tp.id_pessoa = ta.id_pessoa');
        $this->db->where( 'ta.ativo', 'S');
        $this->db->where( 'tp.status', 'ATIVO');
        $this->db->where( '(tp.login_temporario = 0 OR (tp.login_temporario = 1 AND tp.data_cad > DATE_SUB(current_date, INTERVAL 31 DAY)))');
		$this->db->where( 'ta.email', $this->input->post('login') );
		$this->db->where( 'ta.senha', md5( $this->input->post('senha') ) );

//        echo $this->input->post('senha') .'-';
//        echo md5( $this->input->post('senha') );exit;

		$q = $this->db->get( $this->_table . ' as ta');
//		echo '<pre>' . var_export($q->row(),true);exit;

		if($q->num_rows > 0 ) {
			$this->set_session( $q->row() );
			return true;
		}
		return false;
	}

	public function atualizar_first_login()
	{
		$user = $this->session->userdata('contrato_user');
		$this->db->where('id', $user['id_usuario']);
		return $this->db->update($this->_table, array( 'senha' => md5( $this->input->post('senha')), 'first_login' => 't' ));
	}

    public function atualiza_senha( )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id', $user['id_usuario']);
        return $this->db->update($this->_table, array( 'senha' =>  $this->input->post('senha')));
    }

    public function atualiza_data_notificacao()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id', $user['id_usuario']);
        $data_cad 			= date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H'). ':' . date('i');
        return $this->db->update($this->_table, array( 'data_atualizacao_notificacao' => $data_cad));
    }

	function set_session( $usuario ) {

//		$this->db->select('contratos_disponiveis, tem_boletos, tem_gestao');
//		$this->db->where('id_pessoa', $usuario->id_pessoa);
//		$q = $this->db->get( "tb_pessoas" );
//		$usuario_info = $q->row_array();
		
        $datas = array('nome_empresa'   => $usuario->nome,
						'id_usuario'      => $usuario->id ,
						'first_login'   => $usuario->first_login,
						'check_parcial' => $usuario->check_parcial,
						'email'         => $usuario->email,
						'login_temporario'         => $usuario->login_temporario,
						'id_pessoa'     => $usuario->id_pessoa,
						'nivel'         => $usuario->nivel,
//						'color_menu'    => $usuario->color_menu,
						'tipo_usuario'  => (int) $usuario->id_tipo_usuario,
						'first_login'   => $usuario->first_login,
						'sistema_session' => true,
            'id_admin'      => $usuario->id ,
						'is_logged_in'  => true );

//        if( count($usuario_info) ) {
//        	array_push($datas, $usuario_info);
//        }

		$this->session->set_userdata( 'contrato_user', $datas );

		//verifica first_login
		if( $usuario->first_login == 'f') {
			redirect('login/primeiro_acesso');exit();
		}

        //Grava Log
        $this->load->model('tb_logs_model');
        $this->tb_logs_model->insert_history('Acessou o Sistema');
	}

	public function get_admin_contato()
	{
		$user = $this->session->userdata('contrato_user');
		$this->db->select('id, email as login');
		$this->db->where('id_pessoa', $user['id_pessoa'] );
		$this->db->where('id <>', $user['id_usuario'] );
		$this->db->where('ativo', 'S' );
		$this->db->order_by('login');

		$data = array('Selecione uma opção de E-mail');
		$q = $this->db->get( $this->_table );
		if($q->num_rows > 0 ) {
			foreach($q->result() as $row) {
				$data[ $row->id ] = $row->email;
			}
		}
		return $data;
	}
	
	public function fetch_select_admin()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select('id, email as login');
        $this->db->where('id_pessoa', $user['id_pessoa'] );

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

    public function fetch_row_email( $email )
    {
        $this->db->where('email' , $email);

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function fetch_results()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('*');
        $this->db->where('id_pessoa', $user['id_pessoa'] );
        $this->db->order_by('login', 'DESC');

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }

    public function fetch_row( $id_usuario )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select('*');
        $this->db->where('id' , $id_usuario);
        $this->db->where('id_pessoa', $user['id_pessoa'] );

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function update( )
    {
        $data = $this->input->post();
        $this->db->where('id', $this->input->post('id'));
        unset( $data['id'] );
        if( $this->db->update( $this->_table, $data ) ) {
            //Grava Log
            $this->load->model('tb_logs_model');
            $this->tb_logs_model->insert_history('Atualizou usuário ' . $data['nome_usuario']);
            return true;
        }
        return false;
    }

    public function insert()
    {
        $data = $this->input->post();
        $user = $this->session->userdata('contrato_user');

        $data['data_cad']           = date('Y') . '-' . date('m') . '-' . date('d');
        $data['id_pessoa']          = $user['id_pessoa'];
        $data['nome']               = $user['nome_empresa'];

        if( $this->db->insert( $this->_table, $data) ) {
            //Grava Log
            $this->load->model('tb_logs_model');
            $this->tb_logs_model->insert_history('Inseriu usuário ' . $data['nome_usuario']);
            return true;
        }
        return false;
    }

    public function fetch_responsavel_email_juridico()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select('id, email');
        $this->db->where('id_pessoa', $user['id_pessoa']);
        $this->db->order_by('email');
        $q = $this->db->get($this->_table);
        $data = array('' => 'Selecione uma opção');
        if( $q->num_rows > 0 ) {
            foreach ($q->result() as $row) {
                $data[$row->id] = $row->email;
            }
        }
        return $data;
    }

    /**
     * Fetch all data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function rows($search_string = null, $order = null, $order_type = 'Asc', $limit_start = null, $limit_end = null)
    {

        $this->db->select('*');
        $this->db->from($this->_table);
        if ($search_string) {
            $this->db->where('id_grupo', $search_string);
        }
        $this->db->group_by('id');
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('id', $order_type);
        }
        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

}