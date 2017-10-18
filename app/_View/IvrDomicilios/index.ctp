<div class="ivrDomicilios index">
	<h2><?php echo __('Ivr Domicilios'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('ivr_cliente_id'); ?></th>
			<th><?php echo $this->Paginator->sort('domicilio'); ?></th>
			<th><?php echo $this->Paginator->sort('es_principal'); ?></th>
			<th><?php echo $this->Paginator->sort('observaciones'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($ivrDomicilios as $ivrDomicilio): ?>
	<tr>
		<td><?php echo h($ivrDomicilio['IvrDomicilio']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ivrDomicilio['IvrCliente']['id'], array('controller' => 'ivr_clientes', 'action' => 'view', $ivrDomicilio['IvrCliente']['id'])); ?>
		</td>
		<td><?php echo h($ivrDomicilio['IvrDomicilio']['domicilio']); ?>&nbsp;</td>
		<td><?php echo h($ivrDomicilio['IvrDomicilio']['es_principal']); ?>&nbsp;</td>
		<td><?php echo h($ivrDomicilio['IvrDomicilio']['observaciones']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ivrDomicilio['IvrDomicilio']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ivrDomicilio['IvrDomicilio']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ivrDomicilio['IvrDomicilio']['id']), null, __('Are you sure you want to delete # %s?', $ivrDomicilio['IvrDomicilio']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Ivr Domicilio'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ivr Clientes'), array('controller' => 'ivr_clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Cliente'), array('controller' => 'ivr_clientes', 'action' => 'add')); ?> </li>
	</ul>
</div>
