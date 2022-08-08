<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Templates extends CI_Controller {

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

        $crud->set_table('tb_templates');
        $crud->set_subject('template');
        $crud->columns('categoria', 'link');

        $crud->callback_column('link',array($this, 'geraLink'));

        $output = $crud->render();

        $output->content    = 'contract/crud';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    function geraLink($value, $row){
        return '<a target="_blank" href="' . $row->link . '">' . $row->link . '</a>';
    }

}