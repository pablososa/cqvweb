<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
    $(document).ready(function () {

        var input = document.getElementById('UsuarioDireccion');

        var options = {
            types: ['geocode'],
            componentRestrictions: {
                country: 'ar'
            }
        };

        var autocomplete = new google.maps.places.Autocomplete(input, options);

        function geocodeResult(response, status) {
            if (status == 'OK') {

            } else {
                alert('Dirección no válida.');
            }
        }
    });
</script>
<?php
$month_names = array(
    '01' => 'Enero',
    '02' => 'Febrero',
    '03' => 'Marzo',
    '04' => 'Abril',
    '05' => 'Mayo',
    '06' => 'Junio',
    '07' => 'Julio',
    '08' => 'Agosto',
    '09' => 'Septiembre',
    '10' => 'Octubre',
    '11' => 'Noviembre',
    '12' => 'Diciembre',
);
?>
<div class="content">
    <?php echo $this->Form->create('Usuario', array('enctype' => 'multipart/form-data')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo __('Registrarse'); ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $this->Form->input('nombre', array('label' => __('Nombre'), 'type' => 'text', 'class' => 'form-control required', 'placeHolder' => 'Nombre')); ?>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('apellido', array('label' => __('Apellido'), 'type' => 'text', 'class' => 'form-control required', 'placeHolder' => 'Apellido')); ?>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('file', array('label' => __('Foto'), 'type' => 'file', 'class' => 'form-control')); ?>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('localidad_id', array('label' => __('Localidad'), 'class' => 'form-control', 'options' => $localidades)); ?>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('direccion', array('label' => __('Dirección'), 'type' => 'text', 'class' => 'form-control', 'placeHolder' => 'Dirección')); ?>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('fecha_nac', array('label' => __('Fecha de nacimiento'), 'class' => 'form-control required', 'dateFormat' => 'DMY', 'separator' => false, 'monthNames' => $month_names, 'empty' => true, 'minYear' => date('Y') - 90, 'maxYear' => date('Y') - 18)); ?>
            <br>
        </div>
        <div class="col-sm-2">
            <label><?php echo __('Característica'); ?></label>

            <div class="input-group phone">
                <span class="input-group-addon">0</span>
                <?php echo $this->Form->input('caracteristica', array('label' => false, 'type' => 'tel', 'id' => 'caract', 'class' => 'form-control required digits', 'placeHolder' => '342')); ?>
            </div>
            <br>
        </div>
        <div class="col-sm-4">
            <label><?php echo __('Teléfono'); ?></label>

            <div class="input-group phone">
                <span class="input-group-addon">15</span>
                <?php echo $this->Form->input('numero', array('label' => false, 'type' => 'tel', 'id' => 'numero', 'class' => 'form-control required digits', 'placeHolder' => '4567890')); ?>
            </div>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('email', array('label' => __('Email'), 'type' => 'email', 'class' => 'form-control required', 'placeHolder' => 'E-mail')); ?>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('pass', array('label' => __('Contraseña'), 'type' => 'password', 'class' => 'form-control required', 'placeHolder' => 'Contraseña')); ?>
            <br>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('pass1', array('label' => __('Confirmar contraseña'), 'type' => 'password', 'class' => 'form-control required', 'placeHolder' => 'Confirmar contraseña')); ?>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right" style="padding-top: 15px">
            <?php echo $this->Html->link(__('Cancelar'), ['controller' => 'usuarios', 'action' => 'login'], ['class' => 'btn btn-default']); ?>
            &nbsp;
            <?php echo $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>