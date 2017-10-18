<div class="keyTelefonos form">
<?php echo $this->Form->create('KeyTelefono'); ?>
	<fieldset>
		<legend><?php echo __('Add Key Telefono'); ?></legend>
	<?php
		echo $this->Form->input('operador_id');
		echo $this->Form->input('key_telefono');
		echo $this->Form->input('n_linea');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Key Telefonos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Operadors'), array('controller' => 'operadors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operador'), array('controller' => 'operadors', 'action' => 'add')); ?> </li>
	</ul>
</div>
