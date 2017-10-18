<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo __((( isset($admin) ) ? 'Admin - ' : '') . $empresa['Empresa']['nombre']); ?> </h1>
                <h4><i> <?php echo __('Vehiculos'); ?> </i> </h4>
            </div>
            <div class="col-sm-6 hidden-xs">
                <ul id="navTrail">

                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class="row">
        <?php echo $this->element('menus/empresas', array('active' => 'vehiculos:mensajes')) ?>
        <section id = "content" class="col-md-9">
            <div class = "content">
                <div class = 'row'>
                    <?php echo $this->Form->create('Mensaje', array('action' => 'add', 'class' => 'difusion')); ?>
                    <div class = "input-group input-group-lg">
                        <?php echo $this->Form->input('texto', array('label' => false, 'div' => false, 'class' => 'form-control lg', 'placeHolder' => 'Mensaje')); ?>
                        <?php
                        echo $this->Form->submit(__('Difundir'), array(
                            'class' => 'btn btn-sm icon-search',
                            'div' => 'input-group-btn',
                            'escape' => false
                        ));
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <hr>
                <div class = 'row'>
                    <?php echo $this->Form->create('Vehiculo'); ?>
                    <div class = "input-group input-group-lg">
                        <?php echo $this->Form->input('buscar', array('label' => false, 'div' => false, 'class' => 'form-control lg', 'placeHolder' => 'Buscar...')); ?>
                        <?php
                        echo $this->Js->submit('Buscar', array(
                            'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
                            'success' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
                            'update' => '#content',
                            'class' => 'btn btn-sm icon-search',
                            'div' => 'input-group-btn',
                            'escape' => false
                        ));
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <?php
                if (empty($vehiculos)) {
                    echo __('No se encontraron vehiculos.');
                } else {
                    echo $this->Paginator->options(
                            array(
                                'update' => '#content',
                                'before' => $this->Js->get('#loader')->effect(
                                        'fadeIn', array(
                                    'buffer' => false
                                        )
                                ),
                                'complete' => $this->Js->get('#loader')->effect(
                                        'fadeOut', array(
                                    'buffer' => false
                                        )
                                )
                            )
                    );
                    ?>
                    <div class ="row text-center">
                        <?php
                        echo $this->Html->image(
                                'loader.gif', array(
                            'id' => 'loader',
                            'hidden' => 'hidden'
                                )
                        );
                        ?>
                    </div>
                    <div class="row">
                        <table class = "table table-condensed">
                            <?php
                            $tableHeaders = $this->Html->tableHeaders(
                                    array(
                                        $this->Paginator->sort('patente', __('Patente')),
                                        $this->Paginator->sort('nro_registro', __('Nro. de móvil')),
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
                                    $this->Html->link(__('Ver Mensajes'), array('controller' => 'mensajes', 'action' => 'getMensajes', $vehiculo['Vehiculo']['id']), array('class' => 'slide-down'))
                                );
                            }
                            echo $this->Html->tableCells(
                                    $rows, array(
                                'id' => 'filas'
                                    ), array(
                                'id' => 'filas'
                                    )
                            );
                        }
                        ?>
                    </table>
                    <div class = "row text-center">
                        <?php echo $this->element('paginator'); ?>
                    </div>
                </div>
                <?php echo $this->Js->writeBuffer(); ?>
        </section>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('body:first').on('click', '.messages-board a[rel="next"]', function(event){
            event.preventDefault();
            var $this = $(this);
            var options = {
                url: $this.attr('href'),
                success: function(data) {
                    var $data = $(data);
                    $this.closest('.messages-board').find('.all-messajes-container').append($data.find('.mensaje-cont'));
                    $this.replaceWith($data.find('a[rel="next"]'));
                }
            };
            $.ajax(options);
        });
        $('a.slide-down').targetSlideDown();
        $('form.difusion').submit(function() {
            return confirm('<?php echo __('Está a punto de enviar el mensaje a todos los móbiles. ¿Esta Seguro?'); ?>');
        });
    });
</script>