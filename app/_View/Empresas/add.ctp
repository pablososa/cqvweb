<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
    $(document).ready(function() {

        var input = document.getElementById('EmpresaDireccion');

        var options = {
            types: ['geocode']
        };

        var autocomplete = new google.maps.places.Autocomplete(input, options);

        function geocodeResult(response, status) {
            if (status == 'OK') {
                confirmO = true;
                lng_o = response[0].geometry.location.B;
                lat_o = response[0].geometry.location.k;
                $('#EmpresaDireccion').attr('readonly', 'readonly');
            } else {
                alert('Dirección no válida.');
            }
        }
    });
</script>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> Admin </h1>
            </div>
            <div class="col-sm-6 hidden-xs">
                <ul id="navTrail">
                    <li><a href="admin"> <?php echo __('Admin'); ?> </a></li>
                    <li id="navTrailLast"> <?php echo __('Edición de empresas'); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row pt15">
        <?php echo $this->element('menus' . DS . 'admin', array('active' => 'empresas:view')); ?>
        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Empresa', array('novalidate', 'enctype' => 'multipart/form-data')); ?>
            <div class = "row">
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('nombre', array('label' => __('Nombre'), 'class' => 'form-control sm', 'type' => 'text')); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('file', array('label' => __('Avatar'), 'type' => 'file', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('cuit', array('label' => __('Cuil'), 'class' => 'form-control sm', 'type' => 'text number required')); ?>
                        </div>
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('localidad_id', array('label' => __('Localidad'), 'class' => 'form-control sm', 'options' => $localidades)); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('direccion', array('label' => __('Dirección'), 'class' => 'form-control sm', 'type' => 'text')); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('email', array('label' => __('Email'), 'class' => 'form-control sm', 'type' => 'email')); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('telefono', array('label' => __('Teléfono'), 'class' => 'form-control sm', 'type' => 'tel')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class = "row">
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php
                            $options = array(
                                'Taxi' => 'Taxi',
                                'Remis' => 'Remis'
                            );
                            echo $this->Form->input('Tipoempresa.tipo', array('label' => __('Tipo'), 'class' => 'form-control sm', 'options' => $options));
                            ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('Tipoempresa.bajada', array('type' => 'text', 'label' => __('Costo de bajada de bandera'), 'class' => 'form-control sm')); ?>
                        </div>
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('Tipoempresa.ficha', array('type' => 'text', 'label' => __('Costo de ficha'), 'class' => 'form-control sm')); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('Tipoempresa.metros', array('type' => 'text', 'label' => __('Metros'), 'class' => 'form-control sm')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class = "row">
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('pass', array('label' => __('Contaseña'), 'type' => 'password', 'class' => 'form-control', 'placeHolder' => 'Contraseña')); ?>
                        </div>
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('pass1', array('label' => 'Confirmar conrtaseña', 'type' => 'password', 'class' => 'form-control', 'placeHolder' => 'Confirmar conrtaseña')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class = "row">
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('Empresa.empresa_key', array('label' => __('Api Key'), 'class' => 'form-control sm')); ?>
                        </div>
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <label><?php echo __('Despacho admin'); ?></label>
                            <div style="padding-left: 30px;">
                                <?php echo $this->Form->input('Empresa.despacho_admin', array('type' => 'checkbox', 'label' => false, 'class' => 'form-control sm')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "row text-right">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array('action' => 'view'), array('class' => 'btn btn-sm btn-default'));
                    echo $this->Form->button(__('Confirmar'), array('class' => 'btn btn-sm btn-default'));
                    ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>