<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-header">
	<h2>Acordos Realizados</h2>
	<em>Informações dos acordos realizados</em>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Acordos Realizados</h3>
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
					<th>Tipo</th>
					<th>Partes</th>
					<th>Código Contrato</th>
					<th>Valor Total</th>
					<th>Status</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($cobrancas) && count($cobrancas)) { ?>
			<?php foreach( $cobrancas as $cobranca ) { 
				$tipoPagamento = ($cobranca->mensalidade == 't') ? 'por mês' : 'parcelados';

				if( $cobranca->status == 'Em Vigencia') {
					$color = '#008000';
				}
				if( $cobranca->diferenca == '1' && $cobranca->status == 'Em Vigencia') { 
					$color = '#cc0000';
					$cobranca->status = 'Expirando';
				}
                ?>

				<tr>
					<td><?php echo $cobranca->tipo_pessoa; ?></td>
					<td><?php echo $cobranca->id_contrato; ?></td>
					<td><?php echo $cobranca->cod_contrato; ?></td>
					<td><?php echo (empty( $cobranca->valor_total )) ? 'Sem Cobrança' : 'R$ ' . $cobranca->valor_total . ' ' . $tipoPagamento ; ?></td>
					<td>
						<span style="color:<?php echo $color; ?>; font-weight: bold">
						<?php echo $cobranca->status; ?>
						</span>
					</td>
					<td>
					<?php if( $cobranca->status == 'Em Vigencia' || $cobranca->status == 'Expirando') { ?>
						<a class="btn btn-primary" href="#">Download Acordo</a></td>
					<?php } ?>
				</tr>
			<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>