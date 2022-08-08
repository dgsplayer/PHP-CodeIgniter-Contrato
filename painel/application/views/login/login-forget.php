

<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<head>
    <title>Login | Kingboard - Admin Dashboard</title>
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

    <link rel="shortcut icon" href="<?php echo base_url('recursos/assets/ico/favicon.png'); ?>">


</head>
<style>

</style>
<body>
<!--  CONTEUDO -->

<div class="full-page-wrapper page-login text-center">

    <div class="inner-page">

        <div class="logo">
            <a href="#">
                <img src="<?php echo (base_url(). '/recursos/assets/img/logo_contratonet.png'); ?>" alt="" />
            </a>
        </div>

        <?php if( isset($_GET['info'])): ?>
        <div class="alert alert-success">
            <?php echo($_GET['info']) ?>
        </div>
        <?php elseif( isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?php echo($_GET['error']) ?>
        </div>
        <?php endif; ?>

        <div class="login-box center-block">

            <?php echo form_open('login/doforget', array('role' => 'form', 'class' => 'form-signin')); ?>
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

            <p class="title">Resetar Senha</p>
            <div class="input-group">
                <?php echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'email'),set_value('email'),'autofocus'); ?>
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
            </div>

            <?php echo form_button(array('name' => 'enviar','class' => 'btn btn-custom-primary btn-lg btn-block btn-login', 'type' => 'submit', 'content' => 'Resetar')); ?>
            <?php echo form_close(); ?>
            <div class="links">
                <p><a href="<?php echo base_url('login/'); ?>">Retornar</a></p>
            </div>
        </div>


    </div>

    <footer class="footer">&copy; 2014 ControlWork Sistemas</footer>

</div>

<!-- Javascript -->

</body>

</html>







