<script>
    window.NODE_EVENT_SERVER_URL = "<?php echo NODE_EVENT_SERVER_URL;?>"
    $(document).ready(function () {
        var directionsDisplay = null;
        var directionsService = null;
        var map = null;
        var pasajero = null;
        var taxi = null;
        var current_viaje = false;

        setBlocker('__unknown__');

        function initialize(data) {
            var mapOptions = {};
            if (typeof data != 'undefined' && typeof data.Viaje != 'undefined') {
                mapOptions.center = new google.maps.LatLng(data.Viaje.latitud_origen, data.Viaje.longitud_origen);
                mapOptions.zoom = 17;
            } else {
                mapOptions.center = new google.maps.LatLng(-34.9073627, -57.94949729999996);
                if (typeof navigator != 'undefined' && typeof navigator.geolocation != 'undefined') {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        if(typeof map == 'undefined') {
                            mapOptions.center = center;
                        } else {
                            map.setCenter(center);
                        }
                    });
                }
                mapOptions.zoom = 14;
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            directionsDisplay = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });

            directionsService = new google.maps.DirectionsService();
        }

        initialize();

        function ajustarZoom(client_lat, client_lng, taxi_lat, taxi_lng) {
            if (!taxi_lat) {
                taxi_lat = client_lat;
                taxi_lng = client_lng;
            }
            var bounds = new google.maps.LatLngBounds();
            bounds.extend(new google.maps.LatLng(client_lat, client_lng));
            bounds.extend(new google.maps.LatLng(taxi_lat, taxi_lng));
            map.fitBounds(bounds);
        }

        function actualizarMapa(data) {
            if (pasajero === null) {
                pasajero = new google.maps.Marker({
                    position: new google.maps.LatLng(data.Viaje.latitud_origen, data.Viaje.longitud_origen),
                    map: map,
                    icon: '/img/pasajero.png',
                    title: 'Usted está aquí'
                });
            }
            if (data.Localizacion) {
                if (taxi === null) {
                    taxi = new google.maps.Marker({
                        position: new google.maps.LatLng(data.Localizacion.latitud, data.Localizacion.longitud),
                        map: map,
                        icon: '/img/vehiculo.png',
                        title: 'Su taxi'
                    });
                }
                taxi.setPosition(new google.maps.LatLng(data.Localizacion.latitud, data.Localizacion.longitud));

                var request = {
                    origin: new google.maps.LatLng(data.Localizacion.latitud, data.Localizacion.longitud),
                    destination: new google.maps.LatLng(data.Viaje.latitud_origen, data.Viaje.longitud_origen),
                    travelMode: google.maps.TravelMode.DRIVING
                };
                directionsService.route(request, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setMap(map);
                        directionsDisplay.setDirections(response);
                    } else {
                        ajustarZoom(data.Viaje.latitud_origen, data.Viaje.longitud_origen, data.Localizacion.latitud, data.Localizacion.longitud);
                    }
                });
            } else {
                directionsDisplay.setMap(null);
                ajustarZoom(data.Viaje.latitud_origen, data.Viaje.longitud_origen);
            }
        }

        function actualizarInfo(data) {
            if(data.Vehiculo.id == <?php echo SIN_VEHICULO_EN_ZONA; ?>) {
                $('.info-viaje .conductor .info').html('-');
                $('.info-viaje .vehiculo .info.marca').html('-');
                $('.info-viaje .vehiculo .info.patente').html('-');
            } else {
                $('.info-viaje .conductor .info').html(data.Conductor.apellido + ', ' + data.Conductor.nombre);
                $('.info-viaje .vehiculo .info.marca').html(data.Vehiculo.marca + ' ' + data.Vehiculo.modelo);
                $('.info-viaje .vehiculo .info.patente').html(data.Vehiculo.patente);
                if(typeof data.Info != 'undefined') {
                    $('.info-viaje .distancia .info').html(formatDistancia(data.Info.distancia));
                } else {
                    $('.info-viaje .distancia .info').html('-');
                }
            }
        }

        function formatDistancia(distancia) {
            var unit = 'mts';
            var fix = 0;
            if(distancia >= 1000) {
                unit = 'Km';
                distancia /= 1000;
                fix = 3;
            }
            return distancia.toFixed(fix) + ' ' + unit;
        }

        var socket = null;

        function actualizar() {
            var options = {
                url: '<?php echo Router::url(['controller' => 'viajes', 'action' => 'actualizar']); ?>',
                success: function (data) {
                    if (data.Viaje) {
                        hideForm();
                        current_viaje = true;
                        if (socket === null) {
                            socket = new ViajeSocket(data.Viaje.id).connect();
                            socket.on('viaje_status_changed', function () {
                                actualizar();
                            });
                        }
                        if(['Llegado', 'En_viaje'].indexOf(data.Viaje.estado) != -1) {
                            //alert("Su vehiculo ha llegado. Gracias por utilizar nuestro servicio");
                            $('.alert-success').html("Su vehiculo ha llegado. Gracias por utilizar nuestro servicio");
                        }
                        actualizarMapa(data);
                        actualizarInfo(data);
                        setBlocker(data.Viaje.estado);
                    } else if(current_viaje) {// ya estaba siguiendo un viaje y no vino mas
                        window.location = '<?php echo Router::url(['controller' => 'viajes', 'action' => 'canceled']); ?>';
                    } else {
                        showForm();
                        setBlocker();
                    }
                },
                complete: function () {
                    setTimeout(actualizar, 10000);
                }
            };
            $.ajax(options);
        }

        function hideForm() {
            $('.crear-viaje-form-container').hide();
            $('.info-viaje-container').show();
        }

        function showForm() {
            $('.crear-viaje-form-container').show();
            $('.info-viaje-container').hide();
        }

        function setBlocker(status) {
            status = typeof status == 'undefined' ? false : status;
            var text = false;
            switch(status) {
                case '__unknown__':
                    text = 'Consultando por el viaje<br>Por favor aguarde unos monentos.';
                    break;
                case 'Pendiente':
                case 'DelegandoApp':
                    text = 'Buscando un vehiculo para su viaje.<br>Este proceso puede tardar unos minutos.';
                    break;
                case 'Aceptado':
                case 'Ya_voy':
                case 'Llegado':
                    break;
                default:
                    if(status) {
                        console.log(status);
                    }
                    break;
            }
            if(text) {
                $('#blocker').show().html(text);
            } else {
                $('#blocker').hide().html('');
            }
        }

        actualizar();

        //--------- FORM ---------------------------------------
        var lat_o = false;
        var lng_o = false;
        var lat_d = false;
        var lng_d = false;
        var geocoder = new google.maps.Geocoder();
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
                var distancia = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(lat_o, lng_o), new google.maps.LatLng(lat_d, lng_d));
                precio = parseFloat(tipoempresa.bajada) + (parseFloat(distancia) / parseFloat(tipoempresa.metros)) * parseFloat(tipoempresa.ficha);
            }
            setPrecio(precio);
        }

        function setPrecio(precio) {
            if (precio) {
                $('.precio-estimado').html(precio.toFixed(2));
                $('.precio-estimado-error').val('').hide();
                $('.precio-estimado-container').show();
            } else {
                $('.precio-estimado').html('-');
                $('.precio-estimado-error').val('No se ha podido estimar el precio').show();
                $('.precio-estimado-container').hide();
            }
        }
        $('#ViajeDirOrigen').change();
        $('#ViajeDirDestino').change();

        //--------- FORM ---------------------------------------
    });
</script>
<div class="map-canvas-wrapper">
    <div id="map-canvas"></div>
</div>
<?php
if (!empty($viaje)) {
    echo $this->Html->link(__('Cancelar'), array('controller' => 'viajes', 'action' => 'cancelarViaje', $viaje['Viaje']['id']), array('class' => 'btn btn-sm btn-default'), "¿Está seguro que desea cancelar el viaje?");
}
?>
<div id="blocker"></div>
