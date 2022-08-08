<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao extends CI_Controller {

    public function index()
    {
        $view['content'] = 'notificacao/lista_noticia';
        $this->load->model('tb_logs_model');
        $view['atividades'] = $this->tb_logs_model->fetch_noticias();
        $this->load->view('template/sistema_content', $view);
    }

    public function atualiza_data_notificacao()
    {
            $this->load->model('tb_usuarios_model');

            $this->tb_usuarios_model->atualiza_data_notificacao();

            redirect( '/dashboard' );
            //redirect('contrato/visualizar/'.$id_contrato );
    }
}