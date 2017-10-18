<div class="ivrLlamadaEntrantes form">
<?php echo $this->Form->create('IvrLlamadaEntrante'); ?>
	<fieldset>
		<legend><?php echo __('Add Ivr Llamada Entrante'); ?></legend>
	<?php
		echo $this->Form->input('ivr_cliente_id');
		echo $this->Form->input('empresa_id');
		echo $this->Form->input('telefono');
		echo $this->Form->input('fecha');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Ivr Llamada Entrantes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Ivr Clientes'), array('controller' => 'ivr_clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Cliente'), array('controller' => 'ivr_clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
	</ul>
</div>
