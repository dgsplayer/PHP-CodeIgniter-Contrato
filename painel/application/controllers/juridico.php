<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Juridico extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function ajax_autocompletar_vara()
    {
        $this->load->model('tb_jur_forum_model');
        header('Content-Type: application/json');
        echo json_encode($this->tb_jur_forum_model->fetch_by_name($this->input->post('q')));
    }

    public function ajax_autocompletar_processo()
    {
        $this->load->model('tb_jur_processo_model');
        header('Content-Type: application/json');
        echo json_encode($this->tb_jur_processo_model->fetch_by_name($this->input->post('q')));
    }

    public function ajax_autocompletar_contrato()
    {
        $this->load->model('tb_contratos_model');
        header('Content-Type: application/json');
        echo json_encode($this->tb_contratos_model->fetch_by_name($this->input->post('q')));
    }

    public function ajax_autocompletar_parte_adversa()
    {
        $this->load->model('tb_jur_adversas_model');
        header('Content-Type: application/json');
        echo json_encode($this->tb_jur_adversas_model->fetch_by_name($this->input->post('q')));
    }

    public function processo($id_processo = null)
    {
        $view['content'] = 'juridico/processo';
        $this->load->model('tb_jur_forum_model');
        $this->load->model('tb_pessoas_model');
        $this->load->model('tb_jur_adversas_model');
        if (is_numeric($id_processo)) {
            $this->load->model('tb_jur_processo_model');
            $view['processo'] = $this->tb_jur_processo_model->fetch_row($id_processo);

        }
        $view['id_forum']           = $this->tb_jur_forum_model->fetch_all_idpessoa();
        $view['id_parte']           = $this->tb_pessoas_model->clientes_juridico();
        $view['id_parte_adversa']   = $this->tb_jur_adversas_model->fetch_all_idpessoa();
        $view['id_contratos']       = $this->tb_pessoas_model->fetch_all_contrato_cliente();
        $view['id']                 = $id_processo;
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_processo()
    {
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');

            $novonomecliente        = $this->input->post('novoclientenome');
            $novoclienteemail       = $this->input->post('novoclienteemail');
            $novoclientetelefone    = $this->input->post('novoclientetelefone');

            if (empty($novonomecliente) && empty($novoclienteemail) && empty($novoclientetelefone)) {
                $this->form_validation->set_rules('nome_cliente', 'cliente', 'trim|required');
            } else {
                $this->form_validation->set_rules('novoclientenome', 'nome do novo cliente', 'trim|required');
                $this->form_validation->set_rules('novoclienteemail', 'E-mail do novo cliente', 'trim|required|valid_email');
                $this->form_validation->set_rules('novoclientetelefone', 'Telefone do novo cliente', 'trim|required');
            }
            $vara = $this->input->post('novovara');
            if (empty($vara)) {
                $this->form_validation->set_rules('vara', 'vara / fórum', 'trim|required');
            } else {
                $this->form_validation->set_rules('novovara', 'nome da nova vara/fórum', 'trim|required');
            }
            $novoclientenomeadversa     = $this->input->post('novoclientenomeadversa');
            $novocpfadversa             = $this->input->post('novocpfadversa');
            $novoclienteemailadversa    = $this->input->post('novoclienteemailadversa');
            $novoclientetelefoneadversa = $this->input->post('novoclientetelefoneadversa');
            $novoclienteadvadversa      = $this->input->post('novoclienteadvadversa');

            if (empty($novoclientenomeadversa) && empty($novocpfadversa) && empty($novoclienteemailadversa) && empty($novoclientetelefoneadversa) && empty($novoclienteadvadversa)) {
                $this->form_validation->set_rules('parte_adversa', 'parte adversa', 'trim');
            } else {
                $this->form_validation->set_rules('novoclientenomeadversa', 'Nome da nova parte adversa', 'trim');
                $this->form_validation->set_rules('novoclienteemailadversa', 'E-mail da nova parte adversa', 'trim|valid_email');
                $this->form_validation->set_rules('novoclientetelefoneadversa', 'Telefone da nova parte adversa', 'trim');
                $this->form_validation->set_rules('novocpfadversa', 'cpf da nova parte adversa', 'trim');
                $this->form_validation->set_rules('novoclienteadvadversa', 'Advogado da nova parte adversa', 'trim');
            }

            $id = trim($this->input->post('id'));

            $isUnique = (empty($id)) ? '|is_unique[tb_jur_processo.num_processo]' : '';
            $this->form_validation->set_rules('num_processo', 'número do processo', 'trim|required' . $isUnique);
            $this->form_validation->set_message('is_unique','Este número de processo já existe na base de dados.');
            $this->form_validation->set_rules('num_pasta', 'n° da pasta', 'trim|required');

            $this->form_validation->set_rules('id_processo_vinculado', 'id_processo_vinculado', 'trim');
            $this->form_validation->set_rules('id_parte', 'id_parte', 'trim');
            $this->form_validation->set_rules('id_forum', 'id_forum', 'trim');
            $this->form_validation->set_rules('id_parte_adversa', 'id_parte_adversa', 'trim');
            $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim');

            if ($this->form_validation->run() == TRUE) {
                $this->load->model('tb_jur_processo_model');
                if (!empty($id)) {
                    $this->tb_jur_processo_model->update();
                } else {
                    $this->tb_jur_processo_model->insert();
                }

            }
        }
        $this->processo($this->input->post('id'));
    }

    public function delete($id_processo)
    {
        $this->load->model('tb_jur_processo_model');
        $this->tb_jur_processo_model->delete($id_processo);
        $this->session->set_flashdata('sucesso', 'Processo removido com sucesso!');
        redirect('juridico/lista_processos');
    }

    public function busca()
    {
        $view['content'] = 'juridico/busca';
//        $this->load->model('tb_jur_processo_model');
//        $this->load->model('tb_pessoas_model');
//        $view['processos'] = $this->tb_jur_processo_model->fetch_all();
//        $view['cliente'] = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_busca()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');


            $this->form_validation->set_rules('num_processo',   'erro', 'trim');
            $this->form_validation->set_rules('nome',           'erro', 'trim');
            $this->form_validation->set_rules('vara',           'erro', 'trim');
            $this->form_validation->set_rules('parte_adversa',  'erro', 'trim');
            $this->form_validation->set_rules('contrato',       'erro', 'trim');
            $this->form_validation->set_rules('num_pasta',      'erro', 'trim');
            $this->form_validation->set_rules('publicacao',     'erro', 'trim');
            $this->form_validation->set_rules('cpf_cnpj',       'erro', 'trim');

            $num_processo   = $this->input->post('num_processo');
            $nome           = $this->input->post('nome');
            $vara           = $this->input->post('vara');
            $parte_adversa  = $this->input->post('parte_adversa');
            $contrato       = $this->input->post('contrato');
            $num_pasta      = $this->input->post('num_pasta');
            $publicacao     = $this->input->post('publicacao');
            $cpf_cnpj       = $this->input->post('cpf_cnpj');

            if ($this->form_validation->run() == TRUE) {

                $view['content'] = 'juridico/lista_processos';
                $this->load->model('tb_jur_processo_model');
                $this->load->model('tb_pessoas_model');
                $view['processos'] = $this->tb_jur_processo_model->fetch_criterio($num_processo, $nome, $vara, $parte_adversa, $contrato, $num_pasta, $cpf_cnpj, $publicacao);
                $view['cliente'] = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
                $this->load->view('template/sistema_content', $view);

            }
        }



    }

    public function lista_processos()
    {
        $view['content'] = 'juridico/lista_processos';
        $this->load->model('tb_jur_processo_model');
        $this->load->model('tb_pessoas_model');
        $view['processos'] = $this->tb_jur_processo_model->fetch_all();
        $view['cliente'] = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $this->load->view('template/sistema_content', $view);
    }

    public function andamento($id_andamento = null, $id_processo = null)
    {
        $view['content'] = 'juridico/andamento';
        $this->load->model('tb_usuarios_model');
        $this->load->model('tb_jur_situacao_model');
        $this->load->model('tb_jur_peticao_model');
        if (is_numeric($id_andamento)) {
            $this->load->model('tb_jur_andamento_model');
            $view['andamento'] = $this->tb_jur_andamento_model->fetch_row($id_andamento);
        }

        if (is_numeric($id_processo)) {
            $this->load->model('tb_jur_processo_model');
            $view['processo'] = $this->tb_jur_processo_model->fetch_row($id_processo);

            if (!empty($view['processo']->num_processo)) $view['num_processo'] =  $view['processo']->num_processo ;
            if (!empty($view['processo']->id))  $view['id_processo']  = $view['processo']->id  ;
        }

        if (empty($view['num_processo'])) $view['num_processo'] = @$view['andamento']->processo;
        if (empty($view['id_processo']))  $view['id_processo']  = $this->input->post('id_processo');

        $view['email_responsaveis'] = $this->tb_usuarios_model->fetch_responsavel_email_juridico();
        $view['situacaoes'] = $this->tb_jur_situacao_model->fetch_situacao();
        $view['peticoes'] = $this->tb_jur_peticao_model->fetch_peticao();
        $view['prazos'] = array("" => 'Prazo para resposta', 0 => 'Hoje', 5 => '5 Dias', 8 => '8 Dias', 10 => '10 Dias', 15 => '15 Dias', 20 => '20 Dias', 30 => '30 Dias', 60 => '60 Dias');
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_andamento()
    {
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $peticao = $this->input->post('nova_peticao');
            if (empty($peticao)) {
                $this->form_validation->set_rules('peticao', 'Tipo de petição', 'trim');
            } else {
                $this->form_validation->set_rules('nova_peticao', 'nome da nova petição', 'trim');
            }
            $situacao = $this->input->post('nova_situacao');
            if (empty($situacao)) {
                $this->form_validation->set_rules('situacao', 'Tipo de situação', 'trim|required');
            } else {
                $this->form_validation->set_rules('nova_situacao', 'nome da nova situação', 'trim|required');
            }
            $this->form_validation->set_rules('processo', 'Número do processo', 'trim|required');
            $this->form_validation->set_rules('descricao', 'Andamento do processo', 'trim|required');
            $this->form_validation->set_rules('id_usuario_responsavel', 'E-mail do responsável', 'trim|required');
            $this->form_validation->set_rules('publicacao', 'Data da publicação', 'trim|required');
            $this->form_validation->set_rules('prazo', 'Prazo', 'trim');

            $this->form_validation->set_rules('status', 'status', 'trim');
            $this->form_validation->set_rules('id_peticao', 'id_peticao', 'trim');

            $this->form_validation->set_rules('id_processo', 'id_processo', 'trim');
            $this->form_validation->set_rules('agendamento', 'agendamento', 'trim');
            $this->form_validation->set_rules('agendamento_texto', 'agendamento_texto', 'trim');




            if ($this->form_validation->run() == TRUE) {

                $this->load->model('tb_jur_andamento_model');
                $id = trim($this->input->post('id'));
                if (!empty($id)) {
                    $this->tb_jur_andamento_model->update_andamento();
                    $this->session->set_flashdata('sucesso', 'Andamento atualizado com sucesso!');
                } else {
                    if ($this->tb_jur_andamento_model->insert_andamento()) {
                        $this->session->set_flashdata('sucesso', 'Andamento cadastrado com sucesso!');
                    } else {
                        $this->session->set_flashdata('error', 'Problema no cadastrado!');
                    }
                }
                redirect('juridico/visualizar_processo/' . $this->input->post('id_processo'));
            }
        }
        $this->andamento();
    }

    public function lista_andamento()
    {
        $view['content'] = 'juridico/lista_andamento';
        $this->load->model('tb_jur_andamento_model');
        $this->load->model('tb_pessoas_model');
        $view['cliente'] = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
//        $view['andamentos'] = $this->tb_jur_andamento_model->fetch_all();
        $view['andamentos'] = $this->tb_jur_andamento_model->fetch_all_last();
        $this->load->view('template/sistema_content', $view);
    }

    public function delete_andamento($id_andamento = null, $id_processo = null)
    {
        $this->load->model('tb_jur_andamento_model');
        $this->tb_jur_andamento_model->delete($id_andamento);

        $this->session->set_flashdata('sucesso', 'Andamento removido com sucesso!');
//        redirect('juridico/lista_processos');

        redirect('juridico/visualizar_processo/' . $id_processo);


    }

    public function delete_andamento_anexo($id_anexo = null)
    {
        $this->load->model('tb_jur_andamentos_anexos_model');
        $this->tb_jur_andamentos_anexos_model->delete($id_anexo);

        $this->session->set_flashdata('sucesso', 'Anexo removido com sucesso!');
        redirect('juridico/lista_processos');
    }


    public function peticoes()
    {
        $view['content'] = 'juridico/peticoes';
        $this->load->model('tb_jur_peticao_avulso_lista_model');
        $this->load->model('tb_jur_peticao_model');
//        $view['peticoes'] = $this->tb_jur_peticao_avulso_lista_model->fetch_peticao();
        $view['peticoes']       = $this->tb_jur_peticao_model->fetch_peticao();
        $view['lista_peticoes'] = $this->tb_jur_peticao_avulso_lista_model->fetch_all();

        $this->load->view('template/sistema_content', $view);
    }

    public function processa_peticoes()
    {
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('id_peticao', 'tipo de petição', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('Tb_jur_peticao_avulso_model');
                $this->Tb_jur_peticao_avulso_model->insert();
                $this->session->set_flashdata('sucesso', 'Tipo de petição cadastrado com sucesso!');
                redirect('juridico/peticoes');
            }
        }
        $this->peticoes();
    }

    public function cadastro_forum()
    {
        $this->load->model('tb_jur_forum_model');
        if ($this->input->post()) {
            $this->tb_jur_forum_model->insert();
            $this->session->set_flashdata('sucesso', 'Opção cadastrada com sucesso.');
            redirect('juridico/cadastro_forum');
        }
        $view['listas'] = $this->tb_jur_forum_model->fetch_all();
        $view['content'] = 'juridico/cadastro_forum';
        $this->load->view('template/sistema_content', $view);
    }

    public function cadastro_partes_adversas()
    {
        $this->load->model('tb_jur_adversas_model');
        if ($this->input->post()) {
            $this->tb_jur_adversas_model->insert();
            $this->session->set_flashdata('sucesso', 'Opção cadastrada com sucesso.');
            redirect('juridico/cadastro_partes_adversas');
        }
        $view['listas'] = $this->tb_jur_adversas_model->fetch_all();
        $view['content'] = 'juridico/cadastro_partes_adversas';
        $this->load->view('template/sistema_content', $view);
    }

//    public function cadastro_peticao()
//    {
//        $this->load->model('tb_jur_peticao_model');
//        if ($this->input->post()) {
//            $this->tb_jur_peticao_model->insert();
//            $this->session->set_flashdata('sucesso', 'Opção cadastrada com sucesso.');
//            redirect('juridico/cadastro_peticao');
//        }
//        $view['listas'] = $this->tb_jur_peticao_model->fetch_all();
//        $view['content'] = 'juridico/cadastro_peticao';
//        $this->load->view('template/sistema_content', $view);
//    }
//
//    public function cadastro_situacao()
//    {
//        $this->load->model('tb_jur_situacao_model');
//        if ($this->input->post()) {
//            $this->tb_jur_situacao_model->insert();
//            $this->session->set_flashdata('sucesso', 'Opção cadastrada com sucesso.');
//            redirect('juridico/cadastro_situacao');
//        }
//        $view['listas'] = $this->tb_jur_situacao_model->fetch_all();
//        $view['content'] = 'juridico/cadastro_situacao';
//        $this->load->view('template/sistema_content', $view);
//    }

    public function visualizar_processo($id_processo = null)
    {
        $view['content'] = 'juridico/detalhe_processo';
        if (is_numeric($id_processo)) {
            $this->load->model('tb_jur_processo_model');
            $view['processo'] = $this->tb_jur_processo_model->fetch_row($id_processo);

            $this->load->library('forum');
            $view['html_mov'] = $this->forum->getAndamento($view['processo']->num_processo);
        }

        $this->load->model('tb_jur_andamento_model');
        $this->load->model('tb_pessoas_model');
        $view['cliente'] = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $view['andamentos'] = $this->tb_jur_andamento_model->fetch_row_processo($id_processo);

        $this->load->view('template/sistema_content', $view);
    }

    public function visualizar_andamento($id_andamento = null)
    {
        $view['content'] = 'juridico/detalhe_andamento';
        $this->load->model('tb_jur_andamentos_anexos_model');
        $view['aditivos'] = $this->tb_jur_andamentos_anexos_model->fetch_row($id_andamento);
        if (is_numeric($id_andamento)) {
            $this->load->model('tb_jur_andamento_model');
            $view['andamentos'] = $this->tb_jur_andamento_model->fetch_row($id_andamento);
        }
        $this->load->view('template/sistema_content', $view);
    }

    public function configuracao()
    {
        $this->load->model('tb_jur_peticao_model');
        $view['listas_peticoes'] = $this->tb_jur_peticao_model->fetch_all();

        $this->load->model('tb_jur_situacao_model');
        $view['listas_situacoes'] = $this->tb_jur_situacao_model->fetch_all();

        $this->load->model('tb_jur_forum_model');
        $view['listas_forum'] = $this->tb_jur_forum_model->fetch_all();

        $this->load->model('tb_jur_adversas_model');
        $view['listas_adversas'] = $this->tb_jur_adversas_model->fetch_all();

        $view['content'] = 'juridico/configuracao';
        $this->load->view('template/sistema_content', $view);
    }

    public function processa_peticao()
    {
        $this->load->model('tb_jur_peticao_model');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('peticao', 'petição', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $this->tb_jur_peticao_model->insert();
                $this->session->set_flashdata('sucessoPeticao', 'Petição cadastrada com sucesso.');
                redirect('juridico/configuracao');
            } else {
                $view['listas'] = $this->tb_jur_peticao_model->fetch_all();
                $view['content'] = 'juridico/configuracao';
                $this->load->view('template/sistema_content', $view);
            }
        }

    }

    public function delete_peticao($id)
    {
        $this->load->model('tb_jur_peticao_model');
        if ($this->tb_jur_peticao_model->delete($id)) {
            $this->session->set_flashdata('sucessoPeticao', 'Removido com sucesso');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('juridico/configuracao');
    }


    public function processa_situacao()
    {
        $this->load->model('tb_jur_situacao_model');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('situacao', 'situação', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $this->tb_jur_situacao_model->insert();
                $this->session->set_flashdata('sucessoSituacao', 'Situação cadastrada com sucesso.');
                redirect('juridico/configuracao');
            } else {
                $this->configuracao();
            }
        }

    }

    public function delete_situacao($id)
    {
        $this->load->model('tb_jur_situacao_model');
        if ($this->tb_jur_situacao_model->delete($id)) {
            $this->session->set_flashdata('sucessoSituacao', 'Removido com sucesso');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('juridico/configuracao');
    }

    public function processa_forum()
    {
        $this->load->model('tb_jur_forum_model');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('forum', 'vara/fórum', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $this->tb_jur_forum_model->insert();
                $this->session->set_flashdata('sucessoForum', 'Vara/Fórum cadastrada com sucesso.');
                redirect('juridico/configuracao');
            } else {
                $this->configuracao();
            }
        }
    }

    public function delete_forum($id)
    {
        $this->load->model('tb_jur_forum_model');
        if ($this->tb_jur_forum_model->delete($id)) {
            $this->session->set_flashdata('sucessoForum', 'Removido com sucesso');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('juridico/configuracao');
    }

    public function processa_adversas()
    {
        $this->load->model('tb_jur_adversas_model');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
            $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required');
            $this->form_validation->set_rules('cpf', 'CPF', 'trim|required');
            $this->form_validation->set_rules('telefone', 'Telefone', 'trim|required');
            $this->form_validation->set_rules('advogado', 'Advogado', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $this->tb_jur_adversas_model->insert();
                $this->session->set_flashdata('sucessoAdversas', 'Parte Adversa cadastrada com sucesso.');
                redirect('juridico/configuracao');
            } else {
                $this->configuracao();
            }
        }
    }

    public function delete_adversa($id)
    {
        $this->load->model('tb_jur_adversas_model');
        if ($this->tb_jur_adversas_model->delete($id)) {
            $this->session->set_flashdata('sucessoAdversas', 'Removido com sucesso');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu algum problema.');
        }
        redirect('juridico/configuracao');
    }

    public function delete_banco_peticao($id)
    {
        $this->load->model('tb_jur_peticao_avulso_model');
        $this->tb_jur_peticao_avulso_model->delete($id);
        $this->session->set_flashdata('sucesso', 'Petição removida com sucesso!');
        redirect('juridico/peticoes');
    }

}