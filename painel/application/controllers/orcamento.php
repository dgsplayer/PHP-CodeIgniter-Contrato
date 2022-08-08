<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orcamento extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->helper("array");
        $this->load->helper("funcoes");
        $this->load->library("session");
        $this->load->library("email");

        $this->load->library("acl");
        $this->load->model("crud_model");
    }

    public function index()
    {

        $data["menu"]               = "Propostas";
        $data["submenu"]            = "Listar Propostas";
        $data["classbody"]          = "";
        $data["msg"]                = "";

        $this->load->model('tb_orcamentos_model');
        $data['orcamentos'] = $this->tb_orcamentos_model->fetch_orcamento();
        $ultimos_envios = $this->crud_model->rows('tb_orcamentos_emails', null, null, null, null, null, 'id_orcamento,max(data) as data', 'id_orcamento');


        foreach( $ultimos_envios as $row ) {
            $data["last"][$row->id_orcamento] = $row->data;
        }

        $data['content'] = 'orcamento/lista';
        $this->load->view('template/sistema_content', $data);

    }

    public function preCadastro()
    {
        $data["menu"]               = "Propostas";
        $data["submenu"]            = "Nova Proposta";
        $data["classbody"]          = "";
        $data["msg"]                = "";

        $this->load->model("tb_pessoas_model");

        // $clientes        = $this->tb_pessoas_model->fetch_cliente();

        // foreach( $clientes as $row ) {
        //     $data["clientes"][$row->id_pessoa] = $row->nome;
        // }
        $data['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();

        $data['content'] = 'orcamento/precadastro';
        $this->load->view('template/sistema_content', $data);

    }

    public function ajaxListaCliente()
    {
        $name_array = $this->db->query("SELECT id_pessoa, nome from tb_pessoas where status = 'ATIVO' and ativo = 1 and id_pessoa_pai = 100867 order by nome")->result_array();

        echo json_encode($name_array);

    }

    public function pre_processa_orcamento()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_pessoa', 'Cliente', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $this->cadastro(null,$this->input->post('id_pessoa'));

        }else{
            $this->preCadastro();
        }

    }

    public function cadastro( $id_orcamento = null, $id_pessoa = null )
    {
        $data["menu"]               = "Propostas";
        $data["submenu"]            = "Nova Proposta";
        $data["classbody"]          = "";
        $data["msg"]                = "";


        $this->load->model('tb_orcamentos_model');
        $this->load->model('crud_model');

        $data['orcamento'] = $this->tb_orcamentos_model->fetch_row( $id_orcamento );
        $emails     = $this->crud_model->row('tb_pessoas','id_pessoa = ' . $this->input->post("id_pessoa"));
//        var_dump($emails);
//        foreach( $emails as $row ) {
            $data["email"] = $emails->email;
            $data["nome"]  = $emails->nome;
//        }
        $data['id_pessoa'] = $id_pessoa;
        $data['servicos']  = $this->crud_model->rows('tb_orcamentos_modelos');

        $data['content'] = 'orcamento/cadastro';
        $this->load->view('template/sistema_content', $data);

    }

    public function delete( $id )
    {
        $this->load->model('tb_orcamentos_model');
        if( $this->tb_orcamentos_model->delete( $id ) ) {
            $this->session->set_flashdata('sucesso', 'Proposta removida com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('orcamento');
    }

    public function deletarModelo( $id )
    {
        $this->load->model('tb_contratos_servicos_model');
        if( $this->tb_contratos_servicos_model->inativo( $id ) ) {
            $this->session->set_flashdata('sucesso', 'Removido com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('orcamento/lista_servico');
    }

    public function processa_orcamento()
    {

        if($this->input->post()) {

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

            if(empty($_POST['servicos'])) {
                $this->form_validation->set_rules('descricao', 'modelo da proposta', 'trim|required');
            }

            $this->form_validation->set_rules('id_pessoa', 'cliente', 'trim');
            $this->form_validation->set_rules('id_orcamento', 'proposta', 'trim');

            if( $this->form_validation->run() == TRUE ) {

                $this->load->model('tb_orcamentos_model');

                $id_orcamento = trim($this->input->post('id_orcamento'));

                if( !empty( $id_orcamento ) ) {
                    $this->tb_orcamentos_model->update();
                    $this->session->set_flashdata('sucesso', 'Proposta atualizada com sucesso!');
                } else {
                    $this->tb_orcamentos_model->insert();
                    $id_orcamento = $this->db->insert_id();
                    $this->session->set_flashdata('sucesso', 'Proposta inserida com sucesso!');

                    //Grava Log
//                    $dadosLog                = array();
//                    $dadosLog["para_id_cliente"]  = $this->input->post("id_pessoa");
//                    $dadosLog["acao"]        = "Enviou proposta número: " . $id_orcamento;
//                    $this->crud_model->do_insert_log($dadosLog);

                }

                redirect('/orcamento/visualizar/' . $id_orcamento );
            }
        }
        $this->cadastro(null,$this->input->post("id_cliente"));
    }

    public function enviar( $id_orcamento = null )
    {
        $this->load->model('tb_orcamentos_model');
        $objOrcamento = $this->tb_orcamentos_model->fetch_cliente( $id_orcamento );

        for ($i=0; $i<100; $i++) {
            $d=rand(1,30)%2;
            $rand1 = $d ? chr(rand(65,90)) : chr(rand(48,57));
        }
    }

    public function visualizar($idGET = null)
    {
        $data["menu"]               = "Propostas";
        $data["submenu"]            = "Detalhes Proposta";
        $data["classbody"]          = "";
        $data["msg"]                = "";

        $this->load->model('tb_orcamentos_model');
        $this->load->model('tb_usuarios_model');
        $this->load->model('crud_model');

        $dataHoje           = date('Y-m-d');
        $data['today'] 	    = strtotime($dataHoje);
        $data['orcamentos'] = $this->tb_orcamentos_model->fetch_row( $idGET );
        $data['usuario']    = $this->crud_model->row('tb_usuarios','id_usuario = ' . @$data['orcamentos']->id_usuario);
        $emails             = $this->crud_model->row('tb_pessoas','id_pessoa = ' . @$data['orcamentos']->id_pessoa);

        $data['email_pessoa']           = (empty($emails->email)) ? $emails->email_j: $emails->email;
//        $data['permissao_altera']       = $this->acl_permissao->fetch_get_altera_valor();
        $data['emails']                 = $this->tb_orcamentos_model->fetch_select_emails( $idGET );

        $data['content'] = 'orcamento/detalhe';
        $this->load->view('template/sistema_content', $data);
    }

    public function pageNovoModelo($id_servico = null)
    {
        $data["menu"]               = "Propostas";
        $data["submenu"]            = "Cadastrar Modelo";
        $data["classbody"]          = "";
        $data["msg"]                = "";

        $this->load->model('tb_contratos_servicos_model');
        $data['servicos'] = $this->tb_contratos_servicos_model->fetch_row_servicos( $id_servico);

        $this->load->model('tb_servicos_model');
        $data['submenus'] = $this->tb_servicos_model->rows();

        //grupos
        $this->load->model('tb_grupos_model');
        $dados        = $this->tb_grupos_model->rows();
        foreach( $dados as $row ) {
            $data["grupos"][$row['id']] = $row['nome'];
        }

        $data['content'] = 'orcamento/cadastro_servico';
        $this->load->view('template/sistema_content', $data);
    }

    public function processa_cadastro_servico()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
//        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
        $this->form_validation->set_rules('valor_total', 'Valor', 'trim|required');
        $this->form_validation->set_rules('validade', 'Validade', 'trim|required');

        $this->form_validation->set_rules('condicoes_pagamento', 'condicões de pagamento', 'trim');
        $this->form_validation->set_rules('condicoes_gerais', 'condições gerais', 'trim');
        $this->form_validation->set_rules('observacao', 'observação', 'trim');
        $this->form_validation->set_rules('prazo', 'prazo', 'trim');
        $this->form_validation->set_rules("grupo", "grupo", "trim");
        $this->form_validation->set_rules("id_grupo", "", "trim");

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $this->load->model('tb_contratos_servicos_model');
            $id_servico = trim($this->input->post('id'));

            if( !empty( $id_servico ) ) {
                $this->tb_contratos_servicos_model->update();

            } else {
                $this->tb_contratos_servicos_model->insert();
            }

            $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');

            redirect('orcamento/lista_servico');

//            $view['content'] = 'configuracao/lista_servico';
//            $this->load->model('tb_contratos_servicos_model');
//            $view['servicos'] = $this->tb_contratos_servicos_model->fetch_servicos();
//
//            $this->load->view('template/sistema_content', $view);

        }else{
            $this->pageNovoModelo();
        }

//        $this->load->view('template/sistema_content', $view);
    }

    public function lista_servico()
    {
        $data["menu"]               = "Propostas";
        $data["submenu"]            = "Lista dos Modelos";
        $data["classbody"]          = "";
        $data["msg"]                = "";

        $this->load->model('tb_contratos_servicos_model');
        $data['servicos'] = $this->tb_contratos_servicos_model->fetch_servicos();

        //grupos
        $this->load->model('tb_grupos_model');
        $dados        = $this->tb_grupos_model->rows();
        foreach( $dados as $row ) {
            $data["grupos"][$row['id']] = $row['nome'];
        }

        $data['content'] = 'orcamento/lista_servico';
        $this->load->view('template/sistema_content', $data);



//        $this->load->view("abre_html", $data);
//        $this->load->view("orcamento/lista_servico", $data);
//        $this->load->view("fecha_html");
    }


    public function altera_valor()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('valor_total', 'Valor', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        $this->load->model('tb_orcamentos_model');
        $id_orcamento = trim($this->input->post('id_orcamento'));

        if( $this->form_validation->run() == TRUE ) {

            if( !empty( $id_orcamento ) ) {
                $this->tb_orcamentos_model->update();

            }
            $this->session->set_flashdata('sucesso', 'Valor atualizado com sucesso!');

            redirect('orcamento/visualizar/' . $id_orcamento);

//            $view['content'] = 'configuracao/lista_servico';
//            $this->load->model('tb_contratos_servicos_model');
//            $view['servicos'] = $this->tb_contratos_servicos_model->fetch_servicos();
//
//            $this->load->view('template/sistema_content', $view);

        }else{
            $this->visualizar($id_orcamento);
        }

//        $this->load->view('template/sistema_content', $view);
    }


    public function altera_condicoes_pagamento()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('condicoes_pagamento', 'Condições', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        $this->load->model('tb_orcamentos_model');
        $id_orcamento = trim($this->input->post('id_orcamento'));

        if( $this->form_validation->run() == TRUE ) {

            if( !empty( $id_orcamento ) ) {
                $this->tb_orcamentos_model->update();

            }
            $this->session->set_flashdata('sucesso', 'Condição de pagamento atualizada com sucesso!');

            redirect('orcamento/visualizar/' . $id_orcamento);

//            $view['content'] = 'configuracao/lista_servico';
//            $this->load->model('tb_contratos_servicos_model');
//            $view['servicos'] = $this->tb_contratos_servicos_model->fetch_servicos();
//
//            $this->load->view('template/sistema_content', $view);

        }else{
            $this->visualizar($id_orcamento);
        }

//        $this->load->view('template/sistema_content', $view);
    }


    public function altera_observacao()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('observacao', 'Observação', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        $this->load->model('tb_orcamentos_model');
        $id_orcamento = trim($this->input->post('id_orcamento'));

        if( $this->form_validation->run() == TRUE ) {

            if( !empty( $id_orcamento ) ) {
                $this->tb_orcamentos_model->update();

            }
            $this->session->set_flashdata('sucesso', 'Observação atualizada com sucesso!');

            redirect('orcamento/visualizar/' . $id_orcamento);

        }else{
            $this->visualizar($id_orcamento);
        }
    }

    public function altera_servico()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('descricao', 'Serviços', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        $this->load->model('tb_orcamentos_model');
        $id_orcamento = trim($this->input->post('id_orcamento'));

        if( $this->form_validation->run() == TRUE ) {

            if( !empty( $id_orcamento ) ) {
                $this->tb_orcamentos_model->update();

            }
            $this->session->set_flashdata('sucesso', 'Serviços atualizados com sucesso!');

            redirect('orcamento/visualizar/' . $id_orcamento);

        }else{
            $this->visualizar($id_orcamento);
        }
    }
}