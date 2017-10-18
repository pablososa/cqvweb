<?php echo $this->element('menus' . DS . 'admin', array('active' => 'usuarios:view')); ?>

<section>
    <div class="container-fluid">
        <?php echo $this->element('title', ['title' => __('Usuarios')]); ?>
        <?php echo $this->element('default_search', ['type' => 'Usuario']); ?>
        <?php echo $this->element('loader'); ?>
        <div class="row">
            <div id="content" class="col-xs-12">
                <?php if (empty($usuarios)) : ?>
                    <?php echo $this->element('no_se_econtraron', ['not_found' => __('usuarios')]); ?>
                <?php else: ?>
                    <table class="table table-hover table-striped">
                        <?php
                        $tableHeaders = $this->Html->tableHeaders(array(
                            $this->Paginator->sort('apellido', __('Apellido')),
                            $this->Paginator->sort('nombre', __('Nombre')),
                            $this->Paginator->sort('telefono', __('Teléfono')),
                            $this->Paginator->sort('direccion', __('Dirección')),
                            $this->Paginator->sort('email', __('Email')),
                            $this->Paginator->sort('estado', __('Estado')),
                            __('Acciones')
                        ));
                        echo $tableHeaders;

                        $rows = array();
                        $estados = array(
                            __('No verificado'),
                            __('Verifico celular'),
                            __('Verifico mail'),
                            __('Verifico mail y cel'),
                        );
                        foreach ($usuarios as $usuario) {

                            if ($usuario['Usuario']['habilitado']) {
                                $accion = $this->Html->link(__('Deshabilitar'), array('controller' => 'usuarios', 'action' => 'deshabilitar', $usuario['Usuario']['id']));
                            } else {
                                $accion = $this->Html->link(__('Habilitar'), array('controller' => 'usuarios', 'action' => 'habilitar', $usuario['Usuario']['id']));
                            }

                            $rows[] = array(
                                $this->Html->link(
                                    $usuario['Usuario']['apellido'], array(
                                        'controller' => 'usuarios',
                                        'action' => 'reservation',
                                        $usuario['Usuario']['id']
                                    )
                                ),
                                $usuario['Usuario']['nombre'],
                                $usuario['Usuario']['telefono'],
                                $usuario['Usuario']['direccion'],
                                $usuario['Usuario']['email'],
                                $estados[$usuario['Usuario']['estado']],
                                $accion
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
