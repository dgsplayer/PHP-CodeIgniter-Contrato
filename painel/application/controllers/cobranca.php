<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cobranca extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}
	
	public function pagamento_receber()
	{
		$view['content'] = 'cobranca/pagamento_receber';
		$this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_bancos_model');
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $view['bancos']          = $this->tb_bancos_model->fetch_bancos();
		$view['cobrancas'] = $this->tb_contratos_parcelas_model->fetch_pagamento_receber();

		$this->load->view('template/sistema_content', $view);
	}

	public function processa_efetuar_pagamento()
	{	
		$this->load->model('tb_contratos_parcelas_model');
		if( $this->tb_contratos_parcelas_model->set_array_recebido( $this->input->post('ids') ) ) {
			echo json_encode(array('pago' => true));

//        $this->enviar_recibo();

			// aqui enviar email de confirmação do pagamento recibo em anexo
		} else {
			echo json_encode(array('pago' => false));
		}
		die();
	}

	public function pagamento_recebido()
	{
		$view['content'] = 'cobranca/pagamento_recebido';
		$this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
		$view['cobrancas'] = $this->tb_contratos_parcelas_model->fetch_pagamento_recebido();
		$this->load->view('template/sistema_content', $view);
	}

	public function pagamento_cancelado()
	{
		$view['content'] = 'cobranca/pagamento_cancelado';
		$this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
		$view['cobrancas'] = $this->tb_contratos_parcelas_model->fetch_pagamento_cancelados();
		$this->load->view('template/sistema_content', $view);
	}

	public function processa_cancelamento()
	{
		$this->load->model('tb_contratos_parcelas_model');
		if( $this->tb_contratos_parcelas_model->set_array_cancelados( $this->input->post('ids') ) ) {
			echo json_encode(array('cancelamento' => true));
		} else {
			echo json_encode(array('cancelamento' => false));
		}
		die();
	}

	public function acordo_realizado()
	{
		$view['content'] = 'cobranca/acordo_realizado';
		$this->load->model('tb_contratos_parcelas_model');
		$view['cobrancas'] = $this->tb_contratos_parcelas_model->acodos_realizados();
		$this->load->view('template/sistema_content', $view);
	}

	public function recibo( $id_parcela = null )
	{	

		var_dump($id_parcela);exit();


		$arquivo = $_SERVER['DOCUMENT_ROOT'] . "/painel/upload/create_pdf/Sistema_ContratoNet_". $id_orcamento .".pdf";
		if (file_exists($arquivo) == TRUE) {
			unlink($arquivo);
		}

		ini_set('memory_limit','32M');

		require_once APPPATH.'third_party/mpdf/mpdf.php';
		$mpdf = new mPDF('pt-BR','A4',9,'verdana','8','8','35','15','8','8');


		$this->load->model('tb_orcamentos_model');
		$this->load->model('tb_pessoas_model');

		$view['resCon'] = (array) $this->tb_orcamentos_model->fetch_row( $id_orcamento );
		$view['resCli'] = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
		$view['resAdm'] = (array) $this->tb_pessoas_model->contratada();
		$view['NumOrcamento'] = $id_orcamento;

		$html = $this->load->view('orcamento/pdf_recibo', $view, true);

		if(!empty($watermark)){
			$mpdf->SetWatermarkText($watermark);
			$mpdf->showWatermarkText = true;
		}
		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->allow_charset_conversion = true;
		//$mpdf->charset_in = 'iso-8859-1';
		$mpdf->WriteHTML($html);

		$mpdf->Output($arquivo);

		redirect("/upload/create_pdf/Sistema_ContratoNet_". $id_orcamento .".pdf");
	}

    public function enviar_recibo()
    {
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_model');
        $this->load->model('tb_contratos_parcelas_model');

        $email                  = $this->input->post('email');
        $id_complementar        = $this->input->post('id_complementar');
        $banco                  = base64_encode($this->input->post('bancoEscolhido' . $id_complementar));

        $view['contratos']      = $this->tb_contratos_model->fetch_row($this->input->post('id_contrato'));
        $view['cliente']        = $this->tb_pessoas_model->contratoPessoa($view['contratos']->id_pessoa_pai);
        $view['clientela']      = $this->tb_pessoas_model->contratoPessoa($view['contratos']->id_pessoa_principal);
        $view['resParc']        = (array) $this->tb_contratos_parcelas_model->fetch_row($id_complementar);

        //validando cliente
        $id_contrato            = base64_encode($this->input->post('id_contrato'));
        $cod_verificacao        = rand(100, 50000); // TROCAR POR MD5

        //informacao de data no formato correto do modelo solicitado para o email
        $data                   = date('d/m/Y');
        $hora                   = date ("H:i");
        $tipo_documento         = base64_encode($this->input->post('checkDocumento'));
        $id_complementar        = (!empty($id_complementar)) ? base64_encode($id_complementar) : rand(100, 50000);
//        $id_complementar      = base64_encode($id_complementar) ;

//        $assunto    = $this->input->post('checkDocumento') . " via email";
        $assunto    = "Confirmação de Pagamento de Fatura";
        $assunto    = sprintf('=?%s?%s?%s?=', 'UTF-8', 'B', base64_encode($assunto));

        //definindo link para o email
        $view['data']       = $data;
        $view['hora']       = $hora;
        $view['documento']  = $this->input->post('checkDocumento');

        $message  = $this->load->view('template_emails/documento_recibo', $view, true);

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= 'From: ' . $view['cliente']->nome . ' <no-reply@contratonet.com.br>' . "\r\n" ;

        //envio do email ao cliente
        $email = "xxx@gmail.com";
        mail($email, $assunto, $message , $headers);
//        $this->session->set_flashdata('sucesso', 'E-mail do boleto enviado com sucesso!');

//        redirect("/contrato/");
    }

}