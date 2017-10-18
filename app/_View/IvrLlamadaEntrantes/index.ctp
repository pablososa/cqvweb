<div class="ivrLlamadaEntrantes index">
	<h2><?php echo __('Ivr Llamada Entrantes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('ivr_cliente_id'); ?></th>
			<th><?php echo $this->Paginator->sort('empresa_id'); ?></th>
			<th><?php echo $this->Paginator->sort('telefono'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($ivrLlamadaEntrantes as $ivrLlamadaEntrante): ?>
	<tr>
		<td><?php echo h($ivrLlamadaEntrante['IvrLlamadaEntrante']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ivrLlamadaEntrante['IvrCliente']['id'], array('controller' => 'ivr_clientes', 'action' => 'view', $ivrLlamadaEntrante['IvrCliente']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ivrLlamadaEntrante['Empresa']['id'], array('controller' => 'empresas', 'action' => 'view', $ivrLlamadaEntrante['Empresa']['id'])); ?>
		</td>
		<td><?php echo h($ivrLlamadaEntrante['IvrLlamadaEntrante']['telefono']); ?>&nbsp;</td>
		<td><?php echo h($ivrLlamadaEntrante['IvrLlamadaEntrante']['fecha']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ivrLlamadaEntrante['IvrLlamadaEntrante']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ivrLlamadaEntrante['IvrLlamadaEntrante']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ivrLlamadaEntrante['IvrLlamadaEntrante']['id']), null, __('Are you sure you want to delete # %s?', $ivrLlamadaEntrante['IvrLlamadaEntrante']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Ivr Llamada Entrante'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ivr Clientes'), array('controller' => 'ivr_clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Cliente'), array('controller' => 'ivr_clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
	</ul>
</div>
