 <?php echo $this->element('menus/empresas', array('active' => 'operadors:index')) ?>

<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Operadores'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Formulario de edicion de configuraciones'); ?>
                            </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->



              <div class="panel panel-primary" style="border-color:black">
                            <div class="panel-heading" style="background:black">
                            <h2></h2>
                            </div>
                            <div class="panel-body" style="margin: 10px">
<div class="container pt15 pb15">
    <div class="row">
       
        <section id = "content" class="col-md-9">
            <div class="row">
                <div class="col-md-6"> 
                    <?php echo $this->Form->create('Operador', array('novalidate')); ?>
                    <?php echo $this->Form->input('id'); ?>
                    <div class="form-group">
                        <label> <?php echo __('Puede elegir a que móvil crear el viaje'); ?> </label>
                        <?php
                        echo $this->Form->input('Operador.configs.puede_asignar_moviles_determinados', array(
                            'label' => false,
                            'class' => 'form-control',
                            'options' => $si_no
                        ));
                        ?>
                    </div>

                    <div class="form-group">
                        <label> <?php echo __('Puede modificar vehículos y conductores'); ?> </label>
                        <?php
                        echo $this->Form->input('Operador.configs.puede_modificar_vehiculos_conductores', array(
                            'label' => false,
                            'class' => 'form-control',
                            'options' => $si_no
                        ));
                        ?>
                    </div>


                </div>
            </div>


            <div class = "row text-right">
                <div class = "btn-group">
                    <?php echo $this->Html->link(__('Cancelar'), array('controller' => 'operadors', 'action' => 'index'), array('class' => 'btn btn-sm btn-default')); ?>
                    <?php echo $this->Form->button(__('Confirmar'), array('class' => 'btn btn-sm btn-default')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>

 </div>
</div>

 </div>
</div>