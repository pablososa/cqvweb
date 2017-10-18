<?php echo $this->element('menus/admin', array('active' => 'feriados:index')) ?>
<?php echo $this->Html->script('jquery.politedatepicker'); ?>

<section id="content" class="">
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="">
					<h1 class="page-header">
						<?php echo __('Crear viaje programado'); ?>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i> <?php echo __('Crear viaje programado'); ?>
						</li>
					</ol>
				</div>
			</div>
			<div class="panel panel-primary" style="border-color:black">
				<div class="panel-body">
					<?php echo $this->Form->create('Feriado'); ?>
					<div class="container">
						<div class="feriados form">
							<div class="row">
								<div class="col-xs-12">
									<?php echo $this->Form->input('fecha', ['type' => 'text', 'class' => 'form-control lg datepicker']); ?>
									<br>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<?php echo $this->Form->submit(__('Crear'), ['class' => 'btn btn-primary']); ?>
								</div>
							</div>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</section>