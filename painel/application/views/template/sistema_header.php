<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<head>
    <title>ControlWork Sistemas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="Controlwork"> 
    <meta name="robots" 	content="noindex,nofollow">
    <!-- CSS -->
    <link href="<?php echo base_url('recursos/assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('recursos/assets/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('recursos/assets/css/main.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('recursos/assets/css/jquery-ui-1.10.4.custom.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo (base_url(). '/recursos/assets/js/intro/introjs.css'); ?>" rel="stylesheet" type="text/css">
    <!-- CSS for demo style switcher. you can remove this -->
    <link href="<?php echo base_url('recursos/demo-style-switcher/assets/css/style-switcher.css'); ?>" rel="stylesheet" type="text/css">
<!--    <link href="--><?php //echo base_url('recursos/assets/css/fullcalendar.css'); ?><!--" rel="stylesheet" type="text/css">-->

    <!-- Fav and touch icons -->
<!--    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="--><?php //echo base_url('recursos/assets/ico/kingboard-favicon144x144.png'); ?><!--">-->
<!--    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="--><?php //echo base_url('recursos/assets/ico/kingboard-favicon114x114.png'); ?><!--">-->
<!--    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="--><?php //echo base_url('recursos/assets/ico/kingboard-favicon72x72.png'); ?><!--">-->
<!--    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="--><?php //echo base_url('recursos/assets/ico/kingboard-favicon57x57.png'); ?><!--">-->
    <link rel="shortcut icon" href="http://www.controlwork.com.br/home/recursos/images/favicon.ico">
    <script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jquery-2.1.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo (base_url(). '/recursos/assets/js/intro/intro.js'); ?>"></script>
</head>
<?php if(!empty($css_files) )foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php if(!empty($js_files)) foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<body class="forms-elements comp-wizard">
<!--<div class="wrapper">-->
<!-- TOP GENERAL ALERT -->
<div class="alert alert-info top-general-alert">
    <span>The system has been upgraded to the new version. Click the <a href="#">release notes</a> to see the changes.</span>
    <a type="button" class="close">&times;</a>
</div>
<!-- END TOP GENERAL ALERT -->

<!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
<div class="bottom">

    <!-- top -->
    <?php $this->load->view('template/include/sistema_topo'); ?>
    <!-- END top -->
<?php
$user = $this->session->userdata('contrato_user');
if(!$user) {
    redirect('/login');
    exit();
}
?>
    <div class="container">
        <div class="row">

            <!-- left sidebar -->
            <div class="col-md-2 left-sidebar">
                <?php $this->load->view('template/include/sistema_menu'); ?>
            </div>
            <!-- end left sidebar -->

            <!-- content-wrapper -->
            <div class="col-md-10 content-wrapper">
                <div class="row">
                    <div class="<?php echo ($this->uri->segment(2) === "dashboard") ? 'col-md-6' : 'col-md-12'; ?>">
                        <ul class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="#">Início</a></li>
                            <li class="active"></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <!-- CONTEUDO DINAMICO AQUI -->
                        <?php $this->load->view( $content );?>
                        <!-- END CONTEUDO DINAMICO AQUI -->
                    </div>
                </div>
            </div>
            <!-- END content-wrapper -->

        </div>
        <!-- END row -->
        <div id="push"></div>
    </div>
    <!-- END container -->
</div>
<!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
<!--</div>-->
<?php //$user = $this->session->userdata('contrato_user'); ?>
<!--<script>-->
<!--  window.intercomSettings = {-->
<!--    // TODO: The current logged in user's full name-->
 
<!--    // TODO: The current logged in user's sign-up date as a Unix timestamp.-->
<!--    created_at: --><?php //echo time() ?><!--,-->
<!--    app_id: "w6rz1gri"-->
<!--  };-->
<!--</script>-->
<!--<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/w6rz1gri';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>-->

