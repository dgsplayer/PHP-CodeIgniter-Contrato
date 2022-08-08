<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-header">
	<h2>Lista das Atividades</h2>
	<em>Lista de todos as atividades do seu sistema.</em>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Atividades</h3>
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
<!--					<th>Tipo</th>-->
					<th>Usuário</th>
					<th>Ação</th>
                    <th>Data do Evento</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $atividades as $atividade ) { ?>
				<tr>
					<td><?php echo tracoVazio($atividade->admin); ?></td>
					<td><?php echo  $atividade->acao; ?></td>
                    <td><?php echo  parseDate($atividade->data,'both'); ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-table.js'); ?>"></script>