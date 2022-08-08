<?php

class Tb_usuarios_model extends CI_Model {

	private $_table = "tb_usuarios";

	public function atualizar_first_login()
	{
        $user = $this->session->userdata('contrato_user');
        // var_dump(@$user['id_usuario']);exit;
		$this->db->where('id_usuario', $user['id_usuario']);
		return $this->db->update($this->_table, array( 'senha' => md5( $this->input->post('senha')), 'first_login' => 't' ));
	}

//
//    public function fetch_select_usuarios()
//    {
////        $user = $this->session->userdata('contrato_user');
//        $this->db->select('id_usuario, usuario');
////        $this->db->where('id_pessoa', $user['id_pessoa'] );
//
//        $q = $this->db->get($this->_table);
//        $data = array();
//        if($q->num_rows > 0) {
//            foreach( $q->result() as $row ) {
//                $data[$row->id_usuario] = $row->usuario;
//            }
//            return $data;
//        }
//        return $data;
//    }

    //resgata login
    public function get_by_login($username=NULL, $password=NULL){
        if($username!=NULL && $password!=NULL){

            $this->db->select('tb_usuarios.*');
            $this->db->from('tb_usuarios');
            $this->db->where('email' , $username);
            $this->db->where('password' , $password);
            $this->db->where('ativo' , 'Sim');

            return $this->db->get()->result();
        }else{
            return false;
        }
    }


    /**
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function row($id)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('id_usuario', $id);
        $query = $this->db->get();
        if( $query->num_rows > 0 ) {
            return $query->row();
        }
        return false;

//        return $query->result_array();
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

        $this->db->group_by('id_usuario');
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('id_usuario', $order_type);
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

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_($search_string = null, $order = null)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        if ($search_string) {
            $this->db->like('name', $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('id_usuario', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function insert($data)
    {
        $insert = $this->db->insert($this->_table, $data);
        return $insert;
    }

    /**
     * Update manufacture
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update($id, $data)
    {
        $this->db->where('id_usuario', $id);
        $this->db->update($this->_table, $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete
     * @param int $id - manufacture id
     * @return boolean
     */
    function delete($id)
    {
        $this->db->where('id_usuario', $id);
        $this->db->delete($this->_table);

        $this->db->where('id_grupo', $id);
        $this->db->delete('tb_grupos_x_cliente');

    }


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
		// echo '<pre>' . var_export($q->row(),true);exit;

        if($q->num_rows > 0 ) {
            $this->set_session( $q->row() );
            return true;
        }
        return false;
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
        $this->db->where('id_usuario', $user['id_usuario']);
        $data_cad 			= date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H'). ':' . date('i');
        return $this->db->update($this->_table, array( 'data_atualizacao_notificacao' => $data_cad));
    }

    function set_session( $usuario ) {

//		$this->db->select('contratos_disponiveis, tem_boletos, tem_gestao');
//		$this->db->where('id_pessoa', $usuario->id_pessoa);
//		$q = $this->db->get( "tb_pessoas" );
//		$usuario_info = $q->row_array();

        $datas = array('nome_empresa'   => $usuario->usuario,
            'id_usuario'      => $usuario->id_usuario ,
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
        $this->db->select('id_usuario, email as login');
        $this->db->where('id_pessoa', $user['id_pessoa'] );
        $this->db->where('id_usuario <>', $user['id_usuario'] );
        $this->db->where('ativo', 'S' );
        $this->db->order_by('login');
 
        $data = array('Selecione uma op��o de E-mail');
        $q = $this->db->get( $this->_table );
        if($q->num_rows > 0 ) {
            foreach($q->result() as $row) {
                $data[ $row->id_usuario ] = $row->email;
            }
        }
        return $data;
    }

    public function fetch_select_admin()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select('id_usuario, email as login');  
        $this->db->where('id_pessoa', $user['id_pessoa'] );

        $q = $this->db->get($this->_table);
        $data = array();
        if($q->num_rows > 0) {
            foreach( $q->result() as $row ) {
                $data[$row->id_usuario] = $row->login;
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
        $this->db->order_by('usuario', 'DESC');

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
        $this->db->where('id_usuario' , $id_usuario);
        $this->db->where('id_pessoa', $user['id_pessoa'] );

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }


    public function fetch_responsavel_email_juridico()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select('id_usuario, email');
        $this->db->where('id_pessoa', $user['id_pessoa']);
        $this->db->order_by('email');
        $q = $this->db->get($this->_table);
        $data = array('' => 'Selecione uma op��o');
        if( $q->num_rows > 0 ) {
            foreach ($q->result() as $row) {
                $data[$row->id_usuario] = $row->email;
            }
        }
        return $data;
    }

}