
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
                                <i class="fa fa-home"></i>  <?php echo __('Mi perfil'); ?>
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

        <h3 style="color:black">
        <?php
        echo __($empresa['Empresa']['nombre']);
                        ?>: Profile
                        </h3>
                        
        <section id = "content1" class="col-md-9" style="background-color:white">
            <?php /*
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img  class = "img-thumbnail" id = "usuario" src="<?php echo Router::url(array('controller' => 'empresas', 'action' => 'getThumb', $empresa['Empresa']['id'])) ?>"/>
                </div>
            </div>
             */ ?>


            <div class = "col-md-4">

                         <div class = "form-group">
                                    <label>  </label>
                                    <br>
                                    <div class="thumbnail-edit-cont">
                                        <div class="thumbnail">
                                            <img  class = "img-thumbnail" src="/conductors/getThumb/"/>
                                        </div>
                                    </div>
                                   
                            </div>
</div>
<div class = "col-md-4">
                <dl>
                    <dt> <?php echo __('Nombre:'); ?> </dt>
                    <dd> 
                        <?php
                        echo __($empresa['Empresa']['nombre']);
                        ?> 
                    </dd>
                    <dt> <?php echo __('Cuit:'); ?> </dt>
                    <dd> 
                        <?php
                        echo __($empresa['Empresa']['cuit']);
                        ?> 
                    </dd>
                    <dt> <?php echo __('Dirección:'); ?> </dt>
                    <dd> 
                        <?php
                        echo __($empresa['Empresa']['direccion']);
                        ?> 
                    </dd>
                    <dt> <?php echo __('E-mail:'); ?> </dt>
                    <dd> 
                        <?php
                        echo __($empresa['Empresa']['email']);
                        ?> 
                    </dd>
                    <dt> <?php echo __('Teléfono'); ?> </dt>
                    <dd> 
                        <?php
                        echo __($empresa['Empresa']['telefono']);
                        ?> 
                    </dd>
                </dl>
            </div>
            
                <div class = "row text-right">
                    <div class = "btn-group">
                        <?php
                        echo $this->Html->link(__('Cambiar Contraseña'), array(
                            'controller' => 'empresas',
                            'action' => 'ChangePassword'
                                ), array(
                            'class' => 'btn btn-sm btn-default'
                                )
                        );
                        ?>
                    </div>	
                </div>
        </section>
    </div>
</div>