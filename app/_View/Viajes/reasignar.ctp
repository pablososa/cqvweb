<div class="container pt15 pb15">
    <div class="row">
        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Viaje'); ?>
            <div class = "row">
                <?php echo $this->Form->input('id'); ?>
                <div class = "col-md-6">
                    <div class="marg-15-res">
                        <?php echo $this->Form->input('vehiculo_id', array('label' => false, 'class' => 'form-control lg', 'div' => false, 'options' => $conductors, 'empty' => __('Móvil mas cercano'))); ?>
                    </div>
                </div>
            </div>
            <div class = "row text-right marg-15-res">
                <div class = "btn-group">
                    <?php
//                    echo $this->Html->link(__('Cancelar'), array('controller' => 'usuarios', 'action' => 'reservation'), array('class' => 'btn btn-sm btn-default'));
                    echo $this->Form->submit(__('Confirmar'), array('id' => 'reservar', 'class' => 'btn btn-sm btn-default', 'div' => false));
                    ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>