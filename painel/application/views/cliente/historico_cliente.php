<div class="main-header">
	<h2>Histórico do Cliente</h2>
	<em>Histórico do Cliente</em>
</div>

<?php echo form_open( '/cliente/processa_historico', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="widget">

	<div class="widget-header">
		<h3><i class="fa fa-edit"></i> Histórico do Cliente</h3>
	</div>

	<div class="widget-content">
			<div class="form-group">
				<label class="col-sm-2 control-label">Incluir no Histórico:</label>
				<div class="col-sm-10">
					<?php echo form_textarea(array('name' => 'historico', 'class' => 'form-control', 'cols' => 30, 'rows' => 5)); ?>
					<?php echo form_error('historico'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Enviar cópia para o Usuário (Opcional): </label>
				<div class="col-sm-10">
					<?php echo form_dropdown('partes', $contatos , 'large', 'class="multiselect"'); ?>
					<?php echo form_error('partes'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<a href="<?php echo base_url('log'); ?>" class="btn btn-primary">Ver histórico deste cliente</a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<button class="btn btn-primary" type="submit">Cadastrar</button>
					<a href="<?php echo base_url('cliente');?>" class="btn btn-info" >Cancelar</a>
				</div>
			</div>
	</div>
		
	<?php echo form_hidden( 'id_cliente', @$cliente->id_cliente ); ?>
	
</div>
<?php echo form_close()?>