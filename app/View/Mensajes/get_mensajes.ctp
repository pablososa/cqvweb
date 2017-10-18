<div class="messages-board">
    <?php echo $this->Form->create('Mensaje', array('action' => 'add')); ?>
    <?php echo $this->Form->input('vehiculo_id', array('type' => 'hidden', 'value' => $vehiculo_id)); ?>
    <div class="input-group input-group-lg">
        <?php echo $this->Form->input('texto', array('label' => false, 'div' => false, 'class' => 'form-control lg', 'placeHolder' => 'Mensaje')); ?>
        <?php
        echo $this->Form->submit(__('Enviar'), array(
            'class' => 'btn btn-sm icon-search btn-primary',
            'div' => 'input-group-btn',
            'escape' => false
        ));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
    <br>
    <div class="all-messajes-container">
        <?php if (empty($mensajes)) : ?>
            <div class="jumbotron not-found">
                <?php echo __('No existe ningún mensaje.'); ?>
            </div>
        <?php else: ?>
            <?php foreach ($mensajes as $mensaje): ?>
                <?php
                $user_class = $mensaje['Mensaje']['operador'] ? 'operador' : 'vehiculo';
                $mensaje_class = $mensaje['Mensaje']['visto'] ? 'visto' : 'pendiente';
                if (empty($pre_user_class)) {
                    $pre_user_class = $user_class;
                    $first_round = true;
                }
                $has_changed = $pre_user_class != $user_class;
                $pre_user_class = $user_class;
                ?>
                <?php if ($first_round) : ?>
                    <div class="mensaje-cont <?php echo $user_class . ' ' . $mensaje_class; ?>">
                    <div class="mensaje">
                <?php endif; ?>
                <?php if ($has_changed) : ?>
                    </div>
                    </div>
                    <div class="mensaje-cont <?php echo $user_class . ' ' . $mensaje_class; ?>">
                    <div class="mensaje">
                <?php elseif (!$first_round) : ?>
                    <hr/>
                <?php endif; ?>
                <div class="texto">
                    <?php echo $mensaje['Mensaje']['texto']; ?>
                </div>
                <div>
                    <div class="fecha">
                        <?php echo date('d/m/Y H:i:s', strtotime($mensaje['Mensaje']['fecha'])); ?>
                        <?php
                        if ($mensaje['Mensaje']['operador']) {
                            echo '&nbsp;';
                            echo $mensaje['Mensaje']['visto'] ? '&#10004;' : '&#10006;';
                        }
                        ?>
                    </div>
                </div>
                <?php $first_round = false; ?>
            <?php endforeach; ?>
            <?php if (isset($first_round)) : ?>
                </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="text-center">
        <?php echo $this->Paginator->next(__('Ver mas'), array('class' => 'btn btn-info'), null, array('class' => 'next disabled')); ?>
    </div>
</div>