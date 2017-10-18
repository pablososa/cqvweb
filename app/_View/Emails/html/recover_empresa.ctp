<body>
	<h1>
		<?php
			echo __('ConQuienViajo');
		?>
	</h1>
	<br>	
	<?php echo __('Solicitud de recuperación de contraseña'); ?>
	<br>
	<p>
		<?php 
			echo __('Para recuperar su contraseña, haga click en el siguiente enlace:');
		?>
	</p>
	<a href="<?php echo Router::url(array('controller' => 'empresas', 'action' => 'doRecover', $empresa['Empresa']['id'], $hash), true); ?>"><?php echo Router::url(array('controller' => 'empresas', 'action' => 'doRecover', $empresa['Empresa']['id'], $hash), true); ?></a>
	
</body>