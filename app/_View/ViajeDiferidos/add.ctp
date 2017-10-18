<?php echo $this->element('menus/empresas', array('active' => 'ivr_clientes:index')) ?>
<?php echo $this->Html->script('jquery.politedatepicker'); ?>

<section id="content" class="">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <h1 class="page-header">
                        <?php echo __('Crear viaje diferido'); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <?php echo __('Crear viaje diferido'); ?>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="panel panel-primary" style="border-color:black">
                <div class="panel-body">
                    <div class="container">
                        <div class="viajeProgramados form">
                            <?php echo $this->Form->create('ViajeProgramado', ['novalidate'=>true]); ?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('hora'); ?>
                                    <?php echo $this->Form->input('fecha_desde', ['label' => 'Fecha', 'type' => 'text', 'class' => 'form-control lg datepicker']); ?>
                                    <?php echo $this->Form->input('dir_destino', array('class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Destino', 'div' => false)); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('observaciones', ['type' => 'textarea', 'class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $this->Form->submit(__('Crear'), ['class'=>'btn btn-primary']); ?>
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

