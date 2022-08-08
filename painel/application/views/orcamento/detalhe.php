<div class="content">

    <div class="row">
        <div class="main-header">
            <div class="col-md-5">
                <h2>Proposta Número <?php echo($orcamentos->id_orcamento);?></h2>
            </div>
            <div class="col-md-7">
                <div class="top-content">
                    <ul class="list-inline quick-access">
                        <li>
                            <a href="<?php echo base_url('orcamento/preCadastro'); ?>">
                                <div class="quick-access-item bg-color-blue">
                                    <i class="fa fa-clipboard"></i>
                                    <h5>Cadastrar Proposta</h5>
                                    <em>Criar uma nova</em>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="widget widget-table">
        <div class="widget-header">
            <h3><i class="fa fa-table"></i>Detalhe da Proposta</h3>
        </div>
        <div class="widget-content">
            <?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
                <div class="alert alert-success bg-success text-center">
                    <?php echo $mensagem; ?>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="user-info-right">
                        <div class="basic-info">
                            <p class="data-row">
                                <span class="data-name">Cliente</span>
                            <span class="data-value">
                                <?php echo($orcamentos->nome_cliente); ?>
                            </span>
                            </p>
                            <p class="data-row">
                                <span class="data-name">Status</span>
							<span class="data-value"><?php echo($orcamentos->status); ?>
							</span>
                            </p>
                            <p class="data-row">
                                <span class="data-name">Criado por</span>
                                <span class="data-value"><?php echo($usuario->usuario); ?></span>
                            </p>
                            <p class="data-row">
                                <span class="data-name">Valor Total</span>
                                <span class="data-value">R$ <?php echo($orcamentos->valor_total); ?></span>
                                <span><a class="btn btn-sm btn-info"  data-toggle="modal" data-target="#valor<?php echo($orcamentos->id_orcamento);?>" type="button">Alterar</a></span>
                            </p>
                            <p class="data-row">
                                <span class="data-name">Criado em</span>
                                <span class="data-value"><?php echo(parseDate($orcamentos->dt_cad,'date3')); ?></span>
                            </p>
                            <!--                                <p class="data-row">-->
                            <!--                                    <span class="data-name">E-mail enviado em</span>-->
                            <!--                                    <span class="data-value">--><?php //echo(parseDate($orcamentos->dt_email,'both')); ?><!--</span>-->
                            <!--                                </p>-->
                            <!--                                <p class="data-row">-->
                            <!--                                    <span class="data-name">E-mail enviado para</span>-->
                            <!--                                    <span class="data-value">--><?php //echo($orcamentos->email_envio); ?><!--</span>-->
                            <!--                                </p>-->
                            <p class="data-row">
                                <span class="data-name">Validade</span>
                                <span class="data-value"><?php echo($orcamentos->validade); ?> dias corridos</span>
                            </p>
                            <p class="data-row">
                                <span class="data-name">Prazo</span>
                                <span class="data-value"><?php echo (empty($orcamentos->prazo)) ? 'Indeterminado' : $orcamentos->prazo . ' dias corridos';  ?></span>
                            </p>
                            <p class="data-row">
                                <span class="data-name">Condições de Pagamento</span>
                                <span class="data-value"><?php echo(tracoVazio($orcamentos->condicoes_pagamento)); ?></span>
                                <span><a class="btn btn-sm btn-info"  data-toggle="modal" data-target="#pagamento<?php echo($orcamentos->id_orcamento);?>" type="button">Alterar</a></span>
                            </p>
                            <BR>
                            <p class="data-row">
                                <span class="data-name">Condições Gerais</span>
                                <span class="data-value"><?php echo(tracoVazio($orcamentos->condicoes_gerais)); ?></span>
                            </p>
                            <BR>
                            <p class="data-row">
                                <span class="data-name">Observação</span>
                                <span class="data-value"><?php echo(tracoVazio($orcamentos->observacao)); ?></span>
                                <span><a class="btn btn-sm btn-info"  data-toggle="modal" data-target="#obs<?php echo($orcamentos->id_orcamento);?>" type="button">Alterar</a></span>
                            </p>
                            <BR>
                            <p class="data-row">
                                <span class="data-name">Serviços</span><BR>
                                <span class="data-value"> <?php echo($orcamentos->descricao); ?></span>
                                    <span><a class="btn btn-sm btn-info"  data-toggle="modal" data-target="#servico<?php echo($orcamentos->id_orcamento);?>" type="button">Alterar</a></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="user-info-left">
                        <div class="contact">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('orcamento/delete/' . $orcamentos->id_orcamento ); ?>" onclick="return ask_delete();" class="btn btn-danger btn-block">
                                        <i class="fa fa-trash fa-2"></i> Excluir
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('../contract_key/orcamento/download/' . base64_encode($orcamentos->id_orcamento) . '/' . md5(date('d')) . '/' . md5(date('Y')) ); ?>" class="btn btn-primary btn-block" target="_blank">
                                        <i class="fa fa-download fa-2"></i> Visualizar
                                    </a>
                                </div>
                            </div><BR>
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#orcamento<?php echo($orcamentos->id_orcamento);?>">
                                        <i class="fa fa-paper-plane fa-2"></i> Enviar Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <BR>
                        <div class="widget widget-table">
                            <div class="widget-header">
                                <h3><i class="fa fa-envelope-o"></i>Controle de e-mails enviados</h3>
                            </div>
                            <div class="widget-content">
                                <table id="visit-stat-table" class="table table-sorting table-striped table-hover datatable3" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>E-mail</th>
                                        <th>Data do envio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($emails)) { foreach( $emails as $linha ) { ?>
                                        <tr>
                                            <td><?php echo  $linha->id; ?></td>
                                            <td><?php echo  $linha->email; ?></td>
                                            <td><?php echo  parseDate($linha->data,'both'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                        <td colspan="15">Sem e-mails enviados</td>
                                    <?php }  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE TAB CONTENT -->
        <!-- ACTIVITY TAB CONTENT -->
    </div>
</div>

<!-- /content-wrapper -->

<!--MODAL EMAIL-->
<?php echo form_open( 'email/enviar_orcamento', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="orcamento<?php echo($orcamentos->id_orcamento);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">O que deseja fazer:</h4>
            </div>
            <div class="modal-body">
                <p>
                    Enviar para os e-mails abaixo (clique no botão para adicionar mais):

                <div>
                    <input type="hidden" name="count" value="1">
                    <div class="input-appendable-wrapper">
                        <input type="hidden" id="count" value="1">
                        <div class="input-group input-group-appendable" id="input-group-appendable1">
                            <?php echo form_input(array('name' => 'email[]','class' => 'form-control' , 'maxlength' => '150', 'placeholder' => 'Insira aqui o email de destino', 'id' => 'field1', 'autocomplete'=> 'off'), set_value('email',$email_pessoa )); ?>
                            <span class="input-group-btn">
																	<button id="btn1" class="btn btn-primary add-more" type="button">+</button>
																</span>
                        </div>
                    </div>
                </div><BR>
                <p>
                    Assunto do e-mail:
                    <?php echo form_input(array('name' => 'assunto','class' => 'form-control' , 'maxlength' => '100', 'placeholder' => 'Insira aqui o assunto do email'), set_value('assunto')); ?>
                </p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" data-dismiss="" value="Ok" />
            </div>
            <input name="id_orcamento"   type="hidden" value="<?php echo($orcamentos->id_orcamento); ?>">

        </div>
    </div>
</div>
<?php echo form_close()?>

<!--MODAL ALTERA VALOR-->
<?php echo form_open( 'orcamento/altera_valor', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="valor<?php echo($orcamentos->id_orcamento);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Alterar valor desta proposta</h4>
            </div>
            <div class="modal-body">
                <p>
                    Insira novo valor abaixo:
                    <?php echo form_input(array('name' => 'valor_total','class' => 'form-control' , 'placeholder' => 'Insira aqui o novo valor'), set_value('valor_total',$orcamentos->valor_total )); ?>
                </p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" data-dismiss="" value="Ok" />
            </div>
            <input name="id_orcamento"   type="hidden" value="<?php echo($orcamentos->id_orcamento); ?>">
        </div>
    </div>
</div>
<?php echo form_close()?>


<!--MODAL ALTERA VALOR-->
<?php echo form_open( 'orcamento/altera_condicoes_pagamento', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="pagamento<?php echo($orcamentos->id_orcamento);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Alterar condições de pagamento desta proposta</h4>
            </div>
            <div class="modal-body">
                <p>
                    Condição de pagamento:
                    <?php echo form_input(array('name' => 'condicoes_pagamento','class' => 'form-control' ), set_value('condicoes_pagamento',  @$orcamentos->condicoes_pagamento  )); ?>
                </p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" data-dismiss="" value="Ok" />
            </div>
            <input name="id_orcamento"   type="hidden" value="<?php echo($orcamentos->id_orcamento); ?>">
        </div>
    </div>
</div>
<?php echo form_close()?>


<?php echo form_open( 'orcamento/altera_observacao', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="obs<?php echo($orcamentos->id_orcamento);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Alterar a observação desta proposta</h4>
            </div>
            <div class="modal-body">
                <p>
                    Observação:
                    <textarea class="form-control" name="observacao" rows="6" id="observacao" placeholder=""><?php echo set_value('observacao', @$orcamentos->observacao); ?></textarea>

                </p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" data-dismiss="" value="Ok" />
            </div>
            <input name="id_orcamento"   type="hidden" value="<?php echo($orcamentos->id_orcamento); ?>">
        </div>
    </div>
</div>
<?php echo form_close()?>

<?php echo form_open( 'orcamento/altera_servico', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
<div class="modal fade" id="servico<?php echo($orcamentos->id_orcamento);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Alterar os serviços desta proposta</h4>
            </div>
            <div class="modal-body">
                <p>
                    Serviços:
                    <textarea class="form-control" name="descricao" rows="6" id="servico" placeholder=""><?php echo set_value('descricao', @$orcamentos->descricao); ?></textarea>

                </p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" data-dismiss="" value="Ok" />
            </div>
            <input name="id_orcamento"   type="hidden" value="<?php echo($orcamentos->id_orcamento); ?>">
        </div>
    </div>
</div>
<?php echo form_close()?>

<script>
    function ask_delete(){
        var r = confirm("Deseja realmente excluir este registro?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }

    //*******************************************
    /*	input append
     /********************************************/

    $(document).ready(function(){


        $( "form.input-append" ).keypress(function(e) {
            if ( e.which == 13 ) {
                e.preventDefault();
            }
        });

        $('.input-group-appendable .add-more').click(function(){
            $wrapper = $(this).parents('.input-appendable-wrapper');
            $lastItem = $wrapper.find('.input-group-appendable').last();

            $newInput = $lastItem.clone(true);

            // change attribute for new item
            $count = $wrapper.find('#count').val();
            $count++;

            // change text input and the button
            $newInput.attr('id', 'input-group-appendable' + $count);
            $newInput.find('input[type="text"]').attr({
                id: "field" + $count,
//                name: "field" + $count
                name: "email[]"
            });

            $newInput.find('.btn').attr('id', 'btn' + $count);
            $newInput.appendTo($wrapper);

            //change the previous button to remove
            $lastItem.find('.btn')
                .removeClass('add-more btn-primary')
                .addClass('btn-danger')
                .text('-')
                .off()
                .on('click', function(){
                    $(this).parents('.input-group-appendable').remove();
                });

            $wrapper.find('#count').val($count);

        });

    });
</script>
