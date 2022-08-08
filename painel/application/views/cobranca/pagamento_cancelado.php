<?php echo $this->load->helper('date'); ?>
<div class="main-header">
    <div class="col-md-5">
        <h2>Pagamentos Cancelados</h2>
        <em>Informações dos pagamentos cancelados</em>
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
		<h3><i class="fa fa-table"></i>Pagamentos Cancelados</h3>
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
					<th>Situação</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($cobrancas) && count($cobrancas)) { ?>
				<?php foreach( $cobrancas as $cobranca ) { ?>
					<tr>
                        <td><?php echo $cliente[$cobranca->id_pessoa_principal]; ?></td>
						<td><?php echo $cobranca->cod_contrato; ?></td>
						<td>N° <?php echo $cobranca->num_parcela; ?> / R$ <?php echo $cobranca->valor_parcela; ?></td>
						<td><?php echo parseDate($cobranca->data_parcela,'date3'); ?></td>
						<td>Este pagamento foi cancelado</td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="5" class="text-center"> Sem informação cadastrada.</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>