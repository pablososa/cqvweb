<div class="mensajes form">
<?php echo $this->Form->create('Mensaje'); ?>
	<fieldset>
		<legend><?php echo __('Edit Mensaje'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('texto');
		echo $this->Form->input('fecha');
		echo $this->Form->input('operador');
		echo $this->Form->input('vehiculo_id');
		echo $this->Form->input('visto');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Mensaje.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Mensaje.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Mensajes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Vehiculos'), array('controller' => 'vehiculos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehiculo'), array('controller' => 'vehiculos', 'action' => 'add')); ?> </li>
	</ul>
</div>
