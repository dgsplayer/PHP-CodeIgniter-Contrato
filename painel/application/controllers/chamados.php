<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Chamados extends CI_Controller {

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
        $this->load->model("chamados_model");
        $this->load->model("tb_usuarios_model");
        $this->load->model("tb_area_model");
        $this->load->model("tb_status_model");
        $this->load->model("tb_chamados_ocorrencias_model");

        $this->load->database();
    }

    public function index( )
    {

        $this->form_validation->set_rules('data', 'data', 'trim');
        $this->form_validation->set_rules('descricao', 'descricao', 'trim');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        $view['dados']              = $this->chamados_model->rows('tb_chamados.id_status <> 7 AND tb_chamados.id_chamado > 100 ');

        $view['areas']              = $this->tb_area_model->rows();
        foreach( $view['areas'] as $row ) {
            $view["area"][$row['id_area']] = $row['area'];
        }
        $view['content']            = 'template/chamados/index';
        $view['class']              = strtolower(get_called_class()); //retorna o nome da classe

        //lista administradores
        $rows        = $this->tb_usuarios_model->rows();
        foreach( $rows as $row ) {
            $view["admin"][$row['id_usuario']] = $row['usuario'];
        }

        //lista status
        $rows        = $this->tb_status_model->rows();
        foreach( $rows as $row ) {
            $view["status"][$row['id_status']] = $row['status'];
        }

        $this->load->view('template/sistema_content', $view);
    }

    public function detalhe($id)
    {
        $view['content']    = 'template/chamados/detalhe';
        $view['dados']      = $this->crud_model->get_by_id( 'tb_chamados', $id , 'id_chamado' );

        $view['class']      = strtolower(get_called_class()); //retorna o nome da classe
        date_default_timezone_set('America/Sao_Paulo');

        //lista administradores
        $rows      = $this->crud_model->get_by_something( 'tb_usuarios');
        foreach( $rows as $row ) {
            $view["admin"][$row->id_usuario] = $row->usuario;
        }

        //lista chamados
        $rows   = $this->chamados_model->rows();
        foreach( $rows as $row ) {
            $view["chamados"][0] = "0";
            $view["chamados"][$row->id_chamado] = $row->id_chamado . ' - ' . $row->titulo;
        }

        //lista status
        $rows      = $this->crud_model->get_by_something( 'tb_status');
        foreach( $rows as $row ) {
            $view["status"][$row->id_status] = $row->status;
        }

        //lista areas
        $rows      = $this->crud_model->get_by_something( 'tb_area');
        foreach( $rows as $row ) {
            $view["areas"][$row->id_area] = $row->area;
        }

        //lista motivos
        $rows      = $this->crud_model->get_by_something( 'tb_sla');
        foreach( $rows as $row ) {
            $view["motivos"][$row->id_sla] = $row->sla;
        }
        $view['anexos']         = $this->crud_model->get_by_something( 'tb_chamados_anexos', null, 'id_chamado = ' . $id );
        $view['rows']           = $this->crud_model->get_by_something( 'tb_chamados_ocorrencias', null, 'id_chamado = ' . $id , 'id_ocorrencia DESC');

        $view['date']           = date('d/m/Y');

        $this->load->view('template/sistema_content', $view);
    }

    public function altera_porcentagem()
    {

        $this->form_validation->set_rules('percentual', 'percentual', 'trim');
        $this->form_validation->set_rules('ocorrencia', 'ocorrencia', 'trim');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $data_array                 = $this->input->post();
            $date_now                   = date('Y-m-d');

            $data                       = array();
            $data['id_usuario']         = $this->session->userdata("id_usuario");
            $data['ocorrencia']         = (!empty($data_array['ocorrencia'])) ? $data_array['ocorrencia'] : 'Alterada porcentagem';
            $data['id_chamado']         = $data_array['id_chamado'];
            $data['id_area']            = $data_array['id_area'];
            $data['id_responsavel']     = $data_array['id_responsavel'];
            $data['percentual']         = $data_array['percentual'];
            $data['data']               = $date_now;
            $this->tb_chamados_ocorrencias_model->insert($data);


            $data                       = array();
            $data['percentual']         = $data_array['percentual'];
            $this->chamados_model->update($data_array['id_chamado'],$data);

            $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');
            redirect('chamados/detalhe/' . $data_array['id_chamado']);

        }

        redirect('chamados/detalhe/' . $data_array['id_chamado']);

    }

    public function adiciona_ocorrencia()
    {

//        $this->form_validation->set_rules('percentual', 'percentual', 'trim');
        $this->form_validation->set_rules('ocorrencia', 'ocorrencia', 'trim');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $data_array                 = $this->input->post();

            if (!empty($_FILES)) {

                $upload_path      = BASEPATH . '../recursos/chamados/' . $data_array['id_chamado'];

                if(!is_dir($upload_path))
                    mkdir ($upload_path, 0777);

                $config['upload_path']      = $upload_path;
                $config['allowed_types']    = 'gif|jpg|png|txt';
                $targetFile = time() . $_FILES["file"]["name"];
                $targetFile = retira_acentos($targetFile);

                $config['file_name']    = $targetFile;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('file')) {
                }else{
//                    echo 'no funcionou';
                }
//                exit;
                //insere na tb_documentos
//                $dados                      = array();
//                $dados["id_chamado"]         = $data_array['id_chamado'];
//                $dados["arquivo"]           = $targetFile;
//                $this->albuns_filhas_model->insert($dados);
                $data['anexo']              = $targetFile;
            }

            $data                       = array();
            $data['id_usuario']         = $this->session->userdata("id_usuario");
            $data['ocorrencia']         = $data_array['ocorrencia'];
            $data['id_chamado']         = $data_array['id_chamado'];
            $data['id_chamado_externo'] = ($data_array['id_chamado'] != $data_array['id_chamado_externo']) ? $data_array['id_chamado_externo'] : '';

            $data['id_area']            = $data_array['id_area'];
            $data['id_responsavel']     = $data_array['id_responsavel'];
            $data['percentual']         = $data_array['percentual'];
            $data['data']               = parseDate($data_array['data'],'date2mysql');
            $this->tb_chamados_ocorrencias_model->insert($data);


            $data                       = array();
            $data['id_area']            = $data_array['id_area'];
            $data['id_responsavel']     = $data_array['id_responsavel'];
            $data['id_status']          = $data_array['id_status'];

            $this->chamados_model->update($data_array['id_chamado'],$data);


            $this->load->model('crud_model');
            $email = array();
            $emails        = $this->crud_model->rows('tb_usuarios', 'ativo = "S"', 'id_usuario');
            foreach( $emails as $row ) {
                $email[$row->id_usuario] = $row->email;
            }

            $data     = $this->crud_model->rows('tb_area_x_usuarios', 'id_area = ' . $data_array['id_area'] , 'id_area');

            foreach( $data as $row ) {
                $assunto    = "Você tem um novo chamado";
                $assunto    = sprintf('=?%s?%s?%s?=', 'UTF-8', 'B', base64_encode($assunto));

                $message    = "Novo chamado aguarda sua atenção, acesse o painel da ControlWork para verificar\n";
                $message    .= "<pre>" . var_export($data_array,true) . "</pre>";

                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\n";
                $headers .= 'From: Chamado ControlWork <no-reply@contratonet.com.br>' . "\r\n" ;
                mail($email[$row->id_usuario], $assunto, $message , $headers); //envia email para pós-venda

            }

            $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');
            redirect('chamados/detalhe/' . $data_array['id_chamado']);

        }

        redirect('chamados/detalhe/' . $data_array['id_chamado']);

    }


//
//    public function relatorio($id)
//    {
//        $id = base64_decode($id);
//        $view['content']    = 'template/chamados/detalhe';
//        $view['dados']      = $this->chamados_model->row( $id );
//        $view['dadosOcorrencia']      = $this->chamados_ocorrencias_model->rows( $id );
//        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe
//
//        //lista administradores
//        $rows        = $this->tb_usuarios_model->rows();
//        foreach( $rows as $row ) {
//            $view["admin"][$row['id']] = $row['nome'];
//        }
//
//        //lista status
//        $rows        = $this->tb_status_model->rows();
//        foreach( $rows as $row ) {
//            $view["status"][$row['id']] = $row['status'];
//        }
//
//        //lista areas
//        $rows        = $this->tb_area_model->rows();
//        foreach( $rows as $row ) {
//            $view["areas"][$row['id']] = $row['nome'];
//        }
//
//        //lista motivos
//        $rows        = $this->tb_sla_model->rows();
//        foreach( $rows as $row ) {
//            $view["motivos"][$row['id']] = $row['nome'];
//        }
//
//        //lista ultimos status
//        $rows        = $this->chamados_log_model->rows_last_status();
//        foreach( $rows as $row ) {
//            $view["last"][$row['id_chamado']] = $row['id_status'];
//        }
//
//        $view['rows']       = $this->chamados_log_model->rows( $id );
//        $view['dadosTipo']      = $this->tb_status_model->rows();
//        $view['anexos']      = $this->chamados_anexos_model->rows( $id );
//
//        $this->load->view('template/chamados/relatorio', $view);
//    }
//
//    public function pizza()
//    {
//
//        $view['content']    = 'template/chamados/pizza';
//
//        $this->load->view('template/sistema_content', $view);
//    }
//
//    public function processa_area()
//    {
//
//        $this->form_validation->set_rules('id_area', 'área', 'trim|required');
//
//        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
//
//        if( $this->form_validation->run() == TRUE ) {
//
//            $id_area                  = $this->input->post('id_area');
//            $concluido                = $this->input->post('concluido');
//
//            redirect('chamados/index/' . $id_area . '/' . $concluido );
//        }
//            $this->index();
//
//
//    }
}