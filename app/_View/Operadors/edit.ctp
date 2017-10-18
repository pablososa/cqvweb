  <?php echo $this->element('menus/empresas', array('active' => 'operadors:index')) ?>


<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Operadores'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Formulario de edicion de usuarios'); ?>
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
      
        <section id="content" class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->create('Operador', array('novalidate')); ?>
                    <?php echo $this->Form->input('id'); ?>
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('usuario', array(
                            'label' => __('Nombre de Usuario'),
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('password', array(
                            'label' => __('Contraseña'),
                            'type' => 'password',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('password2', array(
                            'label' => __('Verifique Contraseña'),
                            'type' => 'password',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <?php foreach ($this->data['KeyTelefono'] as $key => $keyTelefono) : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    if (isset($keyTelefono['id'])) {
                                        echo $this->Form->input("KeyTelefono.{$key}.id");
                                    }
                                    echo $this->Form->input("KeyTelefono.{$key}.operador_id", array('type' => 'hidden'));
                                    ?>
                                    <?php
                                    echo $this->Form->input("KeyTelefono.{$key}.key_telefono", array('label' => __('Clave de telefono'), 'class' => 'form-control'));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->input("KeyTelefono.{$key}.n_linea", array('label' => __('Número de linea'), 'class' => 'form-control'));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="row text-right">
                <div class="btn-group">
                    <?php echo $this->Html->link(__('Cancelar'), array('controller' => 'operadors', 'action' => 'index'), array('class' => 'btn btn-sm btn-default')); ?>
                    <?php echo $this->Form->button(__('Confirmar'), array('class' => 'btn btn-sm btn-default')); ?>
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