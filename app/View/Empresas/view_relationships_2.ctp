        <?php echo $this->element('menus/empresas', array('active' => 'empresas:viewRelationships')) ?>

<div id="page-wrapper">

    <div class="container-fluid">



 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Vehiculo/Conductor'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>   <?php echo __('Vehiculo/Conductor'); ?>
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


              <div class = 'fixed-table-toolbar'>
                <?php echo $this->Form->create('Conductor'); ?>

                <div class = 'pull-right search'>
                    <?php echo $this->Form->input('buscar', array('label' => false, 'div' => false, 'class' => 'form-control lg', 'placeHolder' => 'Search...')); ?>
                    <?php
                    echo $this->Js->submit('Search', array(
                        'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
                        'success' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
                        'update' => '#content',
                        'class' => 'btn btn-sm icon-search',
                        'div' => 'input-group-btn',
                        'escape' => false
                    ));
                    ?>
                </div>
                </div>
                <?php echo $this->Form->end(); ?>
      
            <?php
            if (empty($relaciones)) {
                echo __('No existe ningún conductor asignado a un vehiculo en este momento.');
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
                        $this->Paginator->sort('name', __('Conductor')),
                        $this->Paginator->sort('fecha_inicio', __('Fecha Inicio')),
                        $this->Paginator->sort('hora_inicio', __('Hora Inicio')),
                        $this->Paginator->sort('patente', __('Patente')),
                        $this->Paginator->sort('Vehiculo.nro_registro', __('Nro de Móvil')),
                        __('Acciones')
                    );
                    echo $this->Html->tableHeaders($options, array('id' => 'titulos'));
                    $rows = array();
                    foreach ($relaciones as $relacion) {
                        $rows[] = array(
                            $relacion['Conductor']['name'],
                            $relacion['Historialvcs']['fecha_ini'],
                            $relacion['Historialvcs']['hora_ini'],
                            $relacion['Vehiculo']['patente'],
                            $relacion['Vehiculo']['nro_registro'],
                            $this->Html->link(__('Cerrar Sesión'), array('controller' => 'historialvcs', 'action' => 'closeSession', $relacion['Historialvcs']['id']))
                        );
                    }
                    echo $this->Html->tableCells($rows);
                    ?>
                </table>
                <div class = "row text-center">
                    <?php echo $this->element('paginator'); ?>
                </div>
                <?php echo $this->Js->writeBuffer(); ?>
            <?php } ?>

    </div>
</div>

    </div>
</div>
