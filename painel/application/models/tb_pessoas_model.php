<?php

class Tb_pessoas_model extends CI_Model {

	private $_table = "tb_pessoas";

	public function insert( $tipo_pessoa )
	{
		$user = $this->session->userdata('contrato_user');

		$data = $this->input->post();
		$data['atividade'] = implode( "-", array_reverse( explode( "/", $this->input->post('atividade') ) ) ); 
		if( empty( $data['atividade'] ) ) $data['atividade'] = '0000-00-00';
		
		$data['nome'] = strtoupper(trim($this->input->post('nome')));
		$data['tipo_pessoa'] = $tipo_pessoa;
		$data['data_cad'] = date('Y') . '-' . date('m') . '-' . date('d');
		$data['id_pessoa_pai'] = $user['id_pessoa'];
		$data['id_usuario_criador'] = $user['id_usuario'];

		//evita cadastrar informações do outro tipo de pessoa
        switch ( $data['pessoa'] ) {
            case 'F':
                unset( $data['razao'] );
                unset( $data['cnpj'] );
                unset( $data['email_j'] );
                unset( $data['telefone_principal'] );
                break;
            case 'J':
                unset( $data['profissao'] );
                unset( $data['rg'] );
                unset( $data['cpf'] );
                unset( $data['telefone'] );
                unset( $data['email'] );
                unset( $data['responsavel'] );
                unset( $data['email_responsavel'] );
                unset( $data['rgContato'] );
                unset( $data['cpfContato'] );
                unset( $data['nacionalidade'] );
                unset( $data['civil'] );
                unset( $data['telefoneContato'] );
                unset( $data['celularContato'] );
                unset( $data['cepContato'] );
                unset( $data['logradouroContato'] );
                unset( $data['numeroContato'] );
                unset( $data['bairroContato'] );
                unset( $data['complementoContato'] );
                unset( $data['cidadeContato'] );
                $data['nome'] = strtoupper(trim($this->input->post('razao')));
                break;
        }

		unset( $data['id_pessoa'] );

		if( $this->db->insert( $this->_table, $data) ) {
			return true;
		}
		return false;
	}

	public function insert_all( $dados )
	{
		return $this->db->insert( $this->_table, $dados);
	}
	
	public function delete( $id )
	{	
		$user = $this->session->userdata('contrato_user');
		$this->db->where( 'id_pessoa', $id );
		$this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
		if( $this->db->update( $this->_table, array('ativo' => 0) ) ) {
			return true;
		}
		return false;
	}

	public function update( $tipo_pessoa )
	{	
		$user = $this->session->userdata('contrato_user');

		$data = $this->input->post();
		$data['atividade'] = implode( "-", array_reverse( explode( "/", $this->input->post('atividade') ) ) ); 
		if( empty( $data['atividade'] ) ) $data['atividade'] = '0000-00-00';
		
		$data['nome'] = strtoupper(trim($this->input->post('nome')));
		$data['tipo_pessoa'] = $tipo_pessoa;
		$data['data_cad'] = date('Y') . '-' . date('m') . '-' . date('d');
		$data['id_pessoa_pai'] = $user['id_pessoa'];
		$data['id_usuario_criador'] = $user['id_usuario'];
		$razao = trim($this->input->post('razao'));
		if( !empty( $razao  ) ) $data['nome'] = $razao;

		$this->db->where( 'id_pessoa', $this->input->post('id_pessoa') );
		unset( $data['id_pessoa'] );
		if( $this->db->update( $this->_table, $data ) ) {
			return true;
		}
		return false;
	}

	public function fetch_by_name( $nome )
	{	
		$user = $this->session->userdata('contrato_user');
		$this->db->select(' id_pessoa, nome as label,');
		$this->db->like('LOWER(nome)', strtolower($nome));
		$this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
        $this->db->order_by('nome');
		$q = $this->db->get( $this->_table );

		//echo $this->db->last_query();exit();
		$data = array();
		if( $q->num_rows > 0 ) {
			return $q->result();
		}
		return false;
	}

	public function fetch_row( $id_cliente, $tipo_pessoa = null )
	{	
		$user = $this->session->userdata('contrato_user');

		$this->db->where('id_pessoa' , $id_cliente);
		$this->db->where('id_pessoa_pai', $user['id_pessoa'] );
        if(!empty($tipo_pessoa))
		    $this->db->where('tipo_pessoa', $tipo_pessoa );
//		$this->db->where('ativo', 1);

		$q = $this->db->get( $this->_table );
		if( $q->num_rows > 0 ) {
			return $q->row();
		}
		return false;
	}

	public function fetch_fornecedor()
	{	
		$data = array();
		$user = $this->session->userdata('contrato_user');

		$this->db->select('id_pessoa, cpf, nome, telefone, cnpj, razao, telefone_principal, data_cad, celular, status, pessoa');
		$this->db->where('id_pessoa_pai', $user['id_pessoa'] );
		$this->db->where('tipo_pessoa', 'FORNECEDOR');
		$this->db->where('ativo', 1);

		$q = $this->db->get( $this->_table );
		if( $q->num_rows > 0 ) {
            foreach( $q->result() as $row ) {
                switch ( strtoupper( $row->pessoa ) ) {
                    case 'F':
                        $clienteIncompleto = (empty($row->cpf) || empty($row->nome)  || empty($row->telefone)  ) ? '<i class="fa fa-ban"></i>' : '' ;
                        $data[] = (object) array( 'cpf_cnpj' => $row->cpf,
                            'nome' => $row->nome,
                            'telefone' => $row->telefone,
                            'clienteIncompleto' => $clienteIncompleto,
                            'data_cad' => $row->data_cad,
                            'status' => $row->status, 'id_pessoa' => $row->id_pessoa );
                        break;
                    case 'J':
                        $clienteIncompleto = (empty($row->cnpj) || empty($row->razao)  || empty($row->telefone_principal)  ) ? '<i class="fa fa-ban"></i>' : '' ;
                        $data[] = (object) array( 'cpf_cnpj' => $row->cnpj,
                            'nome' => $row->razao,
                            'telefone' => $row->telefone_principal,
                            'clienteIncompleto' => $clienteIncompleto,
                            'data_cad' => $row->data_cad,
                            'status' => $row->status , 'id_pessoa' => $row->id_pessoa );
                        break;
                }
            }
			return $data;
		}
		return $data;
	}

    public function fetch_cliente()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('id_pessoa, cpf, nome, telefone, cnpj, razao, telefone_principal, data_cad, celular, status, pessoa, estado_civil,email');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where('tipo_pessoa', 'CLIENTE');
        $this->db->where('ativo', 1);

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            foreach( $q->result() as $row ) {

                switch ( strtoupper( $row->pessoa ) ) {
                    case 'F':
                        $clienteIncompleto = (empty($row->cpf) || empty($row->nome)  || empty($row->telefone)  ) ? '<i class="fa fa-ban"></i>' : '' ;
                        $data[] = (object) array( 'cpf_cnpj' => $row->cpf,
                            'nome' => $row->nome,
                            'telefone' => $row->telefone,
                            'clienteIncompleto' => $clienteIncompleto,
                            'data_cad' => $row->data_cad,
                            'status' => $row->status, 'id_pessoa' => $row->id_pessoa );
                        break;
                    case 'J':
                        $clienteIncompleto = (empty($row->cnpj) || empty($row->razao)  || empty($row->telefone_principal)  ) ? '<i class="fa fa-ban"></i>' : '' ;
                        $data[] = (object) array( 'cpf_cnpj' => $row->cnpj,
                            'nome' => $row->razao,
                            'telefone' => $row->telefone_principal,
                            'clienteIncompleto' => $clienteIncompleto,
                            'data_cad' => $row->data_cad,
                            'status' => $row->status , 'id_pessoa' => $row->id_pessoa );
                        break;
                }

            }

            return $data;
        }
        return $data;
    }

	public function fetch_select_cliente()
	{	
        $user = $this->session->userdata('contrato_user');
        // echo '<pre>'.var_export($user,true);exit;

		$this->db->select('id_pessoa, nome');
		$this->db->where('id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where("(telefone <> '' or telefone_principal <> '' )");
        $this->db->where("(cnpj <> '' or cpf <> '' )");
        $this->db->where("(nome <> '' or razao <> '' )");
		$this->db->where('tipo_pessoa', 'CLIENTE');
//		$this->db->where('tipo_pessoa', 'CLIENTE');
		$this->db->where('ativo', 1);
        $this->db->order_by('nome');

		$q = $this->db->get($this->_table);
		$data = array('' => 'Selecione um cliente com cadastro completo (Com CNPJ/CPF + Nome/Razão Social + Telefone)');
		if($q->num_rows > 0) {
			foreach( $q->result() as $row ) {
				$data[$row->id_pessoa] = $row->nome;
			}
			return $data;
		}
		return $data;
	}

    public function fetch_select_fornecedor()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->select('id_pessoa, nome');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where("(telefone <> '' or telefone_principal <> '' )");
        $this->db->where("(cnpj <> '' or cpf <> '' )");
        $this->db->where("(nome <> '' or razao <> '' )");
        $this->db->where('tipo_pessoa', 'FORNECEDOR');
//		$this->db->where('tipo_pessoa', 'CLIENTE');
        $this->db->where('ativo', 1);
        $this->db->order_by('nome');

        $q = $this->db->get($this->_table);
        $data = array('' => 'Selecione um fornecedor com cadastro completo');
        if($q->num_rows > 0) {
            foreach( $q->result() as $row ) {
                $data[$row->id_pessoa] = $row->nome;
            }
            return $data;
        }
        return $data;
    }

    public function fetch_select_cliente_com_inativos()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->select('id_pessoa, nome');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

		$this->db->order_by('nome');
		
        $q = $this->db->get($this->_table);
        $data = array('' => 'Selecione um cliente');
        if($q->num_rows > 0) {
            foreach( $q->result() as $row ) {
                $data[$row->id_pessoa] = $row->nome;
            }
            return $data;
        }
        return $data;
    }

	public function fetch_pessoapai()
	{	
		$data = array();
		$user = $this->session->userdata('contrato_user');

		$this->db->select('id_pessoa, cpf, nome, telefone, cnpj, razao, telefone_principal, data_cad, celular, status, pessoa');
		$this->db->where('id_pessoa_pai', $user['id_pessoa'] );
		$this->db->where('ativo', 1);

		$q = $this->db->get( $this->_table );
		if( $q->num_rows > 0 ) {
			foreach( $q->result() as $row ) {
				switch ( strtoupper( $row->pessoa ) ) {
					case 'F':
						$clienteIncompleto = (empty($row->cpf) || empty($row->nome)  || empty($row->telefone)  ) ? '<i class="fa fa-ban"></i>' : '' ;
						$data[] = (object) array( 'cpf_cnpj' => $row->cpf,
												  'nome' => $row->nome, 
												  'telefone' => $row->telefone, 
												  'clienteIncompleto' => $clienteIncompleto,
												  'data_cad' => $row->data_cad,
												  'status' => $row->status, 'id_pessoa' => $row->id_pessoa );
					break;	
					case 'J':
						$clienteIncompleto = (empty($row->cnpj) || empty($row->razao)  || empty($row->telefone_principal)  ) ? '<i class="fa fa-ban"></i>' : '' ;
						$data[] = (object) array( 'cpf_cnpj' => $row->cnpj, 
												  'nome' => $row->razao, 
												  'telefone' => $row->telefone_principal, 
												  'clienteIncompleto' => $clienteIncompleto, 
												  'data_cad' => $row->data_cad,
												  'status' => $row->status , 'id_pessoa' => $row->id_pessoa );
					break;
				}
			}
			return $data;
		}
		return $data;
	}


	public function contratada()
	{	
		$user = $this->session->userdata('contrato_user');

		$this->db->where('id_pessoa', $user["id_pessoa"] );
		$this->db->limit(1);
		$q = $this->db->get( $this->_table );
		if($q->num_rows > 0) {			
			return $q->row();
		}
	}

    public function contratonet()
	{	

		$this->db->where('id_pessoa', 100900 );
		$this->db->limit(1);
		$q = $this->db->get( $this->_table );
		if($q->num_rows > 0) {			
			return $q->row();
		}
	}

	public function contratoPessoa( $id_pessoa_principal )
	{	

		$this->db->where('id_pessoa', $id_pessoa_principal);

		$q = $this->db->get( $this->_table );
		if($q->num_rows > 0) {			
			return $q->row();
		}
	}

    public function update_pessoa_pai()
    {
        $user = $this->session->userdata('contrato_user');

        $data = $this->input->post();
        unset($data['imagem']);
        $this->db->where( 'id_pessoa', $user['id_pessoa'] );

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function update_assinatura($arquivo = null)
    {
        $user = $this->session->userdata('contrato_user');

        $data = array();
        $data['imagem_assinatura'] = $arquivo;

        $this->db->where( 'id_pessoa', $user['id_pessoa'] );

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function update_rubrica($arquivo = null)
    {
        $user = $this->session->userdata('contrato_user');

        $data = array();
        $data['imagem_rubrica'] = $arquivo;

        $this->db->where( 'id_pessoa', $user['id_pessoa'] );

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function clientes_juridico()
    {

		$user = $this->session->userdata('contrato_user');

		$this->db->select('id_pessoa, nome');
		$this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
		$this->db->where( 'status', 'ATIVO' );
		$this->db->where( 'tipo_pessoa', 'CLIENTE' );
		$this->db->order_by('nome');
		$q = $this->db->get( $this->_table );

		$data = array('' => 'Selecione uma opção' );
		if( $q->num_rows > 0 ) {
			foreach($q->result() as $row) {
				$data[$row->id_pessoa] = $row->nome;
			}
		}
		return $data;

    }

    public function count_clientes_incompletos()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->select('count(*) as total');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

        $this->db->where('(cnpj is null OR telefone_principal is null OR razao is null) OR (cpf is null OR telefone is null OR nome is null)');

        $this->db->where('tipo_pessoa', 'CLIENTE');
        $this->db->where('ativo', 1);

        $q = $this->db->get( $this->_table );
        if($q->num_rows > 0) {
            return $q->row();
        }

        return false;
    }

    public function fetch_all_contrato_cliente()
    {
    	$user = $this->session->userdata('contrato_user');

    	$this->db->select('tc.id_contrato, tc.cod_contrato, tp.nome');
    	$this->db->from('tb_contratos tc, tb_pessoas tp');
    	$this->db->where('tc.id_pessoa_principal = tp.id_pessoa');
    	$this->db->where('tc.id_pessoa_pai', $user['id_pessoa'] );
		$q = $this->db->get( $this->_table );

		$data = array('' => 'Selecione uma opção' );
        if($q->num_rows > 0) {
        	foreach($q->result() as $row) {
        		$data[ $row->id_contrato ] = $row->cod_contrato . ' - ' . $row->nome;
        	}
        }
        return $data;
    }

    public function lista_clientes()
	{
		$user = $this->session->userdata('contrato_user');
		$this->db->select('id_pessoa, nome');
		$this->db->where('id_pessoa_pai', $user['id_pessoa']);
		$this->db->where('status', 'ATIVO');
		$this->db->order_by('tipo_pessoa,nome');

		$data = array('' => 'Selecione uma opção');
		$q = $this->db->get( $this->_table );
		if($q->num_rows > 0 ) {
			foreach ($q->result() as $key => $row) {
				$data[$row->id_pessoa] = $row->nome;
			}
		}
		return $data;
	}

    public function lista_clientes_inativos()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('id_pessoa, cpf, nome, telefone, cnpj, razao, telefone_principal, data_cad, celular, status, pessoa, estado_civil');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where('tipo_pessoa', 'CLIENTE');
        $this->db->where('ativo', 0);

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            foreach( $q->result() as $row ) {

                switch ( strtoupper( $row->pessoa ) ) {
                    case 'F':
                        $clienteIncompleto = (empty($row->cpf) || empty($row->nome)  || empty($row->telefone)  ) ? '<i class="fa fa-ban"></i>' : '' ;
                        $data[] = (object) array( 'cpf_cnpj' => $row->cpf,
                            'nome' => $row->nome,
                            'telefone' => $row->telefone,
                            'clienteIncompleto' => $clienteIncompleto,
                            'data_cad' => $row->data_cad,
                            'status' => $row->status, 'id_pessoa' => $row->id_pessoa );
                        break;
                    case 'J':
                        $clienteIncompleto = (empty($row->cnpj) || empty($row->razao)  || empty($row->telefone_principal)  ) ? '<i class="fa fa-ban"></i>' : '' ;
                        $data[] = (object) array( 'cpf_cnpj' => $row->cnpj,
                            'nome' => $row->razao,
                            'telefone' => $row->telefone_principal,
                            'clienteIncompleto' => $clienteIncompleto,
                            'data_cad' => $row->data_cad,
                            'status' => $row->status , 'id_pessoa' => $row->id_pessoa );
                        break;
                }

            }

            return $data;
        }
        return $data;
    }

}