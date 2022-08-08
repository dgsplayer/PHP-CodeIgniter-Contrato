<?php echo $this->load->helper('funcoes'); ?>
<link href="<?php echo base_url('recursos/assets/css/owl.carousel.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('recursos/assets/css/owl.theme.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('recursos/assets/css/owl.transitions.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/owl.carousel.min.js'); ?>"></script>
<script type="text/javascript">

    $(document).ready(function(){

//        $('.subMenuText').click(function(){
//            $(this).find('span').css('font-weight','bold').css('font-size','12px');
//        });

        $("#owl-demo").owlCarousel({
            navigation : true, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem:true,
            autoPlay: 8000 //8 sec
        });

    });
</script>
<style>
    .subMenuText a:hover{
        background: #ffffff;
    }

    .subMenuText a:active{
        background: #ffffff;
    }

</style>

<!-- main-nav -->
<nav class="main-nav">
    <ul class="main-menu">
        <li class="menuText ">
            <a href="<?php echo base_url('dashboard'); ?>">
                <i class="fa fa-home fa-fw"></i>
                <span class="text">Área de Trabalho</span>
            </a>
        </li>

        <?php
        $user = $this->session->userdata('contrato_user');

        ?>
        <?php if( $this->acl->verifica_permissao('contrato')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa fa-legal fw"></i>
                    <span class="text">Contratos</span>
                    <i class="toggle-icon fa fa-angle-down"></i></a>
                <ul class="sub-menu">
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "contrato" && $this->uri->segment(2) === "cadastro") ? 'active' : ''; ?>">
                        <a href="#" data-toggle="modal" data-target="#dialog-confirm-contrato">
                            <span class="text">Novo Contrato</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "contrato" && $this->uri->segment(2) == "") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('contrato'); ?>">
                            <span class="text">Lista de Contratos</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "contrato" && $this->uri->segment(2) === "cadastro_servico") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/cadastro_servico'); ?>">
                            <span class="text">Novo Serviço</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "contrato" && $this->uri->segment(2) === "lista_servico") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/lista_servico'); ?>">
                            <span class="text">Lista de Serviços</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "contrato" && $this->uri->segment(2) === "index") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/index'); ?>">
                            <span class="text">Multa</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "contrato" && $this->uri->segment(2) === "cadastro_header") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/cadastro_header'); ?>">
                            <span class="text">Design do Contrato</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <li class="menuText active">
            <a href="#" class="js-sub-menu-toggle">
                <i class="fa fa-edit fw"></i>
                <span class="text">Chamados</span>
                <i class="toggle-icon fa fa-angle-down"></i></a>
            <ul class="sub-menu">
                <li class="menuText <?php echo (strpos($_SERVER['REQUEST_URI'], "chamados_crud/index/add")) ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('chamados_crud/index/add'); ?>" class="">
                        <span class="text">Adicionar</span>
                    </a>
                </li>
                <li class="menuText <?php echo ($this->uri->segment(1) === "chamados" && $this->uri->segment(2) == "") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('chamados'); ?>" class="">
                        <span class="text">Abertos</span>
                    </a>
                </li>
                <!--            <li class="menuText --><?php //echo ($this->uri->segment(1) === "chamados_concluidos") ? 'active' : ''; ?><!--">-->
                <!--                <a href="--><?php //echo base_url('chamados_concluidos'); ?><!--" class="">-->
                <!--                    <span class="text">Concluídos</span>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li class="menuText --><?php //echo ($this->uri->segment(1) === "chamados_anexos") ? 'active' : ''; ?><!--">-->
                <!--                <a href="--><?php //echo base_url('chamados_anexos'); ?><!--" class="">-->
                <!--                    <span class="text">Anexos</span>-->
                <!--                </a>-->
                <!--            </li>-->
                <?php //if($user['id_usuario'] != 99) { //fabio  ?>
                <!--            <li class="menuText --><?php //echo ($this->uri->segment(1) === "areas") ? 'active' : ''; ?><!--">-->
                <!--                <a href="--><?php //echo base_url('areas'); ?><!--" class="">-->
                <!--                    <span class="text">Áreas</span>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li class="menuText --><?php //echo ($this->uri->segment(1) === "areas_x_usuarios") ? 'active' : ''; ?><!--">-->
                <!--                <a href="--><?php //echo base_url('areas_x_usuarios'); ?><!--" class="">-->
                <!--                    <span class="text">Áreas dos usuários</span>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li class="menuText --><?php //echo ($this->uri->segment(1) === "sla") ? 'active' : ''; ?><!--">-->
                <!--                <a href="--><?php //echo base_url('sla'); ?><!--" class="">-->
                <!--                    <span class="text">SLA's</span>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            --><?php //} ?>
            </ul>

            <!--        <ul class="sub-menu">-->
            <!--    <li class="subMenuText --><?php //echo ($this->uri->segment(2) === "cadastro") ? 'active' : ''; ?><!--">-->
            <!--        <a href="--><?php //echo base_url('chamados/cadastro'); ?><!--" class="">-->
            <!---->
            <!--            <span class="text">Novo Chamado</span>-->
            <!--        </a>-->
            <!--    </li>-->
            <!--    <li class="subMenuText --><?php //echo ($this->uri->segment(1) === "chamados" && $this->uri->segment(2) == "") ? 'active' : ''; ?><!--">-->
            <!--        <a href="--><?php //echo base_url('chamados'); ?><!--" class="">-->
            <!---->
            <!--            <span class="text">Lista de Chamados</span>-->
            <!--        </a>-->
            <!--    </li>-->
            <!--        </ul>-->
        </li>


        <?php if( $this->acl->verifica_permissao('financeiro')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa fa-credit-card fw"></i>
                    <span class="text">Financeiro</span>
                    <i class="toggle-icon fa fa-angle-down"></i></a>
                <ul class="sub-menu">
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "financeiro" && $this->uri->segment(2) == "") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('financeiro'); ?>">
                            <span class="text">Extrato</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "financeiro" && $this->uri->segment(2) === "receber") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('financeiro/receber'); ?>">
                            <span class="text">Contas a Receber</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "financeiro" && $this->uri->segment(2) === "pagar") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('financeiro/pagar'); ?>">
                            <span class="text">Contas a Pagar</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "financeiro" && $this->uri->segment(2) === "fluxocaixa") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('financeiro/fluxocaixa'); ?>">
                            <span class="text">Fluxo de Caixa</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if( $this->acl->verifica_permissao('cliente')) { ?>
            <li class="menuText ">
                <a href="<?php echo base_url('cliente'); ?>">
                    <i class="fa fa-user fw"></i>
                    <span class="text">Clientes</span>
                </a>
                <!--    <ul class="sub-menu">-->
                <!--        <li class="subMenuText --><?php //echo ($this->uri->segment(1) === "cliente" && $this->uri->segment(2) === "cadastro") ? 'active' : ''; ?><!--" data-step="2"  data-intro="Primeiro passo é cadastrar seus clientes">-->
                <!--            <a href="--><?php //echo base_url('cliente/cadastro'); ?><!--">-->
                <!--                <span class="text">Novo Cliente</span>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="subMenuText --><?php //echo ($this->uri->segment(1) === "cliente" && $this->uri->segment(2) == "") ? 'active' : ''; ?><!--">-->
                <!--            <a href="--><?php //echo base_url('cliente'); ?><!--">-->
                <!--                <span class="text">Lista de Cliente</span>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--    </ul>-->
            </li>
        <?php } ?>

        <?php if( $this->acl->verifica_permissao('fornecedor')) { ?>
            <li class="menuText">
                <a href="<?php echo base_url('fornecedor'); ?>">
                    <i class="fa fa-exchange fw"></i>
                    <span class="text">Fornecedores</span>
                    </a>
<!--                <ul class="sub-menu">-->
<!--                    <li class="subMenuText --><?php //echo ($this->uri->segment(1) === "fornecedor" && $this->uri->segment(2) === "cadastro") ? 'active' : ''; ?><!--">-->
<!--                        <a href="--><?php //echo base_url('fornecedor/cadastro'); ?><!--">-->
<!--                            <span class="text">Novo Fornecedor</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="subMenuText --><?php //echo ($this->uri->segment(1) === "fornecedor" && $this->uri->segment(2) == "") ? 'active' : ''; ?><!--">-->
<!--                        <a href="--><?php //echo base_url('fornecedor'); ?><!--">-->
<!--                            <span class="text">Lista de Fornecedores</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
            </li>
        <?php } ?>
        <?php if( $this->acl->verifica_permissao('orcamento')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa fa-clipboard fa-fw"></i>
                    <span class="text">Propostas</span>
                    <i class="toggle-icon fa fa-angle-down"></i></a>
                <ul class="sub-menu">
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "orcamento" && $this->uri->segment(2) === "cadastro") ? 'active' : ''; ?>"  data-step="4"  data-intro="Este é o passo final. Depois de criados cliente e modelo da proposta você pode enfim criar uma proposta e envia-lá ao seu cliente.">
                        <a href="<?php echo base_url('orcamento/cadastro'); ?>">
                            <span class="text">Nova Proposta</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "orcamento" && $this->uri->segment(2) == "") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('orcamento'); ?>">
                            <span class="text">Lista de Proposta</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "orcamento" && $this->uri->segment(2) === "cadastro_servico") ? 'active' : ''; ?>"  data-step="3"  data-intro="Depois do cliente cadastrado insira um modelo para a sua proposta">
                        <a href="<?php echo base_url('orcamento/cadastro_servico'); ?>">
                            <span class="text">Novo Modelo</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "orcamento" && $this->uri->segment(2) === "lista_servico") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('orcamento/lista_servico'); ?>">
                            <span class="text">Lista de Modelo</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php /* if( $this->acl->verifica_permissao('proposta')) { ?>
<li class="menuText <?php echo ($this->uri->segment(1) === "proposta") ? 'active' : ''; ?>">
    <a href="#" class="js-sub-menu-toggle">
        <i class="fa fa-clipboard fa-fw"></i>
        <span class="text">Propostas</span>
        <i class="toggle-icon fa fa-angle-down"></i></a>
    <ul class="sub-menu" <?php echo ($this->uri->segment(1) === "proposta") ? 'style="display: block;"' : ''; ?> >
        <li class="subMenuText <?php echo ($this->uri->segment(1) === "proposta" && $this->uri->segment(2) === "cadastro") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('proposta/cadastro'); ?>">
                <span class="text">Cadastrar Proposta</span>
            </a>
        </li>
        <li class="subMenuText <?php echo ($this->uri->segment(1) === "proposta" && $this->uri->segment(2) == "") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('proposta'); ?>">
                <span class="text">Listar Proposta</span>
            </a>
        </li>
        <li class="subMenuText <?php echo ($this->uri->segment(1) === "proposta" && $this->uri->segment(2) === "cadastro_modelo") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('configuracao/cadastro_modelo'); ?>">
                <span class="text">Cadastrar Modelo</span>
            </a>
        </li>
        <li class="subMenuText <?php echo ($this->uri->segment(1) === "proposta" && $this->uri->segment(2) === "lista_modelo") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('configuracao/lista_modelo'); ?>">
                <span class="text">Listar Modelos</span>
            </a>
        </li>
    </ul>
</li>
    <?php } */?>





        <?php if( $this->acl->verifica_permissao('cobranca')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa  fa-bullhorn fw"></i>
                    <span class="text">Cobrança</span>
                    <i class="toggle-icon fa fa-angle-down"></i></a>
                <ul class="sub-menu">
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "cobranca" && $this->uri->segment(2) === "pagamento_receber") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('cobranca/pagamento_receber'); ?>">
                            <span class="text">Pagamentos a Receber</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "cobranca" && $this->uri->segment(2) === "pagamento_recebido") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('cobranca/pagamento_recebido'); ?>">
                            <span class="text">Pagamentos Recebidos</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "cobranca" && $this->uri->segment(2) === "pagamento_cancelado") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('cobranca/pagamento_cancelado'); ?>">
                            <span class="text">Pagamentos Cancelados</span>
                        </a>
                    </li>
                    <!--        <li class="subMenuText">-->
                    <!--            <a href="--><?php //echo base_url('cobranca/acordo_realizado'); ?><!--">-->
                    <!--                <span class="text">Acordos Realizados</span>-->
                    <!--            </a>-->
                    <!--        </li>-->
                </ul>
            </li>
        <?php } ?>
        <?php  if( $this->acl->verifica_permissao('juridico')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa fa-legal fa-fw"></i>
                    <span class="text">Jurídico</span>
                    <i class="toggle-icon fa fa-angle-down"></i></a>
                <ul class="sub-menu">
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "juridico" && $this->uri->segment(2) == "processo") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('juridico/processo'); ?>">
                            <span class="text">Novo Processo</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "juridico" && ($this->uri->segment(2) === "lista_processos" || $this->uri->segment(2) === "processa_busca"  || $this->uri->segment(2) === "visualizar_processo")) ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('juridico/lista_processos'); ?>">
                            <span class="text">Lista de Processos</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "juridico" && $this->uri->segment(2) === "busca") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('juridico/busca'); ?>">
                            <span class="text">Busca Avançada</span>
                        </a>
                    </li>
                    <!--        <li class="subMenuText --><?php //echo ($this->uri->segment(1) === "juridico" && $this->uri->segment(2) === "lista_andamento") ? 'active' : ''; ?><!--">-->
                    <!--            <a href="--><?php //echo base_url('juridico/lista_andamento'); ?><!--">-->
                    <!--                <span class="text">Lista de Andamento</span>-->
                    <!--            </a>-->
                    <!--        </li>-->
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "juridico" && $this->uri->segment(2) === "peticoes") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('juridico/peticoes'); ?>">
                            <span class="text">Banco de Petições</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "juridico" && $this->uri->segment(2) === "configuracao") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('juridico/configuracao'); ?>">
                            <span class="text">Cadastros Gerais</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php }  ?>
        <?php if( $this->acl->verifica_permissao('administrador')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa fa-key fw"></i>
                    <span class="text">Administrador</span>
                    <i class="toggle-icon fa fa-angle-down"></i></a>
                <ul class="sub-menu">

                    <?php if( $this->acl->verifica_permissao('contrato')) { ?>
                        <li class="subMenuText <?php echo ($this->uri->segment(1) === "administrador" && $this->uri->segment(2) === "assinatura") ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('administrador/assinatura') ; ?>">
                                <span class="text">Assinatura</span>
                                <span class="badge element-bg-color-blue">Novo</span>
                            </a>
                        </li>
                        <li class="subMenuText <?php echo ($this->uri->segment(1) === "administrador" && $this->uri->segment(2) === "rubrica") ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('administrador/rubrica'); ?>">
                                <span class="text">Rúbrica</span>
                                <span class="badge element-bg-color-blue">Novo</span>
                            </a>
                        </li>
                        <li class="subMenuText <?php echo ($this->uri->segment(1) === "administrador" && $this->uri->segment(2) === "page_resumo") ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('administrador/page_resumo'); ?>">
                                <span class="text">Resumo de Créditos</span>
                            </a>
                        </li>
                        <li class="subMenuText <?php echo ($this->uri->segment(1) === "administrador" && $this->uri->segment(2) === "cadastro") ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('administrador/cadastro'); ?>">
                                <span class="text">Novo Usuário</span>
                            </a>
                        </li>
                        <li class="subMenuText <?php echo ($this->uri->segment(1) === "administrador" && $this->uri->segment(2) == "") ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('administrador'); ?>">
                                <span class="text">Lista de Usuários</span>
                            </a>
                        </li>
                    <?php }  ?>


                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "administrador" && $this->uri->segment(2) === "atualiza") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('administrador/atualiza'); ?>">
                            <span class="text">Atualização Cadastral</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "administrador" && $this->uri->segment(2) === "page_meus_dados") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('administrador/page_meus_dados'); ?>">
                            <span class="text">Dados Gerais</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <?php if( $this->acl->verifica_permissao('contrato')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa fa-cog fw"></i>
                    <span class="text">Configuração</span>
                    <i class="toggle-icon fa fa-angle-down"></i></a>
                <ul class="sub-menu">
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "configuracao" && $this->uri->segment(2) === "cadastro_servico") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/cadastro_servico'); ?>">
                            <span class="text">Novo Serviço</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "configuracao" && $this->uri->segment(2) === "lista_servico") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/lista_servico'); ?>">
                            <span class="text">Lista de Serviços</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "configuracao" && $this->uri->segment(2) === "index") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/index'); ?>">
                            <span class="text">Multa</span>
                        </a>
                    </li>
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "configuracao" && $this->uri->segment(2) === "cadastro_header") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('configuracao/cadastro_header'); ?>">
                            <span class="text">Design do Contrato</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <?php if( $this->acl->verifica_permissao('notificacao')) { ?>
            <li class="menuText active">
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa  fa-coffee fw"></i>
                    <span class="text">Notícias dos Clientes</span>
                    <i class="toggle-icon fa fa-angle-down"></i>
                </a>
                <ul class="sub-menu"  >
                    <li class="subMenuText <?php echo ($this->uri->segment(1) === "notificacao" && $this->uri->segment(1) === "notificacao") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('notificacao'); ?>">
                            <span class="text">Lista das Atividades</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <?php if( $this->acl->verifica_permissao('agenda')) { ?>
            <li class="menuText active">
                <a href="<?php echo base_url('agenda'); ?>">
                    <i class="fa fa-calendar fa-fw"></i>
                    <span class="text">Agenda</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>
<!-- /main-nav 
<div class="sidebar-minified js-toggle-minified">
    <i class="fa fa-angle-down"></i>
</div>-->
<!-- sidebar content -->
<!--<div class="sidebar-content">-->
<!--    <div id="owl-demo" class="" style="width: 210px !important;">-->
<!--        --><?php
//        $ajudas = array();
//        $this->db->select('*');
//        $this->db->order_by('id', 'DESC');
//        $this->db->limit(5);
//        $q = $this->db->get( 'tb_ajuda_voce_sabia' );
//        if( $q->num_rows > 0 ) {
//            $ajudas = $q->result();
//        }
//        ?>
<!--        --><?php //if(!empty($ajudas)) foreach( $ajudas as $ajuda ) { ?>
<!--        <div class="  item">-->
<!--            <div class="panel panel-default">-->
<!--                <div class="panel-heading">-->
<!--                    <h5><i class="fa fa-lightbulb-o"></i> --><?php //echo($ajuda->titulo); ?><!--</h5>-->
<!--                </div>-->
<!--                <div class="panel-body">                <p style="text-align: justify">--><?php //echo($ajuda->nome); ?><!--</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //} ?>
<!--    </div>-->
<!--</div>-->
<div id="dialog-confirm-contrato" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Criar contrato para</h4>
            </div>
            <div class="modal-body">
                <p>  <a href="<?php echo site_url('contrato/cadastro/cliente'); ?>" class="btn btn-success btn-block">
                        CLIENTE
                    </a>
                </p>
                <BR>
                <p>
                    <a href="<?php echo site_url('contrato/cadastro/fornecedor'); ?>"  class="btn btn-info btn-block">
                        FORNECEDOR
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>

<!-- end sidebar content -->