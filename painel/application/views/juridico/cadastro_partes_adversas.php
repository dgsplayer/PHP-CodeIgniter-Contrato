<div class="main-header">
	<h2>Cadastro Parte Adversa</h2>
	<em>Cadastro de parte adversa</em>
</div>

<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
	<div class="alert alert-success bg-success text-center">
		<?php echo $mensagem; ?>
	</div>
<?php } ?>

<?php echo form_open( 'juridico/cadastro_partes_adversas' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>

	<div class="widget pessoa-fisica">
		<div class="widget-header">
			<h3><i class="fa fa-edit"></i> Novo Cadastro</h3>
		</div>
		<div class="widget-content">
			<div class="form-group">
				<label class="col-sm-2 control-label">* Nome / Razão Social</label>
				<div class="col-sm-10">
					<?php echo form_input(array('name' => 'nome','class' => 'form-control' ,  'id' => 'nome'), set_value('nome', @$processo->nome )); ?>
					<?php echo form_error('nome'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">* CPF / CNPJ </label>
				<div class="col-sm-10">
					<?php echo form_input(array('name' => 'cpf','class' => 'form-control' ,  'id' => 'cpf'), set_value('cpf', @$processo->cpf )); ?>
					<?php echo form_error('cpf'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">* E-mail </label>
				<div class="col-sm-10">
					<?php echo form_input(array('name' => 'email','class' => 'form-control' ,  'id' => 'email'), set_value('email', @$processo->email )); ?>
					<?php echo form_error('email'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">* Telefone </label>
				<div class="col-sm-10">
					<?php echo form_input(array('name' => 'telefone','class' => 'form-control' ,  'id' => 'telefone'), set_value('telefone', @$processo->telefone )); ?>
					<?php echo form_error('telefone'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">* Nome do Advogado </label>
				<div class="col-sm-10">
					<?php echo form_input(array('name' => 'advogado','class' => 'form-control' ,  'id' => 'advogado'), set_value('advogado', @$processo->advogado )); ?>
					<?php echo form_error('advogado'); ?>
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
					<td><?php echo $lista->nome; ?></td>
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