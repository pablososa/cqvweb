<body style = " background: #EB7F37; color: black;">

	<?php echo __('Ha cambiado su contraseña'); ?>
	
	<p>
		Usuario: <?php echo $user['Usuario']['email']; ?> <br>
		Contraseña: <?php echo $user['Usuario']['pass']; ?>
	</p>
	
</body>