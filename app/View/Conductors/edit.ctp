        <?php echo $this->element('menus/empresas', array('active' => 'empresas:viewConductors')) ?>


<script src="/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/css/jquery-ui.css"></link>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ConductorFechaNac').datepicker(
                {
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1930:2006",
                    dateFormat: "dd/mm/yy"
                }
        );
    });
</script>




<div id="page-wrapper">

    <div class="container-fluid">
    <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Conductores'); ?> 
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Editar'); ?>
                            </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="panel panel-primary" style="border-color:black">
                            <div class="panel-heading" style="background:black">
                            <h2></h2>
                            </div>
                            <div class="panel-body">





<div class="container pt15 pb15">
    <div class="row">

        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Conductor', array('novalidate', 'enctype' => 'multipart/form-data')); ?>
            <div class="row">
                <div class="col-md-6"> 
                    <?php
                    echo $this->Form->hidden('id', array('label' => false, 'type' => 'text'));
                    echo $this->Form->hidden('empresa_id', array('label' => false, 'type' => 'text'));
                    echo $this->Form->hidden('password', array('label' => false));
                    ?>
                    <div class="form-group">
                        <label> <?php echo __('Nombre'); ?> </label>
                        <?php
                        echo $this->Form->input(
                                'nombre', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => 'Nombre'
                                )
                        );
                        ?>
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('Apellido'); ?> </label>
                        <?php
                        echo $this->Form->input(
                                'apellido', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => 'Apellido'
                                )
                        );
                        ?>
                    </div>

                    <div class="form-group">
                        <label> <?php echo __('Documento'); ?> </label>
                        <?php
                        echo $this->Form->input(
                                'dni', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => 'Dni'
                                )
                        );
                        ?>
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('Fecha de nacimiento'); ?> </label>
                        <input id = 'ConductorFechaNac' type="text" class = "form-control" name = "data[Conductor][fecha_nac]" value = "<?php echo $this->request->data['Conductor']['fecha_nac']; ?>" >
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('Dirección'); ?> </label>
                        <?php
                        echo $this->Form->input('direccion', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'title' => 'Por favor ingrese su domicilio',
                            'placeHolder' => 'direccion',
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('Teléfono'); ?> </label>
                        <?php
                        echo $this->Form->input('telefono', array(
                            'label' => false,
                            'type' => 'tel',
                            'class' => 'form-control required digits',
                            'title' => 'Por favor ingrese su teléfono',
                            'placeHolder' => 'telefono',
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('CUIL'); ?> </label>
                        <?php
                        echo $this->Form->input(
                                'cuil', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => 'Cuil'
                                )
                        );
                        ?>
                    </div>

                    <div class = "form-group">
                        <label> <?php echo __('Licencia'); ?> </label>
                        <br>
                        <div class="thumbnail-edit-cont">
                            <div class="thumbnail">
                                <img  class = "img-thumbnail" src="<?php echo Router::url(array('controller' => 'conductors', 'action' => 'getThumb', $this->data['Conductor']['id'].'lic')) ?>"/>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->input('file2', array(
                            'label' => false,
                            'type' => 'file',
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>


                    
                </div>

                <div class="col-md-6">
                    <div class = "form-group">
                        <label> <?php echo __('Foto'); ?> </label>
                        <br>
                        <div class="thumbnail-edit-cont">
                            <div class="thumbnail">
                                <img  class = "img-thumbnail" src="<?php echo Router::url(array('controller' => 'conductors', 'action' => 'getThumb', $this->data['Conductor']['id'])) ?>"/>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->input('file', array(
                            'label' => false,
                            'type' => 'file',
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>
                    
                    <div class="form-group">
                        <label> <?php echo __('Email'); ?> </label>
                        <?php
                        echo $this->Form->input(
                                'email', array(
                            'label' => false,
                            'type' => 'email',
                            'class' => 'form-control',
                            'placeHolder' => 'Email'
                                )
                        );
                        ?>
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('Usuario'); ?> </label>
                        <?php
                        echo $this->Form->input('usuario', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'title' => 'Por favor ingrese su usuario para la aplicación',
                            'placeHolder' => 'Enter user for app'
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="col-md-6 btn-group">
                    <?php echo $this->Html->link(__('Cambiar contraseña'), array('controller' => 'conductors', 'action' => 'changePass', $this->request->data['Conductor']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                </div>
                <div class="col-md-6 btn-group text-right">
                    <div class = "row text-right">
                        <?php echo $this->Html->link(__('Cancelar'), array('controller' => 'empresas', 'action' => 'viewConductors'), array('class' => 'btn btn-sm btn-default')); ?>
                        <?php echo $this->Form->button(__('Confirmar'), array('class' => 'btn btn-sm btn-default')); ?>
                    </div>
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