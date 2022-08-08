<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function download_contrato( $id_contrato = null )
    {
        $nomeArquivo    = "Contrato_". $id_contrato . "_" . date('d') . "-" . date('m') . "-" . date('Y') . ".pdf";
        $arquivo        = $_SERVER['DOCUMENT_ROOT'] . "/painel/upload/create_pdf/" . $nomeArquivo;

        if (file_exists($arquivo) == TRUE) {
            unlink($arquivo);
        }

        ini_set('memory_limit','32M');

        require_once APPPATH.'third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('pt-BR','A4',9,'verdana','8','8','35','15','8','8');

        $this->load->model('tb_contratos_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_design_model');

        $view['resCon']         = (array) $this->tb_contratos_model->fetch_row($id_contrato);
        $view['resCli']         = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
        $view['resDesign']      = (array) $this->tb_contratos_design_model->fetch_row();
        $view['resAdm']         = (array) $this->tb_pessoas_model->contratada();
        $view['NumContrato']    = $id_contrato;
        $view['texto_base']     = $id_contrato;

        if($this->uri->segment(4) == 'Pre'){
            $mpdf->SetWatermarkText('Pré-Visualizar');
            $mpdf->showWatermarkText = true;
        }

        $html  = $this->load->view('contrato/pdf_creator/pdf_creator_contrato', $view, true);

        $mpdf->SetHTMLHeader($view['resDesign']['header']);
        $mpdf->SetHTMLFooter($view['resDesign']['footer']);
        $mpdf->allow_charset_conversion = true;
        //$mpdf->charset_in = 'iso-8859-1';

        $mpdf->WriteHTML($html);

        $mpdf->Output($arquivo);

        //DELETA CONTRATO PRÉ-VISUALIZAR APÓS GERAR PDF
        if($this->uri->segment(4) == 'Pre'){
            $this->tb_contratos_model->delete($id_contrato);
        }

        redirect("/upload/create_pdf/" . $nomeArquivo);
    }

    public function download_rescisao( $id_contrato = null )
    {
        $nomeArquivo    = "Contrato_Rescisao_". $id_contrato . "_" . date('d') . "-" . date('m') . "-" . date('Y') . ".pdf";
        $arquivo        = $_SERVER['DOCUMENT_ROOT'] . "/painel/upload/create_pdf/" . $nomeArquivo;

        if (file_exists($arquivo) == TRUE) {
            unlink($arquivo);
        }

        ini_set('memory_limit','32M');

        require_once APPPATH.'third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('pt-BR','A4',9,'verdana','8','8','35','15','8','8');

        $this->load->model('tb_contratos_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_design_model');

        $view['resCon']         = (array) $this->tb_contratos_model->fetch_row($id_contrato);
        $view['resCli']         = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
        $view['resDesign']      = (array) $this->tb_contratos_design_model->fetch_row();
        $view['resAdm']         = (array) $this->tb_pessoas_model->contratada();
        $view['NumContrato']    = $id_contrato;
        $view['texto_base']     = $id_contrato;


        $html  = $this->load->view('contrato/pdf_creator/pdf_creator_rescisao', $view, true);

//        $mpdf->SetWatermarkText('Rescisão');
//        $mpdf->showWatermarkText = true;

        $mpdf->allow_charset_conversion = true;

        $mpdf->WriteHTML($html);

        $mpdf->Output($arquivo);

        redirect("/upload/create_pdf/" . $nomeArquivo);
    }

    public function download_distrato( $id_contrato = null )
    {
        $nomeArquivo    = "Contrato_Distrato_". $id_contrato . "_" . date('d') . "-" . date('m') . "-" . date('Y') . ".pdf";
        $arquivo        = $_SERVER['DOCUMENT_ROOT'] . "/painel/upload/create_pdf/" . $nomeArquivo;

        if (file_exists($arquivo) == TRUE) {
            unlink($arquivo);
        }

        ini_set('memory_limit','32M');

        require_once APPPATH.'third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('pt-BR','A4',9,'verdana','8','8','35','15','8','8');

        $this->load->model('tb_contratos_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_design_model');

        $view['resCon']         = (array) $this->tb_contratos_model->fetch_row($id_contrato);
        $view['resCli']         = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
        $view['resDesign']      = (array) $this->tb_contratos_design_model->fetch_row();
        $view['resAdm']         = (array) $this->tb_pessoas_model->contratada();
        $view['NumContrato']    = $id_contrato;
        $view['texto_base']     = $id_contrato;


        $html  = $this->load->view('contrato/pdf_creator/pdf_creator_distrato', $view, true);

//        $mpdf->SetWatermarkText('Distrato');
//        $mpdf->showWatermarkText = true;

        $mpdf->allow_charset_conversion = true;

        $mpdf->WriteHTML($html);

        $mpdf->Output($arquivo);

        redirect("/upload/create_pdf/" . $nomeArquivo);
    }

    public function download_notificacao( $id_contrato = null, $id_parcela = null )
    {
        $nomeArquivo    = "Notificacao_" . date('d') . "-" . date('m') . "-" . date('Y') . ".pdf";
        $arquivo        = $_SERVER['DOCUMENT_ROOT'] . "/painel/upload/create_pdf/" . $nomeArquivo;

        if (file_exists($arquivo) == TRUE) {
            unlink($arquivo);
        }

        ini_set('memory_limit','32M');

        require_once APPPATH.'third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('pt-BR','A4',9,'verdana','8','8','35','15','8','8');

        $this->load->model('tb_contratos_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_parcelas_model');

        $view['resCon']         = (array) $this->tb_contratos_model->fetch_row($this->uri->segment(3));
        $view['resCli']         = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
        $view['resAdm']         = (array) $this->tb_pessoas_model->contratada();
        $view['resParc']        = (array) $this->tb_contratos_parcelas_model->fetch_row($this->uri->segment(4));

        $view['NumContrato']    = $id_contrato;
        $view['texto_base']     = $id_contrato;


        $html  = $this->load->view('contrato/pdf_creator/pdf_creator_notificacao', $view, true);

        $mpdf->allow_charset_conversion = true;

        $mpdf->WriteHTML($html);

        $mpdf->Output($arquivo);

        redirect("/upload/create_pdf/" . $nomeArquivo);
    }

    public function download_recibo( $id_contrato = null, $id_parcela = null )
    {
        $nomeArquivo    = "Recibo_" . date('d') . "-" . date('m') . "-" . date('Y') . ".pdf";
        $arquivo        = $_SERVER['DOCUMENT_ROOT'] . "/painel/upload/create_pdf/" . $nomeArquivo;

        if (file_exists($arquivo) == TRUE) {
            unlink($arquivo);
        }

        ini_set('memory_limit','32M');

        require_once APPPATH.'third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('pt-BR','A4',9,'verdana','8','8','35','15','8','8');

        $this->load->model('tb_contratos_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_parcelas_model');

        $view['resCon']         = (array) $this->tb_contratos_model->fetch_row($this->uri->segment(3));
        $view['resCli']         = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
        $view['resAdm']         = (array) $this->tb_pessoas_model->contratada();
        $view['resParc']        = (array) $this->tb_contratos_parcelas_model->fetch_row($this->uri->segment(4));

        $view['NumContrato']    = $id_contrato;
        $view['texto_base']     = $id_contrato;


        $html  = $this->load->view('contrato/pdf_creator/pdf_creator_recibo', $view, true);

        $mpdf->allow_charset_conversion = true;

        $mpdf->WriteHTML($html);

        $mpdf->Output($arquivo);

        redirect("/upload/create_pdf/" . $nomeArquivo);
    }

    public function download_boleto()
    {

        $this->load->helper('funcoes');

        $this->load->model('tb_contratos_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_bancos_model');

        $view['resCon']         = (array) $this->tb_contratos_model->fetch_row($this->uri->segment(3));
        $view['resCli']         = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
        $view['resAdm']         = (array) $this->tb_bancos_model->fetch_row($this->uri->segment(5));
        $view['resParc']        = (array) $this->tb_contratos_parcelas_model->fetch_row($this->uri->segment(4));
        $view['resAdmDados']    = (array) $this->tb_pessoas_model->contratada();

        $html  = $this->load->view('contrato/boleto/'.retornaLinkBanco($this->uri->segment(5)), $view, true);

        echo $html;
    }

    public function download_aditivo( $id_contrato = null )
    {
        $nomeArquivo    = "Aditivo_" . date('d') . "-" . date('m') . "-" . date('Y') . ".pdf";
        $arquivo        = $_SERVER['DOCUMENT_ROOT'] . "/painel/upload/create_pdf/" . $nomeArquivo;

        if (file_exists($arquivo) == TRUE) {
            unlink($arquivo);
        }

        ini_set('memory_limit','32M');

        require_once APPPATH.'third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('pt-BR','A4',9,'verdana','8','8','35','15','8','8');

        $this->load->model('tb_contratos_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_contratos_adicionais_model');

        $view['resCon']         = (array) $this->tb_contratos_model->fetch_row($this->uri->segment(3));
        $view['resCli']         = (array) $this->tb_pessoas_model->contratoPessoa($view['resCon']['id_pessoa_principal']);
        $view['resAdm']         = (array) $this->tb_pessoas_model->contratada();
        $view['resAdt']         = (array) $this->tb_contratos_adicionais_model->fetch_row($this->uri->segment(4));


        $view['NumContrato']    = $id_contrato;
        $view['texto_base']     = $id_contrato;


        $html  = $this->load->view('contrato/pdf_creator/pdf_creator_aditivo', $view, true);

        $mpdf->allow_charset_conversion = true;

        $mpdf->WriteHTML($html);

        $mpdf->Output($arquivo);

        redirect("/upload/create_pdf/" . $nomeArquivo);
    }
}