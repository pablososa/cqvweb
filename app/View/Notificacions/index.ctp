<?php echo $this->element('menus/empresas', array('active' => 'notificacions:index')); ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Promociones')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Notificacion', 'buttons' => [[
                'text' => __('Crear notificacion'),
                'controller' => 'notificacions',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($notificaciones)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('notificaciones')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php echo $this->Html->tableHeaders(
                                array(
                                    
                                    $this->Paginator->sort('hora', __('Hora')),
                                    $this->Paginator->sort('lunes', __('Días')),
                                    $this->Paginator->sort('mensaje', __('Mensaje')),
                                    $this->Paginator->sort('fecha_desde', __('Desde')),
                                    $this->Paginator->sort('fecha_hasta', __('Hasta')),

                                    __('Acciones')
                                ), array(
                                    'id' => 'titulos'
                                )
                            );
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            $nombreDias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                            foreach ($notificaciones as $viajeProgramado) {
                                $actions = $this->Html->link(__('Editar'), array('action' => 'edit', $viajeProgramado['Notificacion']['id']));
                                $actions .= $spacer . $this->Form->postLink(__('Borrar'), array('action' => 'delete', $viajeProgramado['Notificacion']['id']), null, __('¿Está seguro que desea borrar la notificacion?'));
                                $dias = [];
                                foreach ($nombreDias as $nombreDia) {
                                    if (!empty($viajeProgramado['Notificacion'][$nombreDia])) {
                                        $dias[] = ucfirst($nombreDia);
                                    }
                                }

                                $rows[] = array(

                                    $viajeProgramado['Notificacion']['hora'],
                                    implode('&nbsp;&bull;&nbsp;', $dias),
                                    $viajeProgramado['Notificacion']['mensaje'],
                                    Utils::datetize($viajeProgramado['Notificacion']['fecha_desde']),
                                    Utils::datetize($viajeProgramado['Notificacion']['fecha_hasta']),
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