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
        <?php $user = $this->session->userdata('contrato_user'); ?>


        <li class="menuText  <?php echo ($this->uri->segment(1) === "cliente") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('cliente'); ?>">
                <i class="fa fa-user fw"></i>
                <span class="text">Clientes</span>
            </a>
        </li>

        <?php if( $user['nivel'] == 'Admin') { ?>

            <li class="menuText <?php echo ($this->uri->segment(1) === "contrato") ? 'active' : ''; ?>">
                <a href="<?php echo base_url('contrato'); ?>">
                    <i class="fa fa-legal fw"></i>
                    <span class="text">Contratos</span>
                </a>
            </li>
            <li class="menuText  <?php echo ($this->uri->segment(1) === "financeiro") ? 'active' : ''; ?>">
                <a href="<?php echo base_url('financeiro'); ?>">
                    <i class="fa fa-credit-card fw"></i>
                    <span class="text">Financeiro</span>
                </a>
            </li>
            <li class="menuText  <?php echo ($this->uri->segment(1) === "cobranca") ? 'active' : ''; ?>">
                <a href="<?php echo base_url('cobranca/pagamento_receber'); ?>">
                    <i class="fa  fa-bullhorn fw"></i>
                    <span class="text">Cobrança</span>
                </a>
            </li>


            <li class="menuText <?php echo ($this->uri->segment(1) === "configuracao") ? 'active' : ''; ?>">
                <a href="<?php echo base_url('configuracao/index'); ?>">
                    <i class="fa fa-cog fw"></i>
                    <span class="text">Configuração</span>
                </a>
            </li>
            <li class="menuText <?php echo ($this->uri->segment(1) === "contas") ? 'active' : ''; ?>">
                <a href="<?php echo base_url('contas'); ?>">
                    <i class="fa fa-cog fw"></i>
                    <span class="text">Contas</span>
                </a>
            </li>
            <li class="menuText <?php echo ($this->uri->segment(1) === "categorias") ? 'active' : ''; ?>">
                <a href="<?php echo base_url('categorias'); ?>">
                    <i class="fa fa-cog fw"></i>
                    <span class="text">Categorias</span>
                </a>
            </li> 
                <li class="menuText <?php echo ($this->uri->segment(1) === "usuario") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('usuario'); ?>">
                        <i class="fa fa-key fw"></i>
                        <span class="text">Empresas Mãe</span>
                    </a>
                </li>
                <li class="menuText <?php echo ($this->uri->segment(1) === "usuario_filho") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('usuario_filho'); ?>">
                        <i class="fa fa-key fw"></i>
                        <span class="text">Empresas X Usuários</span>
                    </a>
                </li> 
           <!-- <li class="menuText --><?php //echo ($this->uri->segment(1) === "wwww") ? 'active' : ''; ?><!--">-->
<!--                <a href="--><?php //echo base_url('administrador'); ?><!--">-->
<!--                    <i class="fa fa-key fw"></i>-->
<!--                    <span class="text">Usuários</span>-->
<!--                </a>-->
<!--            </li> -->
<!--            <li class="menuText --><?php //echo ($this->uri->segment(1) === "") ? 'active' : ''; ?><!--" >-->
<!--                <a href="--><?php //echo base_url('configuracao/lista_servico'); ?><!--">-->
<!--                    <i class="fa fa-cog fw"></i>-->
<!--                    <span class="text">Serviços</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="menuText  --><?php //echo ($this->uri->segment(1) === "chamados") ? 'active' : ''; ?><!--">-->
<!--                <a href="--><?php //echo base_url('chamados'); ?><!--" class="">-->
<!--                    <i class="fa fa-edit fw"></i>-->
<!--                    <span class="text">Chamados</span>-->
<!--                </a>-->
<!--            </li>-->
        <?php } ?>


        <li class="menuText <?php echo ($this->uri->segment(1) === "orcamento") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('orcamento'); ?>">
                <i class="fa fa-clipboard fa-fw"></i>
                <span class="text">Propostas</span>
            </a>
        </li>
        <li class="menuText  <?php echo ($this->uri->segment(1) === "orcamentos_modelos") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('orcamentos_modelos'); ?>">
                <i class="fa fa-book fa-fw"></i>
                <span class="text">Modelos de Proposta</span>
            </a>
        </li>
        <li class="menuText  <?php echo ($this->uri->segment(2) === "vinc_cliente") ? 'active' : ''; ?>">
            <a href="<?php echo base_url('contract/vinc_cliente'); ?>">
                <i class="fa fa-book fa-fw"></i>
                <span class="text">Modelos de Contrato</span>
            </a>
        </li>
<!--        <li class="menuText --><?php //echo ($this->uri->segment(1) === "templates") ? 'active' : ''; ?><!--">-->
<!--            <a href="--><?php //echo base_url('templates'); ?><!--">-->
<!--                <i class="fa fa-clipboard fa-fw"></i>-->
<!--                <span class="text">Templates</span>-->
<!--            </a>-->
<!--        </li>-->
        <!--        --><?php //if( $this->acl->verifica_permissao('fornecedor')) { ?>
        <!--            <li class="menuText --><?php //echo ($this->uri->segment(1) === "fornecedor") ? 'active' : ''; ?><!--">-->
        <!--                <a href="--><?php //echo base_url('fornecedor'); ?><!--">-->
        <!--                    <i class="fa fa-exchange fw"></i>-->
        <!--                    <span class="text">Fornecedores</span>-->
        <!--                </a>-->
        <!--            </li>-->
        <!--        --><?php //} ?>
        <!--        --><?php //if( $this->acl->verifica_permissao('notificacao')) { ?>
        <!--            <li class="menuText  --><?php //echo ($this->uri->segment(1) === "notificacao") ? 'active' : ''; ?><!--">-->
        <!--                <a href="--><?php //echo base_url('notificacao'); ?><!--">-->
        <!--                    <i class="fa  fa-coffee fw"></i>-->
        <!--                    <span class="text">Notícias dos Clientes</span>-->
        <!---->
        <!--                </a>-->
        <!--            </li>-->
        <!--        --><?php //} ?>
        <!--                --><?php //if( $this->acl->verifica_permissao('agenda')) { ?>
        <!--            <li class="menuText  --><?php //echo ($this->uri->segment(1) === "agenda") ? 'active' : ''; ?><!--">-->
        <!--                <a href="--><?php //echo base_url('agenda'); ?><!--">-->
        <!--                    <i class="fa fa-calendar fa-fw"></i>-->
        <!--                    <span class="text">Agenda</span>-->
        <!--                </a>-->
        <!--            </li>-->
        <!--        --><?php //} ?>
        <!--        <li class="menuText --><?php //echo ($this->uri->segment(1) === "mailmarketing") ? 'active' : ''; ?><!--">-->
        <!--            <a href="--><?php //echo base_url('mailmarketing/index'); ?><!--">-->
        <!--                <i class="fa fa-envelope-o fw"></i>-->
        <!--                <span class="text">Mail Marketing</span>-->
        <!--            </a>-->
        <!--        </li>-->

        <!--        --><?php //if( $this->acl->verifica_permissao('contrato')) { ?>
        <!--        <li class="menuText --><?php //echo ($this->uri->segment(1) === "contract") ? 'active' : ''; ?><!--">-->
        <!--            <a href="--><?php //echo base_url('contract/index'); ?><!--">-->
        <!--                <i class="fa fa-cog fw"></i>-->
        <!--                <span class="text">Painel dos contratos</span>-->
        <!--            </a>-->
        <!--        </li>-->
        <!--        --><?php //} ?>
    </ul>
</nav>
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