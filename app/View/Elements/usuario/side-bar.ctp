<div class="buttons-top">
    <div class="link">
        <?php echo $this->Html->link('Tus trayectos', ['controller' => 'viajes', 'action' => 'viewPending'], ['class' => 'btn btn-primary' . (!empty($renderReservationForm) ? ' active' : '')]); ?>
    </div>
    <div class="link">
        <?php echo $this->Html->link('Cuenta', ['controller' => 'usuarios', 'action' => 'miPerfil'], ['class' => 'btn btn-primary' . (empty($renderReservationForm) ? ' active' : '')]); ?>
    </div>
</div>
<div class="menu-user">
    <?php if (empty($renderReservationForm)): ?>
        <h4><?php echo __('Información de la cuenta'); ?></h4>
    <?php echo $this->element('menus' . DS . 'usuario'); ?>
    <?php else: ?>
        <div class="crear-viaje-form-container">
            <h4><?php echo __('Ordena un IUNIKE'); ?></h4>
            <?php echo $this->Form->create('Viaje', ['url' => ['controller' => 'viajes', 'action' => 'add']]); ?>
            <?php echo $this->Form->input('Viaje.dir_origen', ['label' => 'Desde', 'placeholder' => 'Calle, hotel, compañia, etc...']); ?>
            <?php echo $this->Form->input('Viaje.dir_destino', ['label' => 'Hacia', 'placeholder' => 'Calle, hotel, compañia, etc...']); ?>
            <?php echo $this->Form->input('Viaje.aaa', ['label' => false, 'options' => ['Lo antes posible']]); ?>
            <div class="input">
                <i class="fa fa-car" aria-hidden="true"></i>
                Elige tu trayecto
            </div>
            <?php echo $this->Form->input('Viaje.aaa', ['label' => false, 'options' => ['Para mi']]); ?>
            <?php echo $this->Form->input('Viaje.observaciones', ['label' => false, 'placeholder' => 'Mensaje opcional para conductor']); ?>
            <div class="input">
                <label>Precio estimado
                    <span class="precio-estimado-container">
                        $
                        <span class="precio-estimado">0</span>
                    </span>
                </label>
                <input disabled type="text" class="precio-estimado-error" value="No se ha podido estimar el precio"/>
            </div>
            <?php echo $this->Form->submit('Ordenar', ['class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="info-viaje-container">
            <h4><?php echo __('Información del viaje'); ?></h4>

            <div class="info-viaje">
                <div class="input text conductor">
                    <label>Conductor</label>

                    <div class="info">
                        -
                    </div>
                </div>
                <div class="input text vehiculo">
                    <label>Vehículo</label>

                    <div class="info marca">
                        -
                    </div>
                    <div class="info patente">
                        -
                    </div>
                </div>
                <div class="input text distancia">
                    <label>Distancia</label>

                    <div class="info">
                        -
                    </div>
                </div>
                <?php echo $this->Html->link('Cancelar viaje', ['controller' => 'viajes', 'action' => 'cancelarViaje'], ['class' => 'btn btn-primary cancelar-viaje'], __('¿Está seguro de cancelar el viaje?')); ?>
            </div>
        </div>
    <?php echo $this->element('maps_js') ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#ViajeDirOrigen').directionSearch('Calle 45 375, La Plata, Buenos Aires, Argentina');
                $('#ViajeDirDestino').directionSearch('Calle 45 375, La Plata, Buenos Aires, Argentina');
            });
        </script>
    <?php endif; ?>
</div>