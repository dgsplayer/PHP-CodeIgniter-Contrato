<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<script type="text/javascript">
	$(function () {
		$('#onCheck').click(function(){
			if (this.checked){
				$('.ids').prop('checked',true);
			} else {
				$('.ids').prop('checked',false);
			}
		});

		$('#efetuar_pagamento').on('click', function(e) {
			e.preventDefault();
			var ids = [];
			$('input.ids:checkbox:checked').each(function () {
				ids.push($(this).val());
			});
			console.log(ids);

			if(ids.length == 0 ){
				alert('Por favor selecione pelo menos 1 parcela.');
				return false;
			}
			var value = confirm('Deseja confirmar a operação ?');
			if(value == true) {
				$.post('/painel/cobranca/processa_efetuar_pagamento', {'ids' : ids}, function(d) {
					if(d.pago) {
						window.location.assign('/painel/cobranca/pagamento_recebido');
					}
				},'json');
			}
		});

		$('#cancelar_pagamento').on('click', function(e) {
			e.preventDefault();
			var ids = [];
			$('input.ids:checkbox:checked').each(function () {
				ids.push($(this).val());
			});
			console.log(ids);

			if(ids.length == 0 ){
				alert('Por favor selecione pelo menos 1 parcela.');
				return false;
			}
			var value = confirm('Deseja confirmar a operação ?');
			if(value == true) {
				$.post('/painel/cobranca/processa_cancelamento', {'ids' : ids}, function(d) {
					if(d.cancelamento) {
						window.location.assign('/painel/cobranca/pagamento_cancelado');
					}
				},'json');
			}
		});
	});
</script>
    <div class="main-header">
        <div class="col-md-5">
	<h2>Pagamentos a Receber</h2>
	<em>Informações do pagamentos a receber</em>
 </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('cobranca/pagamento_recebido'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Pagamentos Recebidos</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cobranca/pagamento_receber'); ?>">
                        <div class="quick-access-item bg-color-blue">
                            <i class="fa fa-clipboard"></i>
                            <h5>Pagamentos a Receber</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cobranca/pagamento_cancelado'); ?>">
                        <div class="quick-access-item bg-color-yellow">
                            <i class="fa fa-clipboard"></i>
                            <h5>Pagamentos Cancelados</h5>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="form-group">
	<a class="btn btn-primary" id="efetuar_pagamento" href="<?php echo base_url('cobranca/pagamento_receber/#'); ?>"> Efetuar Pagamento</a>
	<a class="btn btn-danger" id="cancelar_pagamento" href="<?php echo base_url('cobranca/pagamento_receber/#'); ?>"> Cancelar Pagamento</a>
</div>

<div class="widget widget-table">
	<div class="widget-header">
		<h3><i class="fa fa-table"></i>Pagamentos a Receber</h3>
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
					<th><?php echo form_checkbox(array('name' => 'checkbox', 'id' => 'onCheck'));?></th>
					<th>Cliente</th>
					<th>Contrato</th>
					<th>Parcela</th>
					<th>Vencimento</th>
					<th>Situação</th>
					<th>Notificação</th>
					<th>Boleto</th>
<!--					<th>Acordo</th>-->
<!--					<th>Históricos</th>-->
				</tr>
			</thead>
			<tbody>
			<?php if(isset($cobrancas) && count($cobrancas)) { ?>
				<?php foreach( $cobrancas as $cobranca ) { 
						if ($cobranca->atrasos == 'A Receber' && $cobranca->acordo == 'f'){
							$corColumnAtraso    =   '#008000';
							$valorAtualizado    =   $cobranca->valor_parcela;
						}
						if($cobranca->atrasos == 'Em Atraso' && $cobranca->acordo == 'f'){
							$corColumnAtraso    =   '#cc0000' ;
							$valorAtualizado    =  retornaCalculoAtraso( $cobranca->valor_parcela, $cobranca->multa, 1);
						}
						if($cobranca->acordo == 't'){
							$corColumnAtraso    =   '#c67605';
							$valorAtualizado    =   $cobranca->valor_parcela;
							$resCon['atrasos']  =   'Em Acordo';
						}
					?>
					<tr>
						<td><?php echo form_checkbox(array('name' => 'ids[]', 'class' => 'ids', 'value' => $cobranca->id ));?></td>
						<td><?php echo $cliente[$cobranca->id_pessoa_principal]; ?></td>
						<td><?php echo $cobranca->cod_contrato; ?></td>
						<td>N° <?php echo $cobranca->num_parcela; ?> / R$ <?php echo $valorAtualizado; ?></td>
						<td><?php echo parseDate( $cobranca->data_parcela,'date3'); ?></td>
						<td>
							<span style="color:<?php echo($corColumnAtraso); ?>; font-weight: bold"><?php echo $cobranca->atrasos;?></span>
						</td>
						<td><a target="_blank" href="<?php echo prep_url('www.contratonet.com.br/contract_key/download/download_notificacao/' . base64_encode($cobranca->id_contrato).'/'.base64_encode($cobranca->id)); ?>" class="btn btn-warning btn-sm">Notificação</a></td>
						<td><button target="_blank" data-toggle="modal" data-target="#boleto<?php echo($cobranca->id);?>"  class="btn btn-default btn-sm">Boleto</button></td>
<!--						<td><a href="--><?php //echo base_url('orcamento/cadastro/' . $cobranca->id ); ?><!--"></a></td>-->
<!--						<td><a href="--><?php //echo base_url('orcamento/cadastro/' . $cobranca->id ); ?><!--"></a></td>-->
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="9" class="text-center"> Sem informação cadastrada.</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<!--MODAL RECIBO-->
<?php if(!empty($cobrancas)) foreach( $cobrancas as $parcela ) { ?>
<?php echo form_open( 'email/enviar_documento_visualizar', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="recibo<?php echo($parcela->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">O que deseja fazer:</h4>
            </div>
            <div class="modal-body">
                <p><input type="radio" name="opcao_recibo_<?php echo($parcela->id) ?>" value="visualizar" checked>&nbsp;&nbsp;Visualizar</p>
                <p><input type="radio" name="opcao_recibo_<?php echo($parcela->id) ?>" value="email">
                    ou enviar para o e-mail abaixo:
                    <?php echo form_input(array('name' => 'email','class' => 'form-control' , 'placeholder' => 'Insira aqui o email de destino', 'id' => 'email_dialog'), set_value('email' )); ?>
                </p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-custom-primary" data-dismiss="" value="Ok" />
                <input name="id_complementar"   type="hidden" value="<?php echo($parcela->id); ?>">
                <input name="id_contrato"       type="hidden" value="<?php echo($parcela->id_contrato); ?>">
                <input name="checkDocumento"    type="hidden" value="Recibo">
                <!--Para controle do post em email/enviar_documento_visualizar  -> Não é possivel utilizar checkDocumento por causa dos acentos -->
                <input name="checkPost"         type="hidden" value="recibo">
            </div>
        </div>
    </div>
</div>
<?php echo form_close()?>
<?php } ?>