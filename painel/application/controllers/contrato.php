<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrato extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index()
    {
        $view['content'] = 'contrato/index';
        $this->load->model('tb_contratos_model');
        $this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_pessoas_model');
        $view['contratos'] = $this->tb_contratos_model->fetch_contratos();
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $atrasados   = $this->tb_contratos_parcelas_model->fetch_pagamento_atrasados();

//        echo '<pre>' . var_export($atrasados,true);
        $view['atrasados'] = array();
        foreach($atrasados as $value)
            $view['atrasados'][] = $value->id_contrato;

        $this->load->view('template/sistema_content', $view);
    }

    public function cadastro()
    {
        $view['content']                = 'contrato/cadastro';

        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_model');
       $this->load->model('tb_contratos_servicos_model');

        if($this->uri->segment(3) == 'fornecedor'){
            $view['cliente']          = $this->tb_pessoas_model->fetch_select_fornecedor();
            $view['modelo']           = $this->tb_contratos_model->fetch_select_modelos('fornecedor');

        }
        else{


        }

        $view['contratada']          = $this->tb_pessoas_model->contratada();

        $view['cliente']          = $this->tb_pessoas_model->fetch_select_cliente();
        $view['modelo']           = $this->tb_contratos_model->fetch_select_modelos('cliente');

        $view['contratoConfig']   = $this->tb_contratos_model->fetch_row_contratos_config();
       $view['servicos']         = $this->tb_contratos_servicos_model->fetch_servicos();
        $view['mensalidade']      = array(''=>'Escolha o tipo de pagamento', 'Sem Valor'=>'Sem Valor', 'Valor Mensal'=>'Valor Mensal','Valor Parcelado'=>'Valor Parcelado','Valor à Vista'=>'Valor à Vista');
        $view['prazo_contrato']   = array(''=>'Escolha o prazo do contrato', 'Por tempo indeterminado'=>'Por tempo indeterminado', 'Por tempo determinado'=>'Por tempo determinado');
        $view['forma']            = array(''=>'Escolha a forma de pagamento', 'DINHEIRO'=>'DINHEIRO', 'CHEQUE'=>'CHEQUE', 'BOLETO'=>'BOLETO', 'CARTÃO'=>'CARTÃO', 'DEPÓSITO/TRANSFERÊNCIA'=>'DEPÓSITO/TRANSFERÊNCIA');

        $this->load->view('template/sistema_content', $view);
    }

    public function processa_contrato()
    {
//
        $botaoGravar = $this->input->post('botao_gravar');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_pessoa_principal', 'cliente', 'trim|required');
        $this->form_validation->set_rules('texto_base', 'modelo do contrato', 'trim|required');
        $this->form_validation->set_rules('descricao_forma_pagamento', 'Descrição Entrada', 'trim');


        if($this->input->post('descricao') == '' && empty($_POST['servicos'])) {
            $this->form_validation->set_rules('descricao', 'descrição do serviço', 'trim|required');
        }

        //REGRA PARA PRAZO
        $this->form_validation->set_rules('prazo_contrato', 'prazo do contrato', 'trim|required');
        if($this->input->post('prazo_contrato') == 'Por tempo indeterminado') {
            $this->form_validation->set_rules('data_inicio_contrato', 'data de inicio', 'required');
        }
        if($this->input->post('prazo_contrato') == 'Por tempo determinado') {
            $this->form_validation->set_rules('data_vigencia_contrato', 'data de vigencia', 'required');
        }

        //REGRA PARA TIPO DE PAGAMENTO
        $this->form_validation->set_rules('mensalidade', 'tipo de pagamento', 'trim|required');
        if($this->input->post('mensalidade') == 'Valor Mensal') {
            $this->form_validation->set_rules('valor_total', 'valor da mensalidade', 'required');
            $this->form_validation->set_rules('diadomes', 'dia do pagamento', 'required');
            $this->form_validation->set_rules('forma', 'forma do pagamento', 'required');
        }
        if($this->input->post('mensalidade') == 'Valor Parcelado') {
            $this->form_validation->set_rules('valor_total', 'valor da mensalidade', 'required');
            $this->form_validation->set_rules('diadomes', 'dia do pagamento', 'required');
            $this->form_validation->set_rules('forma', 'forma do pagamento', 'required');
            $this->form_validation->set_rules('qtd_parcelas', 'qtde de parcelas', 'numeric|required');
        }



        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {
            $this->load->model('tb_contratos_model');
            $this->load->model('tb_contratos_parcelas_model');
            $this->load->model('tb_agenda_model');
            $this->load->model('tb_contratos_servicos_model');

            $this->tb_contratos_model->insert();
            $idGET = $this->db->insert_id();
            $this->tb_contratos_model->updateCodContrato( $idGET );
            if($this->input->post('mensalidade') != 'Sem Valor') {
                $this->tb_contratos_parcelas_model->insert_parcelas_contrato( $idGET );
            }
            if($this->input->post('prazo_contrato') == 'Por tempo determinado') {
                $this->tb_agenda_model->insert_via_contrato($idGET);
            }

//            if($botaoGravar == 'Pré-Visualizar'){

//                $base = base64_encode($idGET);

//                echo "<script language=\"javascript\" type=\"text/javascript\">window.open('http://www.contratonet.com.br/contract_key/download/download_contrato/$base/Pre');</script>";

//                redirect('../contract_key/download/download_contrato/'.base64_encode($idGET).'/Pre');
//                exit;
//            }

//            $user = $this->session->userdata('contrato_user');
//            $this->load->model('chamados_model');
//            $this->load->model('chamados_log_model');
            //abre automaticamente um chamado
//            $dataChamado               = array();
//            $dataChamado['titulo']     = 'Chamado criado a partir de um contrato';
//            $dataChamado["descricao"]  = 'Chamado iniciado automaticamente a partir do contrato número ' . $idGET;
//            $dataChamado['id_usuario']   = $user['id_usuario'];
//            $dataChamado['prioridade'] = 'Moderada';
//            $dataChamado['tipo']       = 'Novo projeto';
//            $this->chamados_model->insert($dataChamado);
//            $id_chamado             = $this->db->insert_id();

            //cria chamado log
//            $dados                      = array();
//            $dados["id_chamado"]        = $id_chamado;
//            $dados["descricao"]         = 'Chamado iniciado automaticamente a partir do contrato número ' . $idGET;
//            $dados["id_status"]         = '10'; //criado
//            $dados['id_usuario']          = $user['id_usuario'];
//            $this->chamados_log_model->insert($dados);

            //envia email

//            $assunto    = "Você tem um novo chamado";
//            $assunto    = sprintf('=?%s?%s?%s?=', 'UTF-8', 'B', base64_encode($assunto));
//
//            $message    = "Novo chamado número " . $id_chamado . " aguarda sua atenção, acesse o painel para verificar";
//
//            $headers  = "MIME-Version: 1.0\r\n";
//            $headers .= "Content-type: text/html; charset=utf-8\n";
//            $headers .= 'From: Chamado ContratoNET <no-reply@contratonet.com.br>' . "\r\n" ; 


            $assunto    = "Novo contrato criado";
            $assunto    = sprintf('=?%s?%s?%s?=', 'UTF-8', 'B', base64_encode($assunto));
            $message    = "Parabéns sócios! Um novo contrato número " . $idGET . " foi registrado no sistema.";

            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\n";
            $headers .= 'From: Contrato ContratoNET <no-reply@contratonet.com.br>' . "\r\n" ;
//            mail('socios@contratonet.com.br', $assunto, $message , $headers); //envia email para pós-venda



            $this->visualizar($idGET);

//            $view['content']   = 'contrato/detalhe';
//            $this->load->model('tb_pessoas_model');
//            $this->load->model('tb_contratos_model');
//            $this->load->model('tb_usuarios_model');
//            $this->load->model('tb_bancos_model');
//            $this->load->model('tb_contratos_adicionais_model');
//            $this->load->model('tb_contratos_parcelas_model');
//            $view['servicos']         = $this->tb_contratos_servicos_model->fetch_servicos();
//            $view['aditivos']  = $this->tb_contratos_adicionais_model->fetch_result($idGET);
//            $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
//            $view['contratos'] = $this->tb_contratos_model->fetch_row($idGET);
//            $view['admin']     = $this->tb_usuarios_model->fetch_select_admin();
//            $view['parcelas']       = $this->tb_contratos_parcelas_model->fetch_contrato($idGET);
//            $view['bancos']          = $this->tb_bancos_model->fetch_bancos();
//            $view['clienteEmail']   = $this->tb_pessoas_model->contratoPessoa($view['contratos']->id_pessoa_principal);
//            $view['parcela_maxima'] = $this->tb_contratos_parcelas_model->fetch_parcela_maxima($idGET);
//            $dataHoje           = date('Y-m-d');
//            $view['today'] 	    = strtotime($dataHoje);
//            $this->load->view('template/sistema_content', $view);

        }else{
//            redirect('contrato/cadastro');


//            $view['content']                = 'contrato/cadastro';
            $this->cadastro();
//
//            $this->load->model('tb_pessoas_model');
//            $this->load->model('tb_contratos_model');
//            $this->load->model('tb_contratos_servicos_model');
//            $view['cliente']          = $this->tb_pessoas_model->fetch_select_cliente();
//            $view['modelo']           = $this->tb_contratos_model->fetch_select_modelos();
//            $view['contratoConfig']   = $this->tb_contratos_model->fetch_row_contratos_config();
//            $view['servicos']         = $this->tb_contratos_servicos_model->fetch_servicos();
//            $view['mensalidade']      = array(''=>'Escolha o tipo de pagamento', 'Sem Valor'=>'Sem Valor', 'Valor Mensal'=>'Valor Mensal','Valor Parcelado'=>'Valor Parcelado');
//            $view['prazo_contrato']   = array(''=>'Escolha o prazo do contrato', 'Por tempo indeterminado'=>'Por tempo indeterminado', 'Por tempo determinado'=>'Por tempo determinado');
//            $view['forma']            = array(''=>'Forma de pagamento', 'DINHEIRO'=>'DINHEIRO', 'CHEQUE'=>'CHEQUE', 'BOLETO'=>'BOLETO', 'CARTÃO'=>'CARTÃO', 'DEPÓSITO/TRANSFERÊNCIA'=>'DEPÓSITO/TRANSFERÊNCIA');
        }


    }

    public function visualizar($idGET = null)
    {
        $view['content']                = 'contrato/detalhe';

        if(empty($idGET))
            $idGET = $this->uri->segment(3);
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_model');
        $this->load->model('tb_usuarios_model');
        $this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_bancos_model');
        $this->load->model('tb_contratos_adicionais_model');

        $dataHoje           = date('Y-m-d');
        $view['today'] 	    = strtotime($dataHoje);
//        $view['servicos']         = $this->tb_contratos_servicos_model->fetch_servicos();
        $view['aditivos']       = $this->tb_contratos_adicionais_model->fetch_result($idGET);
        $view['cliente']        = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $view['contratos']      = $this->tb_contratos_model->fetch_row($idGET);
        $view['parcelas']       = $this->tb_contratos_parcelas_model->fetch_contrato($idGET);
        $view['parcela_maxima'] = $this->tb_contratos_parcelas_model->fetch_parcela_maxima($idGET);

        $view['admin']          = $this->tb_usuarios_model->fetch_select_admin();
        $view['bancos']         = $this->tb_bancos_model->fetch_bancos();

        //resgata email
        $emails   = $this->tb_pessoas_model->contratoPessoa($view['contratos']->id_pessoa_principal);
        $view['clienteEmail'] = (!empty($emails->email)) ? $emails->email : $emails->email_j ;

        $view['adminRes']       = $this->tb_pessoas_model->contratada();

        $this->load->view('template/sistema_content', $view);
    }

    public function delete( $id )
    {
        $this->load->model('tb_contratos_model');
        if( $this->tb_contratos_model->delete( $id ) ) {
            $this->session->set_flashdata('sucesso', 'Contrato removido com sucesso! Parcelas pagas não serão excluidas');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('contrato/index');
    }

    public function finalizar( $id )
    {
        $this->load->model('tb_contratos_model');
        if( $this->tb_contratos_model->update_status( $id, 'Finalizado' ) ) {
            $this->session->set_flashdata('sucesso', 'Contrato finalizado com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('contrato/index');
    }

    public function distrato( $id )
    {
        $this->load->model('tb_contratos_model');
        if( $this->tb_contratos_model->update_status( $id, 'Distrato' ) ) {
            $this->session->set_flashdata('sucesso', 'Realizado Distrato com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('contrato/index');
    }

    public function rescindir( $id )
    {
        $this->load->model('tb_contratos_model');
        if( $this->tb_contratos_model->update_status( $id, 'Rescindido' ) ) {
            $this->session->set_flashdata('sucesso', 'Contrato rescindido com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('contrato/index');
    }


    public function cadastro_aditivo()
    {
        $this->load->library('form_validation');
        $id_contrato  = $this->input->post('id_contrato');

        if($this->input->post('id_pessoa_secundario') != ''){
            $this->form_validation->set_rules('id_pessoa_secundario', 'cliente', 'trim');
            $_POST['texto'][]         = 'Nova parte foi adicionada ao contrato';
            $_POST['valueAditivo'][]  = '1';
        }


        if($this->input->post('prazo_contrato') != ''){
            //REGRA PARA PRAZO
            $this->form_validation->set_rules('prazo_contrato', 'prazo do contrato', 'trim|required');
            if($this->input->post('prazo_contrato') == 'Por tempo indeterminado') {
                $this->form_validation->set_rules('data_inicio_contrato', 'data de inicio', 'required');
            }
            if($this->input->post('prazo_contrato') == 'Por tempo determinado') {
                $this->form_validation->set_rules('data_vigencia_contrato', 'data de vigencia', 'required');
            }
            $_POST['texto'][]         = 'O Prazo de Vigência foi alterado ';
            $_POST['valueAditivo'][]  = '4';
        }

        if($this->input->post('valor_total') != '' && $this->input->post('valor_total') != '0,00'){
            $this->form_validation->set_rules('mensalidade', 'tipo de pagamento', 'trim|required');
            if($this->input->post('mensalidade') == 'Valor Mensal') {
                $this->form_validation->set_rules('valor_total', 'valor da mensalidade', 'required');
                $this->form_validation->set_rules('diadomes', 'dia do pagamento', 'required');
                $this->form_validation->set_rules('forma', 'forma do pagamento', 'required');
            }
            if($this->input->post('mensalidade') == 'Valor Parcelado') {
                $this->form_validation->set_rules('valor_total', 'valor da mensalidade', 'required');
                $this->form_validation->set_rules('diadomes', 'dia do pagamento', 'required');
                $this->form_validation->set_rules('forma', 'forma do pagamento', 'required');
                $this->form_validation->set_rules('qtd_parcelas', 'qtde de parcelas', 'numeric|required');
            }
            $_POST['texto'][]         = 'Formas de pagamento alteradas';
            $_POST['valueAditivo'][]  = '3';
        }

        $servico = $this->input->post('servicos');

        if(!empty($servico) || $this->input->post('descricao') != ''){
            $this->form_validation->set_rules('descricao', 'descrição', 'trim');
            $_POST['texto'][]         = 'Descrição Alterada';
            $_POST['valueAditivo'][]  = '5';
        }


        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');


        if( $this->form_validation->run() == TRUE ) {


            $this->load->model('tb_contratos_model');
            $this->load->model('tb_contratos_adicionais_model');
            $this->tb_contratos_adicionais_model->insert();

            if($this->input->post('mensalidade') == 'Valor Mensal') {

                $this->db->where( 'id_contrato', $this->input->post('id_contrato') );
                $this->db->where( 'pago', '0' );
                $this->db->delete( 'tb_contratos_parcelas' );

                $this->load->model('tb_contratos_parcelas_model');
                $this->tb_contratos_parcelas_model->insert_parcelas_contrato( $this->input->post('id_contrato') );
            }


            $this->tb_contratos_model->update_aditivo();
            $this->session->set_flashdata('sucesso', 'Aditivo criado com sucesso! Veja o novo aditivo em Documentos disponíveis');



//            redirect('../contract_key/download/download_aditivo/'.base64_encode($id_contrato).'/'.base64_encode($id_adicional));
//            $this->visualizar($id_contrato);
            redirect('contrato/visualizar/'.$id_contrato );

//            $view['content']                = 'contrato/detalhe';
//
//            $this->load->model('tb_pessoas_model');
//            $this->load->model('tb_contratos_model');
//            $this->load->model('tb_usuarios_model');
//            $this->load->model('tb_contratos_parcelas_model');
//            $this->load->model('tb_bancos_model');
//            $this->load->model('tb_contratos_adicionais_model');
//
//            $dataHoje           = date('Y-m-d');
//            $view['today'] 	    = strtotime($dataHoje);
//
//            $view['cliente']        = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
//            $view['contratos']      = $this->tb_contratos_model->fetch_row($id_contrato);
//            $view['parcelas']       = $this->tb_contratos_parcelas_model->fetch_contrato($id_contrato);
//            $view['aditivos']       = $this->tb_contratos_adicionais_model->fetch_result($id_contrato);
//            $view['admin']          = $this->tb_usuarios_model->fetch_select_admin();
//            $view['bancos']          = $this->tb_bancos_model->fetch_bancos();
//            $view['clienteEmail']   = $this->tb_pessoas_model->contratoPessoa($view['contratos']->id_pessoa_principal);
            //var_dump($view['clienteEmail']);exit;

//            $this->load->view('template/sistema_content', $view);


        }else{
            $view['content']                = 'contrato/cadastro_aditivo';

            $this->load->model('tb_pessoas_model');
            $this->load->model('tb_contratos_model');
            $this->load->model('tb_contratos_servicos_model');
            $this->load->model('tb_contratos_parcelas_model');

            $view['cliente']          = $this->tb_pessoas_model->fetch_select_cliente();
            $view['servicos']         = $this->tb_contratos_servicos_model->fetch_servicos();
            $view['mensalidade']      = array(''=>'Escolha o tipo de pagamento', 'Sem Valor'=>'Sem Valor', 'Valor Mensal'=>'Valor Mensal','Valor Parcelado'=>'Valor Parcelado','Valor à Vista'=>'Valor à Vista');
            $view['prazo_contrato']   = array(''=>'Escolha o prazo do contrato', 'Por tempo indeterminado'=>'Por tempo indeterminado', 'Por tempo determinado'=>'Por tempo determinado');
            $view['forma']            = array(''=>'Forma de pagamento', 'DINHEIRO'=>'DINHEIRO', 'CHEQUE'=>'CHEQUE', 'BOLETO'=>'BOLETO', 'CARTÃO'=>'CARTÃO', 'DEPÓSITO/TRANSFERÊNCIA'=>'DEPÓSITO/TRANSFERÊNCIA');

            $view['contratos']        = $this->tb_contratos_model->fetch_row($this->uri->segment(3));
            $view['num_parcela']      = $this->tb_contratos_parcelas_model->get_last_num_parcela($this->uri->segment(3));

            $view['id_contrato'] = $view['contratos']->id_contrato;
            $view['cod_contrato'] = $view['contratos']->cod_contrato;

            $this->load->view('template/sistema_content', $view);
        }
    }



    public function processa_cheque( )
    {
        $this->load->model('tb_contratos_parcelas_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cheque', 'número do cheque', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');

            $this->tb_contratos_parcelas_model->update_cheque( );

            redirect('contrato/visualizar/'.$this->uri->segment(3) );
           // redirect('contrato/index');
        }else{
            redirect('contrato/visualizar/'.$this->uri->segment(3) );

         //   redirect('contrato/index');
        }

    }

    public function processa_reajuste( $id_contrato )
    {
        $this->load->model('tb_contratos_model');
        $this->load->model('tb_contratos_parcelas_model');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('valor_total', 'Valor', 'trim');
        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $this->session->set_flashdata('sucesso', 'Contrato renovado com sucesso!');

            //ENVIAR EMAIL POSTERIORMENTE

            $data['valor_parcela']  = $this->input->post('valor_total');

            $this->tb_contratos_model->update_data_inicio_contrato( $id_contrato );

            $this->tb_contratos_parcelas_model->insert_parcelas_contrato( $id_contrato );

            redirect('contrato/visualizar/'.$id_contrato );
        }else{
            redirect('contrato/visualizar/'.$id_contrato );
        }
    }
}