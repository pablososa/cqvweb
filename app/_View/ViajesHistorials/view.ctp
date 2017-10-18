<div class="viajesHistorials view">
<h2><?php echo __('Viajes Historial'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($viajesHistorial['ViajesHistorial']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Viaje'); ?></dt>
		<dd>
			<?php echo $this->Html->link($viajesHistorial['Viaje']['id'], array('controller' => 'viajes', 'action' => 'view', $viajesHistorial['Viaje']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($viajesHistorial['ViajesHistorial']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($viajesHistorial['ViajesHistorial']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cercanos'); ?></dt>
		<dd>
			<?php echo h($viajesHistorial['ViajesHistorial']['cercanos']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vehiculo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($viajesHistorial['Vehiculo']['id'], array('controller' => 'vehiculos', 'action' => 'view', $viajesHistorial['Vehiculo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Horareasig'); ?></dt>
		<dd>
			<?php echo h($viajesHistorial['ViajesHistorial']['horareasig']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Viajes Historial'), array('action' => 'edit', $viajesHistorial['ViajesHistorial']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Viajes Historial'), array('action' => 'delete', $viajesHistorial['ViajesHistorial']['id']), null, __('Are you sure you want to delete # %s?', $viajesHistorial['ViajesHistorial']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Viajes Historials'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Viajes Historial'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Viajes'), array('controller' => 'viajes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Viaje'), array('controller' => 'viajes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehiculos'), array('controller' => 'vehiculos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehiculo'), array('controller' => 'vehiculos', 'action' => 'add')); ?> </li>
	</ul>
</div>
