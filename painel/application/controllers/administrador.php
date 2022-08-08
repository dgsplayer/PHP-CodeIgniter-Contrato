<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends CI_Controller {

    function __construct(){

        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index()
    {
        $view['content'] = 'administrador/page-lista-usuario';
        $this->load->model('tb_usuarios_model');
        $view['usuarios'] = $this->tb_usuarios_model->fetch_results();
        $this->load->view('template/sistema_content', $view);
    }


    public function cadastro($id_usuario = null)
    {

        $view['content'] = 'administrador/cadastro';
        $this->load->model('tb_usuarios_model');
        $view['usuario'] = $this->tb_usuarios_model->fetch_row( $id_usuario );

        $this->load->view('template/sistema_content', $view);
    }

    public function assinatura()
    {


        $user = $this->session->userdata('contrato_user');

        $view['content'] = 'administrador/assina_documento';
        $this->load->model('tb_pessoas_model');
        $view['cliente'] = $this->tb_pessoas_model->contratoPessoa( $user['id_pessoa']);

        $this->load->view('template/sistema_content', $view);
    }

    public function rubrica()
    {


        $user = $this->session->userdata('contrato_user');

        $view['content'] = 'administrador/assina_rubrica';
        $this->load->model('tb_pessoas_model');
        $view['cliente'] = $this->tb_pessoas_model->contratoPessoa( $user['id_pessoa']);

        $this->load->view('template/sistema_content', $view);
    }

    public function atualiza()
    {

        $user = $this->session->userdata('contrato_user');

        $view['content'] = 'administrador/atualiza';
        $this->load->model('estados_model');
        $this->load->model('tb_pessoas_model');

        $view['cliente'] = $this->tb_pessoas_model->contratoPessoa( $user['id_pessoa']);

        $view['estados'] = $this->estados_model->form_all();
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_cadastro()
    {
        if($this->input->post()) {

            $this->load->library('form_validation');

            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('nome_usuario', 'Nome do Usuário', 'trim|required');
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');


            $this->form_validation->set_rules("celular", "celular", "trim" );

            $id = trim($this->input->post('id'));

            if( empty( $id ) ) {
//                $this->form_validation->set_rules('login', 'Login', 'trim|required|is_unique[tb_usuarios.login]');
                $this->form_validation->set_rules("senha", "Senha", "required|md5" );
            }


            if( $this->form_validation->run() == TRUE ) {
                $this->load->model('tb_usuarios_model');

                if (!empty($id)) {
                    $this->tb_usuarios_model->update();
                    $this->session->set_flashdata('sucesso', 'Usuário atualizado com sucesso!');
                } else {
                    $this->tb_usuarios_model->insert();
                    $this->session->set_flashdata('sucesso', 'Usuário inserido com sucesso!');
                }
                redirect('/administrador');
            }
        }
        $this->cadastro($this->input->post('id'));
    }

    public function processa_atualiza()
    {
        if($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

            if($this->input->post('check_pessoa_fisica') == 't') {
                    $this->form_validation->set_rules('profissao', 'Profissão', 'trim|required');
                    $this->form_validation->set_rules('rg', 'RG', 'trim|required');
                    $this->form_validation->set_rules('cpf', 'CPF', 'trim|required');
                    $this->form_validation->set_rules('telefone', 'DDD + Telefone', 'trim|required');
                    $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
            }else{
                    $this->form_validation->set_rules('inscricao', 'Inscrição Estadual', 'trim|required');
                    $this->form_validation->set_rules('email_j', 'E-mail', 'trim|required|valid_email');
            }

            $this->form_validation->set_rules('cep', 'CEP', 'trim|required');
            $this->form_validation->set_rules('logradouro', 'Logradouro', 'trim|required');
            $this->form_validation->set_rules('numero', 'Número', 'trim|required');
            $this->form_validation->set_rules('bairro', 'Bairro', 'trim|required');
            $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required');
            $this->form_validation->set_rules('estado', 'Estado', 'trim|required');

            if(!empty($_FILES['imagem']['name'])){

                $user = $this->session->userdata('contrato_user');

                $config['upload_path']      = BASEPATH . '../recursos/imagens/logos/';
                $config['allowed_types']    = 'gif|jpg|png|GIF|JPG|PNG';
                $config['max_size']	    = '2000';
                $config['max_width']    = '200';
                $config['max_height']   = '200';
                $filename               = 'thumb' . $user['id_pessoa'] . '.png';
                $config['file_name']    = $filename;
//                preg_replace('"\.(gif|jpg|png|GIF|JPG|PNG)$"', '.png', $filename);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
//                $this->upload->set_allowed_types('*');

//                $_FILES['imagem']['name'] = 'thumb' . $user['id_pessoa'];
                if(file_exists($config['upload_path'].$filename )){
                    unlink($config['upload_path'] . $filename );
                }

                if (!$this->upload->do_upload('imagem')) {

//                    rename($config['upload_path'] . $_FILES['imagem']['name'], $config['upload_path'] . 'thumb' . $user['id_pessoa']);

                    $this->session->set_flashdata('error', $this->upload->display_errors() . '<strong>Atenção:</strong> Sua imagem atual foi excluída.');

                    redirect('administrador/atualiza');

                }else{
//                    $this->session->set_flashdata('sucesso', 'Imagem atualizada com sucesso!');
//                    $imagemPost     = $upload_data['file_name'];
//                    $dados = array(
//                        'titulo' => $this->input->post('titulo'),
//                        'texto'=>$this->input->post('texto'),
//                        'imagem'=>$imagemPost
//                    ) ;
                }
            }

            if( $this->form_validation->run() == TRUE ) {
                $this->load->model('tb_pessoas_model');
                $this->tb_pessoas_model->update_pessoa_pai();
                $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');

                redirect('administrador/atualiza');
            }else{
                $this->atualiza();
            }
        }
    }

    public function page_meus_dados()
    {
        $view['content'] = 'administrador/page-profile';
        $this->load->model('tb_pessoas_model');
        $view['empresa'] = $this->tb_pessoas_model->contratada();
        $view['contratonet'] = $this->tb_pessoas_model->contratonet();

        $user = $this->session->userdata('contrato_user');

        $this->load->model('tb_usuarios_model');
        $view['usuario'] = $this->tb_usuarios_model->fetch_row( $user['id_usuario'] );
        
        $this->load->view('template/sistema_content', $view);
    }

    public function page_resumo()
    {
        $view['content'] = 'administrador/page-resumo';
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_creditos_model');
        $view['empresa'] = $this->tb_pessoas_model->contratada();
        $view['creditos'] = $this->tb_creditos_model->contratos_mes();
        $view['credito_mes'] = $this->tb_creditos_model->credito_mes_vigente();
        $view['credito_usuarios'] = $this->tb_creditos_model->credito_usuarios();
        $view['credito_tipos_contratos'] = $this->tb_creditos_model->credito_tipos_contratos();


        $this->load->view('template/sistema_content', $view);
    }

    public function estaLogado(){
        if($this->session->userdata("logado") != 1){
            redirect("home/");
        }
    }

    public function logout(){
        // GRAVA LOG
        $dados              = array();
        $dados["acao"]      = "Saiu do sistema";
        $dados["lido"]      = "t";
        $this->crud_model->do_insert_log($dados);

        $this->session->sess_destroy();
        redirect("home/");
    }

    public function ajax_remove_assinatura()
    {

        $user = $this->session->userdata('contrato_user');
  
        $data = array('imagem_assinatura'=>'');
        $this->db->where( 'id_pessoa', $user['id_pessoa'] );
        $this->db->update( "tb_pessoas", $data ) ;
 

    }

    public function ajax_salva_assinatura()
    {

        $user = $this->session->userdata('contrato_user');

        $base      = str_replace('data:image/png;base64,','',$_POST['imagedata']);
        $binary   = base64_decode($base);
        $this->load->helper('url');

        if (!$binary) {
            die('invalid image uploaded');
        }
        $rand = mt_rand(0, 0xffff);
        $rand2 = mt_rand(0, 0xffff);
        $arquivo    = base64_encode($user['id_pessoa']);
        $arquivo    = $rand.$arquivo.$rand2.'.png';
        $imagePath  = BASEPATH.'../recursos/imagens/upload_assinaturas/'. $arquivo;


        if (file_exists($imagePath)) {
            $file = @fopen($imagePath, 'w+');
            fwrite($file, $binary);
        } else {
            file_put_contents($imagePath, '');
            $file = @fopen($imagePath, 'w+');
            fwrite($file, $binary);
        }

        $this->load->model('tb_pessoas_model');
        $this->tb_pessoas_model->update_assinatura($arquivo);

        exit;

    }

    public function ajax_salva_rubrica()
    {

        $user = $this->session->userdata('contrato_user');

        $base      = str_replace('data:image/png;base64,','',$_POST['imagedata']);
        $binary   = base64_decode($base);
        $this->load->helper('url');

        if (!$binary) {
            die('invalid image uploaded');
        }
        $rand = mt_rand(0, 0xffff);
        $rand2 = mt_rand(0, 0xffff);
        $arquivo    = base64_encode($user['id_pessoa']);
        $arquivo    = 'Rub'.$rand.$arquivo.$rand2.'.png';
        $imagePath  = BASEPATH.'../recursos/imagens/upload_assinaturas/'. $arquivo;


        if (file_exists($imagePath)) {
            $file = @fopen($imagePath, 'w+');
            fwrite($file, $binary);
        } else {
            file_put_contents($imagePath, '');
            $file = @fopen($imagePath, 'w+');
            fwrite($file, $binary);
        }

        $this->load->model('tb_pessoas_model');
        $this->tb_pessoas_model->update_rubrica($arquivo);

        exit;

    }

}