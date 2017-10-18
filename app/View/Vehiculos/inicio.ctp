<?php echo $this->Html->script('jquery.politedatepicker'); ?>
<?php echo $this->element('menus/empresas', array('active' => 'vehiculos:inicio')) ?>

    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Inicio' )]); ?>
            <?php //echo $this->element('default_search', ['type' => 'Vehiculo' ]); ?>
            <?php echo $this->element('loader'); ?>
            

            <div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-calendar fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"></div>
                    <div></div>
                </div>
            </div>
        </div>
        <a href="/vehiculos/dash">
            <div class="panel-footer">
                <span class="pull-left">Liquidación</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>


<div class="col-lg-3 col-md-6">
    <div class="panel panel-red">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-balance-scale fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"></div>
                    <div></div>
                </div>
            </div>
        </div>
        <a href="/vehiculos/balance">
            <div class="panel-footer">
                <span class="pull-left">Balance</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>


<div class="col-lg-3 col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-bar-chart fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"></div>
                    <div></div>
                </div>
            </div>
        </div>
        <a href="/estadisticas">
            <div class="panel-footer">
                <span class="pull-left">Estadísticas</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>



            
        </div>
    </section>
<?php echo $this->Js->writeBuffer(); ?>