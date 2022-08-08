<link href="<?php echo base_url('recursos/assets/css/components.css'); ?>" rel="stylesheet" type="text/css"
      xmlns="http://www.w3.org/1999/html">
<div class="main-header">
    <div class="col-md-5">
        <h2>Cadastre seu contrato</h2>
        <em>Preencha os campos abaixo para criação de um contrato</em>
    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('contrato'); ?>">
                        <div class="quick-access-item bg-color-yellow">
                            <i class="fa fa-clipboard"></i>
                            <h5>Lista de contratos</h5>
                            <em>Clique aqui para listar contratos</em>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<style>
    .widget .widget-header h3{
        text-align: center !important;
        display: block !important;

    }

    .widget .widget-header{

        background-color: #f8f8d7 !important;
    }

</style>

<?php //echo form_open( '/sistema/contrato/processa_contrato', array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>

<form id="form1" class="form-horizontal" parsley-validate novalidate action="../processa_contrato/<? echo ($this->uri->segment(3))?>" method="POST">

    <div class="row">
        <div class="col-md-12">
            <?php

            if(empty($contratada->nome) || empty($contratada->cep) || empty($contratada->logradouro) || empty($contratada->numero) || empty($contratada->bairro) || empty($contratada->cidade) || empty($contratada->estado) || empty($contratada->telefone) || empty($contratada->email)){ ?>
                <p class="text-primary">Para continuar seus dados cadastrais precisam estar atualizados. <a href="<?php echo base_url('meuCadastro/index/edit/' . $contratada->id_pessoa); ?>"><ins>Clique aqui</ins>.</a></p>
                <?exit; } ?>

            <?php
            if(empty($contratoConfig->multa_padrao)){ ?>
                <div class="form-group">
                    <div class="alert alert-warning">Necessário definir a multa antes de prosseguir. <a href="<?php echo base_url('configuracao/'); ?>">Clique aqui</a></div>
                </div>
            <?  } ?>
            <div class="widget">
                <div class="widget-header">
                    <h3> QUALIFICAÇÃO DA CONTRATANTE(S)</h3>
                </div>
                <div class="widget-content">
                    <?php if(count($cliente) < 1){ ?>
                        <div class="alert alert-warning">Necessário cadastrar um <? echo ($this->uri->segment(3))?> completo antes de prosseguir. Faça este cadastro no menu ao lado.</div>
                    <?  } else { ?>
                        <?php echo form_dropdown('id_pessoa_principal', $cliente, set_value('id_pessoa_principal', @$cliente->nome ) , 'class="form-control"'); ?>
                        <?php echo form_error('id_pessoa_principal'); ?>


                        <button class="btn btn-link btn-xs" type="button" id="dropdown_secundario_button"><i class="fa fa-plus-square"></i> Adicionar um cliente existente</button>
                        <a class="btn btn-link btn-xs" href="<?php echo base_url('cliente/index/add'); ?>" type="button" id="dropdown_secundario_button"><i class="fa fa-plus-square"></i> Criar um novo cliente</a>
                    <?  } ?>
                    <div  style="display: none;" id="dropdown_secundario" >
                        <BR>
                        <?php echo form_dropdown('id_pessoa_secundario', $cliente, set_value('id_pessoa_secundario', @$cliente->nome ) , 'class="form-control"'); ?>
                        <?php echo form_error('id_pessoa_secundario'); ?>
                    </div>
                </div>
            </div>


            <div class="widget">
                <div class="widget-header">
                    <span><h3> CONDIÇÕES DE PAGAMENTO</h3></span>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <!--                            <p class="text-warning">&nbsp;</p>-->

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                <?php  echo form_dropdown('mensalidade', $mensalidade, set_value('mensalidade', @$modelo->mensalidade ) , 'id="tipo_contrato" class="form-control"'); ?>
                                <?php  echo form_error('mensalidade'); ?>
                            </div>
                            <BR>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <?php echo form_input(array('name' => 'valor_total', 'maxlength'=>'13', 'class' => 'form-control' , 'placeholder' => 'Insira o valor total do contrato','autocomplete' => 'off', 'id' => 'valor_total'), set_value('valor_total' )); ?>
                                <?php echo form_error('valor_total'); ?>
                            </div>
                            <BR>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <?php echo form_input(array('name' => 'entrada','maxlength'=>'13', 'class' => 'form-control' ,  'placeholder' => 'Insira o valor de entrada', 'autocomplete' => 'off', 'id' => 'entrada'), set_value('entrada' )); ?>
                            </div>
                            <?php echo form_error('entrada'); ?>
                            <BR>
                            <div class="input-group">
                                <span class="input-group-addon">Qtde</span>
                                <?php echo form_input(array('name' => 'qtd_parcelas','maxlength'=>'4', 'class' => 'form-control parcelas' , 'placeholder' => 'Parcelas', 'autocomplete' => 'off', 'id' => 'parcelas'), set_value('qtd_parcelas' )); ?>
                            </div>
                            <?php echo form_error('qtd_parcelas'); ?>
                            <BR>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                <?php  echo form_dropdown('forma', $forma, set_value('forma', @$forma->forma ) , 'id="forma" class="form-control"'); ?>
                            </div>
                            <?php echo form_error('forma'); ?>
                            <BR>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php echo form_input(array('name' => 'diadomes','class' => 'form-control datepicker' , 'placeholder' => 'Data do primeiro pagamento', 'autocomplete' => 'off', 'id' => 'diadomes'), set_value('diadomes' )); ?>

                            </div>
                            <?php echo form_error('diadomes'); ?>
                            <BR>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php echo form_input(array('name' => 'diaentrada','class' => 'form-control datepicker' , 'placeholder' => 'Data do pagamento de entrada', 'autocomplete' => 'off', 'id' => 'diaentrada'), set_value('diaentrada' )); ?>

                            </div>
                            <?php echo form_error('diaentrada'); ?>

                        </div>

                    </div>

                    <textarea class="form-control" name="descricao_forma_pagamento" rows="3" id="descricao-pagamento" placeholder="Descreva como será o pagamento ou as condições de entrada (Opcional)"><?php echo set_value('descricao_forma_pagamento'); ?></textarea>
                    <!--                    <BR>-->
                    <!--                    <div class="input-group">-->
                    <!--                        <input type="button" class="btn btn-default" id="btn-parcelas" disabled="disabled" data-toggle="modal" data-target="#myModal" style="margin: 0 auto;" value="Ver Parcelas" >-->
                    <!--                    </div>-->
                </div>
            </div>

            <div class="widget">
                <div class="widget-header">
                    <h3>PRAZO DE VIGÊNCIA DO CONTRATO</h3>
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
                    <BR>
                </div>
            </div>
            <div class="widget">
                <div class="widget-header">
                    <h3> MODELO DO SEU CONTRATO</h3>
                </div>
                <div class="widget-content">
                    <?php if(count($modelo) < 2){ ?>
                        <p class="text-danger">Seu modelo de contrato ainda não foi concluído. </p>
                    <?  } else { ?>
                        <?php echo form_dropdown('texto_base', $modelo, set_value('texto_base', @$modelo->tipo ) , 'id="modelo_contrato" class="form-control"'); ?>
                        <?php echo form_error('texto_base'); ?>
                    <?  } ?>
                    <a class="btn btn-link btn-xs" href="<?php echo base_url('contract/vinc_cliente'); ?>" type="button" id="dropdown_secundario_button"><i class="fa fa-plus-square"></i> Adicionar mais um modelo</a>
                </div>
            </div>
        </div>
    </div>
    <div class="widget">
        <div class="widget-header">
            <h3> DESCREVA OU SELECIONE SEU SERVIÇO / PRODUTO</h3>
        </div>
        <div class="widget-content">
            <?php if(!empty($servicos)) { ?>
                <p class="text-primary">Escolha o(s) serviço(s) abaixo previamente cadastrados ou digite no campo abaixo os serviços que serão feitos neste contrato. Caso queira cadastrar mais serviços <a href="<?php echo base_url('servicos/index/add'); ?>"><ins>Clique aqui</ins></a></p>
                <? foreach( $servicos as $servico ) { ?>
                    <div class="simple-checkbox">
                        <input id="checkbox<?php echo($servico->id);?>" name="servicos[]" type="checkbox" value="<?php echo($servico->id);?>">
                        <label for="checkbox<?php echo($servico->id);?>"><?php echo($servico->titulo);?></label>

                    </div>
                <?php } } else { ?>
                <div>
                    <div class="alert alert-warning">Você não possui nenhum serviço pré cadastrado. É <strong>recomendável</strong>
                        definir os seus serviços antes de começar seu contrato. <a href="<?php echo base_url('configuracao/cadastro_servico'); ?>">Clique aqui</a> para criar serviços.
                    </div>
                </div>
            <?php } ?>
            <div>
                <textarea class="form-control myTextEditor" name="descricao" rows="5" placeholder="Descreva aqui o serviço" ><?php echo set_value('descricao'); ?></textarea>
            </div>
            <?php echo form_error('descricao'); ?>
            <BR>
            <div class="row">
                <div class="col-md-6">
                    <input type="button" name="botao_gravar" class="btn btn-block btn-info btAvancar" style="margin: 0 auto;" value="Pré-Visualizar" >
                    * Necessário desbloquear pop-up
                </div>
                <div class="col-md-6">
                    <input type="submit" name="botao_gravar" class="btn btn-block btn-success" style="margin: 0 auto;" value="CONCLUIR" >
                </div>
            </div>
        </div>
    </div>

    <!--    MODAL DOCUMENTO-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Parcelas</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-borderer" id="text_fisica2">
                        <thead>
                        <th colspan="4">Altere se achar necessário </th>
                        </thead>
                        <tbody class="parc" >
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom-primary" data-dismiss="modal"><i class="fa fa-check-circle"></i> Ok</button>
                </div>
            </div>
        </div>
    </div>




    <input type="hidden" value=""  id="controleAnexo">
    <input type="hidden" value="<? echo ($this->uri->segment(3))?>"  name="tipoContrato">
    <input type="hidden" value="MENSAL" name="tipo_data" id="datas" />

    <?php echo form_hidden('multa', @$contratoConfig->multa_padrao ); ?>
    <?php echo form_close()?>

    <!--	<button class="btn btn-primary" type="submit">Gravar e Gerar Contrato</button>-->
    <!--	<button class="btn btn-primary" type="submit">Gravar e Sem Gerar Contrato</button>-->
    <!--	<button class="btn btn-primary" type="submit">Pré-Visualizar</button>-->

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
    <script type="text/javascript" src="<?php echo base_url('recursos/assets/js/tinymce/tinymce.min.js'); ?>"></script>

    <script>
        $(document).ready(function(){

            $(".parcelas").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

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
            $('#dropdown_secundario_button').click(function(){
                $('#dropdown_secundario').show();
                $(this).hide();
            });

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
                    $('#valor_total').attr('placeholder','Digite aqui o valor total do contrato');
                    $('#diadomes').attr('placeholder','Data da primeira parcela');
                    $('#valor_total').prop('disabled',false);
                    $('#diadomes').prop('disabled',false);
                    $('#parcelas').prop('disabled',false);
                    $('#entrada').prop('disabled',false);
                    $('#diaentrada').prop('disabled',false);
                    $('#forma').prop('disabled',false);
                    $('#btn-parcelas').prop('disabled',false);
                }
                if($(this).val() == 'Valor à Vista'){
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
            tinymce.init({
                mode : "specific_textareas",
                language : 'pt_BR',
                editor_selector : "myTextEditor",
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste textcolor "
                ],
                theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
                font_size_style_values: "12px,13px,14px,16px,18px,20px",
                style_formats: [
                    {title: 'Adicionar Classe Parte II', selector: 'tr', classes: 'contrato_color_parte' },
                    {title: 'Adicionar Classe Clausulas', selector: 'tr', classes: 'contrato_color_clausula' }
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | sizeselect | fontselect | fontsizeselect"
            });

            $('.btAvancar').click(function(){

//                $(this).prop('disabled',true);

                var dataString = $('#form1').serialize();

                $.ajax({
                    type: "POST",
                    url: "/contract_key/ajax/set_contrato",
                    data: dataString,
                    success: function(html) {
                        window.open('http://www.contratonet.com.br/contract_key/download/download_contrato/'+html+'/Pre');

//                        $.ajax({
//                            type: "POST",
//                            url: "/contract_key/ajax/del_contrato",
//                            data: { contract : html },
//                            success: function(html) {
//                                //ok
//                            }
//                        });

                    }
                });
            });

        });
    </script>

    <script src="<?php echo base_url('recursos/assets/js/jquery-pagamentos.js'); ?>"></script>
    <script src="<?php echo base_url('recursos/assets/js/jquery.masked-input.min.js'); ?>"></script>

    <script src="<?php echo base_url('recursos/assets/js/bootstrap-colorpicker.min.js'); ?>"></script>
    <script src="<?php echo base_url('recursos/assets/js/jquery.simplecolorpicker.js'); ?>"></script>
    <script src="<?php echo base_url('recursos/assets/js/bootstrap.touchspin.js'); ?>"></script>
    <script src="<?php echo base_url('recursos/assets/js/king-elements.js'); ?>"></script>
    <style>
        .widget .widget-header h3 {
            float: none !important;
            text-align: center !important;
        }
    </style>