<?php echo $this->element('menus/empresas', array('active' => 'viaje_programados:index')); ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Viajes programados')]); ?>
            <?php echo $this->element('default_search', ['type' => 'ViajeProgramado']); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($viajeProgramados)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('viajes programados')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php echo $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('IvrDomicilio.domicilio', __('Dirección')),
                                    $this->Paginator->sort('lunes', __('Días')),
                                    $this->Paginator->sort('hora', __('Hora')),
                                    $this->Paginator->sort('fecha_desde', __('Fecha Desde')),
                                    $this->Paginator->sort('fecha_hasta', __('Fecha Hasta')),
                                    __('Acciones')
                                ), array(
                                    'id' => 'titulos'
                                )
                            );
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            $nombreDias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                            foreach ($viajeProgramados as $viajeProgramado) {
                                $actions = $this->Html->link(__('Editar'), array('action' => 'edit', $viajeProgramado['ViajeProgramado']['id']));
                                $actions .= $spacer . $this->Form->postLink(__('Borrar'), array('action' => 'delete', $viajeProgramado['ViajeProgramado']['id']), null, __('¿Está seguro que desea borrar el viaje programado?'));
                                $dias = [];
                                foreach ($nombreDias as $nombreDia) {
                                    if (!empty($viajeProgramado['ViajeProgramado'][$nombreDia])) {
                                        $dias[] = ucfirst($nombreDia);
                                    }
                                }

                                $rows[] = array(
                                    $viajeProgramado['IvrDomicilio']['domicilio'],
                                    implode('&nbsp;&bull;&nbsp;', $dias),
                                    $viajeProgramado['ViajeProgramado']['hora'],
                                    Utils::datetize($viajeProgramado['ViajeProgramado']['fecha_desde']),
                                    Utils::datetize($viajeProgramado['ViajeProgramado']['fecha_hasta']),
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