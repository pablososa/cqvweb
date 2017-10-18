<div class="viajesHistorials form">
<?php echo $this->Form->create('ViajesHistorial'); ?>
	<fieldset>
		<legend><?php echo __('Add Viajes Historial'); ?></legend>
	<?php
		echo $this->Form->input('viaje_id');
		echo $this->Form->input('fecha');
		echo $this->Form->input('estado');
		echo $this->Form->input('cercanos');
		echo $this->Form->input('vehiculo_id');
		echo $this->Form->input('horareasig');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Viajes Historials'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Viajes'), array('controller' => 'viajes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Viaje'), array('controller' => 'viajes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehiculos'), array('controller' => 'vehiculos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehiculo'), array('controller' => 'vehiculos', 'action' => 'add')); ?> </li>
	</ul>
</div>
