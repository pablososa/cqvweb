<?php echo $this->element('menus/empresas', array('active' => 'notificacions:index')) ?>
<?php echo $this->Html->script('jquery.politedatepicker'); ?>

<section id="content" class="">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <h1 class="page-header">
                        <?php echo __('Crear notificacion'); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <?php echo __('Crear notificacion'); ?>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="panel panel-primary" style="border-color:black">
                <div class="panel-body">
                    <div class="container">
                        <div class="notificaciones form">
                            <?php echo $this->Form->create('Notificacion', ['novalidate' => true]); ?>
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
                            <!--                            </div>-->

                            <!--                            <div class="row">-->
                            <!--                                <div class="col-xs-6">-->
                            <!--                                    --><?php //echo $this->Form->input('localidad'); ?>
                            <!--                                </div>-->
                            <!--                            </div>-->

                      
                      
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $this->Form->submit(__('Crear'), ['class' => 'btn btn-primary']); ?>
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

</script>
