<?php echo $this->element('menus' . DS . 'admin', array('active' => 'mantenimientos:index')); ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Mantenimientos')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Mantenimiento', 'buttons' => [[
                'text' => __('Crear mantenimiento'),
                'controller' => 'mantenimientos',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($mantenimientos)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('mantenimientos')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            $ths = array(
                                $this->Paginator->sort('mensaje', __('Mensaje')),
                                $this->Paginator->sort('estado', __('Estado')),
                                $this->Paginator->sort('desde', __('Desde')),
                                $this->Paginator->sort('hasta', __('Hasta')),
                                __('Acciones')
                            );
                            echo $this->Html->tableHeaders($ths);
                            ?>
                            <?php foreach ($mantenimientos as $mantenimiento) : ?>
                                <tr>
                                    <td><?php echo Utils::cut($mantenimiento['Mantenimiento']['mensaje']); ?></td>
                                    <td><?php echo $mantenimiento['Mantenimiento']['estado']; ?></td>
                                    <td><?php echo Utils::datetimetize($mantenimiento['Mantenimiento']['desde']); ?></td>
                                    <td><?php echo Utils::datetimetize($mantenimiento['Mantenimiento']['hasta']); ?></td>
                                    <td class="actions">
                                        <?php
                                        echo $this->Form->postLink(__('Eliminar'), array('controller' => 'mantenimientos', 'action' => 'delete', $mantenimiento['Mantenimiento']['id']));
                                        echo $this->Html->link(__('Previsualizar'), array('controller' => 'mantenimientos', 'action' => 'index', 'mantenimiento_preview' => $mantenimiento['Mantenimiento']['id']));
                                        echo $this->Html->link(__('Editar'), array('controller' => 'mantenimientos', 'action' => 'edit', $mantenimiento['Mantenimiento']['id']));
                                        if ($mantenimiento['Mantenimiento']['estado'] == "Habilitado") {
                                            echo $this->Html->link(__('Deshabilitar'), array('controller' => 'mantenimientos', 'action' => 'deshabilitar', $mantenimiento['Mantenimiento']['id']));
                                        } else {
                                            echo $this->Html->link(__('Habilitar'), array('controller' => 'mantenimientos', 'action' => 'habilitar', $mantenimiento['Mantenimiento']['id']));
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php echo $this->element('paginator'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php echo $this->Js->writeBuffer(); ?>