<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Usuario extends CI_Controller {

    function __construct(){

        parent::__construct();

        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->helper("array");
        $this->load->helper("funcoes");

        $this->load->library("form_validation");
        $this->load->library("session");
        $this->load->library("email");
        $this->load->library("acl");
        $this->load->library('grocery_CRUD');

        $this->load->model("crud_model");

        $this->load->database();
    }

    public function index()
    {
        $user = $this->session->userdata('contrato_user');

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();
        $crud->set_theme('bootstrap');
        $crud->set_table('tb_pessoas');
        $crud->where('id_pessoa_pai',0);

        $crud->set_subject('Empresa');
        $crud->columns('nome','email','telefone');
        $crud->edit_fields('pessoa','nome', 'rg', 'cpf', 'razao', 'nome_fantasia', 'cnpj',  'inscricao', 'email','cep', 'logradouro','numero','complemento','bairro', 'cidade', 'estado',  'telefone',  'responsavel', 'profissao','rgcontato','rgcontato','nacionalidade_pf','estado_civil'
            ,'cepContato', 'logradouroContato','numeroContato','complementoContato','bairroContato', 'cidadeContato', 'estadoContato',  'telefoneContato','celularContato','docContato','ccm','email_j','celular','telefone_principal');
		$crud->add_fields('id_pessoa_pai','pessoa','nome', 'rg', 'cpf', 'razao', 'nome_fantasia', 'cnpj',  'inscricao', 'email','cep', 'logradouro','numero','complemento','bairro', 'cidade', 'estado',  'telefone',  'responsavel', 'profissao','rgcontato','rgcontato','nacionalidade_pf','estado_civil'
            ,'cepContato', 'logradouroContato','numeroContato','complementoContato','bairroContato', 'cidadeContato', 'estadoContato',  'telefoneContato','celularContato','docContato','ccm','email_j','celular','telefone_principal');
        $crud->required_fields('pessoa' , 'nome','cep', 'logradouro','numero','bairro', 'cidade', 'estado',  'telefone', 'email'); //se mudar aqui mudar também na view a frase Certifique-se de que seus dados cadastrais estão atualizados ...

		$crud->display_as('nome','Nome/Empresa');
        $crud->display_as('razao','Razão');
        $crud->display_as('inscricao','Inscrição');
        $crud->display_as('numero','Número');
        $crud->display_as('email','e-mail');
        $crud->display_as('email_j','e-mail do trabalho');
        $crud->display_as('responsavel','responsável');
        $crud->display_as('pessoa','(J)uridica, (F)ísica');


//        $crud->field_type('id_pessoa_pai','hidden', '100867');
		$crud->field_type('id_usuario_criador','hidden', 0);
		$crud->field_type('id_pessoa_pai','hidden', 0);

        $output = $crud->render();

        $output->content    = 'grocery/puro';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    
}