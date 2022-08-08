<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<head>
    <title>Login | ControlWork Sistemas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Sistema ContratoNet">
  
    <meta name="ROBOTS" content="NOFOLLOW, NOINDEX" />

    <!-- CSS -->
	<link rel="stylesheet" href="<?php echo base_url('recursos/assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('recursos/assets/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('recursos/assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('recursos/assets/css/page.css'); ?>">
	<script src="<?php echo base_url('recursos/assets/js/jquery-2.1.0.min.js'); ?>"></script>
	<script src="<?php echo base_url('recursos/assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('recursos/assets/js/modernizr.js'); ?>"></script>


    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('recursos/assets/ico/kingboard-favicon144x144.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('recursos/assets/ico/kingboard-favicon114x114.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('recursos/assets/ico/kingboard-favicon72x72.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo base_url('recursos/assets/ico/kingboard-favicon57x57.png'); ?>">



</head>
<style>

</style>
<body>
<!--  CONTEUDO -->

<div class="full-page-wrapper page-login text-center">

    <div class="inner-page">

        <div class="logo">
            <!-- <a href="http://www.controlwork.com.br">
                <img src="http://controlwork.com.br/home/recursos/images/control_work.png" width="300" alt="" />
            </a> -->

<!--<h2>Acesso ao Sistema</h2>-->

<?php if (!empty($_GET['msg'])){ echo  '<div class="alert alert-success">Cadastro realizado com sucesso<BR>Insira abaixo seu novo acesso</div>'; } ?>

        </div>

        <div class="login-box center-block">
            <?php echo form_open('login/processa_login', array('role' => 'form', 'class' => 'form-signin')); ?>
            <?php if( validation_errors()) { ?>
            <div class="alert alert-error bg-danger text-center">
                <?php echo validation_errors(); ?>
            </div>
            <?php } ?>

            <?php if($mensagem = $this->session->flashdata("error")) { 	?>
            <div class="alert alert-error bg-danger text-center">
                <?php echo $mensagem; ?>
            </div>
            <?php } ?>

                <!--<p class="title">Acesso ao Sistema</p>-->
                <div class="input-group">
                    <?php echo form_input(array('name' => 'login', 'class' => 'form-control', 'placeholder' => 'Email'),set_value('login'),'autofocus'); ?>
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
                <div class="input-group">
                    <?php echo form_password(array('name' => 'senha', 'class' => 'form-control', 'placeholder' => 'Senha')); ?>
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                </div>

            <?php echo form_button(array('name' => 'enviar','class' => 'btn btn-primary btn-lg btn-block btn-login', 'type' => 'submit', 'content' => 'Login')); ?>
            <?php echo form_close(); ?>

            <div class="links">
               <p><a href="<?php echo base_url('login/forget/'); ?>">Esqueci minha senha?</a></p>
            </div>
        </div>
    </div>

    <footer class="footer">&copy; 2014 ControlWork Sistemas</footer>

</div>

<!-- Javascript -->

</body>

</html>