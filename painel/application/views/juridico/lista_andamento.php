<div class="main-header">
	<h2>Lista de Andamento</h2>
	<em>Informações do andamento</em>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Lista de Andamentos</h3>
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
					<th>Processo</th>
					<th>Cliente</th>
					<th>Situação</th>
                    <th>Descrição</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($andamentos) && count($andamentos)) { ?>
				<?php foreach( $andamentos as $andamento ) { ?>
					<tr>
						<td><a href="<?php echo base_url('juridico/visualizar_processo/' . $andamento->id_processo ); ?>"><?php echo $andamento->num_processo; ?></a></td>
                        <td><a href="<?php echo base_url('cliente/detalhe/' . $andamento->id_parte ); ?>"><?php echo $cliente[$andamento->id_parte]; ?></a></td>
						<td><?php echo $andamento->status; ?></td>
                        <td><?php echo $andamento->descricao; ?></td>
                        <td>
                            <a href="<?php echo base_url('juridico/visualizar_andamento/' . $andamento->id ); ?>" class="btn btn-custom-secondary btn-sm"><i class="fa fa-binoculars"></i> Visualizar</a>
                        </td>
					</tr>
				<?php } ?>
			<?php }  ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-table.js'); ?>"></script>