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
            <?php echo $this->Form->input('Usuario.pass1', [
                'label' => false,
                'type' => 'password',
                'placeHolder' => __('Ingrese su nueva contraseña')
            ]);
            ?>
            <br>
            <?php echo $this->Form->input('Usuario.pass2', [
                'label' => false,
                'type' => 'password',
                'placeHolder' => __('Confirme su nueva contraseña')
            ]);
            ?>
            <br>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-7">
        </div>
        <div class="col-xs-5">
            <?php echo $this->form->submit('Ingresar', ['class' => 'btn btn-primary btn-login']); ?>
        </div>
    </div>
    <?php echo $this->form->end(); ?>
</div>

