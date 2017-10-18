<?php echo $this->element('menus/empresas', array('active' => 'viaje_diferidos:index')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Viajes diferidos')]); ?>
            <?php echo $this->element('default_search', ['type' => 'ViajeProgramado']); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($viajeProgramados)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('viajes diferidos')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php echo $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('fecha_desde', __('Fecha')),
                                    $this->Paginator->sort('hora', __('Hora')),
                                    $this->Paginator->sort('IvrCliente.apellido', __('Cliente')),
                                    $this->Paginator->sort('IvrDomicilio.domicilio', __('Origen')),
                                    $this->Paginator->sort('dir_destino', __('Destino')),
                                    __('Telefono'),
                                    __('Móvil'),
                                    __('Acciones')
                                ), array(
                                    'id' => 'titulos'
                                )
                            );
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            foreach ($viajeProgramados as $viajeProgramado) {
                                $actions = $this->Html->link(__('Editar'), array('action' => 'edit', $viajeProgramado['ViajeProgramado']['id']));
                                $actions .= $spacer . $this->Form->postLink(__('Borrar'), array('action' => 'delete', $viajeProgramado['ViajeProgramado']['id']), null, __('¿Está seguro que desea borrar el viaje diferido?'));

                                $rows[] = array(                                  
                                    Utils::datetize($viajeProgramado['ViajeProgramado']['fecha_desde']),
                                    $viajeProgramado['ViajeProgramado']['hora'],
                                    $viajeProgramado['IvrCliente']['apellido'],
                                    $viajeProgramado['IvrDomicilio']['domicilio'],
                                    $viajeProgramado['ViajeProgramado']['dir_destino'],
                                    $viajeProgramado['IvrCliente']['telefono'],
                                    $viajeProgramado['Vehiculo']['nro_registro'],
                                    $actions
                                );
                            }
                            echo $this->Html->tableCells($rows, array('id' => 'filas'), array('id' => 'filas')); ?>
                        </table>
                        <?php echo $this->element('paginator'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php echo $this->Js->writeBuffer(); ?>