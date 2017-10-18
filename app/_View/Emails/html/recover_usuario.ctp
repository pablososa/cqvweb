<body>

	<?php echo __('Usted ha solicitado recuperar su contraseña:'); ?>
	
	<?php echo __('Link para recuperar contraseña:'); ?>
	<br>
	<a href="<?php echo Router::url(array('controller' => 'usuarios', 'action' => 'doRecover', $user['Usuario']['id'], $hash), true); ?>"><?php echo Router::url(array('controller' => 'usuarios', 'action' => 'doRecover', $user['Usuario']['id'], $hash), true); ?></a>
	
</body>