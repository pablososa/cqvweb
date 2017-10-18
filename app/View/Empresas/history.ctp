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
	});
</script>
<header class="page-header mb30">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1> <?php echo __($empresa['Empresa']['nombre']); ?> </h1>
				<h4><i> <?php echo __('Vehiculo/Conductor'); ?> </i> </h4>
			</div>
			<div class="col-sm-6 hidden-xs">
				<ul id="navTrail">
					<li><a href="empresas"> <?php echo __('Empresas'); ?> </a></li>
					<li id="navTrailLast"> <?php echo __('viewRelationships'); ?> </li>
				</ul>
			</div>
		</div>
	</div>
</header>
<div class="container">
	<div class="row" style = "margin-top: 35px;">
        <?php echo $this->element('menus/empresas', array('active' => 'empresas:viewRelationships'))?>
		<section id = "content" class="col-md-9">
			<div class = "container">
				<div class = "row">
					<?php echo $this->Form->create(); ?>
					<div class="col-md-12">
						<div class="input-group input-group-lg col-md-6">
							<input name="data[Usuario][buscar]" class="form-control lg" placeholder="Buscar..." type="text" value="" id="UsuarioBuscar">
							<span class="input-group-btn">
								<?php echo $this->Form->button(__('Buscar'),array('class'=>'btn btn-sm')); ?> 
							</span>
						</div>
						<div class="input-group input-group-lg col-md-6">
							<select name="data[Usuario][buscar]">
								<option default> Buscar por...</option>
								<option> Fecha de inicio </option>
								<option> Fecha de fin </option>
								<option> Patente </option>
							</select>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
			<div class = "row">
			<?php 
				if( empty( $historial ) ){
					echo __('No hay vehiculos registrados.');
				}else{
			?>
				
				<table class = "table table-condensed">
						<tr id = "titulos">
							<th> <?php echo __('Conductor'); ?> </th>
							<th> <?php echo __('Vehiculo'); ?> </th>
							<th> <?php echo __('Fecha inicio'); ?> </th>
							<th> <?php echo __('Hora inicio'); ?> </th>
							<th> <?php echo __('Fecha fin'); ?> </th>
							<th> <?php echo __('Hora fin'); ?> </th>
						</tr>
						
						<?php foreach( $historial as $fila ): ?>
							
						<tr>
							<td> <?php echo $fila['c']['apellido'].', '.$fila['c']['nombre']; ?> </td>
							<td> <?php echo $fila['v']['marca'].' - '.$fila['v']['modelo'].' - '.$fila['v']['patente']; ?> </td>
							<td> <?php echo $fila['h']['fecha_ini']; ?> </td>
							<td> <?php echo $fila['h']['hora_ini']; ?> </td>
							<td> <?php echo $fila['h']['fecha_fin']; ?> </td>
							<td> <?php echo $fila['h']['hora_fin']; ?> </td>
						</tr>
						
						<?php endforeach;} ?>
				</table>
			</div>	
		</section>
	</div>
</div>




