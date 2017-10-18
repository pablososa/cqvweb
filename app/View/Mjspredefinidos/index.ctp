<?php echo $this->element('menus/empresas', array('active' => 'mjspredefinidos:index')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Mensajes predefinidos')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Mjspredefinido', 'buttons' => [[
                'text' => __('Crear mensaje'),
                'controller' => 'mjspredefinidos',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($mjspredefinidos)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('mensajes predefinidos')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            $tableHeaders = $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('texto', __('Texto')),
                                    __('Acciones')
                                ));
                            echo $tableHeaders;
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            foreach ($mjspredefinidos as $mjspredefinido) {
                                $actions = $this->Html->link(__('Editar'), array('action' => 'edit', $mjspredefinido['Mjspredefinido']['id']));
                                $actions .= $spacer . $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $mjspredefinido['Mjspredefinido']['id']), null, __('¿Esta seguro que desea eliminar el mensaje predefinido "%s"?', $mjspredefinido['Mjspredefinido']['texto']));
                                $rows[] = [
                                    $mjspredefinido['Mjspredefinido']['texto'],
                                    $actions
                                ];
                            }
                            echo $this->Html->tableCells($rows, ['id' => 'filas'], ['id' => 'filas']);
                            ?>
                        </table>
                        <?php echo $this->element('paginator'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php echo $this->Js->writeBuffer(); ?>