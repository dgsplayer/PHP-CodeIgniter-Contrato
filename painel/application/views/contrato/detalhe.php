<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-heade">
    <h2>Contrato número <ins><?php echo($contratos->cod_contrato); ?></ins></h2>
</div>
<BR>
<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
    <div class="alert alert-success bg-success text-center">
        <?php echo $mensagem; ?>
    </div>
<?php } ?>

<div class="widgt">

<div class="widget-content">
<div class="main-content">
<!-- NAV TABS -->
<ul class="nav nav-tabs">
    <li class="<?php echo (empty($verTodas)) ? 'active' : ''; ?>"><a href="#profile-tab" data-toggle="tab"><i class="fa fa-user"></i> Detalhes</a></li>
    <li class="<?php echo (empty($verTodas)) ? '' : 'active'; ?>"><a href="#parcelas-tab" data-toggle="tab"><i class="fa fa-credit-card"></i> Parcelas</a></li>

</ul>
<div class="tab-content profile-page">
<!-- PROFILE TAB CONTENT -->
<div class="tab-pane profile active" id="profile-tab">
<div class="row">
    <div class="col-md-6">
        <div class="user-info-right">
            <div class="basic-info">
                <h3><i class="fa fa-square"></i> Detalhes do Contrato</h3>
                <p class="data-row">
                    <span class="data-name">Número do Contrato</span>
                    <span class="data-value"><?php echo($contratos->cod_contrato); ?></span>
                </p>
                <p class="data-row">
                    <span class="data-name">Parte Principal</span>
                            <span class="data-value">
                                <a href="<?php echo base_url('cliente/index/read/' . @$contratos->id_pessoa_principal ); ?>"><?php echo(@$cliente[$contratos->id_pessoa_principal]); ?></a>

                            </span>
                </p>
                <?php if($contratos->id_pessoa_secundario > 0){ ?>
                    <p class="data-row">
                        <span class="data-name">Parte Secundária</span>
                            <span class="data-value">
                                <a href="<?php echo base_url('cliente/index/read/' . @$contratos->id_pessoa_secundario ); ?>"><?php echo(@$cliente[$contratos->id_pessoa_secundario]); ?></a>
                            </span>
                    </p>
                <?php } ?>
                <p class="data-row">
                    <span class="data-name">Status</span>
							<span class="data-value"><?php echo($contratos->status); ?>
							</span>
                </p>
                <p class="data-row">
                    <span class="data-name">Período de Vigência</span>
                    <span class="data-value"><?php echo($contratos->data_inicio_contrato != '0000-00-00') ? parseDate($contratos->data_inicio_contrato,'date3') : ''; ?> até <?php echo($contratos->dt_expiracao != '0000-00-00') ? parseDate($contratos->dt_expiracao,'date3') : 'Indeterminado'; ?></span>
                </p>

                <p class="data-row">
                    <span class="data-name">Criado por</span>
                    <span class="data-value"><?php echo($admin[$contratos->id_usuario_criador]); ?></span>
                </p>
                <?php if($contratos->check_rubrica == 't'){ ?>
                <p class="data-row">
                    <span class="data-name">Obs.</span>
                    <span class="data-value">Contrato Rubricado</span>
                </p>
                <?php } ?>
            </div>
            <div class="contact_info">
                <h3><i class="fa fa-square"></i> Detalhes do Pagamento</h3>
                <p class="data-row">
                    <span class="data-name">Valor <?php echo($contratos->mensalidade == 't') ? 'Mensal' : 'Total'; ?></span>
                    <span class="data-value">R$ <?php echo($contratos->valor_total); ?></span>
                </p>
                <p class="data-row">
                    <span class="data-name">Entrada</span>
                    <span class="data-value">R$ <?php echo(tracoVazio($contratos->entrada)); ?></span>
                </p>
                <p class="data-row">
                    <span class="data-name">Multa</span>
                    <span class="data-value"><?php echo($contratos->multa); ?> %</span>
                </p>
                <p class="data-row">
                    <span class="data-name">Qtde de Parcelas</span>
                    <span class="data-value"><?php echo(tracoVazio($contratos->qtd_parcelas)); ?></span>
                </p>
                <p class="data-row">
                    <span class="data-name">Forma de Pagamento</span>
                    <span class="data-value"><?php echo(tracoVazio($contratos->forma)); ?> <?php echo($contratos->descricao_forma_pagamento); ?></span>
                </p>
            </div>
            <div class="about">
                <h3><i class="fa fa-square"></i> Detalhes do Serviço</h3>
                <?php echo($contratos->descricao); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget">
            <div class="widget-header">
                <h3> Documentos disponíveis</h3>
            </div>
            <div class="widget-content">


                <?php if(empty($contratos->upload_assinatura)) { ?>

                    <div class="alert alert-danger alert-dismissable">
                        <strong>Aviso!</strong>&nbsp;Seu cliente ainda não assinou este contrato.
                        <a href="#" class=""  data-toggle="modal" data-target="#myModal">Clique aqui</a> para enviar via email agora.
                    </div>

                <?php } ?>

                <?php if(empty($contratos->upload_rubrica) && $contratos->check_rubrica == 't') { ?>

                    <div class="alert alert-danger alert-dismissable">
                        <strong>Aviso!</strong>&nbsp;Seu cliente ainda não rúbricou este contrato.
                        <a href="#" class=""  data-toggle="modal" data-target="#myModal">Clique aqui</a> para enviar via email agora.
                    </div>

                <?php } ?>

                <?php if(empty($adminRes->imagem_assinatura)) { ?>

                    <div class="alert alert-danger alert-dismissable">
                        <strong>Aviso!</strong>&nbsp;Sua empresa ainda não possui assinatura.
                        <a href="<?php echo base_url('administrador/assinatura'); ?>">Clique aqui</a> para registrar uma agora.
                    </div>

                <?php } ?>

                <?php if(empty($adminRes->imagem_rubrica) && $contratos->check_rubrica == 't') { ?>

                    <div class="alert alert-danger alert-dismissable">
                        <strong>Aviso!</strong>&nbsp;Sua empresa ainda não possui uma rúbrica.
                        <a href="<?php echo base_url('administrador/rubrica'); ?>">Clique aqui</a> para registrar uma agora.
                    </div>

                <?php } ?>

                <div class="row">
                    <div class="col-md-5">
                        <p class="more"><a class="btn btn-primary btn-block" target="_blank" href="<?php echo prep_url('www.contratonet.com.br/contract_key/download/download_contrato/' . base64_encode($contratos->id_contrato)); ?>">
                                <i class="fa fa-download fa"></i>
                                Visualizar Contrato
                            </a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <?php if($contratos->status == 'Distrato'){ ?>
                            <p class="more"> <a class="btn btn-primary btn-block" target="_blank" href="<?php echo prep_url('www.contratonet.com.br/contract_key/download/download_distrato/' . base64_encode($contratos->id_contrato)); ?>">
                                    <i class="fa fa-download fa"></i>
                                    Visualizar Distrato
                                </a></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <?php if($contratos->status == 'Rescindido'){ ?>
                            <p class="more"> <a class="btn btn-primary btn-block" target="_blank" href="<?php echo prep_url('www.contratonet.com.br/contract_key/download/download_rescisao/' . base64_encode($contratos->id_contrato)); ?>">
                                    <i class="fa fa-download fa"></i>
                                    Visualizar Rescisão
                                </a></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <?php if(!empty($aditivos)) foreach( $aditivos as $aditivo ) { ?>
                            <p class="more"> <a class="btn btn-primary btn-block" target="_blank" href="<?php echo prep_url('www.contratonet.com.br/contract_key/download/download_aditivo/' . base64_encode($contratos->id_contrato) . '/' . base64_encode($aditivo->id_adicional)); ?>">
                                    <i class="fa fa-download fa"></i>
                                    Visualizar Aditivo Item <?php echo($aditivo->valueAditivo); ?>
                                </a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>



        <div class="widget">
            <div class="widget-header">
                <h3> O que deseja fazer com seu contrato agora ?</h3>
            </div>
            <div class="widget-content">
                <?php if($contratos->status == 'Em Vigencia'){ ?>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo base_url('contrato/distrato/' . $contratos->id_contrato ); ?>" class="btn btn-warning btn-block" onclick="return ask_confirm();"><i class="fa fa-warning"></i> Distrato</a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?php echo base_url('contrato/rescindir/' . $contratos->id_contrato); ?>" class="btn btn-warning btn-block" onclick="return ask_confirm();"><i class="fa fa-warning"></i> Rescindir</a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?php echo base_url('contrato/finalizar/' . $contratos->id_contrato ); ?>" class="btn btn-warning btn-block" onclick="return ask_confirm();"><i class="fa fa-warning"></i> Finalizar</a>
                        </div>
                    </div>
                    <BR>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo base_url('contrato/cadastro_aditivo/' . $contratos->id_contrato ); ?>" class="btn btn-success btn-block"><i class="fa fa-plus-square"></i> Criar um aditivo</a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-success btn-block"  data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope"></i> Enviar por e-mail</a>
                        </div>
                        <div class="col-md-4">
                            <a id="assinando" href="http://contratonet.com.br/contract_key/passaporte/assina_documento_externo/<?php echo (base64_encode($contratos->id_pessoa_principal)); ?>/<?php echo (base64_encode($contratos->id_contrato)); ?>/<?php echo base64_encode('Contrato'); ?>/0/0/<?php echo date('d-m-Y'); ?>00" class="btn btn-success btn-block"><i class="fa fa-check-square-o"></i> Assinatura do Cliente</a>
                        </div>
                    </div>
                    <BR>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo base_url('contrato/delete/' . $contratos->id_contrato ); ?>" class="btn btn-danger btn-block" onclick="return ask_delete();"><i class="fa fa-trash-o"></i> Excluir</a>
                        </div>
                    </div>
                    <?php if( bigger_than_one_year(parseDate($contratos->data_inicio_contrato, 'date2mysql')) == 1 && $contratos->mensalidade == 't' && $contratos->status == 'Em Vigencia') { ?>
                        <BR>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="#" class="btn btn-info btn-block"  data-toggle="modal" data-target="#myModalRenovar"><i class="fa fa-refresh fa-spin"></i> Renovar</a>
                            </div>
                        </div>
                    <?php } ?>

                <?php } else{ ?>
                    <div class="alert alert-success">
                        Este contrato já esta encerrado.
                    </div>
                    <BR>
                    <div class="row">
                        <div class="col-md-5">
                            <a href="#" class="btn btn-success btn-block"  data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope"></i> Enviar documentos por e-mail</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>
</div>
<!-- END PROFILE TAB CONTENT -->


<!-- END ACTIVITY TAB CONTENT -->
<div class="tab-pane activity" id="parcelas-tab">
    <div class="">
        <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <tr>
                <!--					<th>Tipo</th>-->
                <th>Parcela N°</th>
                <th>Vencimento</th>
                <th>Valor</th>
                <th>Data do Pagamento</th>
                <th>Ação</th>
                <th>Observação</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($parcelas)) { foreach( $parcelas as $parcela ) { ?>
                <tr>
                    <td><?php echo($parcela->num_parcela);?> </td>
                    <td><?php echo(parseDate($parcela->data_parcela,'date3'));?></td>
                    <td><?php echo('R$ '.$parcela->valor_parcela);?> </td>
                    <td>
                        <?php echo(parseDate($parcela->data_pagamento,'date3') == '//' && $parcela->pago == 1) ? parseDate($parcela->data_parcela,'date3') : tracoVazio(parseDate($parcela->data_pagamento,'date3')) ; ?>

                    </td>
                    <td>
                        <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#boleto<?php echo($parcela->id);?>" <?php if($parcela->pago == 1) echo 'disabled="disabled"';?> type="button">
                            Boleto
                        </button>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#notificacao<?php echo($parcela->id);?>" <?php if(($parcela->pago == 1) || ( $parcela->pago == 0 && bigger_than_today($parcela->data_parcela) == 0) ) echo 'disabled="disabled"';?> type="button">
                            Notificação
                        </button>
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#recibo<?php echo($parcela->id);?>" <?php if($parcela->pago == 0) echo 'disabled="disabled"';?> type="button">
                            Recibo
                        </button>
                <?php if( $this->acl->verifica_permissao('financeiro')) { ?>
                        <a href="<?php echo base_url('financeiro/cadastro_receber/'. $parcela->id ); ?>" class="btn btn-info btn-sm">
                            <i class="fa fa-pencil-square-o fa-2"></i> Editar
                        </a>
                        <?php } ?>

                    </td>
                    <td style="width: 40%">
                        <?php echo form_open( 'contrato/processa_cheque/' . $contratos->id_contrato.'/'.$parcela->id, array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
                        <div class="input-group">

                            <input type="text" placeholder="Cheque, Agência Bancária, etc..." maxlength="200" class="form-control" value="<?php echo $parcela->num_cheque; ?>" name="cheque" />

                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">OK</button>
                        </span>
                        </div>
                        <?php echo form_close()?>
                    </td>
                </tr>
            <?php } } else { ?>
                <tr><td>Sem Parcelas</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
</div>
<!-- /content-wrapper -->

<!--MODAL RENOVAÇÃO-->
<?php if( bigger_than_one_year(parseDate($contratos->data_inicio_contrato, 'date2mysql')) == 1 && $contratos->mensalidade == 't' && $contratos->status == 'Em Vigencia') { ?>
    <div class="modal fade" id="myModalRenovar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo form_open( 'contrato/processa_reajuste/'.$contratos->id_contrato, array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Ajuste de valor </h4>
                </div>
                <div class="modal-body">
                    <BR>
                    <p><b>Valor de Reajuste?</b></p>
                    <?php echo form_input(array('name' => 'valor_total','class' => 'form-control' , 'placeholder' => 'Insira aqui o novo valor', 'id' => 'valor_total'), set_value('valor_total')); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
                    <button type="submit" class="btn btn-custom-primary"><i class="fa fa-check-circle"></i> Enviar</button>
                </div>
            </div>
            <input name="id_contrato"           type="hidden" value="<?php echo($contratos->id_contrato); ?>">
            <input name="id_pessoa_principal"   type="hidden" value="<?php echo($contratos->id_pessoa_principal); ?>">
            <input name="diadomes"              type="hidden" value="<?php echo($parcela_maxima->data_parcela); ?>">
            <input name="num_parcela"           type="hidden" value="<?php echo($parcela_maxima->num_parcela); ?>">
            <input name="mensalidade"           type="hidden" value="Valor Mensal">
        </div>
        <?php echo form_close()?>
    </div>
<?php } ?>

<!--    MODAL EMAIL DOCUMENTO-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open( 'email/enviar_documento_visualizar', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Envio de documentos via e-mail</h4>
            </div>
            <div class="modal-body">
                <p><b>Qual documento você deseja enviar?</b></p> <!-- SEMPRE QUE ADD UM NOVO ITEM AQUI DEVE SER ADICIONADO TB EM CONTRACT_KEY/CONTROLLER/PASSAPORTE/VER_DOCUMENTO_EXTERNO -->
                <p class="more">
                    <input name="checkDocumento" type="radio" checked="checked" value="Contrato"> Contrato
                </p>
                <?php if($contratos->status == 'Distrato'){ ?>
                    <p class="more">
                        <input  name="checkDocumento" type="radio" value="Distrato"> Distrato
                    </p>
                <?php } ?>
                <?php if($contratos->status == 'Rescindido'){ ?>
                    <p class="more">
                        <input name="checkDocumento" type="radio" value="Rescisão"> Rescisão
                    </p>
                <?php } ?>
                <?php if(!empty($aditivos)) foreach( $aditivos as $aditivo ) { ?>
                    <p class="more">
                        <input name="checkDocumento" type="radio" value="Aditivo"> Aditivo Item <?php echo($aditivo->valueAditivo); ?>
                        <input name="id_complementar" type="hidden" value="<?php echo($aditivo->valueAditivo); ?>">
                    </p>
                <?php } ?>

                <BR>
                <p><b>Para qual e-mail você deseja enviar?</b></p>
                <?php echo form_input(array('name' => 'email','class' => 'form-control' , 'placeholder' => 'Insira aqui o email de destino', 'id' => 'email_dialog'), set_value('email',$clienteEmail )); ?>

                <div class="simple-checkbox">
                    <input id="checkbox2" type="checkbox" name="checkboxDoc"  value="check_assinatura_digital">
                    <label for="checkbox2">Incluir Assinatura Digital</label>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
                <button type="submit" class="btn btn-custom-primary"><i class="fa fa-check-circle"></i> Enviar</button>
            </div>
        </div>
        <input name="id_contrato" type="hidden" value="<?php echo($contratos->id_contrato); ?>">
    </div>
    <?php echo form_close()?>
</div>

<!--MODAL NOTIFICAÇÃO-->
<?php if(!empty($parcelas)) foreach( $parcelas as $parcela ) { ?>
    <?php echo form_open( 'email/enviar_documento_visualizar', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
    <div class="modal fade" id="notificacao<?php echo($parcela->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">O que deseja fazer:</h4>
                </div>
                <div class="modal-body">

                    <p><input type="radio" name="opcao_notificacao_<?php echo($parcela->id) ?>" value="visualizar" checked>&nbsp;&nbsp;Visualizar</p>
                    <p><input type="radio" name="opcao_notificacao_<?php echo($parcela->id) ?>" value="email">
                        ou enviar para o e-mail abaixo:
                        <?php echo form_input(array('name' => 'email','class' => 'form-control' , 'placeholder' => 'Insira aqui o email de destino', 'id' => 'email_dialog'), set_value('email',$clienteEmail )); ?>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-custom-primary" data-dismiss="" value="Ok" />
                </div>
                <input name="id_complementar"   type="hidden" value="<?php echo($parcela->id); ?>">
                <input name="id_contrato"       type="hidden" value="<?php echo($contratos->id_contrato); ?>">
                <input name="checkDocumento"    type="hidden" value="Notificação">
                <!--Para controle do post em email/enviar_documento_visualizar  -> Não é possivel utilizar checkDocumento por causa dos acentos -->
                <input name="checkPost"         type="hidden" value="notificacao">
            </div>
        </div>
    </div>
    <?php echo form_close()?>
<?php } ?>


<!--MODAL RECIBO-->
<?php if(!empty($parcelas)) foreach( $parcelas as $parcela ) { ?>
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
                        <?php echo form_input(array('name' => 'email','class' => 'form-control' , 'placeholder' => 'Insira aqui o email de destino', 'id' => 'email_dialog'), set_value('email',$clienteEmail )); ?>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-custom-primary" data-dismiss="" value="Ok" />
                    <input name="id_complementar"   type="hidden" value="<?php echo($parcela->id); ?>">
                    <input name="id_contrato"       type="hidden" value="<?php echo($contratos->id_contrato); ?>">
                    <input name="checkDocumento"    type="hidden" value="Recibo">
                    <!--Para controle do post em email/enviar_documento_visualizar  -> Não é possivel utilizar checkDocumento por causa dos acentos -->
                    <input name="checkPost"         type="hidden" value="recibo">
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close()?>
<?php } ?>


<!--MODAL BOLETO-->
<?php if(!empty($parcelas)) foreach( $parcelas as $parcela ) { ?>
    <?php echo form_open( 'email/enviar_boleto', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
    <div class="modal fade" id="boleto<?php echo($parcela->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php if(!empty($bancos)) { ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">O que deseja fazer:</h4>
                    </div>
                    <div class="modal-body">
                        <p><input type="radio" name="opcao_boleto_<?php echo($parcela->id) ?>" value="visualizar" checked>&nbsp;&nbsp;Visualizar</p>
                        <p><input type="radio" name="opcao_boleto_<?php echo($parcela->id) ?>" value="email">
                            ou enviar para o e-mail abaixo:
                            <?php echo form_input(array('name' => 'email','class' => 'form-control' , 'placeholder' => 'Insira aqui o email de destino', 'id' => 'email_dialog'), set_value('email',$clienteEmail )); ?>
                        </p>
                        <BR>
                        <p><b>Escolha o banco abaixo:</b></p>
                        <?php foreach( $bancos as $key => $banco ) { ?>
                            <label style="display: inline;">
                                &nbsp;&nbsp;<input <?php if($key == 0) echo "checked='checked'"; ?> type="radio" name="bancoEscolhido<?php echo($parcela->id) ?>" class="myCheckboxDialog" value="<?php echo($banco->banco) ?>">&nbsp;<img src="<?php echo base_url('recursos/assets/img/' . retornaImagemBanco($banco->banco)); ?>" style="border: 0px;"></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php }  ?>
                        <BR>

                    </div>
                    <div class="modal-footer">

                        <input type="submit" class="btn btn-custom-primary" data-dismiss="" value="Ok" />
                    </div>
                    <input name="id_complementar"   type="hidden" value="<?php echo($parcela->id); ?>">
                    <input name="id_contrato"       type="hidden" value="<?php echo($contratos->id_contrato); ?>">
                    <input name="checkDocumento"    type="hidden" value="Boleto">
                <?php } else{  ?>
                    <BR>
                    <div class="alert alert-warning">
                        Você não tem bancos registrados. Por favor envie um email para tecnologia@contratonet.com.br com os dados bancários para registro.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-primary" data-dismiss="modal"><i class="fa fa-check-circle"></i> Ok</button>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
    <?php echo form_close()?>
<?php } ?>
<script>
    $(document).ready(function($) {
        $('#assinando').click(function(){
            var resp;
            resp = confirm("Para sua segurança você será desconectado do sistema. Deseja continuar?");
            if( resp == true ){
                return true;
            }else{
                return false;
            }
        });
    });
</script>