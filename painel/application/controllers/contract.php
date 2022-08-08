<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Contract extends CI_Controller {

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


        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $crud->set_table('tb_contratos_tipos');
        $crud->set_subject('tipo de contrato para clientes');

        $output = $crud->render();

        $output->content    = 'contract/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    public function index_fornecedor()
    {


        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $crud->set_table('tb_contratos_tipos_fornecedor');
        $crud->set_subject('tipo de contrato para fornecedor');

        $output = $crud->render();

        $output->content    = 'contract/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    public function empresas()
    {

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $crud->set_table('tb_pessoas');
        $crud->set_subject('empresas');
        $crud->where('id_pessoa_pai = 0');
        $crud->order_by('nome');
        $crud->columns('nome', 'email','status');
        $crud->unset_fields('id_pessoa_pai', 'data_cad', 'conheceu', 'tem_gestao', 'login_temporario', 'ativo', 'imagem_rubrica', 'imagem_assinatura',
            'check_pessoa_fisica','avisos','plano','tem_boletos','tipo_contrato_disponivel','usuarios_disponiveis','contratos_disponiveis', 'id_usuario_criador');
        $crud->display_as('email_j','Email Pessoa Juridica');

      //  $crud->set_relation('id_pessoa','tb_pessoas','{nome}');

        $output = $crud->render();

        $output->content    = 'contract/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    public function bancos()
    {

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $crud->set_table('tb_pessoas_bancos');
        $crud->set_subject('bancos');
        $crud->set_relation('id_pessoa_pai','tb_pessoas','{nome}','id_pessoa_pai = 0');
        $crud->unset_columns('taxa_boleto');
       // $crud->order_by('nome');
//        $crud->columns('nome', 'email','status');

        $output = $crud->render();

        $output->content    = 'contract/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    public function vinc_cliente()
    {

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $user = $this->session->userdata('contrato_user');

        // $this->db->select('id, tipo');
        $crud->where('id_pessoa_pai', $user['id_pessoa'] );
        $crud->columns('texto_base_objeto', 'texto', 'tipo' );

        $crud->set_table('tb_contratos_tipos_x_pessoas');
        $crud->set_subject('contrato x cliente');
        $crud->set_theme('bootstrap');
		$crud->field_type('id_pessoa_pai','hidden', $user['id_pessoa']);
        // $crud->where('id_pessoa_pai = 0');
        // $crud->set_relation('id_pessoa_pai','tb_pessoas','{nome}','id_pessoa_pai = 0');


        //  $crud->order_by('nome');
//        $crud->columns('nome', 'email','status');

        $output = $crud->render();

        $output->content    = 'contract/true';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    public function vinc_fornecedor()
    {

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $crud->set_table('tb_contratos_tipos_fornecedor_x_pessoas');
        $crud->set_subject('contrato x fornecedor');
        $crud->set_relation('id_pessoa_pai','tb_pessoas','{nome}','id_pessoa_pai = 0');

        $crud->order_by('nome');
//        $crud->columns('nome', 'email','status');

        $output = $crud->render();

        $output->content    = 'contract/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }


}