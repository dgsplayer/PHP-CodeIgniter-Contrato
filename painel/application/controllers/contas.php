<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Contas extends CI_Controller {

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
        $crud->set_table('tb_financeiro_conta');
        $crud->set_subject('Contas');
        $crud->where('id_pessoa_pai',$user['id_pessoa']);
        $crud->columns('nome');
        $crud->field_type('id_pessoa_pai','hidden', $user['id_pessoa']);

        $output = $crud->render();

        $output->content    = 'grocery/puro';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }
 
}