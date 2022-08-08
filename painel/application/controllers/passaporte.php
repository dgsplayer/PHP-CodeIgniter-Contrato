<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passaporte extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{

        $this->load->view('invalid/not_found');
	}

    public function ver_documento_externo()
    {

        $this->session->unset_userdata('contrato_user');

        $this->uri->segment(3);

        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_model');

        $view['pessCon']        = $this->tb_pessoas_model->contratoPessoa(base64_decode($this->uri->segment(3)));
        $view['razaoCon']       = $this->tb_pessoas_model->contratoPessoa($view['pessCon']->id_pessoa_pai);
        $view['resCon1']        = $this->tb_contratos_model->fetch_row(base64_decode($this->uri->segment(4)));

//        $view['content'] = 'cobranca/pagamento_receber';
//        $this->load->model('tb_contratos_parcelas_model');
//        $view['cobrancas'] = $this->tb_contratos_parcelas_model->fetch_pagamento_receber();
//        $this->load->view('template/sistema_content', $view);
        $this->load->view('passaporte/ver_documento_externo', $view);
        //redirect('passaporte/ver_documento_externo');
    }

}