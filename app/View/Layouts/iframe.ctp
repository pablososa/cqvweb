<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<?php
$style = '';
if(Configure::read('debug') < 2) {
    $style = 'overflow: hidden;';
}
?>
<html lang="en" class="<?php echo $extra_classes?>" style="<?php $style; ?>">
    <!--<![endif]-->
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>Con Quien Viajo</title>
        <meta name="description" content="Con Quien Viajo es una aplicacion para la reserva de taxis y remises mediante un sistema de geolocalizacion">
        <!--Mobile Specific Metas================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?php echo $this->element('layout'.DS.'css_files');?>
        <?php echo $this->Html->script('jquery.min'); ?>
        <?php echo $scripts_for_layout; ?>
    </head>
    <body class="header5 isIframe" style="margin-top:0px; background: white" >
        <div id="globalWrapper" class="localscroll">
            <section id = "content" class = "mt30 pt15 pb15">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
            </section>
            <?php echo $this->element('sql_dump'); ?>
        </div>
        <?php echo $this->element('layout'.DS.'js_files');?>
    </body>
</html>