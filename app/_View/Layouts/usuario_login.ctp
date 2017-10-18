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
        <?php echo $this->Html->css('usuario');; ?>
        <?php echo $this->Html->script('jquery.min'); ?>
        <?php echo $this->Html->script('bootstrap.min'); ?>
</head>

<body class="login">
    <div id="wrapper">
        <div class="alert-container">
            <?php echo $this->Session->flash(); ?>
        </div>
        <div class="container-fluid">
            <?php echo $this->fetch('content'); ?>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </div>
    <?php echo $scripts_for_layout; ?>
</body>
</html>