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

        $.validator.addMethod("regex", function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Please check your input.");
        var validator = $('#ViajeAddForm').validate({
            errorPlacement: function(error, element) {
                element.parent().after(error);
            },
            submitHandler: function(form) {
                $('#blocker').html('Espere, por favor, mientras<br>se confirma su viaje');
                $('#blocker').show();
                $('#cancelar').attr('disabled', 'disabled');
                form.submit();
            },
            rules: {
                "data[Viaje][dir_origen]": {
                    required: true,
                    regex: /.{3,30} [0-9]{1,5}, .{3,30}, .{3,30}/
                },
                "data[Viaje][dir_destino]": {
                    required: true,
                    regex: /.{3,30} [0-9]{1,5}, .{3,30}, .{3,30}/
                },
                "data[Viaje][tarifa]": {
                    required: true
                }
            },
            messages: {
                "data[Viaje][dir_origen]": {
                    required: "Debes ingresar una dirección de origen",
                    regex: 'Dirección inválida ej: "San Martín 1234, Santa Fe, Argentina"'
                },
                "data[Viaje][dir_destino]": {
                    required: "Debes ingresar una dirección de destino",
                    regex: 'Dirección inválida ej: "San Martín 1234, Santa Fe, Argentina"'
                },
                "data[Viaje][tarifa]": {
                    required: 'Debes calcular el costo'
                }
            }
        });

        $('#calcular').click(function(e) {
            e.preventDefault();
            var valid_ViajeDirOrigen = $('#ViajeDirOrigen').valid();
            var valid_ViajeDirDestino = $('#ViajeDirDestino').valid();

            lng_o = false;
            lat_o = false;
            lng_d = false;
            lat_d = false;
            if (valid_ViajeDirOrigen && valid_ViajeDirDestino) {
                $('#ViajeTarifa').val('');
                geocoder.geocode({'address': $('#ViajeDirOrigen').val()}, function(response, status) {
                    if (status == 'OK') {
                        lng_o = response[0].geometry.location.lng();
                        lat_o = response[0].geometry.location.lat();
                        calcular_precio();
                    } else {
                        validator.showErrors({
                            "data[Viaje][dir_origen]": 'Dirección inválida ej: "San Martín 1234, Santa Fe, Argentina"'
                        });
                    }
                });
                geocoder.geocode({'address': $('#ViajeDirDestino').val()}, function(response, status) {
                    if (status == 'OK') {
                        lng_d = response[0].geometry.location.lng();
                        lat_d = response[0].geometry.location.lat();
                        calcular_precio();
                    } else {
                        validator.showErrors({
                            "data[Viaje][dir_destino]": 'Dirección inválida ej: "San Martín 1234, Santa Fe, Argentina"'
                        });
                    }
                });
            }
        });

        function calcular_precio() {
            if (lat_o && lng_o && lat_d && lng_d) {
                var tipoempresa = <?php echo json_encode($tipoempresa['Tipoempresa']); ?>;
                var distancia = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(lat_o, lng_o), new google.maps.LatLng(lat_d, lng_d));
                $('#ViajeDistancia').val(distancia);
                var precio = parseFloat(tipoempresa.bajada) + (parseFloat(distancia) / parseFloat(tipoempresa.metros)) * parseFloat(tipoempresa.ficha);
                $('#ViajeTarifa').val(precio.toFixed(2));
            }
        }
    });
</script>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo __($usuario['Usuario']['apellido'] . ', ' . $usuario['Usuario']['nombre']); ?> </h1>
                <h4><i> <?php echo __('Reserva'); ?> </i> </h4>
            </div>
            <div class="col-sm-6 hidden-xs">
                <ul id="navTrail">
                    <li><a href="/usuarios"> <?php echo __('Usuarios'); ?> </a></li>
                    <li id="navTrailLast"> <?php echo __('reservation'); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class="row">
        <?php echo $this->element('menus' . DS . 'usuario', array('active' => 'usuarios:reservation')); ?>
        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Viaje'); ?>
            <?php echo $this->Form->input('empresa_id', array('type' => 'hidden')); ?>
            <?php echo $this->Form->input('distancia', array('type' => 'hidden')); ?>
            <div class = "row">
                <div class = "col-md-6">
                    <div>
                        <?php echo $this->Form->input('dir_origen', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Origen', 'div' => false)); ?>
                    </div>
                    <div class="marg-15-res">
                        <?php echo $this->Form->input('dir_destino', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Destino', 'div' => false)); ?>
                    </div>
                    <div class="input-group input-group-lg marg-15-res">
                        <?php echo $this->Form->input('tarifa', array('label' => false, 'class' => 'form-control lg', 'readonly' => 'readonly', 'type' => 'text', 'div' => false, 'placeHolder' => 'Costo')); ?>
                        <span class="input-group-btn" data-placement="top" title="El costo es aproximado">
                            <button id="calcular" class="btn btn-sm"  type="submit" style="text-transform: none;">
                                Calcular
                            </button>
                        </span>
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class="form-group">
                        <?php echo $this->Form->input('observaciones', array('label' => false, 'type' => 'text', 'rows' => '6', 'class' => 'form-control lg', 'placeHolder' => 'Observaciones', 'div' => false)); ?>
                    </div>
                </div>
            </div>
            <div class = "row text-right marg-15-res">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array('controller' => 'usuarios', 'action' => 'reservation'), array('class' => 'btn btn-sm btn-default'));
                    echo $this->Form->submit(__('Confirmar'), array('id' => 'reservar', 'class' => 'btn btn-sm btn-default', 'div' => false));
                    ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>
<div id="blocker"></div>