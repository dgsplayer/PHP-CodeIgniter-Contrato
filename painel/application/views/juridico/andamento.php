<script type="text/javascript">
    $(document).ready(function() {
        $( "#processo" ).autocomplete({
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

        $( "#processo" ).on( "autocompleteselect", function( e, ui ) {
            $("#id_processo").val(ui.item.id);
        });

        //LIMPA OUTROS CAMPOS
        $( "#nova_peticao" ).blur( function(  ) {
            if($('#nova_peticao').val() != ''){
                $( "#peticao").val('');
                $( "#peticao").prop('disabled',true);
                $( "#id_peticao").val('');
            }else{
                $("#nova_peticao").prop('disabled', false);
            }
        });

        //LIMPA OUTROS CAMPOS
        $( "#nova_situacao" ).blur( function(  ) {
            if($('#nova_situacao').val() != ''){
                $( "#situacao").val('');
                $( "#situacao").prop('disabled',true);
                $( "#status").val('');
            }else{
                $("#situacao").prop('disabled', false);
            }
        });
    });
</script>
<div class="main-header">
    <h2>Andamento</h2>
    <em>Informações do andamento</em>
</div>
<?php if($mensagem = $this->session->flashdata("error")) { 	?>
    <div class="alert alert-danger bg-success text-center">
        <?php echo $mensagem; ?>
    </div>
<?php } ?>

<?php echo form_open_multipart( 'juridico/processa_andamento', array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>
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
                        <?php echo form_input(array('name' => 'processo','class' => 'form-control', 'placeholder' => 'Digite as primeiras letras do processo cadastrado', 'id' => 'processo'), set_value('processo', @$num_processo ),'autofocus'); ?>
                        <?php echo form_error('processo'); ?>
                        <?php echo form_input(array('name'  => 'id_processo', 'type'=>'hidden', 'id' => 'id_processo','value'=>@$id_processo)); ?> <!-- única maneira de funcionar hidden para autocomplete, caso contrário da erro após uso do validation_error_style-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Andamento do processo</label>
                    <div class="col-sm-9">
                        <?php echo form_textarea(array('name' => 'descricao','class' => 'form-control', 'placeholder' => 'Descrição do andamento do processo','cols' => 50 , 'rows' => 6 ,  'id' => 'description'), set_value('descricao', @$andamento->descricao )); ?>
                        <?php echo form_error('descricao'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tipo de petição</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('peticao', $peticoes , set_value('peticao', @$andamento->peticao ) , 'id="peticao" class="form-control"'); ?>
                        <?php echo form_error('peticao'); ?>
                        <?php echo form_input(array('name'  => 'id_peticao', 'type'=>'hidden', 'id' => 'id_peticao','value'=>@$this->input->post('id_peticao'))); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Situação</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('situacao', $situacaoes , set_value('situacao', @$andamento->situacao ) , 'id="situacao" class="form-control"'); ?>
                        <?php echo form_error('situacao'); ?>
                        <?php echo form_input(array('name'  => 'status', 'type'=>'hidden', 'id' => 'status','value'=>@$this->input->post('status'))); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">E-mail do responsável</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('id_usuario_responsavel', $email_responsaveis , set_value('id_usuario_responsavel', @$andamento->id_usuario_responsavel ) , 'class="form-control"'); ?>
                        <?php echo form_error('id_usuario_responsavel'); ?>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Lembrete (Opcional)</label>
                    <div class="col-sm-9">
                        <?php echo form_input(array('name' => 'agendamento_texto','class' => 'form-control',  'placeholder'=>'Digite aqui o texto do lembrete', 'id' => 'agendamento_texto'), set_value('agendamento_texto', @$andamento->agendamento_texto )); ?>
                        <?php echo form_error('agendamento_texto'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Data do lembrete (Opcional)</label>
                    <div class="col-sm-4">
                        <?php echo form_input(array('name' => 'agendamento','class' => 'form-control datepicker','autocomplete' => 'off', 'id' => 'agendamento', 'placeholder'=>'Insira data'), set_value('agendamento', @$andamento->agendamento )); ?>
                        <?php echo form_error('agendamento'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Prazo para resposta</label>
                    <div class="col-sm-6">
                        <?php echo form_dropdown('prazo', $prazos , set_value('prazo', @$andamento->prazo ) , 'class="form-control"'); ?>
                        <?php echo form_error('prazo'); ?>
                    </div>
                </div>
                <div class="form-group"> 
                    <label class="col-sm-3 control-label">Data da publicação</label>
                    <div class="col-sm-4">
                        <?php echo form_input(array('name' => 'publicacao','class' => 'form-control datepicker','autocomplete' => 'off', 'id' => 'publicacao', 'placeholder'=>'Insira data'), set_value('publicacao', @$andamento->publicacao )); ?>
                        <?php echo form_error('publicacao'); ?>
                    </div>
                </div>
                <div class="alert alert-info bg-success">
                    <div class="small">
                        <p class="text-center"><strong>ENVIO DE ARQUIVOS</strong></p>
                        <p><strong>Atenção - Leia as instruções abaixo antes do envio de arquivos:</strong></p>
                        <p>- Somente serão aceitos arquivos no formato PDF, DOC ou DOCX.</p>
                        <p>- Cada arquivo pode ter tamanho máximo de 10MB.</p>
                        <p>- Ao clicar no botão "Gravar" no final aguarde o término do processamento de envio dos documentos.</p>
                    </div><BR>
                    <div class="form-group">
<!--                        <label class="col-sm-3 control-label"></label>-->
                        <div class="col-sm-9">
                            <?php echo form_upload(array('name' => 'anexo[]',  'id' => 'anexo', 'multiple'=>'multiple')); ?>
                            <?php echo form_error('anexo'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo form_hidden('id', @$andamento->id ); ?>

        <?php echo form_error('nova_peticao'); ?>
        <?php echo form_error('nova_situacao'); ?>
        <button class="btn btn-success" type="submit"> Gravar</button>
    </div>
    <?php if(empty($andamento->id)) { ?>
        <div class="col-md-6">
            <div id="accordion2" class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed" href="#collapseOne2" data-parent="#accordion2" data-toggle="collapse">
                                <i class="fa fa-plus-square-o"></i>
                                Adicionar Novo Tipo de Petição
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne2" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nome da petição</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('name' => 'nova_peticao','id' => 'nova_peticao','placeholder' => 'Nome da nova petição','class' => 'form-control' ), set_value('nova_peticao', @$andamento->nova_peticao )); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="accordion1" class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed" href="#collapseOne1" data-parent="#accordion1" data-toggle="collapse">
                                <i class="fa fa-plus-square-o"></i>
                                Adicionar Nova Situação
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne1" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nome da situação</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('name' => 'nova_situacao','id' => 'nova_situacao','placeholder' => 'Nome da nova situação','class' => 'form-control' ), set_value('nova_situacao', @$andamento->nova_situacao )); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php echo form_close(); ?>