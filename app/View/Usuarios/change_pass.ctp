<div class="row">
    <div class="col-xs-10">
        <h2><?php echo __('Cambiar Contraseña'); ?></h2>
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <img class="img-thumbnail"
             src="<?php echo Router::url(array('controller' => 'usuarios', 'action' => 'getThumb', $usuario['Usuario']['id'])) ?>"/>
    </div>
    <div class="col-xs-10">
        <?php echo $this->form->create('Usuario'); ?>
        <div class="row">
            <div class="col-xs-12">
                <h4><?php echo __('Contraseña actual'); ?></h4>
                <?php echo $this->Form->input('Usuario.pass', [
                    'label' => __('Contraseña actual'),
                    'type' => 'password',
                    'placeHolder' => 'Ingrese su contraseña actual'
                ]);
                ?>
            </div>
            <div class="col-xs-12">
                <h4><?php echo __('Nueva contraseña'); ?></h4>
                <?php echo $this->Form->input('Usuario.pass1', [
                    'label' => __('Nueva contraseña'),
                    'type' => 'password',
                    'placeHolder' => 'Ingrese su nueva contraseña'
                ]);
                ?>
                <?php echo $this->Form->input('Usuario.pass2', [
                    'label' => __('Confirme'),
                    'type' => 'password',
                    'placeHolder' => 'Confirme su nueva contraseña'
                ]);
                ?>
                <br>
            </div>
            <div class="col-xs-12">
                <?php echo $this->html->link('Cancelar', ['controller' => 'usuarios', 'action' => 'miPerfil'], ['class' => 'btn btn-primary']); ?>
                <?php echo $this->form->submit('Guardar', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
        <?php echo $this->form->end(); ?>
    </div>
</div>