<?php echo $this->element('maps_js')?>
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
                                    </div>
                                </div>
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
