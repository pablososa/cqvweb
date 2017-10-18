        <?php echo $this->element('menus/empresas', array('active' => 'msjpredefinidos:index')) ?>

<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Mensajes'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Mensajes'); ?>
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


<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo __((( isset($admin) ) ? 'Admin - ' : '') . $empresa['Empresa']['nombre']); ?> </h1>
                <h4><i> <?php echo __('Formulario de creación de mensajes predefinidos'); ?> </i> </h4>
            </div>
            
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class="row">

        <section id = "content" class="col-md-9">
            <div class="row">
                <div class="col-md-12"> 
                    <?php echo $this->Form->create('Mjspredefinido', array('novalidate')); ?>
                    <div class="form-group">
                        <label> <?php echo __('Texto'); ?> </label>
                        <?php
                        echo $this->Form->input('texto', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class = "row text-right">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array(
                        'controller' => 'mjspredefinidos',
                        'action' => 'index'
                            ), array(
                        'class' => 'btn btn-sm btn-default'
                            )
                    );
                    echo $this->Form->button(__('Confirmar'), array(
                        'class' => 'btn btn-sm btn-default'
                            )
                    );
                    ?>
                </div>	
                <?php echo $this->Form->end(); ?>
            </div>
        </section>
    </div>
</div>

</div>

    </div>
</div>

    </div>
</div>