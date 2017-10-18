<?php echo $this->Html->script('rating.js', array('inline' => false)); ?>
<?php echo $this->element('menus/empresas', array('active' => 'empresas:viewConductors')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Conductores')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Conductor', 'buttons' => [[
                'text' => __('Crear conductor'),
                'controller' => 'conductors',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($conductores)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('conductores')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            $options = array(
                                $this->Paginator->sort('apellido', __('Apellido')),
                                $this->Paginator->sort('nombre', __('Nombre')),
                                __('Calificacion'),
                                __('Acciones'));
                            echo $this->Html->tableHeaders($options, array('id' => 'titulos'));
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            foreach ($conductores as $conductor) {
                                $actions = $this->html->link('Editar', array('controller' => 'conductors', 'action' => 'edit', $conductor['Conductor']['id']));
                                $actions .= $spacer . $this->html->link('Ver', array('controller' => 'conductors', 'action' => 'history', $conductor['Conductor']['id']));
                                if (isset($admin)) {
                                    if ($conductor['Conductor']['estado'] == 'Habilitado') {
                                        $estado = $this->Html->Link(
                                            __('Deshabilitar'), array(
                                                'controller' => 'conductors',
                                                'action' => 'deshabilitar',
                                                $conductor['Conductor']['id']
                                            )
                                        );
                                    } elseif ($conductor['Conductor']['estado'] == 'Deshabilitado') {
                                        $estado = $this->Html->Link(
                                            __('Habilitar'), array(
                                                'controller' => 'conductors',
                                                'action' => 'habilitar',
                                                $conductor['Conductor']['id']
                                            )
                                        );
                                    } else {
                                        $estado = __('Eliminado');
                                    }

                                     $estado2 = $this->Html->link(
                                                    __('Eliminar'), array(
                                                'controller' => 'conductors',
                                                'action' => 'eliminar',
                                                $conductor['Conductor']['id']
                                                    ), array(
                                                    ), '¿Está seguro que desea eliminar el conductor ' . $conductor['Conductor']['apellido']." ".$conductor['Conductor']['nombre']. '?'
                                            );


                                    $actions .= $spacer . $estado.$spacer . $estado2;
                                }
                                $rows[] = array(
                                    $conductor['Conductor']['apellido'],
                                    $conductor['Conductor']['nombre'],
                                    $this->element('rating', array('value' => $calificacion[$conductor['Conductor']['id']], 'editable' => false)),
                                    /*
                                      "<div class='rating-container rating-gly-star'>
                                      <input type='number' class='rating' value = " . $calificacion[$conductor['Conductor']['id']] . " data-show-clear = 'false' data-show-caption = 'false' min='0' max='5' step='0.5' data-size='xs' readOnly = 'readOnly'>
                                      </div>",
                                     */
                                    $actions
                                );
                            }
                            echo $this->Html->tableCells(
                                $rows, array(
                                'id' => 'filas'
                            ), array(
                                    'id' => 'filas'
                                )
                            );
                            ?>
                        </table>
                        <?php echo $this->element('paginator'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php //echo $this->Js->writeBuffer(); ?>