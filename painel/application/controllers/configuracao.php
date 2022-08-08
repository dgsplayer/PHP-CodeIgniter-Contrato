<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracao extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$view['content'] = 'configuracao/index';

		$this->load->view('template/sistema_content', $view);
	}


    public function lista_servico()
    {
        $view['content'] = 'configuracao/lista_servico';
        $this->load->model('tb_contratos_servicos_model');
        $view['servicos'] = $this->tb_contratos_servicos_model->fetch_servicos();

        $this->load->view('template/sistema_content', $view);
    }

    public function cadastro_servico( $id_servico = null )
    {
        $view['content']                = 'configuracao/cadastro_servico';

        $this->load->model('tb_contratos_servicos_model');
        $view['servicos'] = $this->tb_contratos_servicos_model->fetch_row_servicos( $id_servico);
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_cadastro_servico()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $this->load->model('tb_contratos_servicos_model');
            $id_servico = trim($this->input->post('id'));

            if( !empty( $id_servico ) ) {
                $this->tb_contratos_servicos_model->update();

            } else {
                $this->tb_contratos_servicos_model->insert();
            }

            $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');

            redirect('configuracao/lista_servico');

//            $view['content'] = 'configuracao/lista_servico';
//            $this->load->model('tb_contratos_servicos_model');
//            $view['servicos'] = $this->tb_contratos_servicos_model->fetch_servicos();
//
//            $this->load->view('template/sistema_content', $view);

        }else{
            $view['content'] = 'configuracao/cadastro_servico';
            $this->load->model('tb_contratos_servicos_model');
            $view['servicos'] = $this->tb_contratos_servicos_model->fetch_servicos();

            $this->load->view('template/sistema_content', $view);
        }

//        $this->load->view('template/sistema_content', $view);
    }


    public function cadastro_header()
    {
        $view['content'] = 'configuracao/cadastro_header';
        $this->load->model('tb_contratos_design_model');
        $view['resDesign'] = $this->tb_contratos_design_model->fetch_row();
        $this->load->view('template/sistema_content', $view);
    }
    public function cadastro_multa()
    {
        $view['content'] = 'configuracao/cadastro_multa';
        $this->load->model('tb_contratos_config_model');
        $view['configuracao'] = $this->tb_contratos_config_model->fetch_row();
        // echo '<pre>'.var_export($view['resDesign'],true);exit;
        $this->load->view('template/sistema_content', $view);
    }

	public function processa_cadastro()
	{
        $this->load->library('form_validation');
        if($this->input->post()) {

            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('multa_padrao', 'Multa', 'trim|required');

            if( $this->form_validation->run() == TRUE ) {
                $this->load->model('tb_contratos_config_model');

                $configuracao = $this->tb_contratos_config_model->fetch_row();

                if(empty($configuracao->id)){
                    $this->tb_contratos_config_model->insert();
                }else{
                    $this->tb_contratos_config_model->update();
                }

                $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');

                redirect('configuracao/index');
            }
        }
        $this->index();
	}

    public function processa_headers()
    {
        $this->load->library('form_validation');

        if($this->input->post()) {
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('cor_topo', 'cor do topo', 'trim|required');
            $this->form_validation->set_rules('cor_topo_fonte', 'cor da fonte do topo', 'trim|required');
            $this->form_validation->set_rules('cor_quadro', 'cor das partes', 'trim|required');
            $this->form_validation->set_rules('cor_quadro_fonte', 'cor da fonte das partes', 'trim|required');
            $this->form_validation->set_rules('cor_clausula', 'cor da cláusula', 'trim|required');
            $this->form_validation->set_rules('cor_clausula_fonte', 'cor da fonte da cláusula', 'trim|required');
            $this->form_validation->set_rules('cor_fundo', 'cor do fundo', 'trim|required');

            if( $this->form_validation->run() == TRUE ) {

                $this->load->model('tb_contratos_design_model');
                $this->tb_contratos_design_model->update();



                $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');

                redirect('configuracao/cadastro_header');
            }
        }
        $this->cadastro_header();
    }

}