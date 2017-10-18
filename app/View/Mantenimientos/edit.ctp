<?php echo $this->Html->script('jquery.politedatepicker'); ?>
<header class="page-header" style="background-color: #555555;">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> Admin </h1>
            </div>
            <div class="col-sm-6 hidden-xs">
                <ul id="navTrail">
                    <li><a href="admin" style="color: #fff;"> <?php echo __('Admin'); ?> </a></li>
                    <li class = "active"> <?php echo __('Mantenimientos'); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row pt15">
        <?php echo $this->element('menus' . DS . 'admin', array('active' => 'mantenimientos:index')); ?>
        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Mantenimiento', array('novalidate')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class = "row">
                <div class = "col-md-6">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('mensaje', array('label' => __('Mensaje'), 'class' => 'form-control sm')); ?>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('desde', array('label' => __('Fecha Desde'), 'class' => 'form-control datepicker', 'type' => 'text')); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('hasta', array('label' => __('Fecha Hasta'), 'class' => 'form-control datepicker', 'type' => 'text')); ?>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('hora_desde', array('label' => __('Hora Desde'), 'class' => 'form-control', 'options' => $horas)); ?>
                        </div>
                    </div>
                    <div class = "form-group">
                        <div class = "col-md-12">
                            <?php echo $this->Form->input('hora_hasta', array('label' => __('Hora Hasta'), 'class' => 'form-control', 'options' => $horas)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "row text-right">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array('action' => 'index'), array('class' => 'btn btn-sm btn-default'));
                    echo $this->Form->button(__('Confirmar'), array('class' => 'btn btn-sm btn-default'));
                    ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>