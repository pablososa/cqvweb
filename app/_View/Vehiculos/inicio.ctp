<?php echo $this->Html->script('jquery.politedatepicker'); ?>
<?php echo $this->element('menus/empresas', array('active' => 'vehiculos:inicio')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Inicio - Liquidación' )]); ?>
            <?php //echo $this->element('default_search', ['type' => 'Vehiculo' ]); ?>
            <?php echo $this->element('loader'); ?>
            

             <div class="row form-estadisticas">
                                <?php echo $this->Form->create('Vehiculo', array('url' => array('action' => 'inicio'), 'class' => 'get-data')); ?>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_ini', array('class' => 'form-control lg datepicker', 'label' => __('Desde'))); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_fin', array('class' => 'form-control lg datepicker', 'label' => __('Hasta'))); ?>
                                </div>

                                <div class="col-md-6" style="margin-top:20px">
                                    <?php echo $this->Form->submit(__('Consultar')); ?>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>


            <div class="row">


                <div id="content" class="col-xs-12">
                    <?php //if (empty($vehiculos)) : ?>
                        <?php //echo $this->element('no_se_econtraron', ['not_found' => __('vehiculos')]); ?>
                    <?php //else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            //print_r($viajes);
                            $tableHeaders = $this->Html->tableHeaders(
                                array(
                                    __('Concepto'),
                                    __('Monto')
                                   
                                ), array(
                                    'id' => 'titulos'
                                )
                            );

                            echo $tableHeaders;
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            
                            $tot = 0;
                            $com = 0;
                            $sal = 0;

                            
                            foreach ($viajes as $viaje) {
                               $descripcion = $viaje[0]['descripcion'];       
                               $total = $viaje[0]['total'];            
                               

                                $rows[] = array(
                                    $descripcion,
                                    '$'.$total
                                   
                                );
                               

                            }

                            echo $this->Html->tableCells($rows, array('id' => 'filas'), array('id' => 'filas'));
                            
                            ?>
                        </table>
                        <?php //echo $this->element('paginator'); ?>
                    <?php //endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php echo $this->Js->writeBuffer(); ?>