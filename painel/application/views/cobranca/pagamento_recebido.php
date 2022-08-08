<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-header">
    <div class="col-md-5">
	<h2>Pagamentos Recebidos</h2>
	<em>Informações pagamentos recebidos</em>
    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('cobranca/pagamento_recebido'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Pagamentos Recebidos</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cobranca/pagamento_receber'); ?>">
                        <div class="quick-access-item bg-color-blue">
                            <i class="fa fa-clipboard"></i>
                            <h5>Pagamentos a Receber</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cobranca/pagamento_cancelado'); ?>">
                        <div class="quick-access-item bg-color-yellow">
                            <i class="fa fa-clipboard"></i>
                            <h5>Pagamentos Cancelados</h5>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Pagamentos Recebidos</h3>
	</div>
	<div class="widget-content">

		<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
			<div class="alert alert-success bg-success text-center">
				<?php echo $mensagem; ?>
			</div>
		<?php } ?>

		<table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Cliente</th>
					<th>Contrato</th>
					<th>Parcela</th>
					<th>Vencimento</th>
					<th>Data do Pagamento</th>
					<th>Situação</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($cobrancas) && count($cobrancas)) { ?>
				<?php foreach( $cobrancas as $cobranca ) { ?>
					<tr>
						<td><?php echo $cobranca->id_contrato; ?></td>
                        <td><?php echo $cliente[$cobranca->id_pessoa_principal]; ?></td>
						<td>N° <?php echo $cobranca->num_parcela; ?> / R$ <?php echo $cobranca->valor_parcela; ?></td>
						<td><?php echo parseDate($cobranca->data_parcela,'date3'); ?></td>
						<td><?php echo parseDate($cobranca->data_pagamento,'date3'); ?></td>
						<td>Recebido</td>
						<td>
							<a target="_blank" href="<?php echo prep_url('www.contratonet.com.br/contract_key/download/download_recibo/' . base64_encode($cobranca->id_contrato).'/'.base64_encode($cobranca->id)); ?>" class="btn btn-primary">Recibo</a>
						</td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="7" class="text-center"> Sem informação cadastrada.</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>