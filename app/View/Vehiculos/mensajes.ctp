<?php echo $this->element('menus/empresas', array('active' => 'vehiculos:mensajes')) ?>
<section>
    <div class="container-fluid">
        <?php echo $this->element('title', ['title' => __('Mensajes')]); ?>
        <?php echo $this->element('default_search', ['type' => 'Vehiculo']); ?>
        <?php echo $this->element('loader'); ?>
        <div class = 'row'>
                    <?php echo $this->Form->create('Mensaje', array('action' => 'add', 'class' => 'difusion')); ?>
                    <div class = "input-group input-group-lg">
                        <?php echo $this->Form->input('texto', array('label' => false, 'div' => false, 'class' => 'form-control lg', 'placeHolder' => 'Mensaje')); ?>
                        <?php
                        echo $this->Form->submit(__('Enviar a todos'), array(
                            'class' => 'btn btn-sm icon-search',
                            'div' => 'input-group-btn',
                            'escape' => false
                        ));
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            <br>
        <div class="row">
            <div id="content" class="col-xs-12">
                <?php if (empty($vehiculos)) : ?>
                    <?php echo $this->element('no_se_econtraron', ['not_found' => __('mensajes')]); ?>
                <?php else: ?>
                    <table class="table table-hover table-striped">
                        <?php
                        $tableHeaders = $this->Html->tableHeaders(
                            array(
                                $this->Paginator->sort('patente', __('Patente')),
                                $this->Paginator->sort('nro_registro_numeric', __('Nro Movil')),
                                $this->Paginator->sort('marca', __('Marca')),
                                $this->Paginator->sort('modelo', __('Modelo')),
                                __('Acciones')
                            ));
                        echo $tableHeaders;
                        $rows = array();
                        foreach ($vehiculos as $vehiculo) {
                            $rows[] = array(
                                $vehiculo['Vehiculo']['patente'],
                                $vehiculo['Vehiculo']['nro_registro'],
                                $vehiculo['Vehiculo']['marca'],
                                $vehiculo['Vehiculo']['modelo'],
                                $this->Html->link(__('Ver mensajes'), array('controller' => 'mensajes', 'action' => 'getMensajes', $vehiculo['Vehiculo']['id']), array('class' => 'slide-down'))
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
<?php echo $this->Js->writeBuffer(); ?>
<script type="text/javascript">
    window.empresa_id = <?php echo $empresa["Empresa"]["id"];?>;
    //cambiar
    window.NODE_EVENT_SERVER_URL = "<?php echo NODE_EVENT_SERVER_URL;?>";

    $(document).ready(function () {
        startMessages();
        $('a.slide-down').targetSlideDown();
        $('form.difusion').submit(function () {
            return confirm('<?php echo __('Está a punto de enviar el mensaje a todos los móbiles. ¿Esta Seguro?'); ?>');
        });
    });
</script>
