<?php 
 $si_no = array(
            '' => __('Elija una opción'),
            0 => __('No'),
            1 => __('Si'),
        );
echo $this->element('maps_js')?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#blocker').show();
        $.ajax({
            url: '/viajes/ajax_checkForPending?rand=' + Math.random(),
            success: function(data) {
                if (data.redirect_url) {
                    window.location = data.redirect_url;
                } else {
                    $('#blocker').hide();
                }
            }
        });
        $('#calcular').parent().tooltip();
        //var intervalo;
        var lat_o = false;
        var lat_d = false;
        var lng_o = false;
        var lng_d = false;

        var options = {
            types: ['geocode']
        };

        var geocoder = new google.maps.Geocoder();

        new google.maps.places.Autocomplete(document.getElementById('ViajeDirOrigen'), options);
        new google.maps.places.Autocomplete(document.getElementById('ViajeDirDestino'), options);
</script>

<?php echo $this->element('menus/empresas', array('active' => 'ivr_clientes:index')) ?>


<section id="content" class="">
    <div id="page-wrapper">

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="">
                    <h1 class="page-header">
                        <?php echo __('Crear cliente'); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <?php echo __('Crear cliente'); ?>
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
                                <?php echo $this->Form->input('back_to', ['type' => 'hidden', 'value' => 1]); ?>
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


  <div class="col-xs-12">
                                    <h3>Domicilio</h3>
                                </div>
                                <?php echo $this->Form->input('ivr_cliente_id', array('type' => 'hidden')); ?>
                                <?php echo $this->Form->input('telefono_alt', array('type' => 'hidden')); ?>
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

                            <div class="row">
                              
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
