<?php

class Tb_contratos_model extends CI_Model {

    private $_table = "tb_contratos";

    public function fetch_contratos()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('tb_contratos.*, CASE WHEN (MONTH(dt_expiracao) <= MONTH(curdate()) OR MONTH(dt_expiracao) = MONTH(curdate())+1) and YEAR(dt_expiracao) = YEAR(curdate()) THEN "1" ELSE "0" END as diferenca', false);
        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );
        $this->db->order_by('dt_cad', 'DESC');

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }

    public function insert()
    {
        $data = $this->input->post();
        //VIGENCIA
        $this->load->helper('funcoes');

        if(!empty($data['data_inicio_contrato'])) {
            $data['data_inicio_contrato']   =  implode( "-", array_reverse( explode( "/", $this->input->post('data_inicio_contrato') ) ) );
        }

        if(!empty($data['data_vigencia_contrato'])) {

            $data['data_inicio_contrato']   =  substr($this->input->post('data_vigencia_contrato') ,0,10);
            $data['data_inicio_contrato']   =  implode( "-", array_reverse( explode( "/", $data['data_inicio_contrato'] ) ) );

            $data['dt_expiracao']   =  substr($this->input->post('data_vigencia_contrato') ,13,10);
            $data['dt_expiracao']   =  implode( "-", array_reverse( explode( "/", $data['dt_expiracao'] ) ) );

        }

		if(!empty($data['diadomes'])) {
            $data['diadomes']   =  implode( "-", array_reverse( explode( "/", $this->input->post('diadomes') ) ) ); 
        }


        $data['valor_total']    =  formata_decimal($this->input->post('valor_total'));
        $data['entrada']        =  formata_decimal($this->input->post('entrada'));
        $data['tipo_pessoa']    =  strtoupper($data['tipoContrato']) ;
        //retirar
        unset($data['data_vigencia_contrato']);
        unset($data['diaentrada']); //resolver depois
        unset($data['servico']); //resolver depois
        unset($data['tipoContrato']);
        unset($data['prazo_contrato']);
        unset($data['tipo_data']);
        unset($data['data_parcela']);
        unset($data['valor_parcela']);
        unset($data['num_parcela']);
        unset($data['botao_gravar']);


        $user = $this->session->userdata('contrato_user');

        //inserção texto e texto base
        $this->db->select('texto, texto_base_objeto');
        $this->db->where('id_pessoa_pai' , $user['id_pessoa']);
        $q = $this->db->get('tb_contratos_tipos_x_pessoas');
        if( $q->num_rows > 0 ) {

            $this->load->model('tb_contratos_design_model');
            $resDesign = $this->tb_contratos_design_model->fetch_row();

            if(empty($resDesign)){
                $data_design = array();
                $data_design['id_pessoa_pai'] = $user['id_pessoa'];
                $this->db->insert( 'tb_contratos_design', $data_design);

                $resDesign = $this->tb_contratos_design_model->fetch_row();
            }

            foreach( $q->result() as $row ) {



//                $data['texto_base']         = $resDesign->header . $row->texto . $resDesign->footer;
                $data['texto_base']         = $row->texto;
                $data['texto_base_objeto']  = $row->texto_base_objeto;
            }
        }

        //serviços
        if(!empty($data['servicos'])) {

            $this->db->select('descricao');
            $this->db->where('id_pessoa_pai' , $user['id_pessoa']);
            $this->db->where('id IN ('. implode(',',$data['servicos']) . ')');
            $q = $this->db->get('tb_contratos_servicos');
            if( $q->num_rows > 0 ) {
                foreach( $q->result() as $row ) {
                    $data['descricao']  .= '<BR>' . $row->descricao ;
                }
            }
        }
        unset($data['servicos']);

        if ($this->input->post('mensalidade') == 'Valor Mensal'){
            $data['qtd_parcelas']  = '';
            $data['mensalidade']   = 't';
        }

        $data['dt_cad']             = date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H'). ':' . date('i');
        $data['id_pessoa_pai']      = $user['id_pessoa'];
        $data['id_usuario_criador']   = $user['id_usuario'];

        if( $this->db->insert( $this->_table, $data) ) {
            return true;
        }

        return false;
    }

    public function fetch_select_modelos()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->select('id, tipo');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

        $q = $this->db->get('tb_contratos_tipos_x_pessoas');
        $data = array('' => 'Escolha o modelo do contrato');
        if($q->num_rows > 0) {
            foreach( $q->result() as $row ) {
                $data[$row->id] = $row->tipo;
            }
            return $data;
        }
        return $data;
    }

    public function fetch_select_modelos_fornecedor()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->select('id, tipo');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

        $q = $this->db->get('tb_contratos_tipos_fornecedor_x_pessoas');
        $data = array('' => 'Escolha o modelo do contrato');
        if($q->num_rows > 0) {
            foreach( $q->result() as $row ) {
                $data[$row->id] = $row->tipo;
            }
            return $data;
        }
        return $data;
    }

    public function fetch_row_contratos_config(  )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

        $q = $this->db->get( 'tb_contratos_config' );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }
    public function fetch_row( $id_contrato )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id_contrato' , $id_contrato);
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function update_status( $id_contrato, $status )
    {
        $user           = $this->session->userdata('contrato_user');
        $data           = array();
        $data['status'] = $status;

        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where( 'id_contrato'  , $id_contrato );

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }
    public function updateCodContrato( $id_contrato )
    {
        $user           = $this->session->userdata('contrato_user');
        $data           = array('cod_contrato' => $id_contrato);

        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where( 'id_contrato', $id_contrato );

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function update_data_inicio_contrato( $id_contrato )
    {
        $user           = $this->session->userdata('contrato_user');
        $data = array();
        $data['data_inicio_contrato']      = date('Y') . '-' . date('m') . '-' . date('d');
        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where( 'id_contrato', $id_contrato );

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function delete( $id )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where( 'id_contrato', $id );
        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
        if( $this->db->delete( $this->_table) ) {

            //Grava Log
            $this->load->model('tb_logs_model');
            $this->tb_logs_model->insert_history('Deletou contrato ' . $id);
            return true;

            $this->db->where( 'id_contrato', $id );
            $this->db->where( 'fin_id_pessoa_pai', $user['id_pessoa'] );
            $this->db->where( 'pago', '0' );
            $this->db->delete( 'tb_contratos_parcelas' );

            return true;
        }
        return false;
    }

    public function update_aditivo( )
    {
        $data = $this->input->post();
        $user = $this->session->userdata('contrato_user');
        $this->load->helper('funcoes');

        if(!empty($data['data_vigencia_contrato'])) {
            $data['data_inicio_contrato']   =  substr($this->input->post('data_vigencia_contrato') ,0,10);
            $data['data_inicio_contrato']   =  implode( "-", array_reverse( explode( "/", $data['data_inicio_contrato'] ) ) );

            $data['dt_expiracao']   =  substr($this->input->post('data_vigencia_contrato') ,13,10);
            $data['dt_expiracao']   =  implode( "-", array_reverse( explode( "/", $data['dt_expiracao'] ) ) );
        }

        if(!empty($data['data_inicio_contrato'])) {
            $data['data_inicio_contrato']   =  implode( "-", array_reverse( explode( "/", $this->input->post('data_inicio_contrato') ) ) );
        }

        $data['valor_total']    =  formata_decimal($this->input->post('valor_total'));
        $data['entrada']        =  formata_decimal($this->input->post('entrada'));


        unset( $data['id_contrato'] );
        unset( $data['tipo_aditivo'] );
        //retirar
        unset($data['data_vigencia_contrato']);
        unset($data['tipoContrato']);
        unset($data['diaentrada']); //resolver depois
        unset($data['servico']); //resolver depois
        unset($data['prazo_contrato']);
        unset($data['tipo_data']);
        unset($data['data_parcela']);
        unset($data['valor_parcela']);
        unset($data['num_parcela']);
        unset($data['texto']);
        unset($data['valueAditivo']);

        //serviços
        if(!empty($data['servicos'])) {

            $this->db->select('descricao');
            $this->db->where('id_pessoa_pai' , $user['id_pessoa']);
            $this->db->where('id IN ('. implode(',',$data['servicos']) . ')');
            $q = $this->db->get('tb_contratos_servicos');
            if( $q->num_rows > 0 ) {
                foreach( $q->result() as $row ) {
                    $data['descricao']  .= '<BR>' . $row->descricao ;
                }
            }
        }
        unset($data['servicos']);

        if ($this->input->post('mensalidade') == 'Valor Mensal'){
            $data['qtd_parcelas']  = '';
            $data['mensalidade']   = 't';



        }else{
            $data['mensalidade']   = '';
        }
        $this->db->where('id_contrato', $this->input->post('id_contrato'));
        if( $this->db->update( $this->_table, $data ) ) {



            //Grava Log
//            $this->load->model('tb_logs_model');
//            $this->tb_logs_model->insert_history('Inseriu aditivo no contrato ' . $this->input->post('id_contrato'));

            return true;
        }
        return false;
    }

    public function update_assinatura( $id_contrato, $arquivo, $user )
    {
        $data                       = array();
        $data['upload_assinatura']  =  $arquivo;

        $this->db->where( 'id_pessoa_pai', $user);
        $this->db->where( 'id_contrato'  , $id_contrato );

        if( $this->db->update( $this->_table, $data ) ) {
            //Grava Log
            $this->load->model('tb_logs_model');
            $this->tb_logs_model->insert_history('Atualizou assinatura');

            return true;
        }
        return false;
    }

    public function fetch_by_name( $nome )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select(' id_contrato, id_contrato as label,');
        $this->db->like('id_contrato', $nome);
        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );

        $q = $this->db->get( $this->_table );

        $data = array();
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return false;
    }
}