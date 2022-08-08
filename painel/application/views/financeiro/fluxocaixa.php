<?php $this->load->helper('date'); ?>
<?php $this->load->helper('funcoes'); ?>
<div class="main-header">
    <div class="col-md-4">
    <h2>Fluxo de caixa</h2>
    <em>Informações sobre seu fluxo de caixa</em>
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

<form action="busca_fluxo" method="POST">
    <div class="row">
        <div class="col-sm-2">
            <select class="form-control" name="mes">
                <option <? if($mes == '1') echo('selected="selected"');?> value="1">JANEIRO</option>
                <option <? if($mes == '2') echo('selected="selected"');?> value="2">FEVEREIRO</option>
                <option <? if($mes == '3') echo('selected="selected"');?> value="3">MARÇO</option>
                <option <? if($mes == '4') echo('selected="selected"');?> value="4">ABRIL</option>
                <option <? if($mes == '5') echo('selected="selected"');?> value="5">MAIO</option>
                <option <? if($mes == '6') echo('selected="selected"');?> value="6">JUNHO</option>
                <option <? if($mes == '7') echo('selected="selected"');?> value="7">JULHO</option>
                <option <? if($mes == '8') echo('selected="selected"');?> value="8">AGOSTO</option>
                <option <? if($mes == '9') echo('selected="selected"');?> value="9">SETEMBRO</option>
                <option <? if($mes == '10') echo('selected="selected"');?> value="10">OUTUBRO</option>
                <option <? if($mes == '11') echo('selected="selected"');?> value="11">NOVEMBRO</option>
                <option <? if($mes == '12') echo('selected="selected"');?> value="12">DEZEMBRO</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select class="form-control" name="ano">
                <?php
                for($i=$anoAtual['year'];$i>=$dezAnosAntes;$i--){ ?>
                    <option  <? if($ano == $i) echo('selected="selected"');?>  value="<?php echo($i);?>"><?php echo($i);?></option>
                <? } ?>
            </select>
        </div>
        <div class="col-sm-1">
            <input type="submit" class="btn btn-success" value="Buscar">
        </div>
    </div>
</form>
<BR>
<div class="widget">
    <div class="widget-content">
        <div class="row">
            <div class="col-sm-8 text-center"  style="margin-top: 30px">
                <strong>FLUXO DE CAIXA</strong>
            </div>
            <div class="demo-popover2">
                <div class="col-sm-4">
                    <p><a class="btn btn-link" href="#" data-content="Soma dos lançamentos recebidos e pagos do mês anterior" data-placement="left" data-toggle="popover" data-container="body" type="button" data-original-title="" title="">?</a> Saldo mês anterior: R$ <?php echo (tracoVazio(number_format(@$anterior_mes,2,',','.'))); ?></p>
                    <p><a class="btn btn-link" href="#" data-content="Soma dos lançamentos recebidos e pagos do mês" data-placement="left" data-toggle="popover" data-container="body" type="button" data-original-title="" title="">?</a> Saldo do mês: R$ <?php echo (tracoVazio(number_format(@$previsto_mes,2,',','.'))); ?></p>
                    <p><a class="btn btn-link" href="#" data-content="Soma dos lançamentos recebidos e pagos deste mês e do mês anterior (Saldo em caixa)" data-placement="left" data-toggle="popover" data-container="body" type="button" data-original-title="" title="">?</a> Saldo atual: R$ <?php echo (tracoVazio(number_format(@$saldo_mes,2,',','.'))); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="widget widget-table">
    <div class="widget-header">
        <h3><i class="fa fa-table"></i>Fluxo de caixa</h3>
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
                <th>Data</th>
                <th>Conta</th>
                <th>Categoria</th>
                <th>Descrição do Lançamento</th>
                <th>Valor</th>
                <th>Situação</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($financeiros) && count($financeiros)) { ?>
                <?php foreach( $financeiros as $financeiro ) {
                    $disabledButtons = ($financeiro->fin_conta != 'Contratos de FORNECEDOR' ) ? '' : 'disabled="disabled"' ;
                    $relButtons      = ($financeiro->fin_conta != 'Contratos de FORNECEDOR' ) ? '' : 'no-validate' ;
                    $cor_linha = ($financeiro->tipo == 'DESPESA') ? 'cd0a0a' : '0065FF';
                    $signal              = ($financeiro->tipo == 'DESPESA') ? '-' : '';
                    $situacao           = '';
                    if($financeiro->tipo == 'DESPESA'){
                        if($financeiro->pago == '1'){
                            $situacao = 'Pago';
                        }
                        if($financeiro->pago != '1'){
                            $situacao = 'à Pagar';
                        }
                    }
                    if($financeiro->tipo == 'RECEITA'){
                        if($financeiro->pago == '1'){
                            $situacao = 'Recebido';
                        }
                        if($financeiro->pago != '1'){
                            $situacao = 'à Receber';
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo parseDate( $financeiro->data_parcela , 'date3'); ?></td>
                        <td>
                            <?php if(!empty($financeiro->fin_id_parte)){?>
                                <a href="<?php echo base_url('cliente/index/read/' . $financeiro->fin_id_parte ); ?>"><?php echo $cliente[$financeiro->fin_id_parte]; ?></a>
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
                        <td><?php echo( $signal . number_format($financeiro->valor_parcela,2,',','.')); ?></td>
                        <td><?php echo $situacao ?><?php if($situacao == 'Recebido' || $situacao == 'Pago') { ?>&nbsp;<i class="fa fa-check"></i><?php } ?></td>
                    </tr>
                <?php } ?>
            <?php }  ?>
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
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-tour.custom.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-common-popover.js'); ?>"></script>