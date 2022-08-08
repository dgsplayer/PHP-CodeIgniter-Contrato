<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Chamados_ocorrencias extends CI_Controller {

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

    public function index($state = null, $id_chamado = null)
    {

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $crud->set_table('tb_chamados_ocorrencias');
        $crud->set_subject('Ocorrência');

        $crud->set_relation('id_chamado','tb_chamados','{id_chamado} - {titulo}');
        $crud->set_relation('id_usuario','tb_usuarios','{usuario}');
        $crud->order_by('id_chamado', 'DESC');

        $crud->display_as('id_chamado','Chamado');
        $crud->display_as('id_usuario','Usuário');
        $crud->display_as('ocorrencia','Ocorrência');
        $crud->display_as('ocorrencia_externa','Foi ocorrência externa?');

        $crud->unset_edit();

        $output = $crud->render();

//        $output->content    = 'template/chamados_ocorrencias/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe
        $output->id_chamado = @$id_chamado;

        $this->load->view('template/chamados_ocorrencias/index', $output);
    }
}