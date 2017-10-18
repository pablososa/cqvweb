<div class="keyTelefonos view">
<h2><?php echo __('Key Telefono'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($keyTelefono['KeyTelefono']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Operador'); ?></dt>
		<dd>
			<?php echo $this->Html->link($keyTelefono['Operador']['id'], array('controller' => 'operadors', 'action' => 'view', $keyTelefono['Operador']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Key Telefono'); ?></dt>
		<dd>
			<?php echo h($keyTelefono['KeyTelefono']['key_telefono']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('N Linea'); ?></dt>
		<dd>
			<?php echo h($keyTelefono['KeyTelefono']['n_linea']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Key Telefono'), array('action' => 'edit', $keyTelefono['KeyTelefono']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Key Telefono'), array('action' => 'delete', $keyTelefono['KeyTelefono']['id']), null, __('Are you sure you want to delete # %s?', $keyTelefono['KeyTelefono']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Key Telefonos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Key Telefono'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Operadors'), array('controller' => 'operadors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operador'), array('controller' => 'operadors', 'action' => 'add')); ?> </li>
	</ul>
</div>
