<?php echo $this->Html->script('rating.js', array('inline' => false)); ?>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo __($usuario['Usuario']['apellido'] . ', ' . $usuario['Usuario']['nombre']); ?> </h1>
                <h4><i> <?php echo __('Calificar viaje') ?> </i> </h4>
            </div>
            <div class="col-sm-6 hidden-xs">
                <ul id="navTrail">
                    <li><a href="usuarios"> <?php echo __('Usuarios'); ?> </a></li>
                    <li id="navTrailLast"> <?php echo __('Calificar'); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class="row">
        <?php echo $this->element('menus' . DS . 'usuario', array('active' => 'usuarios:reservation')); ?>
        <section id = "content" class="col-md-9">
            <div class = "row">
                <?php echo $this->Form->create('Calificacion'); ?>
                <div class = "col-lg-6">
                    <div class="form-group">
                        <label> <?php echo __('Puntaje conductor:'); ?> </label>
                        <!--div class="rating-container rating-gly-star"-->
                            <?php echo $this->element('rating', array('id'=>'CalificacionPuntajeConductor','name' => 'data[Calificacion][puntaje_conductor]', 'value'=>2.5, 'label' => true)); ?>
                            <!--input id="CalificacionPuntajeConductor" type="number" class="rating" value="3" min="0" max="5" step="0.5" data-size="xs"name="data[Calificacion][puntaje_conductor]"-->
                        <!--/div-->
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('obs_conductor', array('label' => false, 'type' => 'text', 'rows' => '5', 'class' => 'form-control lg', 'placeHolder' => 'Observaciones sobre el conductor.')); ?>
                    </div>
                </div>
                <div class = "col-lg-6">
                    <div class="form-group">
                        <label> <?php echo __('Puntaje vehiculo:'); ?> </label>
                        <!--div class="rating-container rating-gly-star"-->
                            <?php echo $this->element('rating', array('id' => 'CalificacionPuntajeVehiculo' ,'name' => 'data[Calificacion][puntaje_vehiculo]', 'value'=>2.5, 'label' => true)); ?>
                            <!--input id="CalificacionPuntajeVehiculo" type="number" class="rating" value="3" min="0" max="5" step="0.5" data-size="xs" name="data[Calificacion][puntaje_vehiculo]"-->
                        <!--/div-->
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('obs_vehiculo', array('label' => false, 'type' => 'text', 'rows' => '5', 'class' => 'form-control lg', 'placeHolder' => 'Observaciones sobre el vehiculo')); ?>
                    </div>
                </div>
            </div>
            <div class = "row text-right">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array(
                        'controller' => 'usuarios',
                        'action' => 'history'
                            ), array(
                        'class' => 'btn btn-sm btn-default',
                            )
                    );
                    echo $this->Form->button(__('Confirmar'), array(
                        'class' => 'btn btn-sm btn-default'
                            )
                    );
                    ?>
                </div>	
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>