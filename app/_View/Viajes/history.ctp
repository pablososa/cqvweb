<script type="text/javascript">
    $(document).ready(function () {
//        $('.slide-down-fixed').fixedSlideDown(); on('click') blah blah blah
//        $('.details').fixedSlideDown();
    });
</script>
<?php
if ($last) {
    echo $this->element('menus/empresas', array('active' => 'viajes:historyLast'));
} else {
    echo $this->element('menus/empresas', array('active' => 'viajes:history'));
}
?>

<section>
    <div class="container-fluid">
        <?php echo $this->element('title', ['title' => __('Historial de viajes')]); ?>
        <?php echo $this->element('default_search', ['type' => 'Viaje']); ?>
        <?php echo $this->element('loader'); ?>
        <div class="row">
            <div id="content" class="col-xs-12">
                <?php if (empty($viajes)) : ?>
                    <?php echo $this->element('no_se_econtraron', ['not_found' => __('viajes')]); ?>
                <?php else: ?>
                    <table class="table table-hover table-striped">
                        <?php
                        $tableHeaders = $this->Html->tableHeaders(
                            array(
                                $this->Paginator->sort('Usuario.apellido', __('Pasajero')),
                                $this->Paginator->sort('Conductor.apellido', __('Conductor')),
                                $this->Paginator->sort('date', __('Fecha')),
                                $this->Paginator->sort('distancia', __('Distancia')),
                                $this->Paginator->sort('tarifa', __('Importe')),
                                $this->Paginator->sort('dir_origen', __('Origen')),
                                $this->Paginator->sort('dir_destino', __('Destino')),
                                $this->Paginator->sort('estado', __('Estado')),
                                __('Acciones')
                            ), array(
                                'id' => 'titulos'
                            )
                        );
                        echo $tableHeaders;
                        ?>
                        <?php foreach ($viajes as $viaje) : ?>
                            <tr>
                                <td><?php echo $viaje['Usuario']['apellido'] . ((empty($viaje['Usuario']['apellido']) || empty($viaje['Usuario']['nombre'])) ? '' : ', ') . $viaje['Usuario']['nombre']; ?></td>
                                <td><?php echo $viaje['Conductor']['apellido'] . ((empty($viaje['Conductor']['apellido']) || empty($viaje['Conductor']['nombre'])) ? '' : ', ') . $viaje['Conductor']['nombre']; ?></td>
                                <td><?php echo utils::datetimetize($viaje['Viaje']['date']); ?></td>
                                <td><?php echo (float) $viaje['Viaje']['distancia']/1000; ?></td>
                                <td><?php echo $viaje['Viaje']['tarifa']; ?></td>
                                <td><?php echo $viaje['Viaje']['dir_origen']; ?></td>
                                <td><?php echo $viaje['Viaje']['dir_destino']; ?></td>
                                <td><?php echo $viaje['Viaje']['estado']; ?></td>
                                <td>
                                    <?php if (!empty($viaje['ViajesHistorial'])): ?>
                                        <?php echo $this->Html->link(__('Detalles'), '#', array('class' => 'slide-down-fixed ')); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if (!empty($viaje['ViajesHistorial'])): ?>
                                <tr class="hidden-fixed-slide-down">
                                    <td>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php echo $this->element('viajes' . DS . 'viajes_historial', ['viajeHistorials' => $viaje['ViajesHistorial']]); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                    <?php echo $this->element('paginator'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php echo $this->Js->writeBuffer(); ?>