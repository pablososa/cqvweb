<div class="operadors view">
<h2><?php echo __('Operador'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($operador['Operador']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo h($operador['Operador']['usuario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($operador['Operador']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Empresa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($operador['Empresa']['id'], array('controller' => 'empresas', 'action' => 'view', $operador['Empresa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($operador['Operador']['estado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Operador'), array('action' => 'edit', $operador['Operador']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Operador'), array('action' => 'delete', $operador['Operador']['id']), null, __('Are you sure you want to delete # %s?', $operador['Operador']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Operadors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operador'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
	</ul>
</div>
