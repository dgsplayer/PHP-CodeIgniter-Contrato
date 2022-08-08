<div class="main-header">
	<h2>Cadastro Tipo Petição</h2>
	<em>Cadastro do tipo de petição</em>
</div>

<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
	<div class="alert alert-success bg-success text-center">
		<?php echo $mensagem; ?>
	</div>
<?php } ?>

<?php echo form_open( 'juridico/cadastro_peticao' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>

	<div class="widget pessoa-fisica">
		<div class="widget-header">
			<h3><i class="fa fa-edit"></i> Novo Cadastro</h3>
		</div>
		<div class="widget-content">
			<div class="form-group">
				<label class="col-sm-2 control-label">* Nome</label>
				<div class="col-sm-10">
					<?php echo form_input(array('name' => 'peticao','class' => 'form-control' ,  'id' => 'peticao'), set_value('peticao', @$processo->peticao )); ?>
					<?php echo form_error('peticao'); ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php echo form_hidden('id', @$processo->id ); ?>
	
	<button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> Salvar</button>

<?php echo form_close(); ?>

<br/>
<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Cadastrados</h3>
	</div>
	<div class="widget-content">
		<table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Nome</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($listas) && count($listas)) { ?>
			<?php foreach( $listas as $lista ) { ?>
				<tr>
					<td><?php echo $lista->peticao; ?></td>
					<td></td>
				</tr>
			<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="2" class="text-center"> Sem informação cadastrada.</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>