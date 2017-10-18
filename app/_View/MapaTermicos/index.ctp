<?php echo $this->element('menus/empresas', array('active' => 'mapatermicos:index')) ?>

<div id="page-wrapper">

    <div class="container-fluid">




        <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Thermal Map - Events'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>   <?php echo __('Thermal Map - Events'); ?>
                            </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="panel panel-primary" style="border-color:black">
                            <div class="panel-heading" style="background:black">
                            <h2></h2>
                            </div>
                            <div class="panel-body">



<div class="container pt15 pb15">
    <div class="row">

        <section id = "content" class="col-md-9">
            <div class = "content">
                <div class = 'row'>
                    <?php echo $this->Form->create('MapaTermico'); ?>
                    <div class = "input-group input-group-lg">
                        <?php echo $this->Form->input('buscar', array('label' => false, 'div' => false, 'class' => 'form-control lg', 'placeHolder' => 'Search...')); ?>
                        <span class="input-group-btn">
                            <?php
                            echo $this->Js->submit('Search', array(
                                'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
                                'success' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
                                'update' => '#content',
                                'class' => 'btn btn-sm icon-search',
                                'div' => false
                            ));
                            ?>

                            <?php echo $this->Html->link(__('Create Event'), array('controller' => 'mapaTermicos', 'action' => 'add'), array('class' => 'btn btn-sm', 'div' => false)); ?>
                            
                        </span>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <?php
                if (empty($mapatermicos)) {
                    echo __('No se encontraron eventos.');
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
                                        $this->Paginator->sort('business', __('Business address')),
                                $this->Paginator->sort('descripcion', __('Description')),
                                $this->Paginator->sort('direccion', __('Address')),
                                $this->Paginator->sort('cant_personas', __('Total Attendance')),
                                 __('Actions'),
                                '',
                                ''
                                    ), array(
                                'id' => 'titulos'
                                    )
                            );
                            echo $tableHeaders;
                            $rows = array();
                            foreach ($mapatermicos as $mapatermico) {
                               

                                $rows[] = array(
                                    $mapatermico['MapaTermico']['business'],
                                    $mapatermico['MapaTermico']['descripcion'],
                                    $mapatermico['MapaTermico']['direccion'],
                                    $mapatermico['MapaTermico']['cant_personas'],
                                    $this->Html->link(
                                                    __('Mapa'), array(
                                                'controller' => 'empresas',
                                                'action' => 'visualization',
                                                'event_to' => $mapatermico['MapaTermico']['id']
                                                    )
                                            ) ,
                                    $this->Html->link(
                                                    __('Editar'), array(
                                                'controller' => 'mapaTermicos',
                                                'action' => 'edit',
                                                $mapatermico['MapaTermico']['id']
                                                    )
                                            ) ,
                                    $this->Html->link(
                                                    __('Eliminar'), array(
                                                'controller' => 'mapaTermicos',
                                                'action' => 'delete',
                                                $mapatermico['MapaTermico']['id']
                                                    ), array(
                                                    ), 'Are you sure you want delete this event?'
                                            )   
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
                </div>
                <div class = "row text-center">
                    <?php //echo $this->element('paginator'); ?>
                </div>
                <?php
                echo $this->Js->writeBuffer();
                ?>
        </section>
    </div>
</div>
</div>


</div>
</div>
</div>
</div>

