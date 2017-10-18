<?php echo $this->element('maps_js')?>
<script type="text/javascript">
    $(document).ready(function() {
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

        $.validator.addMethod("regex", function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Please check your input.");
        var validator = $('#ViajeAdminAddForm').validate({
            errorPlacement: function(error, element) {
                element.parent().after(error);
            },
            rules: {
                "data[Viaje][dir_origen]": {
                    required: true,
                    regex: /.{3,30} [0-9]{1,5}, .{3,30}, .{3,30}/
                }
            },
            messages: {
                "data[Viaje][dir_origen]": {
                    required: "Debes ingresar una dirección de origen",
                    regex: 'Dirección inválida ej: "San Martín 1234, Santa Fe, Argentina"'
                }
            }
        });
    });
</script>
<div class="container pt15 pb15">
    <?php echo $this->Form->create('Viaje'); ?>
    <div class="row">
        <section id = "content" class="col-md-12">
            <div class="col-sm-4">
                <div>
                    <?php echo $this->Form->input('dir_origen', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Origen', 'div' => false)); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <?php $style = empty($vehiculo_id) ? '' : 'display: none;'; ?>
                <?php echo $this->Form->input('vehiculo_id', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'style' => $style, 'options' => $conductors, 'empty' => __('Móvil mas cercano'))); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $this->Form->submit(__('Confirmar'), array('id' => 'reservar', 'class' => 'btn btn-sm btn-default', 'div' => false)); ?>
            </div>
        </section>
    </div>
    <?php echo $this->Form->end(); ?>
</div>