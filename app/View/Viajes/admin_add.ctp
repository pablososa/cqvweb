<?php echo $this->element('maps_js');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#calcular').parent().tooltip();
        //var intervalo;
        var lat_o = false;
        var lat_d = false;
        var lng_o = false;
        var lng_d = false;

        $('#ViajeDirOrigen').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');

        $('#ViajeDirDestino').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');

        $.validator.addMethod("regex", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Please check your input.");
        var validator = $('#ViajeAdminAddForm').validate({
            errorPlacement: function (error, element) {
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
<?php if (empty($isIframe)): ?>
    <header class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1> <?php echo __((( isset($admin) ) ? 'Admin - ' : '') . $empresa['Empresa']['nombre']); ?> </h1>
                    <h4><i> <?php echo __('Vehiculo/Conductor'); ?> </i> </h4>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?>
<div class="container pt15 pb15">
    <div class="row">
        <?php if (empty($isIframe)): ?>
            <?php echo $this->element('menus/empresas', array('active' => 'viajes:adminAdd')) ?>
        <?php endif; ?>
        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Viaje'); ?>
            <?php echo $this->Form->input('empresa_id', array('type' => 'hidden')); ?>
            <?php echo $this->Form->input('des', array('type' => 'hidden','value' =>  $des )); ?>
            <?php echo $this->Form->input('des2', array('type' => 'hidden' )); ?>
            <div class = "row">
                <div class = "col-md-6">
                    <div>
                        <?php echo $this->Form->input('dir_origen', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Origen', 'div' => false)); ?>
                    </div>
                    <div class="marg-15-res">
                        <?php echo $this->Form->input('dir_destino', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Destino', 'div' => false)); ?>
                    </div>

                    <?php if ($empresa['Operador']['configs']['puede_asignar_moviles_determinados']): ?>
                        <?php $style = empty($vehiculo_id) ? '' : ' style="display: none;"'; ?>
                        <div class="marg-15-res"<?php echo $style; ?>>
                            <?php echo $this->Form->input('vehiculo_id', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'options' => $conductors, 'empty' => __('Móvil mas cercano'))); ?>
                        </div>
                    <?php endif; ?>
                    <div class="marg-15-res">
                        <?php echo $this->Form->input('observaciones', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'placeholder' => __('Observaciones')   )  ); ?>
                    </div>

                      <div class="marg-15-res">
                      Cuenta corriente: 
                        <?php echo $this->Form->input('cc', array('type' => 'checkbox','label' => false, 'div' => false, 'placeholder' => __('Cuenta corriente')   )  ); ?>
                          <?php
//                    echo $this->Html->link(__('Cancelar'), array('controller' => 'usuarios', 'action' => 'reservation'), array('class' => 'btn btn-sm btn-default'));
                    echo $this->Form->submit(__('Confirmar'), array('id' => 'reservar', 'style' => 'margin-left:200px' , 'class' => 'btn btn-sm btn-default', 'div' => false));
                    ?>
                    </div>

                </div>
            </div>
            <div class = "row text-right marg-15-res">
                <div class = "btn-group">

                  
                    
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>