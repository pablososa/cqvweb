    <?php echo $this->element('menus/empresas', array('active' => 'vehiculos:index')) ?>


<div id="page-wrapper">

    <div class="container-fluid">
    <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Vehiculos'); ?> 
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Formulario de registro de vehiculos'); ?>
                            </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="panel panel-primary" style="border-color:black">
                            <div class="panel-heading" style="background:black">
                            <h2></h2>
                            </div>
                            <div class="panel-body">



<div class="container pt15 pb15">
    <div class="row">
    
        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Vehiculo', array('novalidate')); ?>
            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label> <?php echo __('Make'); ?> </label>
                        <?php
                        echo $this->Form->input('marca', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('Model'); ?> </label>
                        <?php
                        echo $this->Form->input('modelo', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>	
                                     <div class="form-group">
                        <label> <?php echo __('Type of service'); ?> </label>
                        <?php
                        echo $this->Form->input('tipo_de_auto', array(
                            'label' => false,
                            'class' => 'form-control',
                            'options' => array("Regular","Max","Lux"),

                        ));
                        ?>


                    </div>  

                        <div class = "form-group">
                            <label> <?php echo __('CA Vehicule Registration'); ?> </label>
                            <?php
                            echo $this->Form->input('file4', array(
                                'label' => false,
                                'type' => 'file',
                                'class' => 'form-control'
                            ));
                            ?>
                    </div>

                        <div class = "form-group">
                            <label> <?php echo __('Vehicle Inspection Form'); ?> </label>
                            <?php
                            echo $this->Form->input('file5', array(
                                'label' => false,
                                'type' => 'file',
                                'class' => 'form-control'
                            ));
                            ?>
                    </div>					
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label> <?php echo __('Plate'); ?> </label>
                        <?php
                        echo $this->Form->input('patente', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>		
                    <div class="form-group">
                        <label> <?php echo __('Car VIN'); ?> </label>
                        <?php
                        echo $this->Form->input('nro_registro', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>

                    <div class = "form-group">
                            <label> <?php echo __('Photo'); ?> </label>
                            <?php
                            echo $this->Form->input('file2', array(
                                'label' => false,
                                'type' => 'file',
                                'class' => 'form-control'
                            ));
                            ?>
                    </div>

                        <div class = "form-group">
                            <label> <?php echo __('CA Vehicle insurance'); ?> </label>
                            <?php
                            echo $this->Form->input('file3', array(
                                'label' => false,
                                'type' => 'file',
                                'class' => 'form-control'
                            ));
                            ?>
                    </div>


                </div>



            </div>
            <div class = "row text-right">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array(
                        'controller' => 'vehiculos',
                        'action' => 'index'
                            ), array(
                        'class' => 'btn btn-sm btn-default'
                            )
                    );
                    echo $this->Form->button(__('Confirmar'), array(
                        'class' => 'btn btn-sm btn-default'
                            )
                    );
                    ?>
                </div>	
                <?php echo $this->Form->end(); ?>
            </div>
        </section>
    </div>
</div>


       </div>
</div>

        </div>
</div>