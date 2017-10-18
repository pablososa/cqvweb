<?php echo $this->element('maps_js')?>
<?php echo $this->element('menus/empresas', array('active' => 'empresas:config')) ?>
<script>
    $(document).ready(function () {

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


        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Empresa', array('novalidate', 'enctype' => 'multipart/form-data')); ?>
            <?php
            echo $this->Form->input('id');
            echo $this->Form->input('Tipoempresa.id');
            ?>
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


            <div class = "row">
             
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <label><?php echo __('Despacho automatico'); ?></label>
                            <div style="">
                                <?php echo $this->Form->input('Empresa.despacho_auto', array('type' => 'checkbox', 'label' => false, 'class' => 'form-control sm')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                   <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            
                        </div>
                    </div>
                </div>

            </div>


<br><br><br>
            <div class = "col-md-6">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array('action' => 'visualization'), array('class' => 'btn btn-sm btn-default'));
                    echo $this->Form->button(__('Confirmar'), array('class' => 'btn btn-sm btn-default'));
                    ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
