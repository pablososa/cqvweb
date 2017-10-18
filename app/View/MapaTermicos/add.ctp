
        <?php echo $this->element('menus/empresas', array('active' => 'mapaTermicos:index')) ?>



<?php echo $this->element('maps_js')?>
<script type="text/javascript">
    $(document).ready(function() {

        //var intervalo;
        var lat_o = false;
        var lng_o = false;

        var options = {
            types: ['geocode']
        };

        var geocoder = new google.maps.Geocoder();

        new google.maps.places.Autocomplete(document.getElementById('EventoDireccion'), options);

        $.validator.addMethod("regex", function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Please check your input.");
        var validator = $('#CAMBIARAddForm').validate({
            errorPlacement: function(error, element) {
                element.parent().after(error);
            },
            rules: {
                "data[Evento][direccion]": {
                    required: true,
                    regex: /.{3,30} [0-9]{1,5}, .{3,30}, .{3,30}/
                },
               
            },
            messages: {
                "data[Evento][direccion]": {
                    required: "Debes ingresar una dirección de origen",
                    regex: 'Dirección inválida ej: "San Martín 1234, Santa Fe, Argentina"'
                }
            }
        });


    });
</script>


  <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Nuevo Viaje fijo'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Nuevo Viaje fijo'); ?>
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

        <section id = "content" class="col-md-9">
            <?php echo $this->Form->create('Evento', array('novalidate')); 
                echo $this->Form->hidden('localidad', array('label' => false, 'type' => 'text'));
            ?>
            <div class="row">
                <div class="col-md-6"> 
                <div class="form-group">
                        <label> <?php echo __('Nombre'); ?> </label>
                        <?php
                        echo $this->Form->input('bussiness', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <label> <?php echo __('Observaciones'); ?> </label>
                        <?php
                        echo $this->Form->input('descripcion', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>
                     
                   			
                </div>

                 
                 <div class="col-md-6"> 
                 <div class="form-group">
                        <label> <?php echo __('Costo'); ?> </label>
                        <?php
                        echo $this->Form->input('cant_personas', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>      
                <div class="form-group">

                        <label> <?php echo __('Direccion'); ?> </label>
                        <?php
                        echo $this->Form->input('direccion', array(
                            'label' => false,
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeHolder' => ''
                        ));
                        ?>
                    </div>  
                 </div>


            </div>
            <div class = "row text-right">
                <div class = "btn-group">
                    <?php
                    echo $this->Html->link(__('Cancelar'), array(
                        'controller' => 'mapaTermicos',
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