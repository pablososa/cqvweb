<?php echo $this->element('menus/empresas', array('active' => 'empresas:visualization')) ?>


<?php echo $this->element('maps_js')?>
<script type="text/javascript">

    window.empresa_id = <?php echo $empresa["Empresa"]["id"];?>;
    //cambiar
    window.NODE_EVENT_SERVER_URL = "<?php echo NODE_EVENT_SERVER_URL;?>"
    var map;
    $(document).ready(function () {
        //var map;
        var geocoder;
        var markers = {};
        var central_lat;
        var central_lng;
        var zoom_status = false;
        var event_status = false;
        var configs = <?php echo json_encode(CakeSession::read('Empresa.Operador.configs')); ?>;

        function HomeControl(controlDiv, map) {
            // Set CSS styles for the DIV containing the control
            // Setting padding to 5 px will offset the control
            // from the edge of the map
            controlDiv.style.padding = '5px';

            // Set CSS for the control border
            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = 'white';
            controlUI.style.borderStyle = 'solid';
            controlUI.style.borderWidth = '2px';
            controlUI.style.cursor = 'pointer';
            controlUI.style.textAlign = 'center';
            controlUI.title = '';
            controlDiv.appendChild(controlUI);

            // Set CSS for the control interior
            var controlText = document.createElement('div');
            controlText.style.fontFamily = 'Arial,sans-serif';
            controlText.style.fontSize = '12px';
            controlText.style.paddingLeft = '4px';
            controlText.style.paddingRight = '4px';
            controlText.innerHTML = '<b>Activate Autozoom</b>';
            controlUI.appendChild(controlText);

            var controlUI2 = document.createElement('div');
            controlUI2.style.backgroundColor = 'white';
            controlUI2.style.borderStyle = 'solid';
            controlUI2.style.borderWidth = '2px';
            controlUI2.style.cursor = 'pointer';
            controlUI2.style.textAlign = 'center';
            controlUI2.title = '';
            controlDiv.appendChild(controlUI2);

            // Set CSS for the control interior
            var controlText2 = document.createElement('div');
            controlText2.style.fontFamily = 'Arial,sans-serif';
            controlText2.style.fontSize = '12px';
            controlText2.style.paddingLeft = '4px';
            controlText2.style.paddingRight = '4px';
            controlText2.innerHTML = '<b>Activate Events</b>';
            controlUI2.appendChild(controlText2);

            // Setup the click event listeners: simply set the map to
            // Chicago
            google.maps.event.addDomListener(controlUI, 'click', activar_autozoom);

            function activar_autozoom() {
                if (zoom_status) {
                    controlText.innerHTML = '<b>Activate Autozoom</b>';
                    zoom_status = false;
                } else {
                    ajustarZoom();
                    controlText.innerHTML = '<b>Deactivate Autozoom</b>';
                    zoom_status = true;
                }
            }

            // Setup the click event listeners: simply set the map to
            // Chicago
            google.maps.event.addDomListener(controlUI2, 'click', activar_eventos);

            function activar_eventos() {
                if (event_status) {
                    borrarEventos()
                    controlText2.innerHTML = '<b>Activate Events</b>';
                    event_status = false;
                } else {
                    mostrarEventos();
                    controlText2.innerHTML = '<b>Deactivate Events</b>';
                    event_status = true;
                }
            }
        }

        var mEvents = []
        var cEvents = []

        function mostrarEventos() {

            $.ajax({
                url: '/mapaTermicos/getEvents',
                dataType: 'json',
                success: function (eventos) {
                    reference_counters = {};
                    $.each(eventos, function (index, evento) {

                        var cant = evento.MapaTermico.cant_personas

                        var marker = new google.maps.Marker({
                            map: map,
                            title: evento.MapaTermico.descripcion + ' - ' + cant + ' Persons'
                        });
                        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png')
                        var color;
                        color = 'green';
                        if (cant > 200 && cant < 300) {
                            marker.setIcon('http://maps.google.com/mapfiles/ms/icons/yellow-dot.png')
                            color = 'yellow';
                        }
                        if (cant > 300) {
                            marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png')
                            color = 'red';
                        }
                        marker.setVisible(true);
                        var pos = new google.maps.LatLng(evento.MapaTermico.latitud, evento.MapaTermico.longitud);
                        marker.setPosition(pos);
                        mEvents.push(marker);

                        var circle = new google.maps.Circle({
                            strokeColor: color,
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: color,
                            fillOpacity: 0.35,
                            map: map,
                            center: pos,
                            radius: 100
                        });
                        cEvents.push(circle);

                        if ($('#event_to').val() == evento.MapaTermico.id) {
                            zoomToEvento(evento);
                        }

                    });

                }

            });
        }

        function borrarEventos() {
            for (var i = 0; i < mEvents.length; i++) {
                mEvents[i].setMap(null);
                cEvents[i].setMap(null);
            }
            mEvents = [];
            cEvents = [];
        }

        //funcion para ajustar el zoom
        function ajustarZoom() {
            var max_lat = central_lat;
            var max_lng = central_lng;
            var min_lat = central_lat;
            var min_lng = central_lng;
            for (var index in markers) {
                var marker = markers[index];
                var position = marker.getPosition();
                var visible = marker.getVisible();
                if (visible && position) {
                    var lat = position.lat();
                    var lng = position.lng();
                    if (lat > max_lat) {
                        max_lat = lat;
                    }
                    if (lng > max_lng) {
                        max_lng = lng;
                    }
                    if (lat < min_lat) {
                        min_lat = lat;
                    }
                    if (lng < min_lng) {
                        min_lng = lng;
                    }
                }
            }
            var bounds = new google.maps.LatLngBounds();
            bounds.extend(new google.maps.LatLng(max_lat, max_lng));
            bounds.extend(new google.maps.LatLng(max_lat, min_lng));
            bounds.extend(new google.maps.LatLng(min_lat, max_lng));
            bounds.extend(new google.maps.LatLng(min_lat, min_lng));
            map.fitBounds(bounds);
        }

        function zoomToVehiculo(vehiculo) {
            var bounds = new google.maps.LatLngBounds();
            var inc = 0.0017;
            var max_lat = parseFloat(vehiculo.Localizacion.latitud) + inc;
            var min_lat = parseFloat(vehiculo.Localizacion.latitud) - inc;
            var max_lng = parseFloat(vehiculo.Localizacion.longitud) + inc;
            var min_lng = parseFloat(vehiculo.Localizacion.longitud) - inc;
            bounds.extend(new google.maps.LatLng(max_lat, max_lng));
            bounds.extend(new google.maps.LatLng(max_lat, min_lng));
            bounds.extend(new google.maps.LatLng(min_lat, max_lng));
            bounds.extend(new google.maps.LatLng(min_lat, min_lng));
            map.fitBounds(bounds);
        }

        function zoomToEvento(evento) {
            var bounds = new google.maps.LatLngBounds();
            var inc = 0.0017;
            var max_lat = parseFloat(evento.MapaTermico.latitud) + inc;
            var min_lat = parseFloat(evento.MapaTermico.latitud) - inc;
            var max_lng = parseFloat(evento.MapaTermico.longitud) + inc;
            var min_lng = parseFloat(evento.MapaTermico.longitud) - inc;
            bounds.extend(new google.maps.LatLng(max_lat, max_lng));
            bounds.extend(new google.maps.LatLng(max_lat, min_lng));
            bounds.extend(new google.maps.LatLng(min_lat, max_lng));
            bounds.extend(new google.maps.LatLng(min_lat, min_lng));
            map.fitBounds(bounds);
        }

        function actualizarMarcadores(force_autozoom) {
            force_autozoom = (typeof force_autozoom) === 'undefined' ? false : true;
            $.ajax({
                url: '/vehiculos/getVehiculos',
                dataType: 'json',
                success: function (vehiculos) {
                    reference_counters = {};
                    $.each(vehiculos, function (index, vehiculo) {
                        var marcador = get_marcador(vehiculo);
                        if (marcador) {
                            marcador.setVisible(vehiculo.Vehiculo.visible);
                            if (vehiculo.Vehiculo.visible) {
                                if (typeof window.reference_counters[vehiculo.Vehiculo.color] === 'undefined') {
                                    reference_counters[vehiculo.Vehiculo.color] = 0;
                                }
                                reference_counters[vehiculo.Vehiculo.color]++;
                            }
                            if (vehiculo.Vehiculo.visible) {
                                marcador.setPosition(new google.maps.LatLng(vehiculo.Localizacion.latitud, vehiculo.Localizacion.longitud));
                                marcador.setIcon('/vehiculos/getIcon/' + vehiculo.Vehiculo.nro_registro + '/' + vehiculo.Vehiculo.color);
                            }
                            marcador.data = vehiculo;
                        }
                    });
                    if (zoom_status || force_autozoom) {
                        ajustarZoom();
                    }
                    if ($('#mobile').val() != '') {
                        $('#mobile').keyup();
                    }
                    if ($('#event_to').val() != '') {
                        mostrarEventos();

                    }
                    update_reference(reference_counters);
                },
                complete: function () {
                    setTimeout(actualizarMarcadores, 3000);
                }
            });
        }

        function update_reference(reference_counters) {
            $('#references .reference span.n').html(0);
            total = 0;
            for (var color in reference_counters) {
                $('#references .reference.' + color + ' span.number').html(reference_counters[color]);
                total += reference_counters[color];
            }
            $('#references .reference.total span.number').html(total);
        }

        function get_marcador(vehiculo) {
            if (typeof (markers[vehiculo.Vehiculo.id]) === 'undefined') {
                if (vehiculo.Localizacion.id) {
                    var marker = new google.maps.Marker({
                        map: map,
                        title: 'Nro. de móvil: ' + vehiculo.Vehiculo.nro_registro,
                        infoWindow: false
                    });
                    google.maps.event.addListener(marker, 'mouseover', function () {
                        if (!marker.infoWindow) {
                            var contentDiv = '<div class="marker-info-window">';
                            contentDiv += '<h4>Movil: ' + vehiculo.Vehiculo.nro_registro + '</h4>';
                            contentDiv += '<table>';
                            contentDiv += '<tr><th>Marca:</th><td>' + vehiculo.Vehiculo.marca + '</td></tr>';
                            contentDiv += '<tr><th>Modelo:</th><td>' + vehiculo.Vehiculo.modelo + '</td></tr>';
                            contentDiv += '<tr><th>Patente:</th><td>' + vehiculo.Vehiculo.patente + '</td></tr>';
                            contentDiv += '</table>'
                            contentDiv += '</div>'
                            marker.infowindow = new google.maps.InfoWindow({
                                content: contentDiv
                            });
                            marker.infowindow.open(map, marker);
                        }
                    });
                    google.maps.event.addListener(marker, 'mouseout', function () {
                        marker.infowindow.close();
                        marker.infowindow = false;
                    });
                    google.maps.event.addListener(marker, 'dblclick', function () {
                            if (marker.data.Localizacion.panico) {
                                var options = {
                                    title: 'Pánico',
                                    width: 600,
                                    height: 300
                                };
                                window.apptaxiweb.popup('/localizacions/removePanico/' + marker.data.Vehiculo.id, options);
                            } else if (marker.data.Localizacion.estado.toLowerCase() == 'libre' && configs.puede_asignar_moviles_determinados) {
                                console.log(configs.puede_asignar_moviles_determinados);
                                
                                window.apptaxiweb.popup('/viajes/adminAdd/' + marker.data.Vehiculo.id, {title: 'Asignar'});
                            }
                        }
                    );
                    marker.data = {};
                    markers[vehiculo.Vehiculo.id] = marker;
                }
            }
            return markers[vehiculo.Vehiculo.id];
        }

        function initialize() {
            var lat;
            var lng;
            var central;
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': $('#direccion').val()}, function (results) {
                lat = results[0].geometry.location.lat();
                lng = results[0].geometry.location.lng();
                central_lat = lat;
                central_lng = lng;
                var mapOptions = {
                    center: new google.maps.LatLng(lat, lng),
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                map.setOptions({disableDoubleClickZoom: true});
                google.maps.event.addListener(map, 'dblclick', function (event) {
                    var lat = event.latLng.lat();
                    var lng = event.latLng.lng();
                    if (lat && lng) {
                        var options = {
                            height: 310
                        };
                        window.apptaxiweb.popup('/viajes/adminAdd/0/' + lat + '/' + lng, options);
                    }
                });
                central = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lng),
                    map: map,
                    icon: '/img/parada.png',
                    title: 'Central'
                });
                var homeControlDiv = document.createElement('div');
                HomeControl(homeControlDiv, map);
                homeControlDiv.index = 1;
                map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
                actualizarMarcadores(true);
            });
            $('#mobile').keyup(function () {
                var nro_registro = $('#mobile').val();
                if (nro_registro === '') {
                    ajustarZoom();
                } else {
                    $.each(markers, function (index, value) {
                        var vehiculo = markers[index].data;
                        if (vehiculo.Vehiculo.visible && vehiculo.Vehiculo.nro_registro === nro_registro) {
                            zoomToVehiculo(vehiculo);
                            return false;
                        }
                    });
                }
            });
        }

        initialize();


    });

    function pantallacompleta() {
        //width: 100%; height: 100%; position: fixed;left: 0px; top:0px;z-index: 9999;
        document.getElementById("map_canvas").style.width = '100%';
        document.getElementById("map_canvas").style.height = '100%';
        document.getElementById("map_canvas").style.position = 'fixed';
        document.getElementById("map_canvas").style.left = '0px';
        document.getElementById("map_canvas").style.top = '0px';
        document.getElementById("map_canvas").style.zIndex = '10';
        google.maps.event.trigger(map, 'resize');
        activar_autozoom();
    }


</script>


<section id="content">
    <div class="container-fluid">
        <?php echo $this->element('title', ['title' => __('Visualización')]); ?>
        <div class="row">
            <div class='col-xs-12'>
                <?php echo $this->Form->create('Vehiculo'); ?>
                <div class="form-group input-group-lg">
                    <?php echo $this->Form->input('mobile', array('id' => 'mobile', 'label' => false, 'div' => false, 'class' => 'form-control lg', 'placeholder' => __('Buscar...'))); ?>
                </div>
                <?php echo $this->Form->input('event_to', array('id' => 'event_to', 'type' => 'hidden')); ?>
                <?php echo $this->Form->hidden('direccion', array('default' => $empresa['Empresa']['direccion'], 'id' => 'direccion')); ?>
                <hr>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div class="row">
            <div class='col-xs-12'>
                <table id='vehiculos' class="table table-bordered" hidden>
                    <?php
                    $rows = array();
                    foreach ($vehiculos as $vehiculo) {
                        $rows[] = array(
                            array(
                                $vehiculo['Localizacion']['id'],
                                array(
                                    'class' => 'id'
                                )
                            ),
                            array(
                                $vehiculo['Localizacion']['vehiculo_id'],
                                array(
                                    'class' => 'vehiculo_id'
                                )
                            ),
                            array(
                                $vehiculo['Localizacion']['latitud'],
                                array(
                                    'class' => 'latitud'
                                )
                            ),
                            array(
                                $vehiculo['Localizacion']['longitud'],
                                array(
                                    'class' => 'longitud'
                                )
                            ),
                            array(
                                $vehiculo['Localizacion']['estado'],
                                array(
                                    'class' => 'estado'
                                )
                            ),
                            array(
                                $vehiculo['Vehiculo']['nro_registro'],
                                array(
                                    'class' => 'nro_registro'
                                )
                            )
                        );
                    }
                    echo $this->Html->tableCells($rows);
                    ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="map_canvas" style="width: 100%; height: 600px"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div id="references">
                    <h3>References</h3>

                    <div class="reference verde">
                        <span class="color"></span>
                        <span class="name">Free:</span>
                        <span class="number">0</span>
                    </div>
                    <div class="reference amarillo">
                        <span class="color"></span>
                        <span class="name">Not Available/ On Request:</span>
                        <span class="number">0</span>
                    </div>
                    <div class="reference azul">
                        <span class="color"></span>
                        <span class="name">Assigned:</span>
                        <span class="number">0</span>
                    </div>
                    <div class="reference rojo">
                        <span class="color"></span>
                        <span class="name">Assigned:</span>
                        <span class="number">0</span>
                    </div>
                    <div class="reference total">
                        <span class="color"></span>
                        <span class="name">Total:</span>
                        <span class="number">0</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <span class="pantalla-completa btn btn-primary" style="cursor:pointer" onclick="pantallacompleta()">Pantalla Completa</span>
            </div>
        </div>
    </div>
</section>