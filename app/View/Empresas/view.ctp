<?php echo $this->element('menus' . DS . 'admin', array('active' => 'empresas:view')); ?>
    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Empresas')]); ?>
            <?php echo $this->element('default_search', ['type' => 'Empresa', 'buttons' => [[
                'text' => __('Crear empresa'),
                'controller' => 'empresas',
                'action' => 'add'
            ]]]); ?>
            <?php echo $this->element('loader'); ?>
            <div class="row">
                <div id="content" class="col-xs-12">
                    <?php if (empty($empresas)) : ?>
                        <?php echo $this->element('no_se_econtraron', ['not_found' => __('empresas')]); ?>
                    <?php else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            $tableHeaders = $this->Html->tableHeaders(
                                array(
                                    $this->Paginator->sort('nombre', __('Nombre')),
//                                    $this->Paginator->sort('cuit', __('Cuit')),
//                                    $this->Paginator->sort('fecha_ini_act', __('Inicio')),
//                                    $this->Paginator->sort('direccion', __('Dirección')),
                                    $this->Paginator->sort('email', __('Email')),
                                    $this->Paginator->sort('telefono', __('Teléfono')),
                                    $this->Paginator->sort('estado', __('Estado')),
//                                    $this->Paginator->sort('empresa_key', __('Api Key')),
//                                    __('Modificar'),
                                    __('Acciones')
                                )
                            );
                            echo $tableHeaders;
                            $rows = array();
                            ?>
                            <?php foreach ($empresas as $empresa) : ?>
                                <tr>
                                    <td><?php echo $this->Html->link($empresa['Empresa']['nombre'], array('controller' => 'empresas', 'action' => 'logInAsEmpresa', $empresa['Empresa']['id'])); ?></td>
                                    <td><?php echo $empresa['Empresa']['email']; ?></td>
                                    <td><?php echo $empresa['Empresa']['telefono']; ?></td>
                                    <td><?php echo $empresa['Empresa']['estado']; ?></td>
                                    <?php
                                    $accions = array();
                                    $accions[] = $this->Html->link(__('Detalles'), array('#'), array('class' => 'slide-down-fixed'));
                                    if ($empresa['Empresa']['estado'] == "Habilitado") {
                                        $accions[] = $this->Html->link(__('Deshabilitar'), array('controller' => 'empresas', 'action' => 'deshabilitar', $empresa['Empresa']['id']));
                                    } else {
                                        $accions[] = $this->Html->link(__('Habilitar'), array('controller' => 'empresas', 'action' => 'habilitar', $empresa['Empresa']['id']));
                                    }
                                    $accions[] = $this->Html->link(__('Editar'), array('controller' => 'empresas', 'action' => 'edit', $empresa['Empresa']['id']));
                                    ?>
                                    <td class="actions">
                                        <?php echo implode('', $accions); ?>
                                    </td>
                                </tr>
                                <tr class="hidden-fixed-slide-down">
                                    <td>
                                        <div>
                                            <table>
                                                <tr>
                                                    <td><?php echo __('Cuit'); ?>:</td>
                                                    <td><?php echo $empresa['Empresa']['cuit']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo __('Inicio'); ?>:</td>
                                                    <td><?php echo Utils::datetize($empresa['Empresa']['fecha_ini_act']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo __('Dirección'); ?>:</td>
                                                    <td><?php echo $empresa['Empresa']['direccion']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo __('Api Key'); ?>:</td>
                                                    <td><?php echo $empresa['Empresa']['empresa_key']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
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