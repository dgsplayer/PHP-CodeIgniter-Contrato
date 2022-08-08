<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Orcamentos_modelos extends CI_Controller {

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


        $this->load->database();

    }

    public function index()
    {

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();
        $crud->set_theme('bootstrap');
        $crud->set_table('tb_orcamentos_modelos');
        $crud->set_subject('modelo de proposta');
        $crud->columns('titulo', 'valor_total');

        $crud->required_fields('titulo', 'descricao','valor_total', 'validade', 'prazo');
//        $crud->set_relation('id_chamado','tb_chamados','{id_chamado} - {titulo}');
//        $crud->set_field_upload('arquivo', 'recursos/chamados/');

        $crud->display_as('validade','Validade em dias corridos');
        $crud->display_as('prazo','Prazo de execução');
//        $crud->unset_edit();

        $output = $crud->render();

        $output->content    = 'contract/true';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }
}