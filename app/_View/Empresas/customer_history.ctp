<script>
	$(document).ready( function(){
		$('table tr').mouseover( function(){
			if( $(this).attr('id') != 'titulos' ){
				$(this).toggleClass('success');
			}
		});
		$('table tr').mouseout( function() {
			if( $(this).attr('id') != 'titulos' ){
				$(this).toggleClass('success');
			}
		});
		$('#volver').click(function(){
			document.location.href = 'customerHistory';
		});
		$('td , th').addClass('text-center');
	});
</script>
<header class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1> <?php echo (isset($admin) ? 'Admin - ' : '') . $empresa['Empresa']['nombre']; ?> </h1>
				<h4><i> <?php echo __('Historial de clientes')?> </i> </h4>
			</div>
		</div>
	</div>
</header>
<div class="container pt15 pb15">
	<div class="row">
        <?php echo $this->element('menus/empresas', array('active' => 'usuarios:customerHistory'))?>
		<section id = "content" class="col-md-9">
			<?php 
				if( !isset( $viajes ) ){
					if( empty($clientes) ){
						echo __('Ningún cliente a utilizado los servicios de la empresa.');
					}else{
			?>	
			<table class = "table table-condensed">
				<tr id = "titulos">
					<th> <?php echo __('Apellido y Nombre'); ?> </th>
					<th> <?php echo __('Viajes completados'); ?> </th>
					<th> <?php echo __('Detalles'); ?> </th>
				</tr>
				
				<?php foreach( $clientes as $cliente): ?>
					
				<tr>
					<td> <?php echo $cliente['Viaje']['usuario']; ?> </td>
					<td> <?php echo $cliente['Viaje']['viajes']; ?> </td>
					<td> <?php echo $this->html->link('Ver',array('action'=>'customerHistory', $cliente['Viaje']['usuario_id'])); ?> </td>
				</tr>
				
				<?php endforeach; } ?>
			</table>
			
			<?php 
				}else{
			?>
							
			<h3> <?php echo __('Detalles de viajes realizados por el cliente: '.$cliente); ?> </h3>
			
			<table class = "table table-bordered">
				<tr id = "titulos">
					<th> Fecha </th>
					<th> Hora </th>
					<th> Origen </th>
					<th> Destino </th>
					<th> Distancia (mtrs) </th>
					<th> Tarifa ($) </th>
					<th> Observaciones </th>
				</tr>
				
				<?php foreach( $viajes as $viaje ): ?>
					
				<tr>
					<td> <?php echo $viaje['Viaje']['fecha']; ?> </td>
					<td> <?php echo $viaje['Viaje']['hora']; ?> </td>
					<td> <?php echo __($viaje['Viaje']['dir_origen']); ?> </td>
					<td> <?php echo __($viaje['Viaje']['dir_destino']); ?> </td>
					<td> <?php echo __($viaje['Viaje']['distancia']); ?> </td>
					<td> <?php echo __($viaje['Viaje']['tarifa']); ?> </td>
					<td> <?php echo __($viaje['Viaje']['observaciones']); ?> </td>
				</tr>		
				
				<?php endforeach; ?>
			</table>
			<div class = "row text-right">
				<?php
					echo $this->Html->link( __('Volver'),
						array(
							'controller' => 'empresas',
							'action' => 'customerHistory'
						),
						array(
							'class' => 'btn btn-sm btn-default'
						)
					);
				?>
			</div>
			<?php } ?>
		</section>
	</div>
</div>




