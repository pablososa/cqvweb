<?php echo $this->element('menus/empresas', array('active' => 'notifications:index')) ?>
<?php echo $this->Html->script('jquery.politedatepicker'); ?>

<section id="content" class="">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <h1 class="page-header">
                        <?php echo __('Editar notificacion'); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <?php echo __('Editar notificacion'); ?>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="panel panel-primary" style="border-color:black">
                <div class="panel-body">
                    <div class="container">
                        <div class="notificaciones form">
                            <?php echo $this->Form->create('Notificacion', ['novalidate' => true]); ?>
                            <?php echo $this->Form->input('id'); ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $this->Form->input('hora'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 days form-group">
                                    <?php echo $this->Form->input('lunes'); ?>
                                    <?php echo $this->Form->input('martes'); ?>
                                    <?php echo $this->Form->input('miercoles'); ?>
                                    <?php echo $this->Form->input('jueves'); ?>
                                    <?php echo $this->Form->input('viernes'); ?>
                                    <?php echo $this->Form->input('sabado'); ?>
                                    <?php echo $this->Form->input('domingo'); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                   
                                    <?php echo $this->Form->input('fecha_desde', ['type' => 'text', 'class' => 'form-control lg datepicker']); ?>
                                    <?php echo $this->Form->input('fecha_hasta', ['type' => 'text', 'class' => 'form-control lg datepicker']); ?>
                                         <div class="days">
                                        <?php echo $this->Form->input('activo'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('mensaje', ['type' => 'textarea', 'class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                            </div>

                            <!---->
                            <!--                            --><?php //echo $this->Form->input('dir_origen'); ?>
                            <!--                            --><?php //echo $this->Form->input('dir_destino'); ?>
                            <!---->
                            <!--                            <div>-->
                            <!--                                --><?php //echo $this->Form->input('dir_origen', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Origen', 'div' => false)); ?>
                            <!--                            </div>-->
                            <!--                            <div class="marg-15-res">-->
                            <!--                                --><?php //echo $this->Form->input('dir_destino', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Destino', 'div' => false)); ?>
                            <!--                            </div>-->

                            <!--                            <div class="row">-->
                            <!--                                <div class="col-xs-6">-->
                            <!--                                    --><?php //echo $this->Form->input('localidad'); ?>
                            <!--                                </div>-->
                            <!--                            </div>-->

                       
                       
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
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAecgRosBhzg6muphetDVbV_XDXZdV9u9Q&v=3.exp&libraries=geometry,places"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#ViajeProgramadoDirDestino').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');
    });
</script>

