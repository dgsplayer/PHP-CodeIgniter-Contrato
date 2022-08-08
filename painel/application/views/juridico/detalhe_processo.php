<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-heade">
    <h2>Processo número <ins><?php echo($processo->num_processo); ?></ins></h2>
</div>
<BR>
<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
    <div class="alert alert-success bg-success text-center">
        <?php echo $mensagem; ?>
    </div>
<?php } ?>
<script>
    function ask_delete_processo(){
        var r = confirm("ESTE PROCESSO SERÁ EXCLUÍDO PERMANENTEMENTE, DESEJA CONTINUAR?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
<div class="widgt">

    <div class="widget-content">
        <div class="main-content">
            <!-- NAV TABS -->
            <div class="tab-content profile-page">
                <!-- PROFILE TAB CONTENT -->
                <div class="tab-pane profile active" id="profile-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="user-info-right">
                                <div class="basic-info">
                                    <h3><i class="fa fa-square"></i> Detalhes do Processo</h3>
                                    <p class="data-row">
                                        <span class="data-name">Processo Número</span>
                                        <span class="data-value"><?php echo($processo->num_processo); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Cliente</span>
                                            <span class="data-value">
                                                <a href="<?php echo base_url('cliente/detalhe/' . $processo->id_parte ); ?>"><?php echo $processo->cliente; ?></a>
                                            </span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Vara / fórum</span>
                                        <span class="data-value"><?php echo($processo->forum); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Parte Adversa</span>
                                        <span class="data-value"><?php echo($processo->parte_adversa); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Criado em</span>
                                        <span class="data-value"><?php echo(parseDate($processo->data_cad,'date3')); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Contrato Vinculado</span>
                                        <span class="data-value">
                                          <? if(!empty($processo->id_contrato)){?>  <a href="<?php echo base_url('contrato/visualizar/' . $processo->id_contrato ); ?>"><?php echo($processo->id_contrato); ?></a> <? }else { ?> - <? } ?>
                                        </span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Processo Vinculado</span>
                                        <span class="data-value">
                                          <? if(!empty($processo->id_processo_vinculado)){?>  <a href="<?php echo base_url('juridico/visualizar_processo/' . $processo->id_processo_vinculado ); ?>"><?php echo($processo->num_processo_vinculado); ?></a> <? }else { ?> - <? } ?>
                                        </span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">N° da Pasta</span>
                                        <span class="data-value"><?php echo($processo->num_pasta); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Status do Processo</span>
							            <span class="data-value"><?php echo(converteStatus($processo->status)); ?>
							            </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="widget">
                                <div class="widget-header">
                                    <h3> O que deseja fazer com seu processo agora ?</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo base_url('juridico/delete/' . $processo->id ); ?>" onclick="return ask_delete_processo();" class="btn btn-danger btn-block">
                                                <i class="fa fa-trash fa-2"></i> Excluir
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="<?php echo base_url('juridico/processo/' . $processo->id ); ?>" class="btn btn-info btn-block">
                                                <i class="fa fa-pencil-square-o fa-2"></i> Editar
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="<?php echo base_url('juridico/andamento/0/' . $processo->id ); ?>" class="btn btn-primary btn-block">
                                                Criar Andamento
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div><BR>

                    <div class="widget widget-table">
                        <div class="widget-header">
                            <h3><i class="fa fa-table"></i>Lista de Andamentos</h3>
                        </div>
                        <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                            <tr>
<!--                                <th>Número</th>-->
                                <th>Responsável</th>
                                <th>Descrição</th>
                                <th>Situação</th>
                                <th>Publicado em</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($andamentos) && count($andamentos)) { ?>
                                <?php foreach( $andamentos as $andamento ) { ?>
                                    <tr>
<!--                                        <td><a href="--><?php //echo base_url('juridico/visualizar_andamento/' . $andamento->id ); ?><!--">--><?php //echo $andamento->id; ?><!--</a></td>-->
                                        <td><?php echo (!empty($andamento->responsavel)) ? $andamento->responsavel : $andamento->email ; ?></td>
                                        <td><?php echo $andamento->descricao; ?></td>
                                        <td><?php echo $andamento->status; ?></td>
                                        <td><?php echo parseDate($andamento->publicacao,'date3'); ?></td>
                                        <td>
                                            <a href="<?php echo base_url('juridico/visualizar_andamento/' . $andamento->id ); ?>" class="btn btn-custom-secondary btn-sm"><i class="fa fa-binoculars"></i> Visualizar</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center"> Sem andamentos cadastrados.</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(@$html_mov) { ?>
                    <div class="widget widget-table">
                        <div class="widget-header">
                            <h3><i class="fa fa-table"></i>Movimentação</h3>
                        </div>
                        <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Movimento</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach( $html_mov->getElementById('tabelaTodasMovimentacoes')->find('tr') as $el ) { ?>
                                <tr>
                                    <td><?php echo $el->find('td',0)->text(); ?></td>
                                    <td><?php echo $el->find('td',2)->text(); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content-wrapper -->
