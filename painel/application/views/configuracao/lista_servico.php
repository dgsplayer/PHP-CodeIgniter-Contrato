<?php echo $this->load->helper('date'); ?>

<div class="main-header">
    <div class="col-md-5">
        <h2>Lista dos Serviços</h2>
        <em>Lista de todos os serviços cadastrados</em>

    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('configuracao/cadastro_servico'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Novo Serviço</h5>
                            <em>Clique aqui para cadastrar novo serviço</em>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Serviços</h3>
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
					<th>ID</th>
					<th>Titulo</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $servicos as $servico ) { ?>
				<tr>
					<td><a href="<?php echo base_url('configuracao/cadastro_servico/' . $servico->id ); ?>"><?php echo $servico->id; ?></a></td>
					<td><a href="<?php echo base_url('configuracao/cadastro_servico/' . $servico->id ); ?>"><?php echo  $servico->titulo; ?></a></td>
					<td><a href="<?php echo base_url('configuracao/cadastro_servico/' . $servico->id ); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o fa-2"></i> Editar</a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>