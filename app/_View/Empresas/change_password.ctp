   <?php echo $this->element('menus/empresas', array('active' => 'empresas:miPerfil'))?>
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Mi perfil'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Cambiar Contraseña'); ?>
                            </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->



              <div class="panel panel-primary" style="border-color:black">
                            <div class="panel-heading" style="background:black">
                            <h2></h2>
                            </div>
                            <div class="panel-body" style="margin: 10px">



<div class="container pt15 pb15">
    <div class="row">
     
        <div class="row">
            <section id = "content1" class="col-md-9">
                <?php echo $this->Form->create('Empresa'); ?>
                <div class = "form-group">
                    <div class = "col-md-12">
                        <?php echo $this->Form->input('password_old', array('type' => 'password', 'label' => 'Contraseña actual', 'class' => "form-control sm")); ?>
                    </div>
                </div>
                <div class = "form-group">
                    <div class = "col-md-12">
                        <?php echo $this->Form->input('password1', array('type' => 'password', 'label' => 'Contraseña nueva', 'class' => "form-control sm")); ?>
                    </div>
                </div>
                <div class = "form-group">
                    <div class = "col-md-12">
                        <?php echo $this->Form->input('password2', array('type' => 'password', 'label' => 'Repita la contraseña nueva', 'class' => "form-control sm")); ?>
                    </div>
                </div>
                <div class = "row text-right">
                    <div class = "btn-group">
                        <?php echo $this->Form->submit('Confirmar', array('class' => 'btn btn-sm btn-default')); ?>
                    </div>	
                </div>
                <?php echo $this->Form->end(); ?>
            </section>
        </div>
    </div>
</div>


    </div>
</div>
    </div>
</div>