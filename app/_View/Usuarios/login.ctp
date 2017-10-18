<div class="content narrow">
    <div class="row">
        <div class="col-xs-12 text-center logo">
            <?php echo $this->html->image('logo_iunike.png'); ?>
            <br>
            <br>
            <br>
        </div>
    </div>
    <?php echo $this->form->create('Usuario'); ?>
    <div class="row">
        <div class="col-xs-12 text-center">
            <?php echo $this->form->input('email', ['label' => false, 'placeholder' => 'Email']); ?>
            <br>
            <?php echo $this->form->input('pass', ['type' => 'password', 'label' => false, 'placeholder' => 'Contraseña']); ?>
            <br>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-7">
            <b><?php echo $this->Html->link('¿Olvidaste tu contraseña?', ['controller' => 'usuarios', 'action' => 'recover']); ?></b>
            <br>
            ¿No tenes cuenta?
            <b><?php echo $this->Html->link('Registrate', ['controller' => 'usuarios', 'action' => 'add']); ?></b>
        </div>
        <div class="col-xs-5">
            <?php echo $this->form->submit('Ingresar', ['class' => 'btn btn-primary btn-login']); ?>
        </div>
    </div>
    <?php echo $this->form->end(); ?>
</div>
