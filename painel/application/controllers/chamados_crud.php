<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Chamados_crud extends CI_Controller {

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

        $this->load->database();
    }

    public function index( $id_area = null, $id_chamado = null)
    {

//        $this->form_validation->set_rules('data', 'data', 'trim');
//        $this->form_validation->set_rules('descricao', 'descricao', 'trim');
//
//        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
//
//        if( $this->form_validation->run() == TRUE ) {
//
//            $dados                  = $this->input->post();
//            $dados['id_usuario']      = $this->session->userdata("id_usuario");
//            $dados['data']          = parseDate($dados['data'],'date2mysql');
//            $this->chamados_ocorrencias_model->insert($dados);
//
//            $this->session->set_flashdata('sucesso', 'Ocorrência registrada com sucesso!');
//
//            redirect('chamados');
//        }
//
//        if($this->session->userdata('administrador') == 'Não') {
//
//            $areas              = $this->tb_area_x_id_usuario_model->rows_by_admin($this->session->userdata('id_usuario'));
//            echo $id_area = implode(',',$areas);
//
//        }
//
//        $view['dados']              = $this->chamados_model->rows($id_area, $concluido);
//
//        $view['dadosOcorrencias']   = $this->chamados_ocorrencias_model->rows();
//        $view['areas']              = $this->tb_area_model->rows();
//        foreach( $view['areas'] as $row ) {
//            $view["nome_area"][$row['id']] = $row['nome'];
//        }
//        $view['content']            = 'template/chamados/index';
//        $view['class']              = strtolower(get_called_class()); //retorna o nome da classe
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
//        //lista últimos status
//        $rows        = $this->chamados_log_model->rows_last_status();
//        foreach( $rows as $row ) {
//            $view["last"][$row['id_chamado']] = $row['id_status'];
//        }
//
//        $view['area'] = $id_area;

        date_default_timezone_set('America/Sao_Paulo');

        //Grocery
        $crud = new grocery_CRUD();

        $crud->set_table('tb_chamados');
        $crud->set_subject('chamados');

        //mostrar colunas
        $crud->columns('prazo', 'id_chamado','titulo','id_area', 'id_usuario', 'id_status', 'data_abertura');
        $crud->add_fields('titulo', 'id_usuario', 'id_area', 'id_responsavel', 'tipo', 'prioridade', 'id_sla','descricao','anexo_inicial');

        $crud->edit_fields('id_chamado','titulo', 'id_usuario', 'id_area', 'id_responsavel', 'id_status', 'ocorrencia', 'anexo'); //'data_previsao_analise', 'data_previsao_conclusao'

        $crud->set_field_upload('anexo_inicial', 'recursos/chamados/');
        $crud->set_field_upload('anexo', 'recursos/chamados/');

        //validations
        if($crud->getState() == "insert_validation") {
            $crud->required_fields('titulo', 'id_usuario', 'id_area', 'tipo', 'prioridade', 'id_sla','descricao', 'id_responsavel');
        }

        if($crud->getState() == "update_validation" || $crud->getState() == "edit") {
            $crud->required_fields('id_area', 'tipo', 'prioridade', 'id_responsavel', 'id_status', 'id_sla');
            //Show on Edit
            $crud->field_type('id_chamado', '');
            $crud->field_type('titulo', 'readonly');
            $crud->field_type('id_usuario', 'readonly');
        }

        //validations
        if($crud->getState() == "edit") {
            $crud->display_as('id_area','Enviar para');
//            $crud->display_as('descricao','Descrição inicial (Só alterar se necessário)');
        }else{
            $crud->display_as('id_area','Área de destino');
        }

        if($crud->getState() == "read") {
            if(is_numeric($id_chamado))
                redirect('chamados/detalhe/' . $id_chamado);
        }

        $crud->field_type('data_previsao_conclusao', 'hidden');

        //calbacks
        $crud->callback_before_insert(array($this,'posts_control_before'));
        $crud->callback_before_update(array($this,'posts_control_after'));
        $crud->callback_column('data_abertura', array($this,'data_abertura'));

        //trocar titulos
        $crud->display_as('descricao','Descrição');
        $crud->display_as('id_usuario','Aberto por');
        $crud->display_as('id_responsavel','Responsável');
        $crud->display_as('percentual','Conclusão (%)');
        $crud->display_as('id_sla','Motivo');
        $crud->display_as('id_chamado','Código');
        $crud->display_as('id_status','Status');
        $crud->display_as('data_previsao_analise','Previsão');
        $crud->display_as('data_previsao_conclusao','Previsão');


        //relacionamentos
        $crud->set_relation('id_usuario','tb_usuarios','{usuario}');
        $crud->set_relation('id_responsavel','tb_usuarios','{usuario}', null, null, $default_value = 1);
        $crud->set_relation('id_area','tb_area','{area}');
        $crud->set_relation('id_sla','tb_sla','{sla}');
        $crud->set_relation('id_status','tb_status','{status}');
        $crud->order_by('id_chamado', 'DESC');

        $crud->callback_column('prazo', array($this,'prazo_dias_callback'));

        $crud->where('tb_chamados.tipo <> "Melhoria"');
        $crud->where('tb_chamados.id_status <> 7');

        if(!empty($id_area) && is_numeric($id_area))
            $crud->where('tb_chamados.id_area = ' . $id_area);

        $output = $crud->render();


        //botões de áreas
        $this->db->select('*');
        $this->db->order_by('t.area', 'ASC');
        $q = $this->db->get( 'tb_area as t');
        if( $q->num_rows > 0 ) {
            $areas = $q->result();
        }
        $output->areas      = $areas;
        $output->id_area    = $id_area;

        $output->content    = 'template/chamados/crud';
        $output->class      = strtolower(get_called_class()); //retorna o nome da classe

        $this->load->view('template/sistema_content', $output);
    }

    function posts_control_before($post_array, $primary_key = null)
    {
        $post_array['data_previsao_analise'] = Date('Y-m-d', strtotime("+2 days"));

        return $post_array;
    }

    function posts_control_after($post_array, $primary_key = null)
    {
        $data                       = array();
        $date_now                   = date('Y-m-d');

        $data['id_usuario']         = $this->session->userdata("id_usuario");
        $data['id_chamado']         = $post_array['id_chamado'];;
        $data['ocorrencia']         = $post_array['ocorrencia'];
        $data['anexo']              = $post_array['anexo'];
        $data['data']               = $date_now;
//            $data['id_responsavel']     = $post_array['id_responsavel'];
//            $data['id_area']            = $post_array['id_area'];

        $this->crud_model->do_insert('tb_chamados_ocorrencias',$data, '');

        $post_array['ocorrencia'] = '';
        $post_array['anexo'] = '';

        return $post_array;

    }

    function prazo_dias_callback($value, $row){

        $date_conclusao = new DateTime($row->data_conclusao);
        $date_previsao  = new DateTime($row->data_previsao_conclusao);
        $date_previsao_analise  = new DateTime($row->data_previsao_analise);
        $date_now       = new DateTime(date('Y-m-d'));

        $interval = $date_conclusao->diff($date_previsao);
        $interval = $interval->format('%R%a dias ');

        $interval_abertas = $date_now->diff($date_previsao);
        $interval_abertas = $interval_abertas->format('%R%a dias ');

        $interval_abertas_analise = $date_now->diff($date_previsao_analise);
        $interval_abertas_analise = $interval_abertas_analise->format('%R%a dias ');

        if($row->id_status == 7 ) {
            if($interval < 0  ) {
                $return = '<img src="' . base_url() . '/recursos/img/red.png" border="0" width="16"> Concluído';
            }
            if ($interval >= 0 && $interval <= 3 ){
                $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16"> Concluído';
            }
            if($interval > 3  ) {
                $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16"> Concluído';
            }
        }else{
            if(!empty($row->data_previsao_conclusao)){
                if($interval_abertas < 0  ) {
                    $return = '<img src="' . base_url() . '/recursos/img/red.png" border="0" width="16">';
                }
                if ($interval_abertas >= 0 && $interval_abertas <= 3 ){
                    $return = '<img src="' . base_url() . '/recursos/img/yellow.png" border="0" width="16">';
                }
                if($interval_abertas > 3  ) {
                    $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16">';
                }
            }else{
                if($interval_abertas_analise < 0  ) {
                    $return = '<img src="' . base_url() . '/recursos/img/red.png" border="0" width="16">';
                }
                if ($interval_abertas_analise >= 0 && $interval_abertas_analise <= 3 ){
                    $return = '<img src="' . base_url() . '/recursos/img/yellow.png" border="0" width="16">';
                }
                if($interval_abertas_analise > 3  ) {
                    $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16">';
                }
            }
        }

        return $return;
    }

    function data_previsao_conclusao($value, $row){
        if(!empty($row->data_previsao_conclusao))
            $return = parseDate($row->data_previsao_conclusao,'date3');
        else
            $return = parseDate($row->data_previsao_analise,'date3');

        if($return == '//')
            $return = 'Não definida';
        return $return;
    }

    function data_abertura($value, $row){

        $return = parseDate($row->data_abertura,'date3');

        return $return;
    }



//return '<img src="<?php echo (base_url(). ' / recursos / img / '. $row["prev"] . ' . png'); border="0" width="16">';

//    public function cadastro()
//    {
//
//        $view['areas']      = $this->tb_area_model->rows();
//        $view['moderadas']  = $this->tb_sla_model->rows('Moderada');
//        $view['urgentes']   = $this->tb_sla_model->rows('Urgente');
//
//        //resgata prazo das prioridades e armazena em array
//        $rows        = $this->tb_sla_model->rows();
//        foreach( $rows as $row ) {
//            $view["prazo_sla"][$row['id']] = $row['previsao_em_dias'];
//        }
//
//        $view['content']    = 'template/chamados/cadastro-passo-1';
//        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe
//
//        $this->load->view('template/sistema_content', $view);
//    }
//
//    public function processa_cadastro_passo_um()
//    {
//
//        $this->form_validation->set_rules('titulo', 'título', 'trim|required');
//        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
//        $this->form_validation->set_rules('prioridade', 'grau de prioridade', 'trim|required');
//        $this->form_validation->set_rules('id_motivo', 'motivo da escolha da prioridade', 'trim|required');
//        $this->form_validation->set_rules('descricao', 'descrição', 'trim|required');
//        $this->form_validation->set_rules('id_area', 'área responsável', 'trim|required');
//
//        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
//
//        if( $this->form_validation->run() == TRUE ) {
//
//            $data                    = $this->input->post();
//            $data['id_usuario']        = $this->session->userdata("id_usuario");
//            $data['data_previsao']   = parseDate($data['prazo'],'date2mysql');
//
//            unset($data['prazo']);
//
//            $this->chamados_model->insert($data);
//            $id             = $this->db->insert_id();
//
//            //cria log
//            $dados                      = array();
//            $dados["id_chamado"]        = $id;
//            $dados["descricao"]         = $data['descricao'];
//            $dados["id_status"]         = '10'; //criado
//            $dados['id_usuario']          = $this->session->userdata("id_usuario");
//            $this->chamados_log_model->insert($dados);
//
//
//            $upload_path      = BASEPATH . '../recursos/chamados/' . $id;
//            mkdir ($upload_path, 0777);
//
//            $view['content']    = 'template/chamados/cadastro-passo-2';
//            $view['id']         = $id;
//            $view['class']     = strtolower(get_called_class()); //retorna o nome da classe
//            $this->load->view('template/sistema_content', $view);
//
//
//        }else{
//            $this->cadastro();
//        }
//
//
//    }
//
//    public function processa_cadastro_passo_dois( $id_album = null)
//    {
//
//        $this->load->helper("download");
//        $this->load->helper("url");
//        $this->load->library("ftp");
//
//        if (!empty($_FILES)) {
//
//            $config['upload_path']      = BASEPATH . '../recursos/chamados/' . $id_album;
////            $config['allowed_types']    = 'gif|jpg|png';
//
//            $targetFile = 'Chamado ' . $id_album . '_anexo_' .  $_FILES["file"]["name"];
//            $targetFile = retira_acentos($targetFile);
//
//            $config['file_name']    = $targetFile;
//            $this->load->library('upload', $config);
//            $this->upload->initialize($config);
//
//            if (!$this->upload->do_upload('file')) {
////funcionou
//            }else{
//// funcionou
//            }
//
//            //insere na tb_documentos
//            $dados                      = array();
//            $dados["id_imagem"]         = $id_album;
//            $dados["arquivo"]           = $targetFile;
//            $this->chamados_anexos_model->insert($dados);
//
//
//        }
//
//        $view['content']    = 'template/chamados/cadastro-passo-2';
//        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe
//
//        $this->load->view('template/sistema_content', $view);
//
//    }
//
    public function detalhe($id)
    {
        $view['content']    = 'template/chamados/detalhe';
        $view['dados']      = $this->crud_model->get_by_id( 'tb_chamados', $id , 'id_chamado' );
        $view['class']     = strtolower(get_called_class()); //retorna o nome da classe

        //lista administradores
        $rows      = $this->crud_model->get_by_something( 'tb_usuarios');
        foreach( $rows as $row ) {
            $view["admin"][$row->id_usuario] = $row->usuario;
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
//        $view['rowsComments']   = $this->crud_model->get_by_something( 'tb_chamados_log', null, 'id_chamado = ' . $id , 'data DESC');

        $this->load->view('template/sistema_content', $view);
    }
//
//    public function delete( $id )
//    {
//        if( $this->chamados_model->delete( $id ) ) {
////            $this->session->keep_flashdata('sucesso', 'Removido com sucesso!');
//        } else {
////            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
//        }
//
//        if( $this->chamados_anexos_model->delete_all( $id ) ) {
//            $this->session->keep_flashdata('sucesso', 'Removido com sucesso!');
//        } else {
//            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
//        }
//
//
//        redirect('chamados/');
//
//    }
//
//    public function altera_status()
//    {
//
//        $this->form_validation->set_rules('id_status', 'id_status', 'trim');
//        $this->form_validation->set_rules('descricao', 'descrição', 'trim');
//
//        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
//
//        if( $this->form_validation->run() == TRUE ) {
//
//            $data               = $this->input->post();
//            $data['id_usuario']   = $this->session->userdata("id_usuario");
//            $this->chamados_log_model->insert($data);
//
//            if($data['id_status'] == '80'){
//                $date = date('Y-m-d');
//                $this->chamados_model->update($data['id_chamado'], array('data_conclusao' => $date, 'percentual' => 100));
//            }
//
//            $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');
//            redirect('chamados/detalhe/' . $data['id_chamado']);
//
//        }
//
//        redirect('chamados/detalhe/' . $data['id_chamado']);
//
//    }
//
    public function altera_porcentagem()
    {

        $this->form_validation->set_rules('percentual', 'percentual', 'trim');
        $this->form_validation->set_rules('ocorrencia', 'ocorrencia', 'trim');

        $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

        if( $this->form_validation->run() == TRUE ) {

            $data               = $this->input->post();

            $this->chamados_model->update($data['id'], $data);

            $this->session->set_flashdata('sucesso', 'Atualizado com sucesso!');
            redirect('chamados/detalhe/' . $data['id_chamado']);

        }

        redirect('chamados/detalhe/' . $data['id_chamado']);

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