<div class="ivrLlamadaEntrantes view">
<h2><?php echo __('Ivr Llamada Entrante'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ivrLlamadaEntrante['IvrLlamadaEntrante']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ivr Cliente'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ivrLlamadaEntrante['IvrCliente']['id'], array('controller' => 'ivr_clientes', 'action' => 'view', $ivrLlamadaEntrante['IvrCliente']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Empresa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ivrLlamadaEntrante['Empresa']['id'], array('controller' => 'empresas', 'action' => 'view', $ivrLlamadaEntrante['Empresa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefono'); ?></dt>
		<dd>
			<?php echo h($ivrLlamadaEntrante['IvrLlamadaEntrante']['telefono']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($ivrLlamadaEntrante['IvrLlamadaEntrante']['fecha']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ivr Llamada Entrante'), array('action' => 'edit', $ivrLlamadaEntrante['IvrLlamadaEntrante']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ivr Llamada Entrante'), array('action' => 'delete', $ivrLlamadaEntrante['IvrLlamadaEntrante']['id']), null, __('Are you sure you want to delete # %s?', $ivrLlamadaEntrante['IvrLlamadaEntrante']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ivr Llamada Entrantes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Llamada Entrante'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ivr Clientes'), array('controller' => 'ivr_clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Cliente'), array('controller' => 'ivr_clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
	</ul>
</div>
