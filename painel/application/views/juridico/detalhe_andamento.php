<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-heade">
    <h2>Andamento do processo número <ins><?php echo($andamentos->num_processo); ?></ins></h2>
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

            </ul>
            <div class="tab-content profile-page">
                <!-- PROFILE TAB CONTENT -->
                <div class="tab-pane profile active" id="profile-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="user-info-right">
                                <div class="basic-info">
                                    <h3><i class="fa fa-square"></i> Detalhes do Andamento</h3>
                                    <p class="data-row">
                                        <span class="data-name">Processo Número</span>
                                        <span class="data-value"><a href="<?php echo base_url('juridico/visualizar_processo/' . $andamentos->id_processo ); ?>"><?php echo($andamentos->num_processo); ?></a></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Cliente</span>
                                            <span class="data-value">
                                                <a href="<?php echo base_url('cliente/detalhe/' . $andamentos->id_parte ); ?>"><?php echo $andamentos->nome; ?></a>
                                            </span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Status</span>
							            <span class="data-value"><?php echo($andamentos->status); ?>
							            </span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Petição</span>
                                        <span class="data-value"><?php echo($andamentos->peticao); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Criado em</span>
                                        <span class="data-value"><?php echo(parseDate($andamentos->data,'date3')); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Publicado em</span>
                                        <span class="data-value"><?php echo(parseDate($andamentos->publicacao,'date3')); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Prazo (dias corridos)</span>
                                        <span class="data-value"><?php echo(tracoVazio($andamentos->prazo)); ?></span>
                                    </p>
                                    <p class="data-row">
                                        <span class="data-name">Descrição</span>
                                        <span class="data-value"><?php echo($andamentos->descricao); ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">



                            <div class="widget">
                                <div class="widget-header">
                                    <h3> O que deseja fazer com seu andamento agora ?</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo base_url('juridico/delete_andamento/' . $andamentos->id . '/' . $andamentos->id_processo ); ?>" onclick="return ask_delete();" class="btn btn-danger btn-block">
                                                <i class="fa fa-trash fa-2"></i> Excluir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget">
                                <div class="widget-header">
                                    <h3> Anexos</h3>
                                </div>
                                <div class="widget-content">
                                    <?php if(!empty($aditivos)) { foreach( $aditivos as $key => $aditivo ) { ?>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <p class="more">
                                                    <a class="btn btn-primary btn-block" target="_blank" href="../../recursos/imagens/upload_juridico/<?php echo($aditivo->anexo);?>">
                                                        <i class="fa fa-download fa"></i>
                                                        <?php echo ($aditivo->anexo); ?>
                                                        <?php // echo ($key + 1); ?>
                                                    </a>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="more">
                                                    <a href="<?php echo base_url('juridico/delete_andamento_anexo/' . $aditivo->id ); ?>" onclick="return ask_delete();" class="btn btn-danger btn-block btn-sm">
                                                        <i class="fa fa-trash"></i> Excluir Anexo
                                                    </a></p>
                                            </div>
                                        </div>
                                    <?php }} else { echo 'Sem anexos'; }?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END PROFILE TAB CONTENT -->

                <!-- END ACTIVITY TAB CONTENT -->

            </div>
        </div>
    </div>
</div>
<!-- /content-wrapper -->
