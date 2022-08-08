<?php

class Tb_orcamentos_model extends CI_Model {

	private $_table = "tb_orcamentos";

	public function fetch_orcamento()
	{
		$data = array();
		$this->db->select('o.*, p.nome as nome_cliente, p.email as email_pessoa, m.titulo as titulo_modelo')->from( $this->_table . ' as o');
		$this->db->join('tb_pessoas as p', 'o.id_pessoa = p.id_pessoa', 'left');
        $this->db->join('tb_orcamentos_modelos as m', 'o.id_modelo = m.id', 'left');
		$this->db->where('o.ativo', 1);
		$this->db->group_by('o.id_orcamento');
		$this->db->order_by('o.id_orcamento', 'DESC');

		$q = $this->db->get();
		if( $q->num_rows > 0 ) {
			foreach( $q->result() as $row) {
				$temp = (array) $row;
				$dataHoje = date('Y') . '/' . date('m') . '/' . date('d');
				$validade = date('Y/m/d', strtotime("+". $row->validade . " days", strtotime( $row->dt_cad )));
				$temp['color'] = '';
				if($validade < $dataHoje){
					$temp['color'] = 'style="color: #cc0000"';
				}
				$temp['validade'] = $validade;
				//$emailLinha     = (!empty($arrayEmail[$resCon['id_pessoa_principal']])) ? $arrayEmail[$resCon['id_pessoa_principal']] : $arrayEmailJ[$resCon['id_pessoa_principal']];
				$data[] = (object) $temp;
			}
		}
		return $data;
	}

	public function fetch_row( $id_orcamento = null)
	{
		$this->db->select('o.*, p.nome as nome_cliente, p.email as email_pessoa');
		$this->db->join('tb_pessoas as p ', 'p.id_pessoa= o.id_pessoa');
		$this->db->where('o.id_orcamento' , $id_orcamento);
//		$this->db->where('o.ativo', 1);

		$q = $this->db->get( $this->_table .' as o');
		if( $q->num_rows > 0 ) {
			return $q->row();
		}
		return false;
	}

	public function fetch_cliente( $id_orcamento )
	{
		$this->db->select('p.*');
		$this->db->where('id_orcamento', $id_orcamento );
		$this->db->join('tb_pessoas as p', 'o.id_pessoa_principal = p.id_pessoa', 'left');
		$q = $this->db->get( $this->_table . ' as o');
		if( $q->num_rows > 0 ) {
			return $q->row();
		}
		return false;
	}

	public function update( )
	{
		$data = $this->input->post();
		$this->db->where('id_orcamento', $this->input->post('id_orcamento'));
		unset( $data['id_orcamento'] );

		if( $this->db->update( $this->_table, $data ) ) {
            //Grava Log
//            $this->load->model('tb_logs_model');
//            $this->tb_logs_model->insert_history('Atualizou orçamento ' . $this->input->post('id_orcamento'));

			return true;
		}
		return false;
	}

	public function delete( $id )
	{	
//		$user = $this->session->userdata('contrato_user');
		$this->db->where( 'id_orcamento', $id );
		if( $this->db->update( $this->_table, array('ativo' => 0) ) ) {
            //Grava Log
//            $this->load->model('tb_logs_model');
//            $this->tb_logs_model->insert_history('Deletou proposta ' . $id);
			return true;
		}
		return false;
	}

    public function deletePreVisualizar( $id )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where( 'id_orcamento', $id );
        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
        if( $this->db->delete( $this->_table) ) {

            return true;
        }
        return false;
    }

	public function insert()
	{
		$data = $this->input->post();


		$data['dt_cad'] = date('Y') . '-' . date('m') . '-' . date('d');

        $user = $this->session->userdata('contrato_user');

		$data['id_usuario'] = $user["id_usuario"];

        //serviços
        if(!empty($data['servicos'])) {

            $this->db->select('*');

            $this->db->where('id',$data['servicos']);
            $q = $this->db->get('tb_orcamentos_modelos');
            if( $q->num_rows > 0 ) {
                foreach( $q->result() as $row ) {
                    $data['descricao']      = $row->descricao ;
                    $data['validade']       = $row->validade ;
                    $data['valor_total']    = $row->valor_total ;
                    $data['prazo']          = $row->prazo ;
                    $data['observacao']     = $row->observacao ;
                    $data['condicoes_pagamento']  = $row->condicoes_pagamento ;
                    $data['condicoes_gerais']  = $row->condicoes_gerais ;
                }
            }
        }

        $data['id_modelo'] = $data['servicos'];
        //enviar email
        unset($data['email']);
        unset($data['servicos']);
		unset($data['id_orcamento']);
        unset($data['botao_gravar']);

		if( $this->db->insert( $this->_table, $data) ) {

			return true;
		}
		return false;
	}

    public function fetch_orcamento_by_cliente_id( $id_pessoa )
    {

        $this->db->select('*')->from( $this->_table . ' as o');
        $this->db->where('o.ativo', 1);
        $this->db->where('o.id_pessoa', $id_pessoa);
        $this->db->order_by('o.id_orcamento', 'DESC');

        $q = $this->db->get();
        return $q->result();
    }

    public function fetch_select_emails( $id_orcamento )
    {

        $this->db->select('*')->from( 'tb_orcamentos_emails as o');
        $this->db->where('o.id_orcamento', $id_orcamento);
        $this->db->order_by('o.id', 'DESC');

        $q = $this->db->get();
        return $q->result();
    }

    public function rows($search_string = null, $order = null, $order_type = 'Asc', $limit_start = null, $limit_end = null)
    {

        $this->db->select('*');
        $this->db->from($this->_table);
        if ($search_string) {
            $this->db->where('id_pessoa', $search_string);
        }
        $this->db->group_by('id');
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('id_grupo', $order_type);
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
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function row($table, $id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_pessoa', $id);
        $query = $this->db->get();
        if( $query->num_rows > 0 ) {
            return $query->row();
        }
        return false;

//        return $query->result_array();
    }
}