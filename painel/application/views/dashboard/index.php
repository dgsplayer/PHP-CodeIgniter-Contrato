<!-- main -->
<div class="content">
    <div class="main-header">
        <h2>Área de Trabalho</h2>
<!--        <em>Informações Prioritárias</em>-->
    </div>
    <div class="main-content">
        <BR>
        <div class="col-md-4">
                        <a href="<?php echo base_url('administrador/page_meus_dados' ); ?>" class="btn btn-info" > SUPORTE</a>
                    </div>

        <?php if($user['tipo_usuario'] == 5){  ?>
        <h2 style="color: #1F3DB3"><strong>Olá <?php echo $user['nome_empresa']; ?>, o que você deseja fazer?</strong></h2>
        <BR><BR>
        <div class="col-md-6">
            <div class="row">
                

                <?php if( $this->acl->verifica_permissao('cliente')) { ?>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('cliente/cadastro/' ); ?>" class="btn btn-success" ><i class="fa fa-plus"></i> Adicionar novo cliente</a>
                    </div>
                <?php } ?>
                <?php if( $this->acl->verifica_permissao('orcamento')) { ?>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('orcamento/cadastro'); ?>" class="btn btn-success" ><i class="fa fa-plus"></i> Criar nova proposta</a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('orcamento/' ); ?>" class="btn btn-success" ><i class="fa fa-list"></i> Ver lista de propostas</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

        <!--        --><?php //if($mensagem = $this->session->flashdata("sucesso")) { 	?>
        <!--            <div class="alert alert-success bg-success text-center">-->
        <!--                --><?php //echo $mensagem; ?>
        <!--            </div>-->
        <!--        --><?php //} ?>
        <!---->
        <!---->
        <!--        --><?php //if($mensagem = $this->session->flashdata("error")) {  ?>
        <!--            <div class="alert alert-error bg-danger text-center">-->
        <!--                --><?php //echo $mensagem; ?>
        <!--            </div>-->
        <!--        --><?php //} ?>
        <div class="row">

            <?php if(!empty($agendas)) { ?>
                <legend>Compromissos de Hoje</legend>
                <?php  foreach( $agendas as $agenda ) { ?>

                    <div class="col-md-3">
                        <div class="widget widget-hide-header widget-reminder">
                            <div class="widget-header hide">
                                <h3>Today's Reminder</h3>
                            </div>
                            <div class="widget-content">
                                <div class="today-reminder">
                                    <h4 class="reminder-title">Lembrete</h4>
                                    <p class="reminder-time"><i class="fa fa-clock-o"></i> Hoje</p>
                                    <p class="reminder-place" style="font-size: 14px"><?php echo($agenda->title); ?></p>
                                    <em class="reminder-notes">Mais detalhes no menu agenda</em>
                                    <i class="fa fa-bell"></i>
                                    <div class="btn-group btn-group-xs">
                                        <div class="btn-group  btn-group-xs">
                                            <a href="<?php echo base_url('agenda/updateLido/' . $agenda->id ); ?>" class="btn btn-warning dropdown-toggle" data-toggle="">Ok Concluído
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php } } ?>

            <?php if(!empty($agendasTomorrow)) { ?>
                <legend><h3>Compromissos de Amanhã</h3></legend>
                <? foreach( $agendasTomorrow as $agendaTomorrow ) { ?>

                    <div class="col-md-3">
                        <div class="widget widget-hide-header widget-reminder">
                            <div class="widget-header hide">
                                <h3>Today's Reminder</h3>
                            </div>
                            <div class="widget-content">
                                <div class="today-reminder">
                                    <h4 class="reminder-title">Lembrete</h4>
                                    <p class="reminder-time"><i class="fa fa-clock-o"></i> Amanhã</p>
                                    <p class="reminder-place" style="font-size: 14px"><?php echo($agendaTomorrow->title); ?></p>
                                    <!--                                    <em class="reminder-notes">Mais detalhes no menu agenda</em>-->
                                    <i class="fa fa-bell"></i>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php } } ?>
        </div>
        <BR>
        <div class="row">
            <?php if(!empty($avisos)) { ?>
                <legend>Pendências</legend>
                <? foreach( $avisos as $aviso ) { ?>
                    <div class="alert alert-warning alert-dismissable">
                        <a href="<?php echo base_url('dashboard/updateLido/' . $aviso->id ); ?>" class="closeMsg">Não mostrar novamente</a>
                        <strong><?php echo($aviso->titulo); ?></strong>&nbsp;<?php echo($aviso->nome); ?>
                    </div>
                <?php } } ?>
        </div>
        <!-- /main-content -->
    </div>
</div>
<!-- /main -->
<style>
    .closeMsg {
        color: inherit;
        position: relative;
        right: -21px;
        top: -2px;
    }
    .closeMsg {
        color: #000;
        float: right;
        font-size: 14px;
        font-weight: 700;
        line-height: 1;
        opacity: 0.5;
        text-shadow: 0 1px 0 #fff;
    }
</style>