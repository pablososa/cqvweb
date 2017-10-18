<?php echo $this->element('menus/empresas', array('active' => 'operadors:index')) ?>
    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Operadores')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Operador', 'buttons' => [[
                'text' => __('Crear operador'),
                'controller' => 'operadors',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($operadors)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('operadores')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            echo $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('usuario', __('Operador')),
                                    $this->Paginator->sort('estado', __('Estado')),
                                    __('Acciones')
                                )
                            );
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            foreach ($operadors as $operador) {
                                $actions = $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $operador['Operador']['id']), null, __('¿Esta seguro que desea eliminar el operador "%s"?', $operador['Operador']['usuario']));
                                $actions .= $spacer . $this->Html->link(__('Editar'), array('action' => 'edit', $operador['Operador']['id']));
                                $actions .= $spacer . $this->Html->link(__('Configuraciones'), array('action' => 'editConfigs', $operador['Operador']['id']));
                                if ($operador['Operador']['estado'] == 'habilitado') {
                                    $actions .= $spacer . $this->Html->Link(__('Deshabilitar'), array('controller' => 'operadors', 'action' => 'deshabilitar', $operador['Operador']['id']));
                                } else {
                                    $actions .= $spacer . $this->Html->Link(__('Habilitar'), array('controller' => 'operadors', 'action' => 'habilitar', $operador['Operador']['id']));
                                }

                                $rows[] = array(
                                    $operador['Operador']['usuario'],
                                    $operador['Operador']['estado'],
                                    $actions
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