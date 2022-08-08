<?php echo $this->load->helper('funcoes'); ?>
<div class="main-header">
	<h2>Lista de processos</h2>
	<em>Informações do Processo</em>
</div>
<style>
    input{
        width: 300px;
    }
</style>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Lista de processos</h3>
	</div>
	<div class="widget-content">

		<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
			<div class="alert alert-success bg-success text-center">
				<?php echo $mensagem; ?>
			</div>
		<?php } ?>

		<table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
<!--            <span style="float: right">&nbsp;</span>-->
			<thead>
            <tr>
                <th colspan="4"><a class="btn btn-info btn-sm" href="<?php echo base_url('juridico/busca/' ); ?>">Busca avançada</a></th>
            </tr>
				<tr>
					<th>Processo</th>
					<th>Cliente</th>
					<th>Status</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($processos) && count($processos)) { ?>
			<?php foreach( $processos as $processo ) { ?>
				<tr>
					<td><a href="<?php echo base_url('juridico/visualizar_processo/' . $processo->id ); ?>"><?php echo $processo->num_processo; ?></a></td>
					<td><a href="<?php echo base_url('cliente/detalhe/' . $processo->id_parte ); ?>"><?php echo @$cliente[$processo->id_parte]; ?></a></td>
					<td><?php echo converteStatus($processo->status); ?></td>
                    <td>
                        <a href="<?php echo base_url('juridico/visualizar_processo/' . $processo->id ); ?>" class="btn btn-custom-secondary btn-sm"><i class="fa fa-binoculars"></i> Visualizar</a>
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
