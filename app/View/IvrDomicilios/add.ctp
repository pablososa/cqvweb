<?php echo $this->element('maps_js')?>
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#IvrDomicilioDomicilio').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');
    });
</script>
<?php echo $this->element('menus/empresas', array('active' => 'viajes:adminHistory')); ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo __('Crear domicilio'); ?>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i> <?php echo __('Crear domicilio'); ?>
                    </li>
                </ol>
            </div>
        </div>
        <div class="panel panel-primary" style="border-color:black">
            <div class="panel-body" style="margin: 10px">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $this->Form->create('IvrDomicilio', array('novalidate')); ?>
                        <div class="container">

                        <?php if(empty($this->data['IvrCliente']['id'])): ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <h3>Cliente</h3>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('IvrCliente.telefono', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('IvrCliente.nombre', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('IvrCliente.apellido', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('IvrCliente.razon_social', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('IvrCliente.nombre_de_fantasia', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('IvrCliente.telefono_alternativo', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php echo $this->Form->input('IvrCliente.email', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                </div>

                                 <div class="col-xs-6">
                                <?php echo $this->Form->input('clave', ['type' => 'password','class' => 'form-control', 'div' => 'form-group']); ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('repetir_clave', ['type' => 'password', 'class' => 'form-control', 'div' => 'form-group']); ?>
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
                        <?php else: ?>
                            <?php echo $this->Form->input('IvrCliente.id'); ?>
                        <?php endif; ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <h3>Domicilio</h3>
                                </div>
                                <?php echo $this->Form->input('ivr_cliente_id', array('type' => 'hidden')); ?>
                                <?php echo $this->Form->input('telefono', array('type' => 'hidden')); ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->input('domicilio', array(
                                            'label' => __('Domicilio'),
                                            'class' => 'form-control',
                                        ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->input('es_principal', array(
                                            'options' => $si_no,
                                            'class' => 'form-control'
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->input('observaciones', array(
                                            'label' => __('Observaciones'),
                                            'class' => 'form-control'
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-right">
                                <div class="btn-group">
                                    <?php
                                    echo $this->Form->button(__('Confirmar'), array(
                                            'class' => 'btn btn-sm btn-default'
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



