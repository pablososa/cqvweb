<?php echo $this->element('menus/empresas', array('active' => 'viajes:adminHistory')); ?>

<?php echo $this->element('maps_js')?>
<script type="text/javascript">
    if (typeof window.adminHistory == 'undefined') {
        window.adminHistory = true;
        window.empresa_id = <?php echo $empresa["Empresa"]["id"];?>;
        window.NODE_EVENT_SERVER_URL = "<?php echo NODE_EVENT_SERVER_URL;?>"
        $(document).ready(function () {
            var geocoder = new google.maps.Geocoder();
            $("#ViajeAdminAddForm").submit(function () {
                $(this).submit(function () {
                    return false;
                });
                return true;
            });
            $('#calcular').parent().tooltip();

            $('#ViajeDirOrigen').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');
            $('#ViajeDirDestino').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');

            var lat_o = false;
            var lng_o = false;
            var lat_d = false;
            var lng_d = false;
            $('body').on('change', '#ViajeDirOrigen', function () {
                if ($('#ViajeDirOrigen').val()) {
                    geocoder.geocode({'address': $('#ViajeDirOrigen').val()}, function (response, status) {
                        if (status == 'OK') {
                            lng_o = response[0].geometry.location.lng();
                            lat_o = response[0].geometry.location.lat();
                        } else {
                            lng_o = false;
                            lat_o = false;
                        }
                        calcularPrecio(lat_o, lng_o, lat_d, lng_d);
                    });
                } else {
                    lng_o = false;
                    lat_o = false;
                }
                calcularPrecio(lat_o, lng_o, lat_d, lng_d);
            });
            $('body').on('change', '#ViajeDirDestino', function () {
                if ($('#ViajeDirDestino').val()) {
                    geocoder.geocode({'address': $('#ViajeDirDestino').val()}, function (response, status) {
                        if (status == 'OK') {
                            lng_d = response[0].geometry.location.lng();
                            lat_d = response[0].geometry.location.lat();
                        } else {
                            lng_d = false;
                            lat_d = false;
                        }
                        calcularPrecio(lat_o, lng_o, lat_d, lng_d);
                    });
                } else {
                    lng_d = false;
                    lat_d = false;
                }
                calcularPrecio(lat_o, lng_o, lat_d, lng_d);
            });

            function calcularPrecio(lat_o, lng_o, lat_d, lng_d) {
                var precio = false;
                if (lat_o && lng_o && lat_d && lng_d) {
                    var tipoempresa = <?php echo json_encode($empresa['Tipoempresa']); ?>;
                    //var distancia = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(lat_o, lng_o), new google.maps.LatLng(lat_d, lng_d));
					var distancia = calcularDistancia(lat_o,lat_d,lng_o,lng_d)*1000;
	                   
$('#ViajeDistancia').val(distancia);
					//alert("google: "+distancia);
					//alert("manual: "+distancia2);
                    precio = parseFloat(tipoempresa.bajada) + (parseFloat(distancia) / parseFloat(tipoempresa.metros)) * parseFloat(tipoempresa.ficha);
                }
                setPrecio(precio);
            }

            function setPrecio(precio) {
                if (precio) {
                    $('.precio').html(Math.round(precio.toFixed(2)));
                    $('.precio-container').show();
                } else {
                    $('.precio-container').hide();
                }
            }

            $('#ViajeDirOrigen, #ViajeDirDestino').change();

            $('body').on('click', 'a.reasignar', function (e) {
                e.preventDefault();
                apptaxiweb.popup($(this).attr('href'));
            });
            $('body').on('click', 'a.js-create-viaje', function (e) {
                e.preventDefault();
                apptaxiweb.popup($(this).attr('href'));
            });
            $('#ViajeDirOrigen').keydown(function (e) {
                if (e.which == 13 && $('.pac-container:visible').length)
                    return false;
            });

            /** updateViajes **/
            window.tryedToReload = false;
            window.updateViajes = function () {
                if (!window.preventReloading) {
                    $('#ViajeAdminHistoryForm input[type="submit"]').click();
                } else {
                    window.tryedToReload = true
                }
            }
            window.subscribe(['<?php echo NODE_EVENT_viaje_created; ?>', '<?php echo NODE_EVENT_viaje_status_changed; ?>'], updateViajes);
            setInterval(updateViajes, 35000);
            /** updateViajes **/

            /** updateDespachoPendientes **/
            function updateDespachoPendientes() {
                var options = {};
                options.url = '<?php echo Router::url(array('controller' => 'viajes', 'action' => 'ajaxGetDespachoPendientes')); ?>';
                options.success = function (data) {
                    $('.pendientes').html(data);
                };
                $.ajax(options);
            }

            window.subscribe('<?php echo NODE_EVENT_ivr_despacho_pendiente; ?>', updateDespachoPendientes);
            updateDespachoPendientes();
            setInterval(updateDespachoPendientes, 120000);
            /** updateDespachoPendientes **/

            /** updateIVR **/
            function updateIVR() {
                var url = '<?php echo Router::url(array('controller' => 'viajes', 'action' => 'getIVRLlamadasEntrantes'))?>';
                var options = {
                    url: url,
                    success: function (data) {
                        $('.cont-table-llamadas-entrantes').html($(data).html());
                    }
                };
                $.ajax(options);
            }

            window.subscribe('<?php echo NODE_EVENT_ivr_llamada_entrante; ?>', updateIVR);
            setInterval(updateIVR, 120000);
            /** updateIVR **/
        });
    }

/**
 * Función para calcular la distancia entre dos puntos.
 *
 * @param lat1 = Latitud del punto de origen
 * @param lat2 = Latitud del punto de destino
 * @param lon1 = Longitud del punto de origen
 * @param lon2 = Longitud del punto de destino
 */
function calcularDistancia(lat1, lat2, lon1, lon2){
    var R = 6371; // Radio del planeta tierra en km
    var phi1 = lat1.toRadians();
    var phi2 = lat2.toRadians();
    var deltaphi = (lat2-lat1).toRadians();
    var deltalambda = (lon2-lon1).toRadians();

    var a = Math.sin(deltaphi/2) * Math.sin(deltaphi/2) +
            Math.cos(phi1) * Math.cos(phi2) *
            Math.sin(deltalambda/2) * Math.sin(deltalambda/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

    var d = R * c
    return d;
}

/**
* Prototype para pasar a Radianes
*/
if(typeof Number.prototype.toRadians == 'undefined'){
  Number.prototype.toRadians = function() {
    return this * Math.PI / 180;
  }
}
</script>
<section>
    <div class="container-fluid">
        <?php echo $this->element('title', ['title' => __('Crear viaje')]); ?>
        <?php echo $this->element('viajes' . DS . 'ivr_llamadas_entrantes', compact('ivr_llamada_entrantes')); ?>
        <div class="pendientes">
        </div>

        <?php $puede_asignar_moviles_determinados = $empresa['Operador']['configs']['puede_asignar_moviles_determinados']; ?>
        <?php echo $this->Form->create('Viaje', array('action' => 'adminAdd')); ?>
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <?php echo $this->Form->input('dir_origen', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Origin', 'div' => false)); ?>
                </div>
                <br>

                <div>
                    <?php echo $this->Form->input('dir_destino', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Destination', 'div' => false)); ?>
                    <br>
                </div>
            </div>
            <div class="col-sm-4">
                <?php if ($puede_asignar_moviles_determinados): ?>
                    <div>
                        <?php $style = empty($vehiculo_id) ? '' : 'display: none;'; ?>
                        <?php echo $this->Form->input('vehiculo_id', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'style' => $style, 'options' => $conductors, 'empty' => __('Vehiculo más cercano'))); ?>
                    </div>
                <?php endif; ?>
                <br>

                <div>
                    <?php echo $this->Form->input('tipo_de_auto', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'options' => $tipos_de_auto, 'empty' => __('Cualquier gama'))); ?>
                </div>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <?php echo $this->Form->input('observaciones', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'placeholder' => __('Observaciones'))); ?>
                <br>
            </div>
            <div class="col-sm-2">
                <div class="btn btn-success precio-container" style="display: none;">
                    Precio:
                    <b class="precio"></b>
                    $
                </div>
            </div>
            <div class="col-sm-2 text-right">
                <?php echo $this->Form->submit(__('Aceptar'), array('id' => 'reservar', 'class' => 'btn btn-primary', 'div' => false)); ?>
                <br>
            </div>
        </div>
        <div class="row marg-15-res">
        </div>
        <?php echo $this->Form->end(); ?>

        <?php echo $this->element('default_search', ['type' => 'Viaje']); ?>
        <?php echo $this->element('loader'); ?>
        <?php echo $this->element('viajes' . DS . 'admin_history', ['viajes' => $viajes, 'mostrar_mensajes' => true]); ?>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        var timeout = false;
        window.preventReloading = 0;
        $('a.slide-down').click(function () {
            var $this = $(this);
            if (timeout) {
                clearTimeout(timeout);
                timeout = false;
            }
            if ($this.data('slided-down')) {
                window.preventReloading++;
                timeout = setTimeout(function () {
                    window.preventReloading--;
                    if (window.tryedToReload) {
                        window.updateViajes();
                    }
                }, 60000)
            } else {
                window.preventReloading--;
            }
        });
    });
</script>
