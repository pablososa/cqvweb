<?php echo $this->element('maps_js')?>
<div class="container pt15 pb15">
    <div class="row">
        <section id="content" class="col-md-9">
            <?php
            /*
            ?>
            <div class = "row">
                <?php echo __('Dirección de origen: %s', array($this->data['Viaje']['dir_origen'])); ?>
            </div>
            */
            ?>
            <?php echo $this->Form->create('Viaje'); ?>
            <div class="row">
                <?php echo $this->Form->input('id'); ?>
                <!--                --><?php //echo $this->Form->input('dir_origen', array()); ?>
                <?php echo $this->Form->input('latitud_origen', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('longitud_origen', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('dir_destino', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('latitud_destino', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('longitud_destino', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('localidad', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('usuario_id', array('type' => 'hidden')); ?>
                <div class="col-md-6">
                    <div class="marg-15-res">
                        <?php echo $this->Form->input('dir_origen', array('label' => false, 'class' => 'form-control lg', 'type' => 'text', 'placeHolder' => 'Origen', 'div' => false, 'id' => 'ViajeDirOrigenDespachoPendiente', 'data-direction' => $empresa['Empresa']['direccion'])); ?>
                    </div>
                    <div class="marg-15-res">
                        <?php echo $this->Form->input('vehiculo_id', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'options' => $conductors, 'empty' => __('Móvil mas cercano'))); ?>
                    </div>
                </div>
            </div>
            <div class="row text-right marg-15-res">
                <div class="btn-group">
                    <?php echo $this->Form->submit(__('Confirmar'), array('id' => 'reservar', 'class' => 'btn btn-sm btn-default', 'div' => false)); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#ViajeDirOrigenDespachoPendiente').directionSearch();
    });
</script>