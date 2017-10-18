<div class="row">
    <div class="col-xs-12">
        <h2><?php echo __('Trayectos'); ?></h2>
    </div>
    <div class="col-xs-12">
        <?php if (empty($viajes)): ?>
            <table class="table table-hover table-striped">
                <tr>
                    <td><?php echo __('No se han encontrado trayectos'); ?></td>
                </tr>
            </table>
        <?php else: ?>
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo $this->Paginator->sort('fecha_hora', __('Fecha')); ?></th>
                    <th><?php echo $this->Paginator->sort('dir_origen', __('Punto de inicio')); ?></th>
                    <th><?php echo $this->Paginator->sort('distancia', __('Distancia')); ?></th>
                    <th><?php echo $this->Paginator->sort('tarifa', __('Precio')); ?></th>
                </tr>
                <?php foreach ($viajes as $viaje): ?>
                    <tr>
                        <td><?php echo Utils::datetimetize($viaje['Viaje']['fecha_hora']); ?></td>
                        <td><?php echo $viaje['Viaje']['dir_origen']; ?></td>
                        <td><?php echo $viaje['Viaje']['distancia']; ?></td>
                        <td><?php echo '$' . $viaje['Viaje']['tarifa']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->element('paginator'); ?>
