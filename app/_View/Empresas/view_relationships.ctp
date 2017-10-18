<?php echo $this->element('menus/empresas', array('active' => 'empresas:viewRelationships')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Vehiculo/Conductor')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Conductor']); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($relaciones)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('conductores asignados a un vehiculo en este momento')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            $options = array(
                                $this->Paginator->sort('name', __('Conductor')),
                                $this->Paginator->sort('Vehiculo.nro_registro', __('Nro de Móvil')),
                                $this->Paginator->sort('Vahiculo.patente', __('Patente')),
                                $this->Paginator->sort('fecha_hora_inicio', __('Fecha Inicio')),
                                __('Acciones')
                            );
                            echo $this->Html->tableHeaders($options, array('id' => 'titulos'));
                            $rows = array();
                            foreach ($relaciones as $relacion) {
                                $rows[] = array(
                                    $relacion['Conductor']['name'],
                                    $relacion['Vehiculo']['nro_registro'],
                                    $relacion['Vehiculo']['patente'],
                                    Utils::datetimetize($relacion['Conductor']['fecha_hora_inicio']),
                                    $this->Html->link(__('Cerrar Sesión'), array('controller' => 'historialvcs', 'action' => 'closeSession', $relacion['Historialvcs']['id']))
                                );
                            }
                            echo $this->Html->tableCells($rows);
                            ?>
                        </table>
                        <?php echo $this->element('paginator'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php echo $this->Js->writeBuffer(); ?>