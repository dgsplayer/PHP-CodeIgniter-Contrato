<?php echo $this->load->helper('date'); ?>

<div class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="main-content">
                <?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
                    <div class="alert alert-success bg-success text-center">
                        <?php echo $mensagem; ?>
                    </div>
                <?php } ?>
                <!-- NAV TABS -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="user-info-right">
                                    <div class="basic-info">
                                        <h4><i class="fa fa-square"></i> Chamado código <ins><?php echo($dados->id_chamado); ?></ins></h4>
                                        <p class="data-row">
                                            <span class="data-name">Título:</span>
                                            <span class="data-value"><?php echo($dados->titulo); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Tipo:</span>
                                            <span class="data-value"><?php echo($dados->tipo); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Prioridade:</span>
                                            <span class="data-value"><?php echo($dados->prioridade); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Motivo:</span>
                                            <span class="data-value"><?php echo(@$motivos[$dados->id_sla]); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Área responsável:</span>
                                            <span class="data-value"><?php echo(@$areas[$dados->id_area]); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Responsável:</span>
                                            <span class="data-value"><?php echo(@$admin[$dados->id_responsavel]); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Status atual:</span>
                                            <span class="data-value"><?php echo(@$status[$dados->id_status]); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="user-info-right">
                                    <div class="basic-info">
                                        <h4>&nbsp;</h4>
                                        <p class="data-row">
                                            <span class="data-name">Data de criação:</span>
                                            <span class="data-value"><?php echo(parseDate($dados->data_abertura,'date3')); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Data de previsão:</span>
                                            <span class="data-value"><?php echo(parseDate($dados->data_previsao_conclusao,'date3')); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Data de conclusão:</span>
                                            <span class="data-value"><?php echo(str_replace('//','-',parseDate($dados->data_conclusao,'date3'))); ?></span>
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Percentual de conclusão:</span>
                                            <span class="data-value"><?php echo($dados->percentual); ?> %</span>
<!--                                            <span><a class="btn btn-sm btn-warning"  data-toggle="modal" data-target="#valor" type="button">Alterar</a>:</span>-->
                                        </p>
                                        <p class="data-row">
                                            <span class="data-name">Criado por:</span>
                                            <span class="data-value"><?php echo(@$admin[$dados->id_usuario]); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <BR>
                        <div class="row">
                            <div class="col-md-12">
                                <h4><i class="fa fa-square"></i> Ocorrências</h4>
                                <table class="table table-sorting table-striped table-hover datatable2" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Responsável / Área</th>
                                        <th>Externa</th>
                                        <th>Criado por</th>
                                        <th>%</th>
                                        <th>Ocorrência</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($rows)) foreach( $rows as $row ) { ?>
                                        <tr>
                                            <td>
                                                <?php if(!empty($row->anexo)) { ?>
                                                    <a target="_blank" href='../../recursos/chamados/<?php echo($row->id_chamado);?>/<?php echo($row->anexo);?>' title='ver anexo desta ocorencia' class="add_button"> <img src="<?php echo (base_url(). '/recursos/assets/grocery_crud/themes/flexigrid/css/images/clip.png'); ?>"></a>
                                                <?php } ?>
                                                <?php echo  parseDate($row->data,'date3'); ?>
                                            </td>
                                            <td><?php echo  @$admin[$row->id_responsavel]; ?> / <?php echo  @$areas[$row->id_area]; ?></td>
                                            <td><?php echo  $row->ocorrencia_externa; ?></td>
                                            <td><?php echo  @$admin[$row->id_usuario]; ?></td>
                                            <td><?php echo  tracoVazio(@$row->percentual); ?></td>
                                            <td>
                                                <?php echo (!empty($row->id_chamado_externo)) ?
                                                    '<a href="' . base_url("chamados/detalhe/" . $row->id_chamado_externo) . '">(Chamado externo ' . $row->id_chamado_externo . ')</a><BR>' . @$row->ocorrencia :
                                                    tracoVazio(@$row->ocorrencia) ; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <BR>
                        <div class="row">
                            <div class="col-md-12">
                                <h4><i class="fa fa-square"></i> Descrição</h4>
                                <span class="data-value"><?php echo($dados->descricao); ?></span>
                            </div>
                        </div>

                        <!--                            <BR>-->
                        <!--                            <div class="row">-->
                        <!--                                <div class="col-md-12">-->
                        <!--                                    <h4><i class="fa fa-square"></i> Comentários</h4>-->
                        <!--                                    <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">-->
                        <!--                                        <thead>-->
                        <!--                                        <tr>-->
                        <!--                                            <th>Data</th>-->
                        <!--                                            <th>De</th>-->
                        <!--                                            <th>Para</th>-->
                        <!--                                            <th>Comentário</th>-->
                        <!--                                        </tr>-->
                        <!--                                        </thead>-->
                        <!--                                        <tbody>-->
                        <!--                                        --><?php //if(!empty($rowsComments)) foreach( $rowsComments as $row ) { ?>
                        <!--                                            --><?php //if(!empty($row->descricao)){?>
                        <!--                                                <tr>-->
                        <!--                                                    <td>--><?php //echo  parseDate($row->data,'date3'); ?><!--</td>-->
                        <!--                                                    <td>--><?php //echo  @$admin[$row->id_usuario] ; ?><!--</td>-->
                        <!--                                                    <td>--><?php //echo  @$admin[$row->id_responsavel] . ' - ' . @$areas[$dados->id_area]; ?><!--</td>-->
                        <!--                                                    <td>--><?php //echo  tracoVazio($row->descricao); ?><!--</td>-->
                        <!--                                                </tr>-->
                        <!--                                            --><?php //} ?>
                        <!--                                        --><?php //} ?>
                        <!--                                        </tbody>-->
                        <!--                                    </table>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="widget">
<!--                                <div class="widget-header">-->
<!--                                    <h3>Ações</h3>-->
<!--                                </div>-->
<!--                                <div class="widget-content"><a  data-toggle="modal" data-target="#valor2" class="btn btn-info btn-block"><i class="fa fa-plus fa"></i> Adicionar ocorrência</a>-->
<!--                                    <a  data-toggle="modal" data-target="#valor2" class="btn btn-warning btn-block"><i class="fa fa-edit fa"></i> Alterar chamado</a>-->
<!--                                    <a href="#" class="btn btn-success btn-block" onclick="return confirm('Deseja realmente concluir?')"><i class="fa fa-check fa"></i> Concluir</a>-->
<!--                                </div>-->
<!--                                <hr shade style="margin-top: -0px !important;margin-bottom: -0px !important;">-->
<!--                                <div class="widget-content">-->
<!--                                    <a href="#" class="btn btn-primary btn-block"><i class="fa fa-envelope fa"></i> Enviar por e-mail</a>-->
<!--                                    <a href="#" class="btn btn-danger btn-block"><i class="fa fa-list fa"></i> Relatório</a>-->
<!--                                </div>-->
<!--                                <hr shade style="margin-top: -0px !important;margin-bottom: -10px !important;">-->
                                <div class="widget-content">
                                    <div class="widget-header">
                                        <h3>Anexos</h3>
                                    </div>
                                    <a class="btn btn-link btn-block" target="_blank" href="http://www.controlwork.com.br/home/recursos/upload_chamados/">
                                        <i class="fa fa-download fa"></i>
                                        Clique aqui

                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!--MODAL ALTERA PORCENTAGEM-->
<?php echo form_open( 'chamados/altera_porcentagem', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="valor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Alterar porcentagem deste chamado</h4>
            </div>
            <div class="modal-body" >
                <p>
                    Insira o novo valor (%):
                    <?php echo form_input(array('name' => 'percentual', 'autocomplete'=> 'off', 'required' => 'required',  'class' => 'form-control' , 'maxlength' => '3', 'placeholder' => 'Insira aqui o novo valor'), set_value('percentual',$dados->percentual )); ?>
                    <BR>
                    Observação:
                    <?php echo form_textarea(array('name' => 'ocorrencia','class' => 'form-control' , ), set_value('ocorrencia')); ?>
                </p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" data-dismiss="" value="Ok"  />
            </div>
            <input name="id_chamado"   type="hidden" value="<?php echo($dados->id_chamado); ?>">
            <input name="id_area"   type="hidden" value="<?php echo($dados->id_area); ?>">
            <input name="id_responsavel"   type="hidden" value="<?php echo($dados->id_responsavel); ?>">
        </div>
    </div>
</div>
<?php echo form_close()?>

<?php echo form_open_multipart( 'chamados/adiciona_ocorrencia', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="valor2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Adicionar ocorrência</h4>
            </div>
            <div class="modal-body" >
                <label >
                    <input type="radio" value="Não" name="ocorrencia_externa" id="check_externa_nao" checked="checked">Direcionar
                </label>&nbsp;&nbsp;
                <label>
                    <input type="radio" value="Sim" name="ocorrencia_externa" id="check_externa_sim">Ocorrência Externa
                </label>
                <BR><BR>
                <div id="externa_sim" style="display:none;">
                    <div class="form-group">
                        <label for="area1" class="col-sm-2 control-label">Chamado externo</label>
                        <div class="col-sm-10">
                            <?php echo form_dropdown('id_chamado_externo', $chamados, set_value('id_chamado_externo') , 'class="multiselect form-control"'); ?>
                        </div>
                    </div>
                    <?php echo form_hidden('id_area', @$dados->id_area ); ?>
                    <?php echo form_hidden('id_responsavel', @$dados->id_responsavel ); ?>
                    <?php echo form_hidden('id_status', @$dados->id_status ); ?>

                </div>
                <div id="externa_nao">
                    <div class="form-group">
                        <label for="area2" class="col-sm-2 control-label">Enviar para</label>
                        <div class="col-sm-10">
                            <?php echo form_dropdown('id_area', $areas, set_value('id_area') , 'class="multiselect form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="res3" class="col-sm-2 control-label">Responsável</label>
                        <div class="col-sm-10">
                            <?php echo form_dropdown('id_responsavel', $admin, set_value('id_responsavel') , 'class="multiselect form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="res4" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <?php echo form_dropdown('id_status', $status, set_value('id_status') , 'class="multiselect form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="res5" class="col-sm-2 control-label">Data</label>
                    <div class="col-sm-10">
                        <?php echo form_input(array('name' => 'data', 'autocomplete'=> 'off', 'type' => 'date' ,'maxlength' => '10','required' => 'required',  'class' => 'form-control' , 'placeholder' => 'Data'), set_value('data',$date )); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="res6" class="col-sm-2 control-label">Anexo</label>
                    <div class="col-sm-10">
                        <input type="file" name="file">
                    </div>
                </div>
                <div class="form-group">
                    <label for="res7" class="col-sm-2 control-label">Ocorrência</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea(array('name' => 'ocorrencia','class' => 'form-control', 'rows' => '5' ), set_value('ocorrencia')); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" data-dismiss="" value="Ok"  />
            </div>
            <input name="id_chamado"        type="hidden" value="<?php echo($dados->id_chamado); ?>">
            <input name="percentual"        type="hidden" value="<?php echo($dados->percentual); ?>">
        </div>
    </div>
</div>
<?php echo form_close()?>

<script>

    $(document).ready(function(){


        if($('#check_externa_sim').is(':checked')) {
            $('#externa_nao').hide();
            $('#externa_sim').show();
        }else{
            $('#externa_sim').hide();
            $('#externa_nao').show();
        }


        $('#check_externa_sim').click(function(){
            $('#externa_nao').hide();
            $('#externa_sim').show();
        });
        $('#check_externa_nao').click(function(){
            $('#externa_sim').hide();
            $('#externa_nao').show();
        });

    });
</script>

<!---->
<!--<style>-->
<!--     .modal {-->
<!--        width: 100% !important;-->
<!--        /*margin-left: 280px;*/-->
<!--    }-->
<!--    .modal-dialog {-->
<!--        width: 70% !important;-->
<!--        /*margin-left: 280px;*/-->
<!--    }-->
<!--    .main-content{-->
<!--        padding-bottom: 0px;-->
<!--    }-->
<!--</style>-->
<script type="text/javascript" src="<?php echo base_url('recursos/js/datatable/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/js/datatable/jquery.dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/js/king-table.js'); ?>"></script>
<script>

    $(document).ready(function(){


        if( $('.datatable2').length > 0 ) {

            $('.datatable2').dataTable({
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
//                "bPaginate": false,
                "sPaginationType": "bootstrap",
                "aaSorting": [[ 0, "desc" ]],
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