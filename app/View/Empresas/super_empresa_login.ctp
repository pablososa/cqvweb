<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo __((( isset($admin) ) ? 'Admin - ' : '') . $empresa['Empresa']['nombre']); ?> </h1>
                <h4><i> <?php echo __('Vehiculo/Conductor'); ?> </i> </h4>
            </div>
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class="row">
        <?php echo $this->element('menus/empresas', array('active' => 'empresas:')) ?>
        <section id = "content1" class="col-md-9">
            <div class = 'row'>
                <?php echo $this->Form->create('Empresa'); ?>
                <div class = "input-group input-group-lg">
                    <?php echo $this->Form->input('password', array('label' => false, 'div' => false, 'placeHolder' => __('Contraseña'))); ?>
                    <?php echo $this->Form->submit('Ingresar'); ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </section>
    </div>
</div>