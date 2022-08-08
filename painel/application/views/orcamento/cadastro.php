<!-- main -->
<div class="content">
    <div class="main-header">
    </div>
    <h3>Proposta para <ins><?php echo($nome);?></ins></h3>
    <BR>
    <div class="main-content">
        <!-- WIDGET WIZARD -->
        <?php echo form_open( '/orcamento/processa_orcamento', array('class' => 'form-horizontal label-left', 'role' => 'form') ); //'target' => '_blank',?>
        <div class="widget">
            <div class="widget-header">
                <h3>Escolha abaixo o modelo da proposta</h3>
            </div>
            <div class="widget-content">
                <?php if(!empty($servicos)) { foreach( $servicos as $servico ) { ?>
                    <div class="simple-checkbox">
                        <input id="radio" name="servicos" type="radio" value="<?php echo($servico->id);?>">
                        <label for="radio"><?php echo($servico->titulo);?></label>
                        <a href="#" data-target="#modal<?php echo($servico->id);?>"  data-toggle="modal" class="btn btn-link btn-sm" style="margin-bottom: 3px; clear: both">Visualizar</a>
                    </div>
                <?php } } else { ?>
                    <div>
                        <div class="alert alert-warning">Você não possui nenhum modelo pré cadastrado. É <strong>recomendável</strong>
                            definir os seus serviços antes de começar. <a href="<?php echo base_url('configuracao/cadastro_servico'); ?>">Clique aqui</a> para criar serviços.
                        </div>
                    </div>
                <?php  } ?>
                <?php echo form_error('descricao'); ?>
            </div>
        </div>
        <?php echo form_hidden('id_pessoa', set_value('id_pessoa',@$id_pessoa)); ?>
        <?php echo form_hidden('id_orcamento', set_value('id_orcamento',@$orcamento->id_orcamento)); ?>
        <input type="submit" name="botao_gravar" class="btn btn-success" id="grava" style="margin: 0 auto;" value="Gravar Proposta" >
        <?php echo form_close(); ?>
    </div>
</div>
<!--MODAL -->
<?php if(!empty($servicos)) foreach( $servicos as $servico ) { ?>
    <div class="modal fade" id="modal<?php echo($servico->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo($servico->titulo);?> </h4>
                </div>
                <div class="modal-body">
                    <p><b>Custo:</b> R$ <?php echo($servico->valor_total);?></p>
                    <p><b>Validade em dias corridos:</b> <?php echo($servico->validade);?> dias</p>
                    <p><b>Prazo de execução:</b> <?php echo($servico->prazo);?></p>
                    <?php if(!empty($servico->observacao)) { ?>
                        <p><b>Observação:</b> <?php echo($servico->observacao);?></p>
                    <?php } ?>
                    <?php if(!empty($servico->condicoes_pagamento)) { ?>
                        <p><b>Condições de Pagamento:</b> <?php echo($servico->condicoes_pagamento);?></p>
                    <?php } ?>
                    <?php if(!empty($servico->condicoes_gerais)) { ?>
                        <p><b>Condições Gerais:</b> <?php echo($servico->condicoes_gerais);?></p>
                    <?php } ?>
                    <BR>
                    <p><b>Descrição:</b></p>
                    <p><?php echo($servico->descricao);?></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-custom-primary" data-dismiss="modal" value="Fechar" />
                </div>
            </div>
        </div>
    </div>
<?php } ?>