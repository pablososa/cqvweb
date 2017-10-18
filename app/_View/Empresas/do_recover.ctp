<header class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1>
					<?php 
						echo __('ConQuienViajo');
					?>
				</h1>
			</div>
		</div>
	</div>
</header>
<div class = "container pt30 pb30">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">
						<strong> 
							<?php
								echo __('Recuperar contraseña');
							?>
						</strong>
					</h3>
				</div>
				<div class="panel-body">
					<?php 
						echo $this->Form->create( 'Empresa' );
						echo $this->Form->input('id');
					?>
					<div class = "form-group">
						<label>
							<?php
								echo __('Contraseña');
							?>
						</label>
						<?php 
							echo $this->Form->input('pass1',
								array(
									'label' => false,
									'type' => 'password',
									'class' => 'form-control',
									'placeHolder' => 'contraseña'
								)
							);
						?>
					</div>
					<div class = "form-group">
						<label>
							<?php
								echo __('Confirmar contraseña');
							?>
						</label>
						<?php 
							echo $this->Form->input('pass2',
								array(
									'label' => false,
									'type' => 'password',
									'class' => 'form-control',
									'placeHolder' => 'contraseña'
								)
							);
						?>
					</div>
					<div class = "row text-right">
						<div class = "btn-group">
							
							<?php
								echo $this->Html->link(
									__('Cancelar'),
									array(
										'controller' => 'empresas',
										'action' => 'index'
									),
									array(
										'class' => 'btn btn-sm btn-default'
									)
								);
								echo $this->Form->button(
									__('Confirmar'),
									array(
										'class' => 'btn btn-sm btn-default'
									)
								);
							?>
						</div>	
					</div>
					<?php 
						echo $this->Form->end();
					?>
				</div>
			</div> 
		</div>
	</div>
</div>