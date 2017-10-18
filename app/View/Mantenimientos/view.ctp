<div class="mantenimientos view">
<h2><?php echo __('Mantenimiento'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mantenimiento['Mantenimiento']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mensaje'); ?></dt>
		<dd>
			<?php echo h($mantenimiento['Mantenimiento']['mensaje']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Desde'); ?></dt>
		<dd>
			<?php echo h($mantenimiento['Mantenimiento']['desde']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hasta'); ?></dt>
		<dd>
			<?php echo h($mantenimiento['Mantenimiento']['hasta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($mantenimiento['Mantenimiento']['estado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mantenimiento'), array('action' => 'edit', $mantenimiento['Mantenimiento']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mantenimiento'), array('action' => 'delete', $mantenimiento['Mantenimiento']['id']), null, __('Are you sure you want to delete # %s?', $mantenimiento['Mantenimiento']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mantenimientos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mantenimiento'), array('action' => 'add')); ?> </li>
	</ul>
</div>
