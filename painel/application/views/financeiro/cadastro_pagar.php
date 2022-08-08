<?php $this->load->helper('date'); ?>
    <div class="main-header">
        <div class="col-md-4">
            <h2>Contas a Pagar</h2>
            <em>Informações do contas a pagar</em>
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
    <script type="text/javascript">
        $(function() {
            $('#valor_parcela').maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
            $('#data_parcela').datepicker();
            $("#repeticao").mask("?999", {autoclear: 0});
        })
    </script>

<?php echo form_open( base_url('financeiro/processa_conta'), array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>
    <div class="row">
        <div class="col-md-12">
    <div class="widget pessoa-fisica">
        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Contas a Pagar</h3>
        </div>
        <div class="widget-content">
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label">Descrição da despesa</label>
                    <?php echo form_input(array('name' => 'fin_titulo','class' => 'form-control' ,  'id' => 'fin_titulo' ), set_value('fin_titulo', @$financeiro->fin_titulo )); ?>
                    <?php echo form_error('fin_titulo'); ?>
                </div>
                <div class="col-sm-6">
                    <label class="control-label">Conta (opcional)</label></br>
                    <?php echo form_dropdown('fin_conta', $contas , set_value('fin_conta', @$financeiro->fin_conta ) , 'class="multiselect"'); ?>
                    <?php echo form_error('fin_conta'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label">Valor (R$)</label>
                    <?php echo form_input(array('name' => 'valor_parcela','class' => 'form-control' ,  'id' => 'valor_parcela' ), set_value('valor_parcela', @$financeiro->valor_parcela )); ?>
                    <?php echo form_error('valor_parcela'); ?>
                </div>
                <div class="col-sm-6">
                    <label class="control-label">Categoria (opcional)</label></br>
                    <?php echo form_dropdown('fin_categoria', $categorias , set_value('fin_categoria', @$financeiro->fin_categoria ) , 'class="multiselect"'); ?>
                    <?php echo form_error('fin_categoria'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label">Data do Lançamento (opcional)</label>
                    <?php echo form_input(array('name' => 'data_parcela','class' => 'form-control' ,  'id' => 'data_parcela' ), set_value('data_parcela', parseDate( @$financeiro->data_parcela , 'date3') )); ?>
                    <?php echo form_error('data_parcela'); ?>
                </div>
                <div class="col-sm-6">
                    <label class="control-label"></label>
                    <div>
                        <?php echo form_radio('pago', '1', (@$financeiro->pago == 1)); ?> Pago <?php echo form_radio('pago', '0', (@$financeiro->pago == 0)); ?> À Pagar
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="control-label">Cliente/Fornecedor (opcional)</label></br>
                    <?php echo form_dropdown('fin_id_parte', $pessoas , set_value('fin_id_parte', @$financeiro->fin_id_parte ) , 'class="multiselect"'); ?>
                    <?php echo form_error('fin_id_parte'); ?>
                </div>
                <?php if(empty($financeiro->id)){ ?>
                <div class="col-sm-6">
                    <label class="control-label">Repetir (opcional)</label>
                    <?php echo form_input(array('name' => 'repeticao','class' => 'form-control' ,  'id' => 'repeticao', 'maxlength' => 3), set_value('repeticao', @$financeiro->repeticao )); ?>
                    <?php echo form_error('repeticao'); ?>
                </div>
                <?php } ?>
            </div>

            <?php if(empty($financeiro->id)){ ?>
            <div class="form-group">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <label class="control-label">Período</label></br>
                    <?php echo form_dropdown('repeticaoTipo', array('' => 'Selecione uma opção','QUINZENAL' => '15 EM 15 DIAS', 'MENSAL' => '30 EM 30 DIAS') , set_value('repeticaoTipo', @$financeiro->repeticaoTipo ) , 'class="multiselect"'); ?>
                    <?php echo form_error('repeticaoTipo'); ?>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
        </div>
    </div>
<?php echo form_hidden('id', @$financeiro->id ); ?>
<?php echo form_hidden('tipo', 'DESPESA' ); ?>

    <button class="btn btn-primary" type="submit">Salvar</button>

<?php echo form_close(); ?>