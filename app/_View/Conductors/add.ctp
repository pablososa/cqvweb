<?php echo $this->element('menus/empresas', array('active' => 'empresas:viewConductors'))?>



<script src="/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/css/jquery-ui.css"></link>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ConductorFechaNac').datepicker(
                {
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1930:2006",
                    dateFormat : "dd/mm/yy"
                }
        );
    });
</script>



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
                                <i class="fa fa-home"></i>  <?php echo __('Nuevo'); ?>
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



    <div class="row">


            <?php  echo $this->Form->create('Conductor', array('novalidate', 'enctype' => 'multipart/form-data')); ?>
            <div class="container">
                <div class="row">
                    <?php
                    echo $this->Form->hidden(
                            'empresa_id', array(
                        'default' => $empresa['Empresa']['id'],
                        'label' => false
                            )
                    );
                    ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> <?php echo __('Nombre'); ?> </label>
                            <?php
                            echo $this->Form->input('nombre', array(
                                'label' => false,
                                'type' => 'text',
                                'class' => 'form-control',
                                'title' => 'Por favor ingrese su nombre',
                                'placeHolder' => 'Enter first name'
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Apellido'); ?> </label>
                            <?php
                            echo $this->Form->input('apellido', array(
                                'label' => false,
                                'type' => 'text',
                                'class' => 'form-control',
                                'title' => 'Por favor ingrese su apellido',
                                'placeHolder' => 'Enter last name'
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Driver licence'); ?> </label>
                            <?php
                            echo $this->Form->input('dni', array(
                                'label' => false,
                                'type' => 'numeric',
                                'class' => 'form-control required digits',
                                'title' => 'Por favor ingrese su DNI',
                                'placeHolder' => 'Enter dni'
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Fecha de nacimiento'); ?> </label>
                            <?php
                            echo $this->Form->input('fecha_nac', array(
                                'label' => false,
                                'type' => 'text',
                                'class' => 'form-control required digits',
                                'title' => 'Por favor ingrese su DNI',
                                'placeHolder' => 'Enter dni'
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Dirección'); ?> </label>
                            <?php
                            echo $this->Form->input('direccion', array(
                                'label' => false,
                                'type' => 'text',
                                'class' => 'form-control',
                                'title' => 'Por favor ingrese su domicilio',
                                'placeHolder' => 'Enter address',
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Teléfono'); ?> </label>
                            <?php
                            echo $this->Form->input('telefono', array(
                                'label' => false,
                                'type' => 'tel',
                                'class' => 'form-control required digits',
                                'title' => 'Por favor ingrese su teléfono',
                                'placeHolder' => 'Enter phone',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <div class = "form-group">
                            <label> <?php echo __('Picture'); ?> </label>
                            <?php
                            echo $this->Form->input('file', array(
                                'label' => false,
                                'type' => 'file',
                                'class' => 'form-control'
                            ));
                            ?>
                        </div>
                            <label> <?php echo __('SSN'); ?> </label>
                            <?php
                            echo $this->Form->input('cuil', array(
                                'label' => false,
                                'type' => 'text',
                                'class' => 'form-control',
                                'title' => 'Por favor ingrese su cuil',
                                'placeHolder' => 'Enter cuil'
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Email'); ?> </label>
                            <?php
                            echo $this->Form->input('email', array(
                                'label' => false,
                                'type' => 'email',
                                'class' => 'form-control',
                                'placeHolder' => 'Enter email'
                            ));
                            ?>   
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Usuario'); ?> </label>
                            <?php
                            echo $this->Form->input('usuario', array(
                                'label' => false,
                                'type' => 'text',
                                'class' => 'form-control',
                                'title' => 'Por favor ingrese su usuario para la aplicación',
                                'placeHolder' => 'Enter user for app'
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Password'); ?> </label>
                            <?php
                            echo $this->Form->input('pass', array(
                                'label' => false,
                                'type' => 'password',
                                'class' => 'form-control',
                                'title' => 'Por favor ingrese su contraseña',
                                'placeHolder' => 'Enter password',
                                'ng-model' => 'cond.pass'
                            ));
                            ?>
                        </div>
                        <div class="form-group">
                            <label> <?php echo __('Repeat Password'); ?> </label>
                            <?php
                            echo $this->Form->input('pass1', array(
                                'label' => false,
                                'type' => 'password',
                                'class' => 'form-control',
                                'placeHolder' => 'Confirm password'
                            ));
                            ?>
                        </div>


                    <div class = "form-group">
                        <label> <?php echo __('License'); ?> </label>
                        
                        <?php
                        echo $this->Form->input('file2', array(
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
                            'controller' => 'empresas',
                            'action' => 'viewConductors'
                                ), array(
                            'class' => 'btn btn-sm btn-default'
                                )
                        );
                        echo $this->Form->button(__('Accept'), array(
                            'class' => 'btn btn-sm btn-default'
                                )
                        );
                        ?>
                    </div>	
                </div>
            </div>
            <?php
            echo $this->Form->hidden('empresa_id', array('label' => 'ID empresa', 'type' => 'text', 'default' => $empresa['Empresa']['id'], 'readonly' => 'readonly'));
            echo $this->Form->end();
            ?>

    </div>

        </div>
</div>

        </div>
</div>
