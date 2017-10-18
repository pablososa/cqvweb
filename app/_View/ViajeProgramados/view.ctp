<div class="viajeProgramados view">
<h2><?php echo __('Viaje Programado'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hora'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['hora']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lunes'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['lunes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Martes'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['martes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Miercoles'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['miercoles']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Jueves'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['jueves']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Viernes'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['viernes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sabado'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['sabado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Domingo'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['domingo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Respeta Feriados'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['respeta_feriados']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Desde'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['fecha_desde']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Hasta'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['fecha_hasta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activo'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['activo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Empresa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($viajeProgramado['Empresa']['id'], array('controller' => 'empresas', 'action' => 'view', $viajeProgramado['Empresa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dir Origen'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['dir_origen']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Latitud Origen'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['latitud_origen']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Longitud Origen'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['longitud_origen']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dir Destino'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['dir_destino']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Latitud Destino'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['latitud_destino']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Longitud Destino'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['longitud_destino']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Localidad'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['localidad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observaciones'); ?></dt>
		<dd>
			<?php echo h($viajeProgramado['ViajeProgramado']['observaciones']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ivr Domicilio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($viajeProgramado['IvrDomicilio']['id'], array('controller' => 'ivr_domicilios', 'action' => 'view', $viajeProgramado['IvrDomicilio']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Viaje Programado'), array('action' => 'edit', $viajeProgramado['ViajeProgramado']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Viaje Programado'), array('action' => 'delete', $viajeProgramado['ViajeProgramado']['id']), null, __('Are you sure you want to delete # %s?', $viajeProgramado['ViajeProgramado']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Viaje Programados'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Viaje Programado'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ivr Domicilios'), array('controller' => 'ivr_domicilios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr Domicilio'), array('controller' => 'ivr_domicilios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Viajes'), array('controller' => 'viajes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Viaje'), array('controller' => 'viajes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Viajes'); ?></h3>
	<?php if (!empty($viajeProgramado['Viaje'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Dir Origen'); ?></th>
		<th><?php echo __('Latitud Origen'); ?></th>
		<th><?php echo __('Longitud Origen'); ?></th>
		<th><?php echo __('Dir Destino'); ?></th>
		<th><?php echo __('Latitud Destino'); ?></th>
		<th><?php echo __('Longitud Destino'); ?></th>
		<th><?php echo __('Localidad'); ?></th>
		<th><?php echo __('Tarifa'); ?></th>
		<th><?php echo __('Distancia'); ?></th>
		<th><?php echo __('Fecha'); ?></th>
		<th><?php echo __('Hora'); ?></th>
		<th><?php echo __('Observaciones'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Cercanos'); ?></th>
		<th><?php echo __('Vehiculo Id'); ?></th>
		<th><?php echo __('Conductor Id'); ?></th>
		<th><?php echo __('Empresa Id'); ?></th>
		<th><?php echo __('Usuario Id'); ?></th>
		<th><?php echo __('Ivr Domicilio Id'); ?></th>
		<th><?php echo __('Creador'); ?></th>
		<th><?php echo __('Horareasig'); ?></th>
		<th><?php echo __('Viaje Programado Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($viajeProgramado['Viaje'] as $viaje): ?>
		<tr>
			<td><?php echo $viaje['id']; ?></td>
			<td><?php echo $viaje['dir_origen']; ?></td>
			<td><?php echo $viaje['latitud_origen']; ?></td>
			<td><?php echo $viaje['longitud_origen']; ?></td>
			<td><?php echo $viaje['dir_destino']; ?></td>
			<td><?php echo $viaje['latitud_destino']; ?></td>
			<td><?php echo $viaje['longitud_destino']; ?></td>
			<td><?php echo $viaje['localidad']; ?></td>
			<td><?php echo $viaje['tarifa']; ?></td>
			<td><?php echo $viaje['distancia']; ?></td>
			<td><?php echo $viaje['fecha']; ?></td>
			<td><?php echo $viaje['hora']; ?></td>
			<td><?php echo $viaje['observaciones']; ?></td>
			<td><?php echo $viaje['estado']; ?></td>
			<td><?php echo $viaje['cercanos']; ?></td>
			<td><?php echo $viaje['vehiculo_id']; ?></td>
			<td><?php echo $viaje['conductor_id']; ?></td>
			<td><?php echo $viaje['empresa_id']; ?></td>
			<td><?php echo $viaje['usuario_id']; ?></td>
			<td><?php echo $viaje['ivr_domicilio_id']; ?></td>
			<td><?php echo $viaje['creador']; ?></td>
			<td><?php echo $viaje['horareasig']; ?></td>
			<td><?php echo $viaje['viaje_programado_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'viajes', 'action' => 'view', $viaje['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'viajes', 'action' => 'edit', $viaje['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'viajes', 'action' => 'delete', $viaje['id']), null, __('Are you sure you want to delete # %s?', $viaje['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Viaje'), array('controller' => 'viajes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
