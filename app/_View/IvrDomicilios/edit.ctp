<?php echo $this->element('maps_js')?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#IvrDomicilioDomicilio').directionSearch('<?php echo $empresa['Empresa']['direccion']; ?>');
    });
</script>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo (isset($admin) ? 'Admin - ' : '') . $empresa['Empresa']['nombre']; ?> </h1>
                <h4><i><?php echo __('Editar domicilio'); ?></i></h4>
            </div>
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class = 'row'>
        <div class="row">
            <?php echo $this->element('menus/empresas', array('active' => 'viajes:adminHistory')); ?>
        <section id = "content" class="col-md-9">
            <?php  echo $this->Form->create('IvrDomicilio', array('novalidate')); ?>
            <div class="container">
                <div class="row">
                    <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
                    <?php echo $this->Form->input('ivr_cliente_id', array('type' => 'hidden')); ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $this->Form->input('domicilio', array('label' => __('Domicilio'), 'class' => 'form-control',)); ?>
                        </div>
                        <div class="form-group">
                            <?php
                            echo $this->Form->input('es_principal', array(
                                'options' => $si_no,
                                'class' => 'form-control'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->input('observaciones', array(
                                'label' => __('Observaciones'),
                                'class' => 'form-control'
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class = "row text-right">
                    <div class = "btn-group">
                        <?php
                        echo $this->Form->button(__('Confirmar'), array(
                            'class' => 'btn btn-sm btn-default'
                                )
                        );
                        ?>
                    </div>	
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    </div>
</div>



