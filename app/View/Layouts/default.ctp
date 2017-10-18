<?php

	define('GCM_API_KEY', $empresa['Empresa']['fcm_key']);
	define('LOGO_LOGIN', $empresa['Empresa']['img_login']);
	define('LOGO_HEADER', $empresa['Empresa']['img_header']);

?>

<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <!-- Basic Page Needs================================================== -->
    <?php echo $this->Html->charset(); ?>
    <title>YA VIAJES</title>
    <meta name="description"
          content="YA VIAJES es una aplicación para la reserva de taxis y remises mediante un sistema de geolocalizacion">
    <meta name="author" content="Little NEKO">
    <!--Mobile Specific Metas================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo $this->element('layout' . DS . 'css_files'); ?>
    <?php echo $this->Html->script('jquery.min'); ?>
    <script>
        $(document).ready(function () {
            $('#ingresar').mouseover(function (e) {
                $('#ingresar').unbind('mouseover');
                $('#ingresar').click(function (e) {
                    e.preventDefault();
                    $(this).closest('form').submit();
                });
            });
        });
    </script>
    <?php echo $scripts_for_layout; ?>
    <style type="text/css">
        .styleSwitcher {
            display: none;
        }
    </style>
</head>

<body class="header5">
<div id="wrapper">

    <!-- ACA IBA HEADER -->


    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=""><?php 
			echo $this->html->image(LOGO_HEADER); 
			?></a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php
                    if (isset($empresa['Empresa']['nombre']))
                        echo $empresa['Empresa']['nombre'];
                    else
                        echo "Desconocido"
                    ?> </a>
              
            </li>
        </ul>
    </nav>
    <div id="msn">
        <div class="mensajes-container">
            <div class="title">Mensajes</div>
            <span class="tab-shadow"></span>
            <a href="/mensajes/ajaxGetMensajes" class="js-ajax-url"></a>
            <a href="/mensajes/ajaxAceptarMensajes" class="js-ajax-url-accept"></a>
            <ul>
            </ul>
            <span class="tab metallic"></span>
        </div>
    </div>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>
    <?php echo $this->element('sql_dump'); ?>
</div>
<?php echo $this->element('layout' . DS . 'js_files'); ?>
</body>
</html>