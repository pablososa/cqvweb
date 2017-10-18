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
    <title>IUNIKE</title>
    <meta name="description"
          content="IUNIKE es una aplicación para la reserva de taxis y remises mediante un sistema de geolocalización">
    <meta name="author" content="Little NEKO">
    <!--Mobile Specific Metas================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo $this->Html->css('bootstrap.min'); ?>
    <?php echo $this->Html->css('font-awesome/css/font-awesome.min.css'); ?>
    <?php echo $this->Html->css('usuario'); ?>
    <?php echo $this->Html->script('jquery.min'); ?>
    <?php echo $this->Html->script('jquery.custom'); ?>
    <?php echo $this->Html->script('bootstrap.min'); ?>
    <?php echo $this->Html->script('socket.io'); ?>
    <?php echo $this->Html->script('usuario'); ?>
</head>

<body class="private">
<div id="wrapper">
    <div class="top-bar">
        <div class="site-logo">
            <?php echo $this->html->image('logo_iunike_inv.png'); ?>
        </div><div class="user-info">
            <div class="img">
                <img src="<?php echo Router::url(['controller' => 'usuarios', 'action' => 'getThumb', $sessionUser['Usuario']['id']]) ?>"/>
            </div>
            <div class="name">
                <?php echo ucfirst($sessionUser['Usuario']['nombre']) . ' ' . ucfirst($sessionUser['Usuario']['apellido']); ?>
            </div>
            <div class="logout">
                <?php echo $this->Html->link(__('Salir'), ['controller' => 'usuarios', 'action' => 'logout']); ?>
            </div>
        </div>
    </div>
    <div class="side-bar">
        <?php echo $this->element('usuario' . DS . 'side-bar') ?>
    </div>
    <div class="content container-fluid">
        <div class="alert-container">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php echo $this->fetch('content'); ?>
        <?php echo $this->element('sql_dump'); ?>
    </div>
</div>
<?php echo $scripts_for_layout; ?>
</body>
</html>