<div class="viajesHistorials index">
	<h2><?php echo __('Viajes Historials'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('viaje_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th><?php echo $this->Paginator->sort('cercanos'); ?></th>
			<th><?php echo $this->Paginator->sort('vehiculo_id'); ?></th>
			<th><?php echo $this->Paginator->sort('horareasig'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($viajesHistorials as $viajesHistorial): ?>
	<tr>
		<td><?php echo h($viajesHistorial['ViajesHistorial']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($viajesHistorial['Viaje']['id'], array('controller' => 'viajes', 'action' => 'view', $viajesHistorial['Viaje']['id'])); ?>
		</td>
		<td><?php echo h($viajesHistorial['ViajesHistorial']['fecha']); ?>&nbsp;</td>
		<td><?php echo h($viajesHistorial['ViajesHistorial']['estado']); ?>&nbsp;</td>
		<td><?php echo h($viajesHistorial['ViajesHistorial']['cercanos']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($viajesHistorial['Vehiculo']['id'], array('controller' => 'vehiculos', 'action' => 'view', $viajesHistorial['Vehiculo']['id'])); ?>
		</td>
		<td><?php echo h($viajesHistorial['ViajesHistorial']['horareasig']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $viajesHistorial['ViajesHistorial']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $viajesHistorial['ViajesHistorial']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $viajesHistorial['ViajesHistorial']['id']), null, __('Are you sure you want to delete # %s?', $viajesHistorial['ViajesHistorial']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Viajes Historial'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Viajes'), array('controller' => 'viajes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Viaje'), array('controller' => 'viajes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehiculos'), array('controller' => 'vehiculos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehiculo'), array('controller' => 'vehiculos', 'action' => 'add')); ?> </li>
	</ul>
</div>
