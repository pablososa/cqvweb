<?php echo $this->element('menus/empresas', array('active' => 'ivr_clientes:index')) ?>
    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Clientes')]); ?>
            <?php echo $this->element('default_search', ['type' => 'IvrCliente', 'buttons' => [[
                'text' => __('Crear Cliente'),
                'controller' => 'ivr_clientes',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($ivrClientes)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('clientes')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php echo $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('telefono', __('Teléfono')),
                                    $this->Paginator->sort('nombre', __('Nombre')),
                                    $this->Paginator->sort('apellido', __('Apellido')),
                                    $this->Paginator->sort('razon_social', __('Razon Social')),
                                    $this->Paginator->sort('nombre_de_fantasia', __('Nombre de Fantasia')),
                                    $this->Paginator->sort('telefono_alternativo', __('Telefono Alt.')),
                                    $this->Paginator->sort('email', __('Email')),
                                    $this->Paginator->sort('id', __('Cuenta C.')),
                                    __('Acciones')
                                ), array(
                                    'id' => 'titulos'
                                )
                            );
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            foreach ($ivrClientes as $ivrCliente) {
                                $actions = $this->Html->link(__('Ver'), array('action' => 'view', $ivrCliente['IvrCliente']['telefono']));
                                $actions .= $spacer . $this->Html->link(__('Editar'), array('action' => 'edit', $ivrCliente['IvrCliente']['id']));
                                 $actions .= $spacer . $this->Html->link(__('Cuenta'), array('action' => 'liquidacion', $ivrCliente['IvrCliente']['id']));
                               
                                $rows[] = array(
                                    $ivrCliente['IvrCliente']['telefono'],
                                    $ivrCliente['IvrCliente']['nombre'],
                                    $ivrCliente['IvrCliente']['apellido'],
                                    $ivrCliente['IvrCliente']['razon_social'],
                                    $ivrCliente['IvrCliente']['nombre_de_fantasia'],
                                    $ivrCliente['IvrCliente']['telefono_alternativo'],
                                    $ivrCliente['IvrCliente']['email'],
                                    'Nº '.str_pad($ivrCliente['IvrCliente']['id'], 10, "0", STR_PAD_LEFT),
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