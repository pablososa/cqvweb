<?php echo $this->element('menus/empresas', array('active' => 'ivr_clientes:index')) ?>

<section id="content" class="">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <h1 class="page-header">
                        <?php echo __('Editar cliente'); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <?php echo __('Editar cliente'); ?>
                        </li>

                    </ol>
                </div>
            </div>
            <div class="panel panel-primary" style="border-color:black">
                <div class="panel-body">
                    <div class="container">
                        <div class="row">
                            <div class="ivrClientes form">
                                <?php echo $this->Form->create('IvrCliente'); ?>
                                <?php echo $this->Form->input('id'); ?>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('telefono', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('nombre', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('apellido', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('razon_social', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('nombre_de_fantasia', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('telefono_alternativo', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('email', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('pass', ['type' => 'password','class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('pass2', ['type' => 'password', 'class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>

                                    <div class="col-xs-6">
                                        <?php echo $this->Form->input('cuit', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                    </div>
                                     <div class="col-xs-6">
                                       <label> <?php echo __('Forma de pago'); ?> </label>
                                            <?php
                                            echo $this->Form->input('forma_de_pago', array(
                                                'label' => false,
                                                'class' => 'form-control',
                                                'options' => array("Efectivo","Cheque","Transferencia Bancaria","Tarjeta de credito"),

                                            ));
                                            ?>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <?php echo $this->Form->submit(__('Guardar'), ['class'=>'btn btn-primary']); ?>
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
