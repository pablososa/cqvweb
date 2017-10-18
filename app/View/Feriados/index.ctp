<?php echo $this->element('menus/admin', array('active' => 'feriados:index')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Feriados')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Feriado', 'buttons' => [[
                'text' => __('Crear feriado'),
                'controller' => 'feriados',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($feriados)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('feriados')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php echo $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('id', __('Id')),
                                    $this->Paginator->sort('fecha', __('Fecha')),
                                    __('Acciones')
                                ), array(
                                    'id' => 'titulos'
                                )
                            );
                            $rows = [];
                            $spacer = '&nbsp;&nbsp;';
                            foreach ($feriados as $feriado) {
                                $actions = $this->Html->link(__('Editar'), array('action' => 'edit', $feriado['Feriado']['id']));
                                $actions .= $spacer . $this->Form->postLink(__('Borrar'), array('action' => 'delete', $feriado['Feriado']['id']), null, __('¿Está seguro que desea borrar el feriado de %s?', Utils::datetize($feriado['Feriado']['fecha'])));

                                $rows[] = array(
                                    $feriado['Feriado']['id'],
                                    Utils::datetize($feriado['Feriado']['fecha']),
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