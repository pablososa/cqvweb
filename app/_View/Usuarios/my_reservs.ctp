<script>
	$(document).ready( function(){
		
		actualizar();
		
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
		
		function actualizar(){
			$('table tr#filas').each(function(){
				var tiempo = $(this).children('#h').text().split(':');
				var date = new Date();
				var an = date.getFullYear();
				var mes = date.getMonth();
				mes += 1;
				var dia = date.getDate();
				var fecha = $(this).children('#f').text().split('-');
				var anr = fecha[0];
				var mesr = fecha[1];
				var diar = fecha[2];
				var h = date.getHours();
				var m = date.getMinutes();
				var hr = tiempo[0];
				var mr = tiempo[1];
				var hora,min;
				if( (parseInt(anr) - parseInt(an)) == 1 || (parseInt(mesr) - parseInt(mes)) == 1 || (parseInt(diar) - parseInt(dia)) == 1 ){
					var resto = 24 - parseInt(h);
					hora = resto + parseInt(hr);
				}else{
					hora = parseInt( hr - h );	
				}
				min = parseInt(mr) - parseInt(m);
				if( min < 0 ){
					hora--;
					min = 60 + min;
				}
				( min < 10 ) ? min = '0'+min : min;
				( hora < 10 ) ? hora = '0'+hora : hora;
				$(this).children('#tr').text( hora + ':' + min + ' hs');
			});
		}
		
		setInterval(actualizar,60000);
		
	});
</script>
<header class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1> <?php echo __($usuario['Usuario']['apellido'].', '.$usuario['Usuario']['nombre']); ?> </h1>
				<h4><i> <?php echo __('Mis reservas'); ?> </i> </h4>
			</div>
			<div class="col-sm-6 hidden-xs">
				<ul id="navTrail">
					<li><a href="/../usuarios/logout"> <?php echo __('Salir'); ?> </a></li>
				</ul>
			</div>
		</div>
	</div>
</header>
<div class="container pt15">
	<div class="row">
		<aside id="sidebar" class="col-md-3">
			<nav id="subnav">
				<ul>
					<li><a href = '/usuarios/reservation' > <?php echo __('Reserva'); ?> <i class="icon-right-open"></i></a></li>
					<li><a href = '/usuarios/myReservs' class = "active"> <?php echo __('Mis reservas'); ?> <i class="icon-right-open"></i></a></li>
					<li><a href = '/usuarios/miPerfil' > <?php echo __('Mi perfil'); ?> <i class="icon-right-open"></i></a></li>
					<li><a href = '/usuarios/history' > <?php echo __('Historial'); ?> <i class="icon-right-open"></i></a></li>
					<li><a href = '/usuarios/logout' > <?php echo __('Cerrar sesión'); ?> <i class="icon-right-open"></i></a></li>
				</ul>
			</nav>
		</aside>
		<section id = "content" class="col-md-9">
			<?php 
				if( empty( $reservas ) ){
					echo __('No se encontraron reservas.');
				}else{
			?>
			<?php
				echo $this->Paginator->options(
					array(
						'update' => '#content',
						'before' => $this->Js->get('#loader')->effect(
							'fadeIn',
							array(
								'buffer' => false
							)
						),
						'complete' => $this->Js->get('#loader')->effect(
							'fadeOut',
							array(
								'buffer' => false
							)				
						)
					)
				);
			?>
			<div class ="row text-center">
				<?php
					echo $this->Html->image(
						'loader.gif',
						array(
							'id' => 'loader',
							'hidden' => 'hidden'
						)
					);
				?>
			</div>
			<table class = "table table-condensed">
				<?php
					$tableHeaders = $this->Html->tableHeaders(array(
						$this->Paginator->sort('dir_origen', __('Origen')),
						$this->Paginator->sort('dir_destino', __('Destino')),
						$this->Paginator->sort('tarifa', __('Tarifa')),
						$this->Paginator->sort('fecha', __('Fecha')),
						$this->Paginator->sort('hora', __('Hora')),
						__('Tiempo restante'),
						__('Cancelar')
					),
					array(
						'id' => 'titulos'
					));
					echo $tableHeaders;
					$rows = array();
					foreach( $reservas as $reserva ){
						$rows[] = array(
							__($reserva['Viaje']['dir_origen']),
							__($reserva['Viaje']['dir_destino']),
							__($reserva['Viaje']['tarifa']),
							array(
								__($reserva['Viaje']['fecha']),
								array(
									'id' => 'f'
								)
							),
							array(
								__($reserva['Viaje']['hora']),
								array(
									'id' => 'h'
								)
							),
							array(
								'',
								array(
									'id' => 'tr'	
								)
							),
							$this->Html->link(
								__('Cancelar'),
								array(
									'controller' => 'viajes',
									'action' => 'cancelarReserva',
									$reserva['Viaje']['id']
								),
								array(),
								'¿Está seguro que desea cancelar la reserva?'
							)
						);
					}
					echo $this->Html->tableCells( 
						$rows,
						array(
							'id' => 'filas'
						),
						array(
							'id' => 'filas'
						)
					);
				?>
			</table>
			<div class = "row text-center">
				<ul class = 'pagination'>
					<li>
						<?php
							echo $this->Paginator->prev('<<',array(
								'tag'=>'a'
							));
						?>
					</li>
					<?php
						echo $this->Paginator->numbers(array(
							'tag'=>'li',
							'currentTag'=>'a',
							'currentClass'=>'active',
							'separator'=>''
						));
					?>
					<li>
						<?php
							echo $this->Paginator->next('>>');}
						?>
					</li>
				</ul>
			</div>
			<?php
				echo $this->Js->writeBuffer();
			?>
		</section>
	</div>
</div>	