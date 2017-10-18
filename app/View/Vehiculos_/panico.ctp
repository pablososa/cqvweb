<div class="panic">
    <section id="content">
        <?php echo $this->Form->create('Vehiculo'); ?>
        <div class="image">
        </div>
        <table class="text">
            <tr>
                <td>
                    <?php foreach ($vehiculos as $vehiculo) : ?>
                        <p>
                            <?php echo __('Atención vehículo %s (patente %s) ha precionado el botón de pánico.', $vehiculo['Vehiculo']['nro_registro'], $vehiculo['Vehiculo']['patente']); ?>
                            <?php echo $this->Form->hidden('ids', array('name' => 'data[Vehiculo][ids][]', 'type' => 'hidden', 'value' => $vehiculo['Vehiculo']['id'])); ?>
                        </p>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>
        <div class="row text-center">
            <div class="btn-group">
                <?php echo $this->Form->button(__('Aceptar'), array('class' => 'btn btn-sm btn-default')); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </section>
</div>