<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fornecedor extends CI_Controller {

    protected $custom_error;

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index()
    {
        $view['content'] = 'fornecedor/index';
        $this->load->model('tb_pessoas_model');
        $view['clientes'] = $this->tb_pessoas_model->fetch_fornecedor();

        $count = 0;
        foreach($view['clientes'] as $cont){
            if(!empty($cont->clienteIncompleto)) $count++;
        }

        $view['count_incompletos'] = $count;
        $this->load->view('template/sistema_content', $view);
    }

    public function novo_contrato( $id_cliente = null )
    {
        $view['content'] = 'fornecedor/novo_contrato';
        $this->load->view('template/sistema_content', $view);
    }

    public function historico_cliente( $id_cliente )
    {
        $view['content'] = 'fornecedor/historico_cliente';
        $this->load->model('tb_usuarios_model');

        $view['cliente'] = (object) array( 'id_cliente' => $id_cliente );

        $view['contatos'] = $this->tb_usuarios_model->get_admin_contato();
        $this->load->view('template/sistema_content', $view);
    }

    public function cadastro( $id_cliente = null )
    {
        $view['content'] = 'fornecedor/cadastro';
        $this->load->model('estados_model');
        $this->load->model('tb_pessoas_model');

        $view['cliente'] = $this->tb_pessoas_model->fetch_row( $id_cliente, 'FORNECEDOR');

        $view['estados'] = $this->estados_model->form_all();
        $this->load->view('template/sistema_content', $view);
    }

    public function detalhe( $id_cliente = null )
    {

        if($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('descricao', 'observação', 'trim|required');

            if( $this->form_validation->run() == TRUE ) {
                $this->load->model('tb_pessoas_historico_model');
                $this->session->set_flashdata('sucesso', 'Observação cadastrada com sucesso!');
                $this->tb_pessoas_historico_model->insert();

                redirect('fornecedor/detalhe/'.$id_cliente);
            }

        }

        $view['content'] = 'fornecedor/detalhe';
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_pessoas_historico_model');

        $view['cliente']    = $this->tb_pessoas_model->fetch_row( $id_cliente);
        $view['historicos']  = $this->tb_pessoas_historico_model->fetch_historicos( $id_cliente );

        $this->load->view('template/sistema_content', $view);
    }

    public function delete_historico( $id )
    {
        $this->load->model('tb_pessoas_historico_model');

        $cliente   = $this->tb_pessoas_historico_model->fetch_row_historico( $id);

        if( $this->tb_pessoas_historico_model->delete( $id ) ) {
            $this->session->set_flashdata('sucesso', 'Observação removida com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }

        redirect('fornecedor/detalhe/' . $cliente->id_pessoa );
    }

    public function delete( $id )
    {
        $this->load->model('tb_pessoas_model');
        if( $this->tb_pessoas_model->delete( $id ) ) {
            $this->session->set_flashdata('sucesso', 'Fornecedor removido com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('fornecedor');
    }

    public function processa_historico()
    {
        $this->load->model('tb_logs_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('historico', 'Histórico', 'trim|required');

        if( $this->form_validation->run() == TRUE ) {
            $this->session->set_flashdata('sucesso', 'histórico cadastrado com sucesso!');
            $this->tb_logs_model->insert_history_cliente();
            redirect('fornecedor');
        }

        $this->historico_cliente( $this->input->post('id_cliente') );
    }

    public function processa_cadastro()
    {
        if($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            switch ( strtoupper($this->input->post('pessoa')) ) {
                case 'F':
                    $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
                    $this->form_validation->set_rules('profissao', 'Profissão', 'trim|required');
                    $this->form_validation->set_rules('rg', 'RG', 'trim|required');
                    $this->form_validation->set_rules('cpf', 'CPF', 'trim|required');
                    $this->form_validation->set_rules('telefone', 'DDD + Telefone', 'trim|required');
                    $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
                    $view['cliente'] = (object) array('pessoa' => 'F');
                    break;
                case 'J':
                    $this->form_validation->set_rules('razao', 'Razão Social', 'trim|required');
                    $this->form_validation->set_rules('cnpj', 'CNPJ', 'trim|required');
               //     $this->form_validation->set_rules('inscricao', 'Inscrição Estadual', 'trim|required');
                    $this->form_validation->set_rules('email_j', 'E-mail', 'trim|required|valid_email');
                    $this->form_validation->set_rules('telefone_principal', 'Telefone', 'trim|required');
                    $view['cliente'] = (object) array('pessoa' => 'J');
                    break;
            }

            $this->form_validation->set_rules('cep', 'CEP', 'trim|required');
			
            $this->form_validation->set_rules('logradouro', 'Logradouro', 'trim|required');
            $this->form_validation->set_rules('numero', 'Número', 'trim|required');
            $this->form_validation->set_rules('bairro', 'Bairro', 'trim|required');
            $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required');
            $this->form_validation->set_rules('estado', 'Estado', 'trim|required');

			$this->form_validation->set_rules('complemento', 'Complemento', 'trim');
			$this->form_validation->set_rules('apelido', 'apelido', 'trim');
			$this->form_validation->set_rules('nacionalidade_pf', 'nacionalidade_pf', 'trim');
			$this->form_validation->set_rules('celular', 'celular', 'trim');
			$this->form_validation->set_rules('nome_fantasia', 'nome_fantasia', 'trim');
			$this->form_validation->set_rules('ccm', 'ccm', 'trim');
			$this->form_validation->set_rules('doc', 'doc', 'trim');
			
			$this->form_validation->set_rules('responsavel', 'responsavel', 'trim');
			$this->form_validation->set_rules('email_responsavel', 'email_responsavel', 'trim');
			$this->form_validation->set_rules('rgContato', 'rgContato', 'trim');
			$this->form_validation->set_rules('cpfContato', 'cpfContato', 'trim');
			$this->form_validation->set_rules('nacionalidade', 'nacionalidade', 'trim');
			$this->form_validation->set_rules('civil', 'civil', 'trim');
			$this->form_validation->set_rules('telefoneContato', 'telefoneContato', 'trim');
			$this->form_validation->set_rules('celularContato', 'celularContato', 'trim');
			$this->form_validation->set_rules('cepContato', 'cepContato', 'trim');
			$this->form_validation->set_rules('logradouroContato', 'logradouroContato', 'trim');
			$this->form_validation->set_rules('numeroContato', 'numeroContato', 'trim');
			$this->form_validation->set_rules('bairroContato', 'bairroContato', 'trim');
			$this->form_validation->set_rules('complementoContato', 'complementoContato', 'trim');
			$this->form_validation->set_rules('cidadeContato', 'cidadeContato', 'trim');
			
            if( $this->form_validation->run() == TRUE ) {
                $this->load->model('tb_pessoas_model');
                $id_pessoa = trim($this->input->post('id_pessoa'));
                if( !empty( $id_pessoa ) ) {
                    $this->tb_pessoas_model->update('FORNECEDOR');
                    $this->session->set_flashdata('sucesso', 'Fornecedor atualizado com sucesso!');
                } else {
                    $this->tb_pessoas_model->insert('FORNECEDOR');
                    $this->session->set_flashdata('sucesso', 'Fornecedor cadastrado com sucesso!');
                }
                redirect('fornecedor');
            }

        }
        $this->cadastro( $this->input->post('id_pessoa') );
    }

    public function importar_exportar()
    {
        $view['content'] = 'fornecedor/importar_exportar';
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_importacao()
    {
        if( count($_FILES['file']) ) {

            if($_FILES && substr($_FILES['file']['name'],strrpos($_FILES['file']['name'],'.')+1)=='xls') {
                $user = $this->session->userdata('contrato_user');

                $file = date("YmdHis", time()).'-'. $user["id_pessoa"] .'-importacao.xls';
                if(!rename($_FILES['file']['tmp_name'],'upload/upload_arquivos_importados/'.$file)){
                    echo "a";
                }
            }elseif($_FILES && substr($_FILES['file']['name'],strrpos($_FILES['file']['name'],'.')+1)!='xls') {
                echo "erro 1";
            }else{
                echo "erro";
            }

        }

        $this->load->library('Excel');
        $this->load->model('tb_pessoas_model');

        $excel = PHPExcel_IOFactory::load('upload/upload_arquivos_importados/'. $file);
        foreach ($excel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow();
            $highestColumn      = $worksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString( $highestColumn );
            $nrColumns = ord($highestColumn) - 64;

            $a = array();
            for ($row = 2; $row <= $highestRow; ++ $row) {

                $dados = array();
                $dados['data_cad'] 			= date('Y') . '-' . date('m') . '-' . date('d');
                $user = $this->session->userdata('contrato_user');
                $dados['id_pessoa_pai'] 	= $user['id_pessoa'];
                $dados['tipo_pessoa']    	= 'FORNECEDOR';
                $dados['id_usuario_criador']	= $this->session->userdata('id_usuario');

                $crz = $worksheet->getCellByColumnAndRow(1, $row);
                $cnome = $worksheet->getCellByColumnAndRow(0, $row);
                $cins = $worksheet->getCellByColumnAndRow(2, $row);
                $ctel = $worksheet->getCellByColumnAndRow(3, $row);
                $cemail = $worksheet->getCellByColumnAndRow(4, $row);
                $cctel = $worksheet->getCellByColumnAndRow(5, $row);

                $razaoFormatada = str_replace('.','', $crz->getValue() );
                $razaoFormatada = str_replace('-','',$razaoFormatada);
                if(strlen($razaoFormatada) > 11 ) {
                    $dados["razao"]                 = $cnome->getValue();
                    $dados["nome"]                  = $cnome->getValue();
                    $dados["cnpj"]                  = $crz->getValue();
                    $dados["inscricao"]             = $cins->getValue();
                    $dados["telefone_principal"]    = $ctel->getValue();
                    $dados["email_j"]               = $cemail->getValue();
                    $dados["celularContato"]        = $cctel->getValue();
                    $dados["pessoa"]                = 'J';
                    /*$dados["logradouro"]               = $linha[7];
                    $dados["logradouroContato"]        = $linha[8];
                    $dados["responsavel"]              = $linha[9];
                    $dados["rgContato"]              = $linha[10];*/
                }else{
                    $dados["nome"]                  = $cnome->getValue();
                    $dados["cpf"]                   = $crz->getValue();
                    $dados["rg"]                    = $cins->getValue();
                    $dados["telefone"]              = $ctel->getValue();
                    $dados["email"]                 = $cemail->getValue();
                    $dados["celular"]               = $cctel->getValue();
                    $dados["pessoa"]                = 'F';
                }
                $this->tb_pessoas_model->insert_all( $dados );
            }
        }
        $this->session->set_flashdata('sucesso', 'Fornecedors importado com sucesso!');
        redirect('fornecedor/index');
    }

}