<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{	 
		if(@$this->session->userdata('is_logged_in') ) {

			redirect('dashboard');
		}
		$this->load->view('login/index');
	}

	public function logout() 
	{
		$this->session->unset_userdata('contrato_user');
		redirect('login');
	}


    public function primeiro_acesso()
    {   
        $user = $this->session->userdata('contrato_user');
        if(!$user) {
            redirect('/login');
            exit();
        }

        $view = array();

        if($this->input->post()) {

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[8]|matches[confirmar_senha]');
            $this->form_validation->set_rules('confirmar_senha', 'Confirmar Senha', 'required');
            $this->form_validation->set_rules('checkk', '', 'trim');

            if( $this->form_validation->run() == TRUE ) {
                $checkk = $this->input->post('checkk');
                if($checkk) {
                    $this->load->model("tb_usuarios_model");
                    if( $this->tb_usuarios_model->atualizar_first_login() ) {
                        redirect('/dashboard');
                    }
                } else {
                    $view['alert'] = 'Para continuar você precisar declarar que leu os termos acima.';
                }
            }
        }
        $this->load->view('login/primeiro_acesso', $view );
    }

	public function processa_login()
	{
		$this->load->library('form_validation');
		$config = array(
					array('field' => 'login', 'label' => 'E-mail', 'rules' => 'trim|required|valid_email'), //
					array('field' => 'senha', 'label' => 'Senha', 'rules' => 'trim|required') );

		$this->form_validation->set_rules( $config )->set_error_delimiters('<p class="mensagem-error">', '</p>');
		if ($this->form_validation->run() == TRUE)	{
			$this->load->model("tb_usuarios_model");
			if( $this->tb_usuarios_model->valida_usuario() ) {
				$this->session->set_flashdata('sucesso', 'Logado com sucesso.');
				redirect('/dashboard');
			} else {
				$this->session->set_flashdata('error', 'Email ou Senha inválidos.');
				redirect('/login');
			}
		}
		$this->index();
	}

    public function forget()
    {
        $data = array();
        if (isset($_GET['info'])) {
            $data['info'] = $_GET['info'];
        }
        if (isset($_GET['error'])) {
            $data['error'] = $_GET['error'];
        }

        $this->load->view('login/login-forget');
    }

    public function doforget()
    {
        $this->load->helper('url');

        $email= $_POST['email'];
        $this->load->model('tb_usuarios_model');
        $view['admin']     = $this->tb_usuarios_model->fetch_row_email($email);

        if (!empty($view['admin'])) {
            $this->resetpassword($view['admin']);
            $info= "Senha foi resetada e enviada para o email: ". $email;
            $info.= "<BR>" . anchor('login/', 'Clique aqui') . " para acessar novamente";
            redirect('/index.php/login/forget?info=' . $info, 'refresh');
        }
        $error= "E-mail não encontrado em nossa base de dados";
        redirect('/index.php/login/forget?error=' . $error, 'refresh');

    }

    private function resetpassword($user)
    {
        date_default_timezone_set('GMT');
        $this->load->helper('string');
        $password= random_string('alnum', 16);
        $this->db->where('id_usuario', $user->id_usuario);
        $this->db->update('tb_usuarios',array('senha'=>MD5($password)));
        $this->load->library('email');
        $this->email->from('tecnologia@contratonet.com.br', 'Sistema ControlWork');
        $this->email->to($user->email);
        $this->email->subject('Senha Resetada');
        $this->email->message('Você requisitou uma nova senha. Segue seu novo acesso: '. $password . ' para ' . $user->email);
        $this->email->send();
    }
}