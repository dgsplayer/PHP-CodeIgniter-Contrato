<?php $this->load->helper('date'); ?>
<?php $this->load->helper('funcoes'); ?>
<script type="text/javascript">
    $(function () {
        $('#onCheck').click(function(){
            if (this.checked){
                $('.ids').prop('checked',true);
            } else {
                $('.ids').prop('checked',false);
            }
        });

        $('#cancelar_pagamento').on('click', function(e) {
            e.preventDefault();
            var ids = [];
            $('input.ids:checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if(ids.length == 0 ){
                alert('Por favor selecione pelo menos 1 parcela.');
                return false;
            }
            var value = confirm('Deseja confirmar a operação ?');
            if(value == true) {
                $.post('/painel/financeiro/processa_cancelamento', {'ids' : ids}, function(d) {
                    if(d.cancelamento) {
                        window.location.reload();
                    }
                },'json');
            }
        });

        $('#realizar_pagamento').on('click', function(e) {
            e.preventDefault();
            var ids = [];
            $('input.ids:checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if(ids.length == 0 ){
                alert('Por favor selecione pelo menos 1 parcela.');
                return false;
            }
            var value = confirm('Deseja confirmar a operação ?');
            if(value == true) {
                $.post('/painel/financeiro/processa_pagamento', {'ids' : ids}, function(d) {
                    if(d.recebimento) {
                        window.location.reload();
                    }
                },'json');
            }
        });
    });
</script>
<div class="main-header">
    <div class="col-md-4">
    <h2>Extrato</h2>
    <em>Informações do extrato</em>
    </div>
    <div class="col-md-8">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('financeiro'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Extrato</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('financeiro/receber'); ?>">
                        <div class="quick-access-item bg-color-blue">
                            <i class="fa fa-clipboard"></i>
                            <h5>Contas a Receber</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('financeiro/pagar'); ?>">
                        <div class="quick-access-item bg-color-yellow">
                            <i class="fa fa-clipboard"></i>
                            <h5>Contas a Pagar</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('financeiro/fluxocaixa'); ?>">
                        <div class="quick-access-item bg-color-orange">
                            <i class="fa fa-clipboard"></i>
                            <h5>Fluxo de Caixa</h5>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<form action="financeiro/busca_extrato" method="POST">
    <div class="form-group">
        <a class="btn btn-danger" id="cancelar_pagamento"  href="<?php echo base_url('cobranca/pagamento_receber/#'); ?>">Cancelar Lançamento</a>
        <a class="btn btn-success" id="realizar_pagamento"  href="<?php echo base_url('cobranca/pagamento_receber/#'); ?>">Pagar ou Receber Lançamento</a>

        <?php if(!empty($dt_inicio) && !empty($dt_fim)){ ?>
            <span class="alert  alert-success">
                <strong>Pesquisa: </strong> De <?php echo(parseDate($dt_inicio,'date3'));?> até <?php echo(parseDate($dt_fim,'date3'));?>
            </span>
        <?php } else{ ?>
            <span class="alert  alert-success">
                <strong>Pesquisa: </strong> Mês vigente
            </span>
        <?php }?>
        <button type="submit" class="btn btn-success btn-sm pull-right">Buscar</button>
        <div id="reportrange" class="pull-right report-range">
            <i class="fa fa-calendar"></i>
            <span class="range-value"></span><b class="caret"></b>
        </div>
        <input id="dt_inicio"   name="dt_inicio"  value=""  type="hidden">
        <input id="dt_fim"      name="dt_fim"     value=""  type="hidden">
    </div>
</form>

<div class="widget widget-table">
    <div class="widget-content">
        <div class="form-group">
            <div class="col-sm-8 text-center">
                <strong>EXTRATO / RESUMO</strong>
            </div>
            <div class="demo-popover2">
                <div class="col-sm-4">
                    <p><a class="btn btn-link" href="#" data-content="Soma dos lançamentos recebidos e pagos" data-placement="left" data-toggle="popover" data-container="body" type="button" data-original-title="" title="">?</a> Saldo Atual: R$ <?php echo (tracoVazio(number_format($totalExtratoGeral,2,',','.'))); ?></p>
                    <p><a class="btn btn-link" href="#" data-content="Soma de todas as despesas e receitas (incluindo recebidos e pagos)" data-placement="left" data-toggle="popover" data-container="body" type="button" data-original-title="" title="">?</a> Previsão: R$ <?php echo (tracoVazio(number_format($totalExtratoPrevisao,2,',','.'))); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="widget widget-table">
    <div class="widget-header">
        <h3><i class="fa fa-table"></i>Extrato</h3>
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
                <th>Data</th>
                <th>Conta</th>
                <th>Categoria</th>
                <th>Descrição do Lançamento</th>
                <th>Valor</th>
                <th>Situação</th>
                <!--<th>#</th>-->
            </tr>
            </thead>
            <tbody>
            <?php if(isset($financeiros) && count($financeiros)) { ?>
                <?php foreach( $financeiros as $financeiro ) {
                    $signal = ($financeiro->tipo == 'DESPESA') ? '-' : '';
                    $cor_linha = ($financeiro->tipo == 'DESPESA') ? 'cd0a0a' : '0065FF';
                    $situacao = '';
                    if($financeiro->tipo == 'DESPESA'){
                        if($financeiro->pago == '1'){
                            $situacao = 'Pago';
                        }
                        if($financeiro->pago != '1'){
                            $situacao = 'à Pagar';
                        }
                        $dialogExtrato = 'btn-edit-despesa';
                    }
                    if($financeiro->tipo == 'RECEITA' || $financeiro->tipo == 'ENTRADA'){
                        if($financeiro->pago == '1'){
                            $situacao = 'Recebido';
                        }
                        if($financeiro->pago != '1'){
                            $situacao = 'à Receber';
                        }
                        $dialogExtrato = 'btn-edit-receita';
                    }
                    ?>
                    <tr>
                        <td><?php echo form_checkbox(array('name' => 'ids[]', 'class' => 'ids', 'value' => $financeiro->id ));?></td>
                        <td><?php echo parseDate( $financeiro->data_parcela , 'date3');?></td>
                        <td>
                            <?php if(!empty($financeiro->fin_id_parte)){?>
                                <a href="<?php echo base_url('cliente/index/read/' . $financeiro->fin_id_parte ); ?>"><?php echo substr($cliente[$financeiro->fin_id_parte],0,20).'...'; ?></a>
                            <?php } else { ?>
                                <?php echo tracoVazio($financeiro->fin_conta); ?>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if(!empty($financeiro->id_contrato)){?>
                                <a href="<?php echo base_url('contrato/visualizar/' . $financeiro->id_contrato ); ?>"><?php echo tracoVazio($financeiro->fin_categoria); ?></a>
                            <?php } else { ?>
                                <?php echo tracoVazio($financeiro->fin_categoria); ?>
                            <?php } ?>
                        </td>
                        <td><?php echo tracoVazio($financeiro->fin_titulo); ?></td>
                        <td><?php echo $signal . number_format($financeiro->valor_parcela,2,',','.'); ?></td>
                        <td><?php echo $situacao ?><?php if($situacao == 'Recebido' || $situacao == 'Pago') { ?>&nbsp;<i class="fa fa-check"></i><?php } ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="<?php echo base_url('recursos/assets/js/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/jQAllRangeSliders-min.js'); ?>"></script>

<script src="<?php echo base_url('recursos/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/daterangepicker.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/king-elements-daterange.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-tour.custom.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-common-popover.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-table.js'); ?>"></script>