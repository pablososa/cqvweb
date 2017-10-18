<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
	$(document).ready( function(){
		var input = document.getElementById('UsuarioDireccion');
		
		var options = {
			types: ['geocode'],
			componentRestrictions: {
				country: 'ar'
			}
		};
		
		var autocomplete = new google.maps.places.Autocomplete(input, options);
		
		function geocodeResult(response,status){
			if(status == 'OK') {

			}else{
				alert('Dirección no válida.');
			}
		}	
	});
</script>
<header class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1>
					<?php 
						echo __( ( isset($admin) ? 'Admin - ' : '').$usuario['Usuario']['apellido'].', '.$usuario['Usuario']['nombre'] );
					?>
				</h1>
				<h4><i> <?php echo __('Inicio'); ?> </i> </h4>
			</div>
			<div class="col-sm-6 hidden-xs">
				<ul id="navTrail">
				<li><a href="/usuarios/logout"> <?php echo __('Salir'); ?> </a></li>
				</ul>
			</div>
		</div>
	</div>
</header>
<div class="container pt15 pb15">
	<div class="row">
        <?php echo $this->element('menus' . DS . 'usuario', array('active' => 'usuarios:miPerfil')); ?>
		<section id = "content" class="col-md-9">
			<div class="row">
				<div class="col-md-6"> 
					<?php 
						echo 
							$this->Form->create(
								'Usuario',
								array(
									'enctype' => 'multipart/form-data'
							)
						);
					?>
					<?php 
						echo 
							$this->Form->hidden(
								'id',
								array(
									'label' => false,
									'type' => 'text'
							)
						);
					?>
					<div class="form-group">
						<div class = "row">
							<div class = "row">
								<div class = "col-md-12">
									<label> <?php echo __('Nombre'); ?> </label>
								</div>
							</div>
							<div class = "col-md-12">
								<?php echo $this->Form->input('nombre', array('label' => false,'type'=>'text','class'=>'form-control')); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class = "row">
							<div class = "col-md-12">
								<label> <?php echo __('Apellido'); ?> </label>
							</div>
						</div>
						<div class = "row">
							<div class = "col-md-12">
								<?php echo $this->Form->input('apellido', array('label' => false,'type'=>'text','class'=>'form-control')); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class = "row">
							<div class = "col-md-12">
								<label> <?php echo __('Foto'); ?> </label>
							</div>
						</div>
						<div class = "row">
							<div class = "col-md-12">
								<?php echo $this->Form->input('file', array('label' => false,'type'=>'file','class'=>'form-control')); ?>
							</div>
						</div>
					</div>								
				</div>
				<div class="col-md-6"> 
						<div class="form-group">
							<div class = "row">
								<div class = "col-md-12">
									<label> <?php echo __('Dircción'); ?> </label>
								</div>
							</div>
							<div class = "row">
								<div class = "col-md-12">
									<?php echo $this->Form->input('direccion', array('label' => false,'type'=>'text','class'=>'form-control')); ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class = "row">
								<div class = "col-md-12">
									<label> <?php echo __('Teléfono'); ?> </label>
								</div>
							</div>
							<div class = "row">
								<div class = "col-md-12">
									<?php echo $this->Form->input('telefono', array('label' => false,'type'=>'tel','class'=>'form-control required digits')); ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class = "row">
								<div class = "col-md-12">
									<label> <?php echo __('E-mail'); ?> </label>
								</div>
							</div>
							<div class = "row">
								<div class = "col-md-12">
									<?php echo $this->Form->input('email', array('label' => false,'type'=>'email','class'=>'form-control','div'=>false)); ?>
								</div>
							</div>
						</div>
						<?php echo $this->Form->hidden('pass', array('label' => false,'type'=>'text')); ?>
						<?php echo $this->Form->hidden('estado', array('label' => false,'type'=>'text')); ?>
				</div>
			</div>
			<div class = "row text-right">
				<div class = "btn-group" >
					<?php
						echo $this->Html->link( __('Cancelar'),
							array(
								'controller' => 'usuarios',
								'action' => 'miPerfil'
							),
							array(
								'class' => 'btn btn-sm btn-default'
							)
						);
						echo $this->Form->button(__('Confirmar'),
							array(
								'class' => 'btn btn-sm btn-default'
							)
						);
					?>
				</div>	
			</div>
			<?php echo $this->Form->end(); ?>
		</section>
	</div>
</div>
