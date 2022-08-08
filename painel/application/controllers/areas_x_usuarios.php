<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Areas_x_usuarios extends CI_Controller {

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

        $crud->set_table('tb_area_x_usuarios');
        $crud->set_subject('áreas dos usuários');
//        $crud->columns('nome');

        $crud->required_fields('id_area', 'id_usuario');
        $crud->set_relation('id_usuario','tb_usuarios','{nome_usuario}');
        $crud->set_relation('id_area','tb_area','{area}');
        $crud->display_as('id_usuario','Usuário');
        $crud->display_as('id_area','Área');
//        $crud->edit_fields('nome');
//        $crud->add_fields('nome');
//        $crud->display_as('previsao_em_dias','Previsão em dias úteis');

        $output = $crud->render();

        $output->content    = 'grocery/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }
/*
    public function cadastro($id = null)
    {
        $view['content']    = 'template/areas/cadastro';
        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe
        $arrayCheckes               = array();

        $view['submenus']   = $this->tb_usuarioss_model->rows();
        if(!empty($id)) {
            $data['servicos'] = $this->tb_area_x_id_usuario_model->rows($id);

            if (!empty($data['servicos'])) foreach ($data['servicos'] as $checkes) {
                $arrayCheckes[] = $checkes['id_usuario'];
            }
        }

        $view['checkes'] = $arrayCheckes;

        if(!empty($id)) {
            $view['dados'] = $this->tb_area_model->row($id);
            $view['id']   = $id;
        }

        $this->load->view('template/sistema_content', $view);
    }

    public function processa_cadastro()
    {

        $this->form_validation->set_rules('nome', 'nome', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {
            $data           = $this->input->post();
            $check_todos = $this->input->post('check_todos');
            $id = $this->input->post('id');

            unset($data['check_todos']);

            if(empty($id)) {

                $this->tb_area_model->insert($data);
                $id_area             = $this->db->insert_id();

                if(!empty($check_todos)){
                    foreach($check_todos as $value){
                        $dados               = array();
                        $dados['id_area']   = $id_area;
                        $dados['id_usuario'] = $value;
                        $this->tb_area_x_id_usuario_model->insert($dados);

                    }
                }


            }else{
                $this->tb_area_model->update($id, $data);

                $this->tb_area_x_id_usuario_model->delete($id);

                if(!empty($check_todos)){
                    foreach($check_todos as $value){
                        $dados               = array();
                        $dados['id_area']   = $id;
                        $dados['id_usuario'] = $value;
                        $this->tb_area_x_id_usuario_model->insert($dados);

                    }
                }

            }


            redirect('/areas');

        }else{
           $this->cadastro(); 
        }
    }

    public function detalhe($id)
    {
        $view['content']    = 'template/areas/detalhe';
        $view['dados']      = $this->tb_area_model->row( $id );
        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $view);
    }

    public function delete( $id )
    {
        if( $this->tb_area_model->delete( $id ) ) {
            $this->session->keep_flashdata('sucesso', 'Removido com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }

redirect('areas/');

//redirect('areas/');
       // $this->index();
    }

*/
}