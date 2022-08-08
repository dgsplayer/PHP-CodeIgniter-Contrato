<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<style>
    .vigencia a{
        color: #008800;
    }
</style>
<div class="main-header">
    <div class="col-md-5">
        <h2>Lista de Contratos</h2>
        <em>Lista de todos os contratos cadastrados</em>

    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo site_url('contrato/cadastro/cliente'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Novo Contrato</h5>
                            <em style="color: #ffffff;">Clique aqui para cadastrar novo contrato</em>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Contratos</h3>
	</div>
	<div class="widget-content">

		<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
			<div class="alert alert-success bg-success text-center">
				<?php echo $mensagem; ?>
			</div>
		<?php } //echo '<pre>' . var_export($atrasados,true)?>

        <?php if(count(@$atrasados) > 0 ) { 	?>
            <div class="alert alert-danger bg-success text-center">
                <strong><?php echo 'Atenção, existem <span class="badge badge-important">' . count(@$atrasados) . '</span> parcelas em atraso! <BR>Caso já tenham sido pagas necessário dar baixa, caso contrário cliente continuara recebendo emails. '; ?></strong>
            </div>
        <?php } ?>

		<table class="table table-sorting table-striped table-hover datatable2" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Partes</th>
                    <th>N° do Contrato</th>
					<th>Valor Total</th>
<!--					<th>Início do Contrato</th>-->
<!--                    <th>Data de Expiração</th>-->
					<th>Status</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php if(!empty($contratos)) foreach( $contratos as $contrato ) { ?>

				<tr <?php if ($contrato->status == 'Em Vigencia') echo 'style="color: #3b853b; font-weight: bold" class="vigencia"' ;?> >
					<td><a href="<?php echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?>"><?php echo @$cliente[$contrato->id_pessoa_principal]; ?></a></td>
					<td><a href="<?php echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?>"><?php echo  @$contrato->cod_contrato; ?></a></td>
                    <td><a href="<?php echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?>"><?php echo  'R$ '.$contrato->valor_total; ?>
                            <?php if ($contrato->mensalidade == 't') echo ' (Mensal)';?>
                        </a>&nbsp;

                        <?php if (in_array($contrato->id_contrato,@$atrasados) && $contrato->status == 'Em Vigencia') { ?>
                            <a href="<?php echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?>" class="btn btn-danger btn-sm" style="color: #ffffff;">Parcela em Atraso</a>
                        <?php } ?>

                        <?php if( bigger_than_one_year(parseDate($contrato->data_inicio_contrato, 'date2mysql')) == 1 && $contrato->mensalidade == 't' && $contrato->status == 'Em Vigencia') { //Verifica se contrato ja expirou  ?>
                            <a href="<?php echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?>" class="btn btn-warning btn-sm" style="color: #ffffff;">Expirando</a>
                        <?php } ?>

                    </td>
<!--					<td><a href="--><?php //echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?><!--">--><?php //echo parseDate( $contrato->data_inicio_contrato , 'date3');?><!--</a></td>-->
<!--					<td><a href="--><?php //echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?><!--">--><?php //echo ($contrato->dt_expiracao == '0000-00-00') ? 'Tempo Indeterminado' : parseDate( $contrato->dt_expiracao, 'date3'); ?><!--</a></td>-->
					<td>
						<a href="<?php echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?>">

                                <?php echo $contrato->status ;?>

						</a>
					</td>
					<td>
						<a href="<?php echo base_url('contrato/visualizar/' . $contrato->id_contrato ); ?>" class="btn btn-custom-secondary btn-sm" style="color: #ffffff;"><i class="fa fa-binoculars"></i> Visualizar</a>
					</td>
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
<script>

    $(document).ready(function(){


        if( $('.datatable2').length > 0 ) {

            $('.datatable2').dataTable({
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "bPaginate": false,
                "sPaginationType": "bootstrap",
                "aaSorting": [[ 3, "asc" ]],
                "oLanguage": {
                    "sProcessing":   "Processando...",
                    "sLengthMenu":   "Mostrar _MENU_ registros",
                    "sZeroRecords":  "Não foram encontrados nenhum resultado",
                    "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Buscar:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext":     "Seguinte",
                        "sLast":     "Último"
                    }
                }
            });
        }
    });

</script>