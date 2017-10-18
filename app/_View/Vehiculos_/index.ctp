<?php echo $this->element('menus/empresas', array('active' => 'vehiculos:index')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Vehiculos')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Vehiculo', 'buttons' => [[
                'text' => __('Crear vehiculo'),
                'controller' => 'vehiculos',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($vehiculos)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('vehiculos')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            $tableHeaders = $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('patente', __('Plate')),
                                    $this->Paginator->sort('nro_registro_numeric', __('Mobile')),
                                    $this->Paginator->sort('marca', __('Make')),
                                    $this->Paginator->sort('modelo', __('Model')),
                                    $this->Paginator->sort('habilitado', __('State')),
                                    $this->Paginator->sort('tipo_de_auto', __('Type')),
                                    __('Acciones'),
                                ), array(
                                    'id' => 'titulos'
                                )
                            );
                            echo $tableHeaders;
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            foreach ($vehiculos as $vehiculo) {
                                if ($vehiculo['Vehiculo']['habilitado'] == 'Habilitado') {
                                    $estado = $this->Html->Link(
                                        __('Deshabilitar'), array(
                                            'controller' => 'vehiculos',
                                            'action' => 'deshabilitar',
                                            $vehiculo['Vehiculo']['id']
                                        )
                                    );
                                } elseif ($vehiculo['Vehiculo']['habilitado'] == 'Deshabilitado') {
                                    $estado = $this->Html->Link(
                                        __('Habilitar'), array(
                                            'controller' => 'vehiculos',
                                            'action' => 'habilitar',
                                            $vehiculo['Vehiculo']['id']
                                        )
                                    );
                                } else {
                                    $estado = __('Eliminado');
                                }

                                $actions = $this->Html->link(__('Ver multas'), 'http://www.santafe.gov.ar', ['target' => '_blank']);
                                if ($vehiculo['Vehiculo']['habilitado'] != 'Eliminado') {
                                    $actions .= $spacer . $this->Html->link(__('Editar'), ['controller' => 'vehiculos', 'action' => 'edit', $vehiculo['Vehiculo']['id']]);
                                    $actions .= $spacer . $this->Html->link(__('Eliminar'), ['controller' => 'vehiculos', 'action' => 'delete', $vehiculo['Vehiculo']['id']], [], '¿Está seguro que desea eliminar el vehiculo ' . $vehiculo['Vehiculo']['modelo'] . ' - ' . $vehiculo['Vehiculo']['patente'] . '?');
                                }
                                $actions .= $spacer . $estado;

                                $rows[] = array(
                                    $vehiculo['Vehiculo']['patente'],
                                    $vehiculo['Vehiculo']['nro_registro'],
                                    $vehiculo['Vehiculo']['marca'],
                                    $vehiculo['Vehiculo']['modelo'],
                                    $vehiculo['Vehiculo']['habilitado'],
                                    $vehiculo['Vehiculo']['tipo_de_auto'],
                                    $actions
                                );
                            }
                            echo $this->Html->tableCells($rows, array('id' => 'filas'), array('id' => 'filas'));
                            ?>
                        </table>
                        <?php echo $this->element('paginator'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php echo $this->Js->writeBuffer(); ?>