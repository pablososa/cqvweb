<div class="ivrDomicilios view">
<h2><?php echo __('Ivr Domicilio'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ivrDomicilio['IvrDomicilio']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ivr Cliente'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ivrDomicilio['IvrCliente']['id'], array('controller' => 'ivr_clientes', 'action' => 'view', $ivrDomicilio['IvrCliente']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Domicilio'); ?></dt>
		<dd>
			<?php echo h($ivrDomicilio['IvrDomicilio']['domicilio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Es Principal'); ?></dt>
		<dd>
			<?php echo h($ivrDomicilio['IvrDomicilio']['es_principal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observaciones'); ?></dt>
		<dd>
			<?php echo h($ivrDomicilio['IvrDomicilio']['observaciones']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ivr Domicilio'), array('action' => 'edit', $ivrDomicilio['IvrDomicilio']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ivr Domicilio'), array('action' => 'delete', $ivrDomicilio['IvrDomicilio']['id']), null, __('Are you sure you want to delete # %s?', $ivrDomicilio['IvrDomicilio']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ivr Domicilios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Domicilio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ivr Clientes'), array('controller' => 'ivr_clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Cliente'), array('controller' => 'ivr_clientes', 'action' => 'add')); ?> </li>
	</ul>
</div>
