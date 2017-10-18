<div class="row">
    <div id="content" class="col-xs-12">
        <?php if (empty($viajes)) : ?>
            <?php echo $this->element('no_se_econtraron', ['not_found' => __('viajes')]); ?>
        <?php else: ?>
            <table class="table table-hover table-striped table-admin-pendientes">
                <?php
                $ths = array(
                    $this->Paginator->sort('Vehiculo.nro_registro', __('Vehiculo')),
                    $this->Paginator->sort('Conductor.apellido', __('Conductor')),
                    $this->Paginator->sort('Viaje.fecha', __('Fecha')),
                    $this->Paginator->sort('Viaje.hora', __('Hora')),
                    $this->Paginator->sort('Viaje.dir_origen', __('Origen')),
                    $this->Paginator->sort('Viaje.estado', __('Estado')),
                    $this->Paginator->sort('Viaje.estado', __('Acción')),
                );
                echo $this->Html->tableHeaders($ths, array('id' => 'titulos'));
                ?>
                <?php foreach ($viajes as $viaje) : ?>
                    <?php
                    $tr_class = array();
                    $tr_class[] = 'viaje-' . strtolower($viaje['Viaje']['estado']);
                    if ($viaje['Viaje']['atrasado']) {
                        $tr_class[] = 'atrasado';
                    }
                    $tr_class = implode(' ', $tr_class);
                    ?>
                    <tr class="<?php echo $tr_class; ?>">
                        <td><?php echo $viaje['Vehiculo']['nro_registro']; ?></td>
                        <td><?php echo $viaje['Conductor']['apellido'] . ((empty($viaje['Conductor']['apellido']) || empty($viaje['Conductor']['nombre'])) ? '' : ', ') . $viaje['Conductor']['nombre']; ?></td>

                        <td><?php echo Utils::datetize($viaje['Viaje']['fecha']); ?></td>
                        <td><?php echo $viaje['Viaje']['hora'] . ' [' . $viaje['Viaje']['horareasig'] . ']'; ?></td>
                        <td><?php echo $viaje['Viaje']['dir_origen']; ?></td>
                        <td><?php
                            $reasig = '';
                            if (!empty($viaje['Viaje']['reasignar']) and empty($viaje['Viaje']['atrasado']) and $viaje['Viaje']['estado'] == 'Pendiente') {
                                $reasig = ' [' . __('Reasignar') . '] ';
                            }

                            echo $viaje['Viaje']['estado'] . $reasig . ($viaje['Viaje']['atrasado'] ? ' [' . __('Atrasado') . ']' : ''); ?></td>
                        <td class="actions">
                            <?php if (!empty($mostrar_mensajes)): ?>
                                <?php echo $this->Html->link(__('Mensajes'), array('controller' => 'mensajes', 'action' => 'getMensajes', $viaje['Vehiculo']['id']), array('class' => 'slide-down-target')) ?>
                            <?php endif; ?>
                            <?php if (!empty($viaje['Viaje']['observaciones']) or !empty($viaje['ViajesHistorial'])): ?>
                                <?php echo $this->Html->link(__('Detalles'), '#', ['class' => 'slide-down-fixed']); ?>
                            <?php endif; ?>
                            <?php echo $this->Html->link(__('Reasignar'), array('controller' => 'viajes', 'action' => 'reasignar', $viaje['Viaje']['id']), array('class' => 'reasignar')); ?>
                            <?php echo $this->Html->link(__('Cancelar'), array('controller' => 'viajes', 'action' => 'adminCancelarViaje', $viaje['Viaje']['id']), array(), __('¿Está seguro que desea cancelar el viaje?')); ?>
                            <?php echo $this->Html->link(__('Mapa'), array('controller' => 'empresas', 'action' => 'visualization', 'zoom_to' => $viaje['Vehiculo']['nro_registro'])); ?>
                        </td>
                    </tr>
                    <?php if (!empty($viaje['Viaje']['observaciones']) or !empty($viaje['ViajesHistorial'])): ?>
                        <tr class="hidden-fixed-slide-down">
                            <td>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5><?php echo __('Observaciones:'); ?></h5>
                                            <?php echo $viaje['Viaje']['observaciones']; ?>
                                        </div>
                                        <?php if (!empty($viaje['ViajesHistorial'])): ?>
                                            <div class="col-lg-8">
                                                <?php echo $this->element('viajes' . DS . 'viajes_historial', ['viajeHistorials' => $viaje['ViajesHistorial']]); ?>
                                            </div>
                                        <?php endif; ?>
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
