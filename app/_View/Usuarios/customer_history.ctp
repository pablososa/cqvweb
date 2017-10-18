<?php echo $this->element('menus/empresas', array('active' => 'usuarios:customerHistory')); ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Historial de clientes')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Usuario']); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($usuarios)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('clientes')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            $options = array(
                                $this->Paginator->sort('Usuario.name', __('Apellido y Nombre')),
                                $this->Paginator->sort('n_viajes', __('Viajes completados')),
                                __('Detalles')
                            );
                            echo $this->Html->tableHeaders($options, array('id' => 'titulos'));
                            $rows = array();
                            foreach ($usuarios as $usuario) {
                                $rows[] = array(
                                    $usuario['Usuario']['name'],
                                    $usuario['Usuario']['n_viajes'],
                                    $this->Html->link(__('Ver'), array('controller' => 'viajes', 'action' => 'customerHistory', $usuario['Usuario']['id']))
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