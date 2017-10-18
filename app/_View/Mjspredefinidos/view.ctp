<div class="mjspredefinidos view">
<h2><?php echo __('Mjspredefinido'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mjspredefinido['Mjspredefinido']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Texto'); ?></dt>
		<dd>
			<?php echo h($mjspredefinido['Mjspredefinido']['texto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Empresa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mjspredefinido['Empresa']['id'], array('controller' => 'empresas', 'action' => 'view', $mjspredefinido['Empresa']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mjspredefinido'), array('action' => 'edit', $mjspredefinido['Mjspredefinido']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mjspredefinido'), array('action' => 'delete', $mjspredefinido['Mjspredefinido']['id']), null, __('Are you sure you want to delete # %s?', $mjspredefinido['Mjspredefinido']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mjspredefinidos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mjspredefinido'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
	</ul>
</div>
