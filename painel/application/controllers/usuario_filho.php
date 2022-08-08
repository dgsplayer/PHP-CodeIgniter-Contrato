<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Usuario_filho extends CI_Controller {

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
        $crud->set_table('tb_usuarios');

        $crud->set_subject('Usuario');

        $crud->columns('id_pessoa','nome_usuario','usuario','email','celular','nivel','data_cad');
        
        // $crud->unset_edit();
        $crud->edit_fields('nome_usuario', 'celular');
        $crud->add_fields('id_pessoa','nome_usuario','usuario','email','celular','senha');
        $crud->required_fields('id_pessoa','nome_usuario','usuario','email','celular','senha');
 
        $crud->display_as('nome_usuario','Nome');
        $crud->display_as('id_pessoa','Empresa mãe');
        $crud->callback_before_insert(array($this,'posts_control'));
        $crud->change_field_type('senha','password');
        $crud->set_relation('id_pessoa','tb_pessoas','{nome}','id_pessoa_pai = 0');
        $output = $crud->render();

        $output->content    = 'grocery/puro';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    function posts_control($post_array)
    {
        $user = $this->session->userdata('contrato_user');
        // $post_array['id_empresa'] = $user['id_empresa'];
        $post_array['first_login'] = 't';
        $post_array['id_tipo_usuario'] = 3;
        $post_array['nivel'] = 'Admin';

        $this->load->helper('security');
        $post_array['senha'] = do_hash($post_array['senha'], 'md5');

        return $post_array;

    }

}