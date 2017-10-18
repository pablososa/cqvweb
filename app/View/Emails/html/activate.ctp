<body style=" background: #858585; color: black;">
<h2> <?php echo __('Bienvenido a IUNIKE'); ?> </h2>
<br>
<h4> <?php echo __("Gracias {$user['Usuario']['nombre']} por registarte."); ?> </h4>

<?php echo __('Para activar tu cuenta haz click en el siguiente link:'); ?>
<br>
<?php $url = Router::url(array('controller' => 'usuarios', 'action' => 'activate', $user['Usuario']['id'], $hash), true); ?>
<a href="<?php echo $url; ?>">
    <?php echo $url; ?>
</a>
</body>