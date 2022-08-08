<div class="main-header">
	<h2>Configurações do Contrato</h2>
<!--	<em>Campos com dados do orçamento</em>-->
</div>
<?php if($this->session->flashdata("sucesso")) echo ('<div class="alert alert-success">' . $this->session->flashdata("sucesso") . '</div>'); ?>

<?php echo form_open( '/configuracao/processa_cadastro', array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>

	<div class="widget">
		<div class="widget-header">
			<h3><i class="fa fa-edit"></i> Atualize a multa estipulada para todos os contratos</h3>
		</div>
		<div class="widget-content">
				<div class="form-group">
					<label class="col-sm-2 control-label">Valor Padrão da Multa</label>
                    <div class="input-group col-sm-3">

						<?php echo form_input(array('name' => 'multa_padrao', 'maxlength' => '2', 'placeholder'=>'Atualize aqui o valor da multa', 'class' => 'form-control' , 'autocomplete' => 'off'), set_value('multa_padrao', @$configuracao->multa_padrao ),'autofocus'); ?>
						<?php echo form_error('multa_padrao'); ?>
                        <span class="input-group-addon">%</span>
					</div>
				</div>
		</div>
	</div>

	<button class="btn btn-primary" type="submit">Salvar</button>

<?php echo form_close(); ?>
