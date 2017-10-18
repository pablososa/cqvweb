<div class="row">
    <div class="col-xs-10">
        <h2><?php echo __('Perfil'); ?></h2>
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
                <h4><?php echo __('Datos de conexión'); ?></h4>
                <?php echo $this->form->input('email', ['readonly' => 'readonly']); ?>
                <?php echo $this->html->link(__('Cambiar contraseña'), ['controller' => 'usuarios', 'action' => 'changePass']); ?>
                <br>
            </div>
            <div class="col-xs-12">
                <h4><?php echo __('Información personal'); ?></h4>
                <?php echo $this->form->input('nombre'); ?>
                <?php echo $this->form->input('apellido'); ?>
                <?php echo $this->form->input('telefono', ['label' => __('Teléfono')]); ?>
                <br>
            </div>
            <div class="col-xs-12">
                <h4><?php echo __('Preferencias'); ?></h4>
                <?php echo $this->form->input('pais'); ?>
                <?php echo $this->form->input('idioma'); ?>
                <br>
                <br>
            </div>
            <div class="col-xs-12">
                <?php echo $this->form->submit('Guardar', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
        <?php echo $this->form->end(); ?>
    </div>
</div>