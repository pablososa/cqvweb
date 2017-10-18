<script type="text/javascript">
    $(document).ready(function () {
        $('a.reasignar').click(function (e) {
            e.preventDefault();
            apptaxiweb.popup($(this).attr('href'));
        });
    });
</script>
<?php echo $this->element('menus/empresas', array('active' => 'viajes:adminHistory')); ?>

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo __('Atender'); ?>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i> <?php echo __('Atender'); ?>
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="panel panel-primary" style="border-color:black">
            <div class="panel-heading" style="background:black">
                <h2></h2>
            </div>
            <div class="panel-body" style="margin: 10px">
                <div class="row">
                    <div class="col-sm-12">
                        <h4><i> <?php echo __('Cliente'); ?> </i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="ivrClientes form">
                        <?php echo $this->Form->create('IvrCliente'); ?>
                        <?php echo $this->Form->input('id'); ?>
                        <div class="row">
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('telefono', ['class' => 'form-control', 'div' => 'form-group', 'readonly' => true]); ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('nombre', ['class' => 'form-control', 'div' => 'form-group']); ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('apellido', ['class' => 'form-control', 'div' => 'form-group']); ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('razon_social', ['class' => 'form-control', 'div' => 'form-group']); ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('nombre_de_fantasia', ['class' => 'form-control', 'div' => 'form-group']); ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('telefono_alternativo', ['class' => 'form-control', 'div' => 'form-group']); ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $this->Form->input('email', ['class' => 'form-control', 'div' => 'form-group']); ?>
                                <?php echo $this->Form->input('back_to', ['type' => 'hidden', 'value' => 1]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?php echo $this->Form->submit(__('Guardar'), ['class' => 'btn btn-primary']); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $this->Html->link(__('Crear Domicilio'), array('controller' => 'ivr_domicilios', 'action' => 'add', $telefono), array('class' => 'btn btn-primary')); ?>
                        <br>
                        <br>

                        <table class="table table-condensed table-admin-pendientes table-ivr-domicilios">
                            <tr>
                                <th><?php echo __('Domicilio'); ?></th>
                                <th><?php echo __('Observaciones'); ?></th>
                                <th><?php echo __('Pricipal'); ?></th>
                                <th><?php echo __('Acciones'); ?></th>
                            </tr>
                            <?php foreach ($domicilios as $domicilio) : ?>
                                <tr class="<?php echo $domicilio['IvrDomicilio']['es_principal'] ? 'es-principal' : '' ?>">
                                    <td><?php echo $domicilio['IvrDomicilio']['domicilio']; ?></td>
                                    <td><?php echo $domicilio['IvrDomicilio']['observaciones']; ?></td>
                                    <td><?php echo $domicilio['IvrDomicilio']['es_principal'] ? __('Es Principal') : ''; ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('Editar'), array('controller' => 'ivr_domicilios', 'action' => 'edit', $domicilio['IvrDomicilio']['id'])); ?>
                                        <?php echo $this->Form->postLink(__('Eliminar'), array('controller' => 'ivr_domicilios', 'action' => 'delete', $domicilio['IvrDomicilio']['id']), null, __('¿Está seguro que desea eliminar el domicilio?')); ?>
                                        <?php echo $this->Html->link(__('Crear Diferido'), array('controller' => 'viaje_diferidos', 'action' => 'add', $domicilio['IvrDomicilio']['id'])); ?>
                                        <?php echo $this->Html->link(__('Crear Programado'), array('controller' => 'viaje_programados', 'action' => 'add', $domicilio['IvrDomicilio']['id'])); ?>
                                        <?php
                                        $data = array(
                                            'data' => array(
                                                'Viaje.ivr_domicilio_id' => $domicilio['IvrDomicilio']['id'],
                                                'Viaje.dir_origen' => $domicilio['IvrDomicilio']['domicilio'],
                                                'Viaje.observaciones' => $domicilio['IvrDomicilio']['observaciones'],
                                                'Viaje.back_to_referer' => true,
                                            )
                                        );
                                        echo $this->Form->postLink(__('Crear Viaje'), array('controller' => 'viajes', 'action' => 'adminAdd'), $data);
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $this->element('viajes' . DS . 'admin_history', compact('viajes')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>