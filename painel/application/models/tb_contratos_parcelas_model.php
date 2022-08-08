<?php

class Tb_contratos_parcelas_model extends CI_Model {

    private $_table = "tb_contratos_parcelas";

    public function fetch_pagamento_receber()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("tp.*, tc.*, (case when data_parcela >= current_date then 'A Receber' else 'Em Atraso' end)  as atrasos");
        $this->db->join('tb_contratos as tc', 'tp.id_contrato = tc.id_contrato');
        $this->db->where('tc.id_pessoa_pai', $user['id_pessoa']);
        $this->db->where('tc.tipo_pessoa', 'CLIENTE' );
        $this->db->where('tp.data_parcela < current_date');
        $this->db->where('tp.pago', 0);
        $this->db->order_by('atrasos', 'DESC');
        

        $q = $this->db->get( $this->_table.' as tp');
        return $q->result();
    }

    public function fluxo_saldo_mes($mes = null, $ano = null)
    {   

        $anoAtual = getdate();
        $mes = (empty($mes)) ? $anoAtual['mon']  : $mes;
        $ano = (empty($ano)) ? $anoAtual['year'] : $ano;

        $user = $this->session->userdata('contrato_user');
        $sql = "SELECT (select COALESCE(sum(valor_parcela),0)
            from tb_contratos_parcelas
            WHERE 1
            AND MONTH(data_parcela) <= " . $mes . " AND YEAR(data_parcela) <= " . $ano . "
            AND tb_contratos_parcelas.fin_id_pessoa_pai = '" . $user['id_pessoa'] . "' AND tipo = 'RECEITA'  AND pago = 1 )
            - (SELECT COALESCE(sum(valor_parcela),0)
            from tb_contratos_parcelas
            WHERE 1
            AND MONTH(data_parcela) <= " . $mes . " AND YEAR(data_parcela) <= " . $ano . "
            AND tb_contratos_parcelas.fin_id_pessoa_pai = '" . $user['id_pessoa'] . "' AND tipo = 'DESPESA'  AND pago = 1) as valor
            from tb_contratos_parcelas
            limit 1 ;";
        
        $q = $this->db->query($sql);
        $row = $q->row();
        return $row->valor;
    }

    public function fluxo_previsto_mes($mes = null, $ano = null)
    {   
        $anoAtual = getdate();
        $mes = (empty($mes)) ? $anoAtual['mon']  : $mes;
        $ano = (empty($ano)) ? $anoAtual['year'] : $ano;

        $user = $this->session->userdata('contrato_user');
        $sql = "SELECT (select COALESCE(sum(valor_parcela),0)
        from tb_contratos_parcelas
        WHERE 1
        AND MONTH(data_parcela) = " . $mes . " AND YEAR(data_parcela) = " . $ano . "
        AND tb_contratos_parcelas.fin_id_pessoa_pai = '" . $user['id_pessoa'] . "' AND tipo = 'RECEITA'  AND pago = 1 )
        - (SELECT COALESCE(sum(valor_parcela),0)
        from tb_contratos_parcelas
        WHERE 1
        AND MONTH(data_parcela) = " . $mes . " AND YEAR(data_parcela) = " . $ano . "
        AND tb_contratos_parcelas.fin_id_pessoa_pai = '" . $user['id_pessoa'] . "' AND tipo = 'DESPESA'  AND pago = 1) as valor
        from tb_contratos_parcelas
        limit 1 ;";

        $q = $this->db->query($sql);
        $row = $q->row();
        return $row->valor;
    }

    public function fluxo_anterior_mes($mes = null, $ano = null)
    {   
        $anoAtual = getdate();
        $mes = (empty($mes)) ? $anoAtual['mon']  : $mes;
        $ano = (empty($ano)) ? $anoAtual['year'] : $ano;

        if($mes == 1) $ano = $ano - 1;
        if($mes == 1)
            $mes = 12;
        else
            $mes = $mes - 1 ;

        $user = $this->session->userdata('contrato_user');
        $sql = "SELECT (select COALESCE(sum(valor_parcela),0)
                from tb_contratos_parcelas
                WHERE 1
                AND MONTH(data_parcela) <= " . $mes . " AND YEAR(data_parcela) <= " . $ano . "
                AND tb_contratos_parcelas.fin_id_pessoa_pai = '" . $user['id_pessoa'] . "' AND tipo = 'RECEITA'  AND pago = 1 )
                - (SELECT COALESCE(sum(valor_parcela),0)
                from tb_contratos_parcelas
                WHERE 1
                AND MONTH(data_parcela) <= " . $mes . " AND YEAR(data_parcela) <= " . $ano . "
                AND tb_contratos_parcelas.fin_id_pessoa_pai = '" . $user['id_pessoa'] . "' AND tipo = 'DESPESA'  AND pago = 1) as valor
                from tb_contratos_parcelas
                limit 1 ;";

        $q = $this->db->query($sql);
        $row = $q->row();
        return $row->valor;
    }

    public function set_array_recebido( $array )
    {   
        if(count($array)) {
            foreach($array as $id) {
			
		//enviar emails			
		$this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_model');
        $this->load->model('tb_contratos_parcelas_model');

        $view['resParc']        = (array) $this->tb_contratos_parcelas_model->fetch_row($id);
		if($view['resParc']['tipo'] == 'RECEITA'){
        $view['cliente']        = $this->tb_pessoas_model->contratoPessoa($view['resParc']['fin_id_pessoa_pai']);
        $view['clientela']      = $this->tb_pessoas_model->contratoPessoa($view['resParc']['fin_id_parte']);
        $view['data']           = date('d-m-Y');
		$assunto    = "Confirmação de Pagamento de Fatura";
        $assunto    = sprintf('=?%s?%s?%s?=', 'UTF-8', 'B', base64_encode($assunto));

        //definindo link para o email
        $view['linkCompleto'] = "http://www.controlwork.com.br/painel/";

        $message  = $this->load->view('template_emails/documento_recebido', $view, true);

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= 'From: ' . $view['cliente']->nome . ' <no-reply@controlwork.com.br>' . "\r\n" ;

		$email       = (!empty($view['clientela']->email)) ? $view['clientela']->email : $view['clientela']->email_responsavel;
		
        //envio do email ao cliente
        mail($email, $assunto, $message , $headers);
        				}		
               $this->db->where('id', $id);
               $this->db->update($this->_table, array('pago' => 1, 'data_pagamento' => date("Y-m-d")));
            }
            return true;
        }
        return false;
    }

    public function set_array_cancelados( $array )
    {
		if(count($array)) {
			foreach($array as $id) {
				$this->db->select('id, id_contrato, num_parcela, valor_parcela, data_parcela');
				$this->db->where('id', $id);
				$q = $this->db->get( $this->_table );

				$this->db->insert('tb_contratos_parcelas_canceladas', $q->row_array() );

				$this->db->where('id', $id);
				$this->db->delete( $this->_table );
				
			}
			return true;
		}
		return false;
    }

    public function fetch_pagamento_recebido()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("tp.*, tc.*, (case when data_parcela >= current_date then 'A Receber' else 'Em Atraso' end)  as atrasos");
        $this->db->join('tb_contratos as tc', 'tp.id_contrato = tc.id_contrato');
        $this->db->where('tc.id_pessoa_pai', $user['id_pessoa']);
        $this->db->where('tc.tipo_pessoa', 'CLIENTE' );
        $this->db->where('tp.pago', 1);
        $this->db->order_by('atrasos', 'DESC');

        $q = $this->db->get( $this->_table.' as tp');
        return $q->result();
    }

    public function fetch_pagamento_cancelados()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("tp.*, tc.*");
        $this->db->join('tb_contratos as tc', 'tp.id_contrato = tc.id_contrato');
        $this->db->where('tc.id_pessoa_pai', $user['id_pessoa']);
        $q = $this->db->get('tb_contratos_parcelas_canceladas as tp');
        return $q->result();
    }

    public function fetch_pagamento_atrasados()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->select('tc.id_contrato, tc.id,tc.valor_parcela, tc.data_parcela, tpai.nome as nome_pai, tp.email, tp.email_responsavel, tp.nome, tc.fin_id_pessoa_pai', false);
        $this->db->join('tb_pessoas as tp', 'tp.id_pessoa = tc.fin_id_parte');
        $this->db->join('tb_pessoas as tpai', 'tpai.id_pessoa = tc.fin_id_pessoa_pai');
        $this->db->join('tb_contratos as tcc', 'tc.id_contrato = tcc.id_contrato');
        $this->db->where("tc.data_parcela < current_date ");
        $this->db->where('tc.fin_id_pessoa_pai', $user['id_pessoa']);
        $this->db->where("tc.pago = 0");
        $this->db->where("tc.data_parcela <> '0000-00-00'");
        $this->db->where("tpai.ativo = 1");
        $this->db->where("tcc.status = 'Em Vigencia'");

        $q = $this->db->get( $this->_table.' as tc');
        return $q->result();
    }


    public function acodos_realizados()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("c.*, CASE WHEN (MONTH(c.dt_expiracao) <= MONTH(curdate()) OR MONTH(c.dt_expiracao) = MONTH(curdate())+1) and YEAR(c.dt_expiracao) = YEAR(curdate()) THEN '1' ELSE '0' END as diferenca", false);
        $this->db->where('c.id_pessoa_pai', $user['id_pessoa']);
        $this->db->where('c.acordo', 't');
        $this->db->order_by('dt_cad', 'DESC');

        $q = $this->db->get('tb_contratos as c');
        return $q->result();   
    }

    public function fetch_all_receber( $tipo = null ,$dt_inicio = null,$dt_fim = null)
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('fin_id_pessoa_pai', $user['id_pessoa']);
        $this->db->where('tipo', $tipo);
        if(!empty($dt_inicio) && !empty($dt_fim)){
            $this->db->where("data_parcela >= '" . $dt_inicio . "' AND data_parcela <= '" . $dt_fim . "'");
        }else{
            $anoAtual = getdate();
            $mes = (empty($mes)) ? $anoAtual['mon']  : $mes;
            $ano = (empty($ano)) ? $anoAtual['year'] : $ano;
            $this->db->where("MONTH(data_parcela) = " . $mes . " AND YEAR(data_parcela) = " . $ano . "");
        }

        $this->db->where('ativo', 1);
        //$this->db->where("( tb_contratos_parcelas.data_parcela <= CURDATE() && tb_contratos_parcelas.data_parcela >=  CURDATE() - INTERVAL '7' DAY)");

        $q = $this->db->get($this->_table);
        return $q->result();
    }

    public function insert()
    {
        
        $this->load->helper('funcoes');
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['fin_id_pessoa_pai'] = $user['id_pessoa'];
        $datinha = date('Y') . '-' . date('m') . '-' . date('d');

        if(!empty($data['data_parcela'])){
            $data['data_parcela'] = parseDate($data['data_parcela'],'date2mysql');
        }else{
            $data['data_parcela'] = $datinha;
        }

        if(!empty($data['data_pagamento'])){
            $data['data_pagamento'] = parseDate($data['data_pagamento'],'date2mysql');
        }

        $nova_conta = $this->input->post('nova_conta');
        if( !empty($nova_conta) ){
            $this->db->insert('tb_financeiro_conta', array( 'id_pessoa_pai' => $user['id_pessoa'], 'nome' => $data['nova_conta'] ));
            $data['fin_conta'] = $data['nova_conta'];
        }

        $novo_cliente = $this->input->post('novo_cliente');
        if(!empty( $novo_cliente )){
            $colParte = array();
            $colParte['data_cad'] = $datinha;
            $colParte['id_pessoa_pai'] = $user['id_pessoa'];
            $colParte['tipo_pessoa'] = $data['novo_cliente_tipo'];

            if( $this->input->post('novo_cliente_jur') == 'FISICA') {
                $colParte['nome'] = $data['novo_cliente'];
                $colParte['pessoa'] = 'F';
            } else {
                $colParte['razao'] = $data['novo_cliente'];
                $colParte['nome_fantasia'] = $data['novo_cliente'];
                $colParte['nome'] = $data['novo_cliente'];
                $colParte['pessoa'] = 'J';
            }
            $colParte['id_usuario_criador']	= $user['id_usuario'];

            $this->db->insert('tb_pessoas', $colParte);
            $data['fin_id_parte'] = $this->db->insert_id();
        }

        $nova_categoria = $this->input->post('nova_categoria');
        if( !empty( $nova_categoria ) ){
            $this->db->insert('tb_financeiro_categoria', array( 'id_pessoa_pai' => $user['id_pessoa'] , 'nome' => $data['nova_categoria']));
            $data['fin_categoria']	= $data['nova_categoria'];
        }

        if(!empty( $data['repeticao'] )){
            $repetir = $data['repeticao'];
            if( $this->input->post('repeticaoTipo') == 'QUINZENAL'){
                $repetir = $data['repeticao'] * 2;
            }
        } else {
            $repetir = 1;
        }

        $dataControle = explode("-" , $data['data_parcela'] );
        $dia_inicial = $dataControle[2];

        unset($data['repeticao']);
        unset($data['repeticaoTipo']);

        for( $i=1; $i<=$repetir; $i++ ){

            $dataControle[2] = $dia_inicial;

            //Edicao na mao das datas
            if($dataControle[1] == 13){
                $dataControle[1] = 1;
                $dataControle[0] = $dataControle[0] + 1;
            }

            //caso meses nao vao até dia 31
            if($dataControle[2] == '31'){
                if($dataControle[1] == '04' || $dataControle[1] == '06' || $dataControle[1] == '09' || $dataControle[1] == '11'){
                    $dataControle[2] = 30;
                }
            }

            //caso seja fevereiro
            if($dataControle[2] > 28){
                if($dataControle[1] == '02'){
                    $dataControle[2] = 28;
                }
            }

            $data['data_parcela'] = ($dataControle[0] . '-' . $dataControle[1] . '-' . $dataControle[2]);
            $data['valor_parcela']      = formata_decimal($this->input->post('valor_parcela'));
            //insere no banco o lançamento
            $this->db->insert( $this->_table, $data);

            //quinzenal
            if( $this->input->post('repeticaoTipo') == 'QUINZENAL') {

                $dia_inicial = $dia_inicial + 15;

                if($dia_inicial > 28 && $dia_inicial <= 31){
                    $dia_inicial = 28;
                }


                if($dia_inicial > 31){
                    $calculo            = $dia_inicial - 28;
                    $dia_inicial        = 1;
                    $dia_inicial        = $dia_inicial + $calculo ;
                    $dataControle[1]    = $dataControle[1] + 1;
                }

            } else {
                $dataControle[1] = $dataControle[1] + 1;
            }
        }

    }

    public function update( $id = null)
    {
        $this->load->helper('funcoes');
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['fin_id_pessoa_pai'] = $user['id_pessoa'];
        $datinha = date('Y') . '-' . date('m') . '-' . date('d');

        if(!empty($data['data_parcela'])){
            $data['data_parcela'] = parseDate($data['data_parcela'],'date2mysql');
        }else{
            $data['data_parcela'] = $datinha;
        }

        if(!empty($data['data_pagamento'])){
            $data['data_pagamento'] = parseDate($data['data_pagamento'],'date2mysql');
        }
        unset($data['repeticaoTipo']);
        unset($data['repeticao']);

        $this->db->where('id', $id);
        $this->db->update( $this->_table, $data );
    }

    public function fetch_row( $id , $tipo = null)
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('fin_id_pessoa_pai', $user['id_pessoa']);
        $this->db->where('id', $id);
        $this->db->order_by('num_parcela','DESC');

        if(!empty($tipo)){
            $this->db->where('tipo', $tipo);
        }

        $q = $this->db->get($this->_table);
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return array();
    }

    public function get_last_num_parcela( $id)
    {
        $q = $this->db->query('select max(num_parcela) as num_parcela from tb_contratos_parcelas where pago = 1 and id_contrato = ' . $id);

        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return array();
    }

    public function delete( $id )
    {
        $this->db->where('id', $id);
        return $this->db->update( $this->_table, array('ativo' => 0 ) );
    }

    public function array_delete( $array ) 
    {
        if(count($array)) {
            foreach($array as $id) {
                $this->db->where('id', $id);
                $this->db->update( $this->_table, array('ativo' => 0 ) );
            }
            return true;
        }
        return false;
    }

    public function fetch_extrato( $dt_inicio = null,$dt_fim = null )
    {

        $anoAtual = getdate();
        $mes = $anoAtual['mon'];
        $ano = $anoAtual['year'];

        $user = $this->session->userdata('contrato_user');
        $this->db->where('fin_id_pessoa_pai', $user['id_pessoa']);
        if(!empty($dt_inicio) && !empty($dt_fim)){
            $this->db->where("data_parcela >= '" . $dt_inicio . "' AND data_parcela <= '" . $dt_fim . "'");
        }else{
            $this->db->where("(MONTH(data_parcela) = " . $mes . " AND YEAR(data_parcela) = " . $ano . ")");
        }

        $this->db->order_by('data_parcela','DESC');
        $this->db->join('tb_pessoas as p', 'o.fin_id_pessoa_pai = p.id_pessoa', 'left');
        $this->db->where("p.ativo" , 1);
        $q = $this->db->get( $this->_table . ' as o');


        if($q->num_rows>0) {
//            echo '<pre>' . var_export($q->result(),true);
//            exit;
            return $q->result();
        }

        return array();
    }

    public function fetch_fluxo($mes = null, $ano = null)
    {
        $anoAtual = getdate();
        $mes = (empty($mes)) ? $anoAtual['mon']  : $mes;
        $ano = (empty($ano)) ? $anoAtual['year'] : $ano;
        $user = $this->session->userdata('contrato_user');

        $this->db->where('MONTH(data_parcela)', $mes);
        $this->db->where('YEAR(data_parcela)', $ano);
        $this->db->where('fin_id_pessoa_pai', $user['id_pessoa']);
        $this->db->order_by('data_parcela', 'DESC');

        $q = $this->db->get($this->_table);
        if($q->num_rows>0) {
            return $q->result();
        }
        return array();
    }

    public function fetch_cliente( $id_parcela )
    {
        $this->db->select('p.*');
        $this->db->where('id', $id_parcela );
        $this->db->join('tb_pessoas as p', 'o.fin_id_pessoa_pai = p.id_pessoa', 'left');
        $q = $this->db->get( $this->_table . ' as o');
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function fetch_contrato( $id_contrato )
    {
      //  $this->db->select('*');
        $this->db->where('id_contrato', $id_contrato );
        $this->db->order_by('id ASC' );
        $q = $this->db->get( $this->_table ) ;
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return false;
    }

    public function insert_parcelas_contrato( $id_contrato )
    {
        // var_dump(@$_POST);
        $this->load->helper('funcoes');
        $qtdParcelas = $this->input->post('qtd_parcelas');

      
        //formata data para trabalhar
        $dataControle = explode("-",parseDate($this->input->post('diadomes'), 'date2mysql'));

        //Se dia escolhido for menor que data atual então a primeira parcela é registrada no mes subsequente
        if( bigger_than_today(str_replace('/','-',$this->input->post('diadomes'))) == 1)
                $dataControle[1] = $dataControle[1] + 1;

        //insert para valor mensal(é inserido 12 meses de parcelas para contratos mensais.  após estes 12 meses um botão de renovação surge para reajuste do valor)
        if ($this->input->post('mensalidade') == 'Valor Mensal'){
          
            // processo utilizado somente no reajuste********
                $numParcelas = $this->input->post('num_parcela');
                if(!empty($numParcelas)){
                    $num_parcela = $this->input->post('num_parcela');
//                    $dataControle[1] = $dataControle[1] + 1; // passar para proximo mês
                    $num_parcela++; // passar para próxima num_parcela
                }else{
                    $num_parcela = 1;
                }

              
            //**********************************************

            for( $i=$num_parcela; $i<=$num_parcela+11; $i++ ){

                //Edicao na mao das datas
                if($dataControle[1] >= 13){
                    $dataControle[1] = 1;
                    $dataControle[0] = $dataControle[0] + 1;
                }

                //caso meses nao vao até dia 31
                if($dataControle[2] == '31'){
                    if($dataControle[1] == '04' || $dataControle[1] == '06' || $dataControle[1] == '09' || $dataControle[1] == '11'){
                        $dataControle[2] = 30;
                    }
                }

                //caso seja fevereiro
                if($dataControle[2] > 28){
                    if($dataControle[1] == '02'){
                        $dataControle[2] = 28;
                    }
                }

                //insere no banco o lançamento
                $data = array();

                $user                       = $this->session->userdata('contrato_user');
                $data['data_parcela']       = ($dataControle[0] . '-' . $dataControle[1] . '-' . $dataControle[2]);
                $data['fin_id_pessoa_pai']  = $user['id_pessoa'];
                $data['id_contrato']        = $id_contrato;
                $data['valor_parcela']      = formata_decimal($this->input->post('valor_total'));
                $data['fin_id_parte']       = $this->input->post('id_pessoa_principal');
                $data['fin_conta']          = 'Contratos';
                $data['fin_categoria']      = 'Contratos n° ' . $id_contrato;
                $data['tipo']               = 'Receita';
                $data['num_parcela']        = $i;
                $data['fin_titulo']         = 'Parcela nº ' . $i;
                $this->db->insert($this->_table , $data);

                $dataControle[1] = $dataControle[1] + 1;
            }
        }

        // echo 'aaaa'; 
        //insert para valor parcelado
        if(!empty($qtdParcelas)){
            // echo 'bbb'.$qtdParcelas;
            // exit;
            // var_dump(@$_POST);
            $i              = 1;
              $valor_parcela  = $this->input->post('valor_parcela');
              $valor_total  = $this->input->post('valor_total');
            $data_parcela   = $this->input->post('data_parcela');
            $valor_parcelado  = formata_decimal(@$valor_total) / @$qtdParcelas;

            // echo @$qtdParcelas.'<BR><BR>';
            // var_dump($valor_parcela);echo '<BR><BR>';
            // var_dump($valor_total);echo '<BR><BR>';
            // exit;
            # INSERE NO BANCO AS PARCELAS
            while($i <= $qtdParcelas){
          
                if(!empty($valor_parcela[$i])){
                    $data = array();
                    $user                       = $this->session->userdata('contrato_user');
                    $data['fin_id_pessoa_pai']  = $user['id_pessoa'];
                    $data['id_contrato']        = $id_contrato;
                    $data['valor_parcela']      = $valor_parcelado;
                    $data['data_parcela']       = parseDate($data_parcela[$i],'date2mysql');
                    $data['fin_id_parte']       = $this->input->post('id_pessoa_principal');;
                    $data['fin_conta']          = 'Contratos';
                    $data['fin_categoria']      = 'Contratos n° ' . $id_contrato;
                    $data['tipo']               = 'Receita';
                    $data['num_parcela']        = $i;
                    $data['fin_titulo']         = 'Parcela nº ' . $i;
// var_dump($data);echo '<BR><BR>';
                    $this->db->insert($this->_table , $data);
                }

                if(@$valor_total){

                    //Edicao na mao das datas
                if($dataControle[1] >= 13){
                    $dataControle[1] = 1;
                    $dataControle[0] = $dataControle[0] + 1;
                }

                //caso meses nao vao até dia 31
                if($dataControle[2] == '31'){
                    if($dataControle[1] == '04' || $dataControle[1] == '06' || $dataControle[1] == '09' || $dataControle[1] == '11'){
                        $dataControle[2] = 30;
                    }
                }

                //caso seja fevereiro
                if($dataControle[2] > 28){
                    if($dataControle[1] == '02'){
                        $dataControle[2] = 28;
                    }
                }

                    $data = array();
                    $user                       = $this->session->userdata('contrato_user');
                    $data['fin_id_pessoa_pai']  = $user['id_pessoa'];
                    $data['id_contrato']        = $id_contrato;
                    $data['valor_parcela']      = $valor_parcelado;
                    $data['data_parcela']       = ($dataControle[0] . '-' . $dataControle[1] . '-' . $dataControle[2]);
                    $data['fin_id_parte']       = $this->input->post('id_pessoa_principal');;
                    $data['fin_conta']          = 'Contratos';
                    $data['fin_categoria']      = 'Contratos n° ' . $id_contrato;
                    $data['tipo']               = 'Receita';
                    $data['num_parcela']        = $i;
                    $data['fin_titulo']         = 'Parcela nº ' . $i;
                    $dataControle[1] = $dataControle[1] + 1;
// var_dump($data);echo '<BR><BR>';
                    $this->db->insert($this->_table , $data);
                }

                $i++;

            }
        } 
    }

    public function update_cheque(  )
    {
        $user           = $this->session->userdata('contrato_user');
        $data           = array('num_cheque' => $this->input->post('cheque'));



        $this->db->where( 'fin_id_pessoa_pai', $user['id_pessoa'] );
        $this->db->where( 'id_contrato', $this->uri->segment(3) );
        $this->db->where( 'id', $this->uri->segment(4));

        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function fetch_parcela_maxima( $id_contrato)
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select('num_parcela, data_parcela, id');
        $this->db->where('fin_id_pessoa_pai', $user['id_pessoa']);
        $this->db->where('id_contrato', $id_contrato);
        $this->db->order_by('id','DESC');
        $this->db->limit(1);

        $q = $this->db->get($this->_table);
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return array();
    }
}