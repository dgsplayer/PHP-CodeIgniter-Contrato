<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailmarketing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index()
    {

        //lista de permissoes
        $this->load->model('tb_pessoas_model');
        $view['rows'] = $this->tb_pessoas_model->fetch_cliente();

        $view['content'] = 'mailmarketing/index';
        $this->load->view('template/sistema_content', $view);
    }

    public function atualiza_senha()
    {
        $view['content'] = 'dashboard/atualiza_senha';
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_senha()
    {
        if($this->input->post()) {

            $this->load->library('form_validation');

            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

            $this->form_validation->set_rules("senha", "Senha", "trim|required|md5" );
//            $this->form_validation->set_rules("senhaConfirma", "Confirma Senha", "trim|required|md5" );

            if( $this->form_validation->run() == TRUE ) {

                $this->load->model('tb_usuarios_model');

                $this->tb_usuarios_model->atualiza_senha();
                $this->session->set_flashdata('sucesso', 'Senha atualizada com sucesso!');

                redirect('/dashboard');
            }else{
                $view['content'] = 'dashboard/atualiza_senha';
                $this->load->view('template/sistema_content', $view);
            }
        }

    }

    public function updateLido()
    {
        $this->load->model('tb_avisos_model');
        header('Content-Type: application/json');

        $this->tb_avisos_model->updateLido( $this->uri->segment(3) );

        redirect('dashboard/index');
    }

    public function update_process()
    {
        $this->load->library('forum');
        $this->load->model('tb_jur_processo_model');

        foreach( $this->tb_jur_processo_model->fetch_all() as $processo) {
            $html = $this->forum->getAndamento($processo->num_processo);
            $this->forum->getNews($html, $processo->num_processo);
        }
    }

    public function cron_update_andamento()
    {
        $this->load->library('forum');
        $this->load->model('tb_jur_processo_model');
        foreach( $this->tb_jur_processo_model->fetch_all_processo_andamento() as $processo) {
            $html = $this->forum->getAndamento($processo->num_processo);
            $this->forum->getNews($html, $processo->num_processo);
        }   
    }
}