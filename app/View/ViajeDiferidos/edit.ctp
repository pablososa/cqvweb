<?php echo $this->element('menus/empresas', array('active' => 'viaje_diferidos:index')) ?>
<?php echo $this->Html->script('jquery.politedatepicker'); ?>

<section id="content" class="">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <h1 class="page-header">
                        <?php echo __('Editar viaje diferido'); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <?php echo __('Editar viaje diferido'); ?>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="panel panel-primary" style="border-color:black">
                <div class="panel-body">
                    <div class="container">
                        <div class="viajeProgramados form">
                            <?php echo $this->Form->create('ViajeProgramado', ['novalidate' => true]); ?>
                            <?php echo $this->Form->input('id'); ?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('hora'); ?>
                                    <?php echo $this->Form->input('fecha_desde', ['label' => 'Fecha', 'type' => 'text', 'class' => 'form-control lg datepicker']); ?>
                                    <?php echo $this->Form->input('dir_destino', array('class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Destino', 'div' => false)); ?>
                                                                     
                                     <?php echo $this->Form->input('vehiculo_id', array('label' => 'Móvil', 'class' => 'form-control lg', 'div' => false, 'options' => $conductors, 'empty' => __('Móvil mas cercano'))); ?>
                                      <?php echo $this->Form->input('viaje_fijo', array('label' => 'Viaje fijo', 'class' => 'form-control lg', 'div' => false, 'options' => $viajesf, 'empty' => __('No'))); ?>
                                     <br>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('observaciones', ['type' => 'textarea', 'class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $this->Form->submit(__('Editar'), ['class' => 'btn btn-primary']); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo $this->element('maps_js')?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#ViajeProgramadoDirDestino').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');
    });
</script>
