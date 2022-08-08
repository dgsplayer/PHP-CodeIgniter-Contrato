<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes');?>
<!-- TOP BAR -->
<script type="text/javascript">

    $(document).ready(function() {

        var janelaInicio = $( window ).width();
        janelaInicio = parseInt(janelaInicio);

        if(janelaInicio > 1000){
            $('.nome_topo').show();
        }else{
            $('.nome_topo').hide();
        }

        $(window).resize(function() {
            var janelaInicio = $( window ).width();
            janelaInicio = parseInt(janelaInicio);

            if(janelaInicio > 1000){
                $('.nome_topo').show();
            }else{
                $('.nome_topo').hide();
            }
        });
    });
</script>
<div class="top-bar"  style="height: 45px !important;">
    <div class="container">
        <div class="row">
           <div class="col-md-7 logo" >
                <a href="">
                  
                    <h4 class="nome_topo" style="font-weight: bold; color: #DDD; width: 430px; line-height: 0px">CONTRATONET</h4>
                </a>
                <h1 class="sr-only">Painel de Controle
                </h1>
            </div>

            <div class="col-md-5">


                        <!-- responsive menu bar icon -->
                        <a href="#" style="color: #fff" class="hidden-md hidden-lg main-nav-toggle"><i class="fa fa-bars"></i></a>

                        <div class="top-bar-right">
                            <div class="logged-user">
                                <div class="btn-group">
                                  
                                    <span style="float:left; margin: 5px 0px 0px 15px; font-size: 11px;color: #ffffff" class="name"><i class="fa fa-user"></i>
<?php $user = $this->session->userdata('contrato_user'); ?>
                                        <?php echo $user["email"]; ?></span>
                                    <a style="float:left; margin: 5px 0px 0px 10px; font-size: 11px; color: #ffffff" href="<?php echo (site_url('login/logout')); ?>">
                                        <i class="fa fa-power-off">
                                        </i>
                                            <span class="text">Sair
                                            </span>
                                    </a>
                                </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>
<!-- /top -->