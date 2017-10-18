<div class="keyTelefonos index">
	<h2><?php echo __('Key Telefonos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('operador_id'); ?></th>
			<th><?php echo $this->Paginator->sort('key_telefono'); ?></th>
			<th><?php echo $this->Paginator->sort('n_linea'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($keyTelefonos as $keyTelefono): ?>
	<tr>
		<td><?php echo h($keyTelefono['KeyTelefono']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($keyTelefono['Operador']['id'], array('controller' => 'operadors', 'action' => 'view', $keyTelefono['Operador']['id'])); ?>
		</td>
		<td><?php echo h($keyTelefono['KeyTelefono']['key_telefono']); ?>&nbsp;</td>
		<td><?php echo h($keyTelefono['KeyTelefono']['n_linea']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $keyTelefono['KeyTelefono']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $keyTelefono['KeyTelefono']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $keyTelefono['KeyTelefono']['id']), null, __('Are you sure you want to delete # %s?', $keyTelefono['KeyTelefono']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Key Telefono'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Operadors'), array('controller' => 'operadors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operador'), array('controller' => 'operadors', 'action' => 'add')); ?> </li>
	</ul>
</div>
