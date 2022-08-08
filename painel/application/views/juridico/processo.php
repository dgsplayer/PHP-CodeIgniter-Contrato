<script type="text/javascript">
    $(document).ready(function() {

        //AJAX PARA POPULAR CAMPOS TYPEAHEAD
        $( "#nome_cliente" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "/painel/orcamento/ajax_autocompletar",
                    dataType: "json",
                    method: "post",
                    data: { q: request.term },
                    success: function( data ) {
                        response( data );
                    }

                });
            }
        });
        $( "#nome_cliente" ).on( "autocompleteselect", function( e, ui ) {
            $("#id_parte").val(ui.item.id_pessoa);
        });

        $( "#vara" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "/painel/juridico/ajax_autocompletar_vara",
                    dataType: "json",
                    method: "post",
                    data: { q: request.term },
                    success: function( data ) {
                        response( data );
                    }

                });
            }
        });
        $( "#vara" ).on( "autocompleteselect", function( e, ui ) {
            $("#id_forum").val(ui.item.id_forum);
        });

        $( "#processo_vinculado" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "/painel/juridico/ajax_autocompletar_processo",
                    dataType: "json",
                    method: "post",
                    data: { q: request.term },
                    success: function( data ) {
                        response( data );
                    }

                });
            }
        });
        $( "#processo_vinculado" ).on( "autocompleteselect", function( e, ui ) {
            $("#id_processo_vinculado").val(ui.item.id);
        });

        $( "#contrato" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "/painel/juridico/ajax_autocompletar_contrato",
                    dataType: "json",
                    method: "post",
                    data: { q: request.term },
                    success: function( data ) {
                        response( data );
                    }

                });
            }
        });
        $( "#contrato" ).on( "autocompleteselect", function( e, ui ) {
            $("#id_contrato").val(ui.item.id_contrato);
        });

        $( "#parte_adversa" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "/painel/juridico/ajax_autocompletar_parte_adversa",
                    dataType: "json",
                    method: "post",
                    data: { q: request.term },
                    success: function( data ) {
                        response( data );
                    }

                });
            }
        });
        $( "#parte_adversa" ).on( "autocompleteselect", function( e, ui ) {
            $("#id_parte_adversa").val(ui.item.id);
        });



        //LIMPA OUTROS CAMPOS
        $( ".new" ).blur( function(  ) {
            var count = 0;
            $(".new").each(function(){
                if($(this).val() != ''){
                    $( "#nome_cliente").val('');
                    $( "#nome_cliente").prop('disabled',true);
                    $( "#id_pessoa_principal").val('');
                    count = 1;
                }
            });

            if(count == 0){
                $("#nome_cliente").prop('disabled', false);
            }
        });

        //LIMPA OUTROS CAMPOS
        $( ".newadversa" ).blur( function(  ) {
            var count = 0;
            $(".newadversa").each(function(){
                if($(this).val() != ''){
                    $( "#parte_adversa").val('');
                    $( "#parte_adversa").prop('disabled',true);
                    $( "#id_parte_adversa").val('');
                    count = 1;
                }
            });

            if(count == 0){
                $("#parte_adversa").prop('disabled', false);
            }
        });

        //LIMPA OUTROS CAMPOS
        $( "#novovara" ).blur( function(  ) {
                if($('#novovara').val() != ''){
                    $( "#vara").val('');
                    $( "#vara").prop('disabled',true);
                    $( "#id_forum").val('');
                }else{
                    $("#vara").prop('disabled', false);
                }

        });

    });
</script>
<div class="main-header">
    <h2>Novo Processo</h2>
    <em>Informações do processo</em>
</div>

<?php echo form_open( 'juridico/processa_processo' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>
<div class="row">
<div class="col-md-6">
    <div class="widget">
        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Informações Iniciais</h3>
        </div>
        <div class="widget-content">
            <div class="form-group">
                <label class="col-sm-3 control-label">Número do processo</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'num_processo','class' => 'form-control' ,  'id' => 'num_processo'), set_value('num_processo', @$processo->num_processo ),'autofocus'); ?>
                    <?php echo form_error('num_processo'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Vincular com outro processo</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'processo_vinculado','id' => 'processo_vinculado','class' => 'form-control' , 'placeholder' => 'Digite os primeiros números do processo já cadastrado'), set_value('processo_vinculado', @$processo->processo_vinculado )); ?>
                    <?php echo form_error('processo_vinculado'); ?>
                    <?php echo form_input(array('name'  => 'id_processo_vinculado', 'type'=>'hidden', 'id' => 'id_processo_vinculado','value'=>@$processo->id_processo_vinculado)); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-3 control-label">Cliente</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'nome_cliente','class' => 'form-control' , 'placeholder' => 'Digite as primeiras letras do nome do cliente cadastrado' ,'id' => 'nome_cliente'), set_value('nome_cliente', @$processo->cliente )); ?>
                    <?php echo form_error('nome_cliente'); ?>
                    <?php echo form_input(array('name'  => 'id_parte', 'type'=>'hidden', 'id' => 'id_parte','value'=>@$processo->id_parte)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Vara e fórum</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'vara','class' => 'form-control' , 'placeholder' => 'Digite as primeiras letras da vara ou fórum' ,'id' => 'vara'), set_value('vara', @$processo->forum )); ?>
                    <?php echo form_error('vara'); ?>
                    <?php echo form_input(array('name'  => 'id_forum', 'type'=>'hidden', 'id' => 'id_forum','value'=>@$processo->id_forum)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Parte adversas</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'parte_adversa','class' => 'form-control' , 'placeholder' => 'Digite as primeiras letras do nome da parte' ,'id' => 'parte_adversa'), set_value('parte_adversa', @$processo->parte_adversa )); ?>
                    <?php echo form_error('parte_adversa'); ?>
                    <?php echo form_input(array('name'  => 'id_parte_adversa', 'type'=>'hidden', 'id' => 'id_parte_adversa','value'=>@$processo->id_parte_adversa)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Número contrato de honorários</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'contrato','class' => 'form-control' , 'placeholder' => 'Digite os primeiro números do contrato' ,'id' => 'contrato'), set_value('contrato', @$processo->contrato )); ?>
                    <?php echo form_error('contrato'); ?>
                    <?php echo form_input(array('name'  => 'id_contrato', 'type'=>'hidden', 'id' => 'id_contrato','value'=>@$processo->id_contrato)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Número da pasta</label>
                <div class="col-sm-5">
                    <?php echo form_input(array('name' => 'num_pasta','class' => 'form-control' ,  'id' => 'num_pasta'), set_value('num_pasta', @$processo->num_pasta )); ?>
                    <?php echo form_error('num_pasta'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_error('novoclientenome'); ?>
    <?php echo form_error('novoclienteemail'); ?>
    <?php echo form_error('novoclientetelefone'); ?>
    <?php echo form_error('novovara'); ?>
    <?php echo form_error('novoclientenomeadversa'); ?>
    <?php echo form_error('novocpfadversa'); ?>
    <?php echo form_error('novoclienteemailadversa'); ?>
    <?php echo form_error('novoclientetelefoneadversa'); ?>
    <?php echo form_error('novoclienteadvadversa'); ?>
    <button class="btn btn-success" type="submit">Gravar</button>
</div>

    <div class="col-md-6">
        <div id="accordion1" class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="collapsed" href="#collapseOne1" data-parent="#accordion1" data-toggle="collapse">
                            <i class="fa fa-plus-square-o"></i>
                            Adicionar Novo Cliente
                        </a>
                    </h4>
                </div>
            </div>
            <div id="collapseOne1" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tipo de pessoa</label>
                        <div class="col-sm-9">
                            <div class="radio-inline">
                                <?php echo form_radio(array('name'=> 'novo_cliente_jur', 'value' => 'FISICA', 'id' => 'tipo_pessoaf', 'checked'=>'checked' )); ?> <span>Pessoa Física</span>
                            </div>
                            <div class="radio-inline">
                                <?php echo form_radio(array('name'=> 'novo_cliente_jur', 'value' => 'JURIDICA', 'id' => 'tipo_pessoaj' )); ?><span>Pessoa Jurídica</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nome do cliente</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novoclientenome','placeholder' => 'Nome do novo cliente','class' => 'form-control new' ), set_value('novoclientenome', @$processo->novoclientenome )); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email do cliente</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novoclienteemail','placeholder' => 'Email do novo cliente','class' => 'form-control new'), set_value('novoclienteemail', @$processo->novoclienteemail )); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Telefone do cliente</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novoclientetelefone','placeholder' => 'Telefone do novo cliente','class' => 'form-control new', 'id'=>'telefone' ), set_value('novoclientetelefone', @$processo->novoclientetelefone )); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div id="accordion2" class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="collapsed" href="#collapseOne2" data-parent="#accordion2" data-toggle="collapse">
                            <i class="fa fa-plus-square-o"></i>
                            Adicionar Nova Vara e Fórum
                        </a>
                    </h4>
                </div>
                <div id="collapseOne2" class="panel-collapse collapse" style="height: 0px;">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nome da nova vara</label>
                            <div class="col-sm-9">
                                <?php echo form_input(array('name' => 'novovara', 'maxlength' => '250','id' => 'novovara','placeholder' => 'Nome da nova vara ou fórum','class' => 'form-control' ), set_value('novovara', @$processo->novovara )); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div id="accordion3" class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="collapsed" href="#collapseOne3" data-parent="#accordion3" data-toggle="collapse">
                            <i class="fa fa-plus-square-o"></i>
                            Adicionar Nova Parte Adversa
                        </a>
                    </h4>
                </div>
            </div>
            <div id="collapseOne3" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nome / Razão Social: </label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novoclientenomeadversa', 'maxlength' => '150','placeholder' => 'Nome da nova parte adversa','class' => 'form-control newadversa' ), set_value('novoclientenomeadversa', @$processo->novoclientenomeadversa )); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">CPF / CNPJ</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novocpfadversa', 'maxlength' => '150','placeholder' => 'CPF ou CNPJ da nova parte adversa','class' => 'form-control newadversa'), set_value('novocpfadversa', @$processo->novocpfadversa )); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">E-mail</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novoclienteemailadversa', 'maxlength' => '150','placeholder' => 'Email da nova parte adversa','class' => 'form-control newadversa' ), set_value('novoclienteemailadversa', @$processo->novoclienteemailadversa )); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Telefone do cliente</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novoclientetelefoneadversa', 'maxlength' => '50','placeholder' => 'Telefone da nova parte adversa','class' => 'form-control newadversa', 'id'=>'telefoneContato' ), set_value('novoclientetelefoneadversa', @$processo->novoclientetelefoneadversa )); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nome do advogado: </label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'novoclienteadvadversa', 'maxlength' => '150','placeholder' => 'Nome do advogado da nova parte adversa','class' => 'form-control newadversa' ), set_value('novoclienteadvadversa', @$processo->novoclienteadvadversa )); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo form_hidden('id', @$id ); ?>

<?php echo form_close(); ?>