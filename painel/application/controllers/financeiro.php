<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Financeiro extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$view['content'] = 'financeiro/extrato';
		$this->load->model('tb_contratos_parcelas_model');
		$view['financeiros'] = $this->tb_contratos_parcelas_model->fetch_extrato();
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
		$view['totalExtratoGeral']      = 0;
        $view['totalExtratoPrevisao']   = 0;
		foreach($view['financeiros'] as $row) {
//            echo '<pre>' . var_export($view['financeiros'],true);
//            exit;

            $signal = ($row->tipo == 'DESPESA') ? '-' : '';

            if($row->pago == 1)
                $view['totalExtratoGeral'] += $signal . $row->valor_parcela;

            $view['totalExtratoPrevisao'] += $signal . $row->valor_parcela;

		}
		$this->load->view('template/sistema_content', $view);
	}

    public function busca_extrato()
    {
        $view['content'] = 'financeiro/extrato';
        $this->load->model('tb_contratos_parcelas_model');
        $view['dt_inicio']  = $this->input->post('dt_inicio');
        $view['dt_fim']    = $this->input->post('dt_fim');
        $view['financeiros'] = $this->tb_contratos_parcelas_model->fetch_extrato($view['dt_inicio'],$view['dt_fim']);
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $view['totalExtratoGeral'] = 0;
        foreach($view['financeiros'] as $row) {
            $signal = ($row->tipo == 'DESPESA') ? '-' : '';

            $view['totalExtratoGeral'] += $signal . $row->valor_parcela;
        }
        $this->load->view('template/sistema_content', $view);
    }

    public function busca_fluxo()
    {
        $view['content']    = 'financeiro/fluxocaixa';
        $this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_pessoas_model');

        $view['mes']  = $this->input->post('mes');
        $view['ano']  = $this->input->post('ano');

        $view['financeiros']    = $this->tb_contratos_parcelas_model->fetch_fluxo($view['mes'], $view['ano']);

        $view['previsto_mes']   = $this->tb_contratos_parcelas_model->fluxo_previsto_mes($view['mes'], $view['ano']);
        $view['anterior_mes']   = $this->tb_contratos_parcelas_model->fluxo_anterior_mes($view['mes'], $view['ano']);

//        $view['saldo_mes']      = $this->tb_contratos_parcelas_model->fluxo_saldo_mes($view['mes'], $view['ano']);
        $view['saldo_mes']      = $view['anterior_mes'] + $view['previsto_mes'];

        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $view['anoAtual']       = getdate();
        $view['dezAnosAntes']   = $view['anoAtual']['year']-10;

        $this->load->view('template/sistema_content', $view);
    }

	public function fluxocaixa()
	{
		$view['content'] = 'financeiro/fluxocaixa';
		$this->load->model('tb_contratos_parcelas_model');
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
		$view['financeiros'] = $this->tb_contratos_parcelas_model->fetch_fluxo();
		$view['saldo_mes'] = $this->tb_contratos_parcelas_model->fluxo_saldo_mes();
		$view['previsto_mes'] = $this->tb_contratos_parcelas_model->fluxo_previsto_mes();
		$view['anterior_mes'] = $this->tb_contratos_parcelas_model->fluxo_anterior_mes();


        $view['anoAtual']       = getdate();
        $view['dezAnosAntes']   = $view['anoAtual']['year']-10;
        $view['mes']            = $view['anoAtual']['mon'];
        $view['ano']            = $view['anoAtual']['year'];

		$this->load->view('template/sistema_content', $view);
	}

	public function teste()
	{
		$this->load->model('tb_contratos_parcelas_model');
		$this->tb_contratos_parcelas_model->fluxo_saldo_mes();
	}

	public function receber()
	{
		$view['content'] = 'financeiro/receber';

		$this->load->model('tb_contratos_parcelas_model');
		$view['financeiros'] = $this->tb_contratos_parcelas_model->fetch_all_receber('RECEITA');
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();

		$view['a_processar'] = 0;
		$view['atual'] = 0;
		foreach($view['financeiros'] as $i) {
			if($i->pago == 0) {
				$view['a_processar'] += $i->valor_parcela;
			} else {
				$view['atual'] += $i->valor_parcela;
			}
		}
		
		$this->load->view('template/sistema_content', $view);
	}

    public function busca_receber()
    {
        $view['content'] = 'financeiro/receber';
        $this->load->model('tb_contratos_parcelas_model');
        $view['dt_inicio']  = $this->input->post('dt_inicio');
        $view['dt_fim']    = $this->input->post('dt_fim');
        $view['financeiros'] = $this->tb_contratos_parcelas_model->fetch_all_receber('RECEITA',$view['dt_inicio'],$view['dt_fim']);
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $view['a_processar'] = 0;
        $view['atual'] = 0;
        foreach($view['financeiros'] as $i) {
            if($i->pago == 0) {
                $view['a_processar'] += $i->valor_parcela;
            } else {
                $view['atual'] += $i->valor_parcela;
            }
        }
        $this->load->view('template/sistema_content', $view);
    }

	public function cadastro_receber( $id = null )
	{
		$view['content'] = 'financeiro/cadastro_receber';
		if(!is_null($id)) {
			$this->load->model('tb_contratos_parcelas_model');
			$view['financeiro'] = $this->tb_contratos_parcelas_model->fetch_row( $id ,'RECEITA');
		}
		$this->load->model('tb_financeiro_conta_model');
		$this->load->model('tb_financeiro_categoria_model');
		$this->load->model('tb_pessoas_model');
		$view['contas'] = $this->tb_financeiro_conta_model->list_conta();
		$view['categorias'] = $this->tb_financeiro_categoria_model->list_categoria();
		$view['pessoas'] = $this->tb_pessoas_model->lista_clientes();
		$this->load->view('template/sistema_content', $view);
	}

	public function processa_conta()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="validation_error_style">', '</div>');
		$this->form_validation->set_rules('fin_titulo', 'Descrição da receita', 'trim|required');
		$this->form_validation->set_rules('valor_parcela', 'valor', 'trim|required');
		//$this->form_validation->set_rules('repeticaoTipo', 'repeticaoTipo', 'trim|required');

		if( $this->form_validation->run() == TRUE ) {
			$this->load->model('tb_contratos_parcelas_model');
			$id = trim($this->input->post('id'));
			if( !empty( $id ) ) {
				$this->tb_contratos_parcelas_model->update( $id );
				$this->session->set_flashdata('sucesso', 'Lançamento atualizado com sucesso!');
			} else {
				$this->tb_contratos_parcelas_model->insert();
				$this->session->set_flashdata('sucesso', 'Lançamento cadastrado com sucesso!');
			}
            switch ($this->input->post('tipo')) {
                case 'DESPESA':
                    redirect('financeiro/pagar');
                    break;
                case 'RECEITA':
                    redirect('financeiro/receber');
                    break;
            }

		}
		switch ($this->input->post('tipo')) {
			case 'DESPESA':
				$view['content'] = 'financeiro/cadastro_pagar';
			break;
			case 'RECEITA':
				$view['content'] = 'financeiro/cadastro_receber';
			break;
		}

		$this->load->model('tb_financeiro_conta_model');
		$this->load->model('tb_financeiro_categoria_model');
		$this->load->model('tb_pessoas_model');
		$view['contas'] = $this->tb_financeiro_conta_model->list_conta();
		$view['categorias'] = $this->tb_financeiro_categoria_model->list_categoria();
		$view['pessoas'] = $this->tb_pessoas_model->lista_clientes();
		
		$this->load->view('template/sistema_content', $view);
	}

	public function receber_xls()
	{
		redirect('financeiro');
	}

	public function pagar()
	{
		$view['content'] = 'financeiro/pagar';
		$this->load->model('tb_contratos_parcelas_model');
		$view['financeiros'] = $this->tb_contratos_parcelas_model->fetch_all_receber('DESPESA');
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
		$view['a_processar'] = 0;
		$view['atual'] = 0;
		foreach($view['financeiros'] as $i) {
			if($i->pago == 0) {
				$view['a_processar'] += $i->valor_parcela;
			} else {
				$view['atual'] += $i->valor_parcela;
			}
		}
		$this->load->view('template/sistema_content', $view);
	}

    public function busca_pagar()
    {
        $view['content'] = 'financeiro/pagar';
        $this->load->model('tb_contratos_parcelas_model');
        $view['dt_inicio']  = $this->input->post('dt_inicio');
        $view['dt_fim']    = $this->input->post('dt_fim');
        $view['financeiros'] = $this->tb_contratos_parcelas_model->fetch_all_receber('DESPESA',$view['dt_inicio'],$view['dt_fim']);
        $this->load->model('tb_pessoas_model');
        $view['cliente']   = $this->tb_pessoas_model->fetch_select_cliente_com_inativos();
        $view['a_processar'] = 0;
        $view['atual'] = 0;
        foreach($view['financeiros'] as $i) {
            if($i->pago == 0) {
                $view['a_processar'] += $i->valor_parcela;
            } else {
                $view['atual'] += $i->valor_parcela;
            }
        }
        $this->load->view('template/sistema_content', $view);
    }

	public function cadastro_pagar( $id = null )
	{
		$view['content'] = 'financeiro/cadastro_pagar';
		if(!is_null($id)) {
			$this->load->model('tb_contratos_parcelas_model');
			$view['financeiro'] = $this->tb_contratos_parcelas_model->fetch_row( $id ,'DESPESA');
		}
		$this->load->model('tb_financeiro_conta_model');
		$this->load->model('tb_financeiro_categoria_model');
		$this->load->model('tb_pessoas_model');
		$view['contas'] = $this->tb_financeiro_conta_model->list_conta();
		$view['categorias'] = $this->tb_financeiro_categoria_model->list_categoria();
		$view['pessoas'] = $this->tb_pessoas_model->lista_clientes();
		$this->load->view('template/sistema_content', $view);
	}

    public function processa_cancelamento()
    {
//		$this->load->model('tb_contratos_parcelas_model');
//		echo json_encode(array('cancelamento' => true));
//
//		if( $this->tb_contratos_parcelas_model->array_delete( $this->input->post('ids') ) ) {
//			echo json_encode(array('cancelamento' => true));
//		} else {
//			echo json_encode(array('cancelamento' => false));
//		}
//		die();
        $this->load->model('tb_contratos_parcelas_model');
        if( $this->tb_contratos_parcelas_model->set_array_cancelados( $this->input->post('ids') ) ) {
            echo json_encode(array('cancelamento' => true));
        } else {
            echo json_encode(array('cancelamento' => false));
        }
        die();
    }

	public function processa_pagamento()
	{
        $this->load->model('tb_contratos_parcelas_model');
        if( $this->tb_contratos_parcelas_model->set_array_recebido( $this->input->post('ids') ) ) {
            echo json_encode(array('recebimento' => true));
        } else {
            echo json_encode(array('recebimento' => false));
        }
        die();
	}

	public function delete( $id = null) 
	{
		$this->load->model('tb_contratos_parcelas_model');
		$this->tb_contratos_parcelas_model->delete( $id );
		$this->session->set_flashdata('sucesso', 'Informação removida com sucesso!');
		redirect('financeiro');
	}


}