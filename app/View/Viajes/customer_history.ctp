   <?php echo $this->element('menus/empresas', array('active' => 'usuarios:customerHistory')) ?>
     
  <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Historial de clientes'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Historial de clientes'); ?>
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



<div class="container pt15 pb15">
    <div class="row">
        <section id = "content1" class="col-md-9">
            <div class = 'row'>
                <?php echo $this->Form->create(); ?>
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
            if (empty($viajes)) {
                echo __('No existen viajes.');
            } else {
                echo $this->Paginator->options(array(
                    'update' => '#content',
                    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false))
                ));
                ?>
                <div class ="row text-center">
                    <?php echo $this->Html->image('loader.gif', array('id' => 'loader', 'hidden' => 'hidden')); ?>
                </div>
                <table class = "table table-condensed">
                    <?php
                    $options = array(
                        $this->Paginator->sort('Viaje.fecha', __('Fecha')),
//                        $this->Paginator->sort('Viaje.hora', __('Hora')),
                        $this->Paginator->sort('Viaje.dir_origen', __('Origen')),
                        $this->Paginator->sort('Viaje.dir_destino', __('Destino')),
                        $this->Paginator->sort('Viaje.distancia', __('Distancia')),
                        $this->Paginator->sort('Viaje.tarifa', __('Tarifa')),
                        $this->Paginator->sort('Viaje.estado', __('Estado')),
                        __('Observaciones')
                    );
                    echo $this->Html->tableHeaders($options, array('id' => 'titulos'));
                    $rows = array();
                    foreach ($viajes as $viaje) {
                        $rows[] = array(
                            Utils::datetimetize($viaje['Viaje']['fecha'] . ' ' . $viaje['Viaje']['hora']),
                            $viaje['Viaje']['dir_origen'],
                            $viaje['Viaje']['dir_destino'],
                            $viaje['Viaje']['distancia'],
                            $viaje['Viaje']['tarifa'],
                            $viaje['Viaje']['estado'],
                            $viaje['Viaje']['observaciones']
                        );
                    }
                    echo $this->Html->tableCells($rows);
                    ?>
                </table>
                <div class = "row text-center">
                    <?php echo $this->Element('paginator'); ?>
                </div>
            <?php } ?>
            <?php
            echo $this->Js->writeBuffer();
            ?>
        </section>
    </div>
</div>

    </div>
</div>

