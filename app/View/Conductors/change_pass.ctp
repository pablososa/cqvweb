 <?php echo $this->element('menus/empresas', array('active' => 'empresas:viewConductors')) ?>
       


<div id="page-wrapper">

    <div class="container-fluid">
    <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Conductores'); ?> 
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Cambiar contraseña'); ?>
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
            <?php echo $this->Form->create('Conductor'); ?>
            <div class="row">
                <div class="col-md-6">
                    
                    <div class = "form-group">
                        <label> <?php echo __('Contraseña nueva'); ?> </label>
                        <?php
                        echo $this->Form->input(
                                'pass1', array(
                            'label' => false,
                            'type' => 'password',
                            'class' => 'form-control',
                            'placeHolder' => __('Contraseña nueva')
                                )
                        );
                        ?>
                    </div>
                    <div class = "form-group">
                        <label> <?php echo __('Confirmar contraseña'); ?> </label>
                        <?php
                        echo $this->Form->input(
                                'pass2', array(
                            'label' => false,
                            'type' => 'password',
                            'class' => 'form-control',
                            'placeHolder' => __('Confirmar contraseña')
                                )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class = "row text-right">
                <div class = "btn-group">

                    <?php
                    echo $this->Html->link(__('Cancelar'), array(
                        'controller' => 'usuarios',
                        'action' => 'miPerfil'
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
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>

       </div>
</div>

       </div>
</div>