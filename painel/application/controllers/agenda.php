<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index()
    {

        //  $view['agendas']          = $this->tb_agenda_model->fetch_results();

        $view['content'] = 'agenda/index';
        $this->load->view('template/sistema_content', $view);
    }

    public function calendar_events()
    {
        $this->load->model('tb_agenda_model');
        header('Content-Type: application/json');

        echo json_encode($this->tb_agenda_model->fetch_results());
    }

    public function calendar_add_events()
    {
        $this->load->model('tb_agenda_model');
        header('Content-Type: application/json');

        $this->tb_agenda_model->insert();
    }

    public function calendar_update_events()
    {
        $this->load->model('tb_agenda_model');
        header('Content-Type: application/json');

        $this->tb_agenda_model->update();
    }

    public function updateLido()
    {
        $this->load->model('tb_agenda_model');
        header('Content-Type: application/json');

        $this->tb_agenda_model->updateLido( $this->uri->segment(3) );

        redirect('dashboard/index');
    }

}