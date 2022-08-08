<link href="<?php echo base_url('recursos/assets/css/components.css'); ?>" rel="stylesheet" type="text/css"
      xmlns="http://www.w3.org/1999/html">
<div class="main-header">
    <h2>Cadastro de Aditivo para <ins>Contrato n° <?php echo($cod_contrato); ?></ins></h2>
    <em>Escolha abaixo qual tipo de aditivo deseja criar</em>
</div>


<div class="row">
            <?php echo form_open( 'contrato/cadastro_aditivo/' . $id_contrato, array('class' => 'form-horizontal') )?>
            <div class="widget">
                <div class="widget-header">
                    <h3><i class="fa fa-user"></i> Aditivo para item 1 do contrato (Inclusão de uma parte)</h3>
                </div>
                <div class="widget-content">
                    <?php if(empty($contratos->id_pessoa_secundario)){ ?>
                        <?php echo form_dropdown('id_pessoa_secundario', $cliente, set_value('id_pessoa_secundario', @$cliente->nome ) , 'class="form-control"'); ?>
                        <?php echo form_error('id_pessoa_secundario'); ?>
                    <?php } else{ ?>
                    <div class="alert alert-info">
                        Contrato já possui máximo permitido
                    </div>
                    <?php } ?>
                </div>


            </div>

    <div class="widget">
        <div class="widget-header">
            <h3><i class="fa fa-user"></i> Aditivo para item 2 do contrato (Alterar pagamentos)</h3>
        </div>
        <div class="widget-content">

            <?php  echo form_dropdown('mensalidade', $mensalidade, set_value('mensalidade', @$modelo->mensalidade ) , 'id="tipo_contrato" class="form-control"'); ?>
            <?php  echo form_error('mensalidade'); ?>

            <BR>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <?php echo form_input(array('name' => 'valor_total', 'maxlength'=>'13', 'class' => 'form-control' , 'placeholder' => 'Insira o valor total','autocomplete' => 'off', 'id' => 'valor_total'), set_value('valor_total' )); ?>

                    </div>
                    <?php echo form_error('valor_total'); ?>
                    <BR>
                    <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <?php echo form_input(array('name' => 'entrada','maxlength'=>'13', 'class' => 'form-control' ,  'placeholder' => 'Insira o valor de entrada', 'autocomplete' => 'off', 'id' => 'entrada'), set_value('entrada' )); ?>
                    </div>
                    <?php echo form_error('entrada'); ?>
                    <BR>
                    <div class="input-group">
                        <span class="input-group-addon">Qtde</span>
                        <?php echo form_input(array('name' => 'qtd_parcelas','maxlength'=>'4', 'class' => 'form-control' , 'placeholder' => 'Parcelas', 'autocomplete' => 'off', 'id' => 'parcelas'), set_value('qtd_parcelas' )); ?>
                    </div>
                    <?php echo form_error('qtd_parcelas'); ?>
                    <BR>
                </div>

                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo form_input(array('name' => 'diadomes','class' => 'form-control datepicker' , 'placeholder' => 'Data do primeiro pagamento', 'autocomplete' => 'off', 'id' => 'diadomes'), set_value('diadomes' )); ?>

                    </div>
                    <?php echo form_error('diadomes'); ?>
                    <BR>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo form_input(array('name' => 'diaentrada','class' => 'form-control datepicker' , 'placeholder' => 'Data da entrada', 'autocomplete' => 'off', 'id' => 'diaentrada'), set_value('diaentrada' )); ?>

                    </div>
                    <?php echo form_error('diaentrada'); ?>
                    <BR>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                        <?php  echo form_dropdown('forma', $forma, set_value('forma', @$forma->forma ) , 'id="forma" class="form-control"'); ?>
                    </div>
                    <?php echo form_error('forma'); ?>
                </div>
            </div>

            <textarea class="form-control" name="descricao_forma_pagamento" rows="3" id="descricao-pagamento" placeholder="Descreva como será o pagamento ou as condições de entrada (Opcional)"><?php echo set_value('descricao_forma_pagamento'); ?></textarea>
            <BR>
<!--            <div class="input-group">-->
<!--                <input type="button" class="btn btn-default" id="btn-parcelas" disabled="disabled" data-toggle="modal" data-target="#myModal" style="margin: 0 auto;" value="Ver Parcelas" >-->
<!--            </div>-->

        </div>
    </div>

    <div class="widget">
                <div class="widget-header">
                    <h3><i class="fa fa-user"></i> Aditivo para item 4 do contrato (Vigência)</h3>
                </div>
                <div class="widget-content">
                    <?php echo form_dropdown('prazo_contrato', $prazo_contrato, set_value('prazo_contrato', @$modelo->prazo_contrato ) , 'id="prazo_contrato" class="form-control"'); ?>
                    <?php echo form_error('prazo_contrato'); ?>
                    <BR>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group date-inicio"  >
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php echo form_input(array('name' => 'data_inicio_contrato', 'disabled'=>'disabled', 'class' => 'form-control datepicker date-inicio' , 'placeholder' => 'Início deste contrato', 'id' => 'data_inicio_contrato'), set_value('data_inicio_contrato', @$cliente->data_inicio_contrato )); ?>
                            </div>
                            <?php echo form_error('data_inicio_contrato'); ?>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group dateRange"  >
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php echo form_input(array('name' => 'data_vigencia_contrato','disabled'=>'disabled','class' => 'form-control dateRange' , 'placeholder' => 'Vigência do contrato', 'id' => 'daterange-default'), set_value('data' )); ?>
                            </div>
                            <?php echo form_error('data_vigencia_contrato'); ?>
                        </div>
                    </div>

                </div>
            </div>
<div class="widget">
    <div class="widget-header">
        <h3><i class="fa fa-user"></i> Aditivo para item 5 do contrato (Serviços Prestados)</h3>
    </div>
    <div class="widget-content">
        <?php foreach( $servicos as $servico ) { ?>
        <div class="simple-checkbox">
            <input id="checkbox<?php echo($servico->id);?>" name="servicos[]" type="checkbox" value="<?php echo($servico->id);?>">
            <label for="checkbox<?php echo($servico->id);?>"><?php echo($servico->titulo);?></label>
        </div>
        <?php } ?>
        <div>
            <textarea class="form-control" name="descricao" cols="25" rows="5" placeholder="Descreva aqui o serviço" ><?php echo set_value('descricao'); ?></textarea>
        </div>
        <BR>
        <div>
            <input type="submit" class="btn btn-success" style="margin: 0 auto;" value="Criar Aditivo" >
        </div>
    </div>
</div>

     <?php echo form_hidden('id_contrato', $id_contrato ); ?>
    <?php echo form_hidden('num_parcela', $num_parcela->num_parcela ); ?>
<?php echo form_close()?>
</div>


<input type="hidden" value=""  id="controleAnexo">
<input type="hidden" value="MENSAL" name="tipo_data" id="datas" />

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jquery.masked-input.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-multiselect.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/custom-form.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/function-form.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jQAllRangeSliders-min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/wizard.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/parsley.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-components.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/daterangepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/moment.min.js'); ?>"></script>

<script>
    $(document).ready(function(){
        //chamando range Slider para data de vigencia
        $('.date-slider').dateRangeSlider({
            arrows: false
        });

        $('#daterange-default').daterangepicker({
            timePicker: true,
            timePickerIncrement: 10,
            format: 'DD/MM/YYYY'
        });

        $(".datepicker-full").datepicker({
            yearRange: '-0:+100',
            minDate: '0',
            format: 'dd/mm/yy'
        });

        //REGRA PARA PRAZO
        if($('#prazo_contrato').val() == 'Por tempo determinado'){
            $('.date-inicio').prop('disabled',true);
            $('.dateRange').prop('disabled',false);
        }
        if($('#prazo_contrato').val() == 'Por tempo indeterminado'){
            $('.date-inicio').prop('disabled',false);
            $('.dateRange').prop('disabled',true);
        }

        $('#prazo_contrato').change(function(){
            if($(this).val() == 'Por tempo determinado'){
                $('.date-inicio').prop('disabled',true);
                $('.dateRange').prop('disabled',false);
            }if($('#prazo_contrato').val() == 'Por tempo indeterminado'){
                $('.date-inicio').prop('disabled',false);
                $('.dateRange').prop('disabled',true);
            }
        });

        //REGRA PARA TIPO DE PAGAMENTO
        $('#tipo_contrato').change(function(){
            if($(this).val() == 'Valor Mensal'){
                $('#valor_total').attr('placeholder','Digite aqui o valor mensal');
                $('#diadomes').attr('placeholder','Data da primeira mensalidade');
                $('#valor_total').prop('disabled',false);
                $('#diadomes').prop('disabled',false);
                $('#parcelas').prop('disabled',true);
                $('#entrada').prop('disabled',false);
                $('#diaentrada').prop('disabled',false);
                $('#forma').prop('disabled',false);
                $('#btn-parcelas').prop('disabled',true);

            }
            if($(this).val() == 'Valor Parcelado'){
                $('#valor_total').attr('placeholder','Digite aqui o valor parcelado');
                $('#diadomes').attr('placeholder','Data da primeira parcela');
                $('#valor_total').prop('disabled',false);
                $('#diadomes').prop('disabled',false);
                $('#parcelas').prop('disabled',false);
                $('#entrada').prop('disabled',false);
                $('#diaentrada').prop('disabled',false);
                $('#forma').prop('disabled',false);
                $('#btn-parcelas').prop('disabled',false);
            }
            if($(this).val() == 'Valor a Vista'){
                $('#valor_total').attr('placeholder','Digite aqui o valor à vista');
                $('#diadomes').attr('placeholder','Data do pagamento');
                $('#valor_total').prop('disabled',false);
                $('#diadomes').prop('disabled',false);
                $('#parcelas').prop('disabled',true);
                $('#entrada').prop('disabled',true);
                $('#diaentrada').prop('disabled',true);
                $('#forma').prop('disabled',false);
                $('#btn-parcelas').prop('disabled',true);
            }
            if($(this).val() == 'Sem Valor'){
                $('#valor_total').prop('disabled',true);
                $('#diadomes').prop('disabled',true);
                $('#parcelas').prop('disabled',true);
                $('#entrada').prop('disabled',true);
                $('#diaentrada').prop('disabled',true);
                $('#forma').prop('disabled',true);
                $('#btn-parcelas').prop('disabled',true);
                $('#descricao-pagamento').attr('placeholder','Descrição da forma de pagamento');

            }
        });


        $('#modelo_contrato').change(function(){
            if($(this).val() == 'Sem Contrato'){
//                $('.msg-form3').show();
//                $('#form3').hide();
                $('#btn-contrato-visualizar').hide();
                $('#btn-contrato-email').hide();
                $('#btn-contrato-cliente-assina').hide();
            }else{
//                $('.msg-form3').hide();
//                $('#form3').show();
                $('#btn-contrato-visualizar').show();
                $('#btn-contrato-email').show();
                $('#btn-contrato-cliente-assina').show();
            }
        });

        //botao parcelas
        $("#diadomes").trigger('change');

        $('#diadomes').change(function(){
            if($(this).val() != ''){
                if($('#valor_total').val() != ''){
                    if($('#parcelas').val() > 0){
                        $('#btn-parcelas').prop('disabled',false);
                    }
                }
            }
        });

        $('#valor_total').change(function(){
            $("#diadomes").trigger('change');
        });
        $('#parcelas').change(function(){

            if($('#parcelas').val() == '' || $('#parcelas').val() == '0'){
                $('#parcelas').val('1');
            }

            $("#diadomes").trigger('change');
        });

    });
</script>

<script src="<?php echo base_url('recursos/assets/js/jquery-pagamentos.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/jquery.masked-input.min.js'); ?>"></script>

<script src="<?php echo base_url('recursos/assets/js/bootstrap-colorpicker.min.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/jquery.simplecolorpicker.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/bootstrap.touchspin.js'); ?>"></script>
<script src="<?php echo base_url('recursos/assets/js/king-elements.js'); ?>"></script>