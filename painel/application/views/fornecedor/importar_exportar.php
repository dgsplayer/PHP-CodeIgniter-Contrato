<script type="text/javascript">
	$(function() {
		$('.click-instrucao').on('click', function() {
			$( ".campo-instrucao" ).slideToggle( "slow");
		});
	});
</script>

<div class="main-header">
	<h2>Importar Clientes</h2>
	<em>Formulário para importa clientes</em>
</div>

<p> - Clique abaixo e selecione um arquivo excel para importar seus clientes. Caso tenha duvidas de como fazer <strong class="click-instrucao"> clique aqui</strong> </p>

<div class="campo-instrucao">

	<h3>Instruções</h3>
	<p>Abaixo mostramos um exemplo de como a planilha <b>PESSOA JURÍDICA</b> deve ser preenchida:</p>
	<div class="widget pessoa-fisica">
		<table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Razao Social</th>
					<th>CNPJ</th>
					<th>Inscricao Estadual</th>
					<th>DDD + Telefone</th>
					<th>Email</th>
					<th>Celular para Contato</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Empresa Ficticia 1</td>
				<td>00.000.000/0001-00</td>
				<td>9999999999999</td>
				<td>(99) 99999-9999</td>
				<td>empresa@ficticia.com.br</td>
				<td>(99) 99999-9999</td>
			</tr>
			<tr>
				<td>Empresa Ficticia 2</td>
				<td>00.000.000/0001-00</td>
				<td>9999999999999</td>
				<td>(99) 99999-9999</td>
				<td>empresa2@ficticia.com.br</td>
				<td>(99) 99999-9999</td>
			</tr>
			</tbody>
		</table>
	</div>

	<hr class="inner-separator">

	<p>Abaixo mostramos um exemplo de como a planilha <b>PESSOA FÍSICA</b> deve ser preenchida:</p>

	<div class="widget pessoa-fisica">
		<table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Nome</th>
					<th>CPF</th>
					<th>RG</th>
					<th>DDD + Telefone</th>
					<th>Email</th>
					<th>DDD + Celular</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Patrícia Araújo</td>
				<td>111.111.111-11</td>
				<td>00.000.000-X</td>
				<td>(99) 99999-9999</td>
				<td>patricia.araujo@email.com.br</td>
				<td>(99) 99999-9999</td>
			</tr>
			<tr>
				<td>Maria de Lourdes</td>
				<td>000.000.000-00</td>
				<td>00.000.000-X</td>
				<td>(99) 99999-9999</td>
				<td>maria.lurdes@email.com.br</td>
				<td>(99) 99999-9999</td>
			</tr>
			</tbody>
		</table>
	</div>

</div>

<?php echo form_open_multipart( 'cliente/processa_importacao', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
	
	<div class="widget pessoa-fisica">
		<div class="widget-header">
			<h3><i class="fa fa-edit"></i> Importar</h3>
		</div>
		<div class="widget-content">
				<div class="form-group">
					<label class="col-sm-2 control-label">* Arquivo</label>
					<div class="col-sm-10">
						<?php echo form_upload(array('name' => 'file',  'id' => 'file')); ?>
						<?php echo form_error('file'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<button class="btn btn-primary" type="submit">Importar</button>
					</div>
				</div>
		</div>
	</div>

<?php echo form_close()?>