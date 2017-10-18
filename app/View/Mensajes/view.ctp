<div class="mensajes view">
<h2><?php echo __('Mensaje'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mensaje['Mensaje']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Texto'); ?></dt>
		<dd>
			<?php echo h($mensaje['Mensaje']['texto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($mensaje['Mensaje']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Operador'); ?></dt>
		<dd>
			<?php echo h($mensaje['Mensaje']['operador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vehiculo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mensaje['Vehiculo']['id'], array('controller' => 'vehiculos', 'action' => 'view', $mensaje['Vehiculo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visto'); ?></dt>
		<dd>
			<?php echo h($mensaje['Mensaje']['visto']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mensaje'), array('action' => 'edit', $mensaje['Mensaje']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mensaje'), array('action' => 'delete', $mensaje['Mensaje']['id']), null, __('Are you sure you want to delete # %s?', $mensaje['Mensaje']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mensajes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mensaje'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehiculos'), array('controller' => 'vehiculos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehiculo'), array('controller' => 'vehiculos', 'action' => 'add')); ?> </li>
	</ul>
</div>
