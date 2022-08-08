<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Sla extends CI_Controller {

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

        $crud->set_table('tb_sla');
        $crud->set_subject('sla');
//        $crud->columns('sla','previsao_em_dias');

        $crud->required_fields('sla','previsao_em_dias');
        $crud->edit_fields('sla','previsao_em_dias');
        $crud->add_fields('sla','previsao_em_dias');
        $crud->display_as('previsao_em_dias','Previsão em dias úteis');

        $output = $crud->render();

        $output->content    = 'grocery/index';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

//    public function cadastro($id = null)
//    {
//        $view['content']    = 'template/sla/cadastro';
//        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe
//
//
//        if(!empty($id)) {
//            $view['dados'] = $this->tb_sla_model->row($id);
//            $view['id']   = $id;
//        }
//
//        $this->load->view('template/sistema_content', $view);
//    }
//
//    public function processa_cadastro()
//    {
//
//        $this->form_validation->set_rules('nome', 'nome', 'trim|required');
//        $this->form_validation->set_rules('previsao_em_dias', 'previsão em dias', 'trim|required');
//        $this->form_validation->set_rules('prioridade', 'prioridade', 'trim|required');
//
//        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
//
//        if( $this->form_validation->run() == TRUE ) {
//            $data           = $this->input->post();
//
//            if(empty($id)) {
//
//                $this->tb_sla_model->insert($data);
//            }else{
//                $this->tb_sla_model->update($id, $data);
//            }
//
//
//            redirect('/sla');
//
//        }else{
//           $this->cadastro();
//        }
//    }
//
//    public function detalhe($id)
//    {
//        $view['content']    = 'template/sla/detalhe';
//        $view['dados']      = $this->tb_sla_model->row( $id );
//        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe
//
//        $this->load->view('template/sistema_content', $view);
//    }
//
//    public function delete( $id )
//    {
//        if( $this->tb_sla_model->delete( $id ) ) {
//            $this->session->keep_flashdata('sucesso', 'Removido com sucesso!');
//        } else {
//            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
//        }
//
//redirect('sla/');
//
////redirect('sla/');
//       // $this->index();
//    }


}