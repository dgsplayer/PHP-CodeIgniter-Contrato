<?php echo $this->load->helper('funcoes'); ?>
<div class="main-header">
    <div class="col-md-5">
        <h2>Fornecedor</h2>

    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('fornecedor/cadastro'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Novo fornecedor</h5>
                            <em>Clique aqui para cadastrar novo fornecedor</em>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Fornecedores</h3>
        <div class="btn-group widget-header-toolbar">


        </div>
	</div>
	<div class="widget-content">

		<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
			<div class="alert alert-success bg-success text-center">
				<?php echo $mensagem; ?>
			</div>
		<?php } ?>

		<table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" id="table" width="100%">
			<thead>
				<tr>
                    <div class="label label-danger">
                        <i class="fa fa-ban"></i>
                        <?php echo($count_incompletos)?> CADASTRO(S) INCOMPLETO(S)
                    </div>
					<th>Nome</th>
					<th>Telefones</th>
                    <th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($clientes) && count($clientes)) { ?>
				<?php foreach( $clientes as $cliente ) {

                    ?>
					<tr>
						<td>                            
                            <?php echo($cliente->clienteIncompleto);?>
                            <a href="<?php echo base_url('fornecedor/detalhe/' . $cliente->id_pessoa ); ?>"><?php echo $cliente->nome; ?></a>
                        </td>
						<td><?php echo tracoVazio($cliente->telefone); ?></td>
                        <td><a href="<?php echo base_url('fornecedor/detalhe/' . $cliente->id_pessoa ); ?>" class="btn btn-custom-secondary btn-sm"><i class="fa fa-binoculars fa-2"></i> Visualizar</a></td>
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