<?php echo $this->Html->script('jquery.politedatepicker'); ?>
<?php echo $this->element('menus/empresas', array('active' => 'vehiculos:inicio')) ?>
<script type="text/javascript">
    var _vehiculo_id;
    function ingMov(){
    

        $('#myModal').modal('show');
    }
    

    function ingMovM(){
        
        var mon = parseFloat($('#monto').val());
        var fecha = $('#fecha').val();
        var det = $('#detalle').val();
        var mul = parseInt($('#tipo').val());
        mon = mon * mul;

        var url = "/vehiculos/ingmov/"+fecha+"/"+det+"/"+mon;
        if (mon==0 || mon =="" || mon == "undefined" ){
            alert("ERROR! Debe ingresar un monto!"); 
            }
        else{
            //alert(url);
            $('#myModal').modal('hide');
            location.href=url;
        }
        
    }


</script>
    <section>
        <div class="container-fluid">
            <?php echo $this->element('title', ['title' => __('Inicio - Balance' )]); ?>
            <?php //echo $this->element('default_search', ['type' => 'Vehiculo' ]); ?>
            <?php echo $this->element('loader'); ?>
            

             <div class="row form-estadisticas">
                                <?php echo $this->Form->create('Vehiculo', array('url' => array('action' => 'balance'), 'class' => 'get-data')); ?>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_ini', array('class' => 'form-control lg datepicker', 'label' => __('Desde'))); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_fin', array('class' => 'form-control lg datepicker', 'label' => __('Hasta'))); ?>
                                </div>

                                <div class="col-md-6" style="margin-top:20px">
                                    <?php echo $this->Form->submit(__('Consultar')); ?>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>



            <h2>Balance General</h2>


             <div class="row">


                <div id="content" class="col-xs-12">
                    <?php //if (empty($vehiculos)) : ?>
                        <?php //echo $this->element('no_se_econtraron', ['not_found' => __('vehiculos')]); ?>
                    <?php //else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            //print_r($vehiculos);
                            $tableHeaders = $this->Html->tableHeaders(
                                array(
                                    __('Fecha'),
                                    __('Usuario'),
                                    __('Detalle'),
                                    __('Monto')
                                   
                                   
                                ), array(
                                    'id' => 'titulos'
                                )
                            );

                            echo $tableHeaders;
                            $rows = array();
                            $spacer = '&nbsp;&nbsp;';
                            
                            $tot = 0;
                            $com = 0;
                            $sal = 0;

                            $i = 0;

                   
                            
                            foreach ($vehiculos as $vehiculo) {
                             
                               $i++;
                              

                                $rows[] = array(
                                    utils::datetimetize($vehiculo[0]["fecha"]),
                                    $vehiculo[0]["usuario"],
                                    $vehiculo[0]["detalle"],
                                    '$ '.$vehiculo[0]["monto"]                                 
                                );

                                $tot = $tot + $vehiculo[0]["monto"] ;
                               

                            }
                            $rows[] = array(
                                    '',
                                    '',
                                    'TOTAL',
                                    '$ '.$tot                                 
                                );

                            echo $this->Html->tableCells($rows, array('id' => 'filas'), array('id' => 'filas'));
                            
                            ?>
                        </table>

                         <button type="button" class="btn btn-primary" onclick="ingMov()">Ingresar movimiento</button>

                        <?php //echo $this->element('paginator'); ?>
                    <?php //endif; ?>
                </div>
            </div>
        </div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Liquidar</h4>
      </div>
      <div class="modal-body">

  
          <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="datetime" class="form-control" id="fecha" name="fecha" placeholder="fecha" value = "<?php echo date('Y-m-d'); ?>" >

          </div>

           <div class="form-group">
            <label for="fecha">Detalle:</label>
            <input type="text" class="form-control" id="detalle" name="detalle" placeholder="Detalle" >

          </div>

           <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select class="form-control" name="tipo" id="tipo">
            <option value="1">Ingreso</option>
            <option value="-1">Egreso</option>
            </select> 

          </div> 


           <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="number" class="form-control" name="monto" id="monto"  step="0.01">
          </div> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="ingMovM()">Ingresar</button>
      </div>
    </div>
  </div>
</div>



    </section>
<?php echo $this->Js->writeBuffer(); ?>