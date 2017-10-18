<?php echo $this->Html->script('jquery.politedatepicker'); ?>
<?php echo $this->element('menus/empresas', array('active' => 'vehiculos:inicio')) ?>
<script type="text/javascript">
    var _vehiculo_id;
    function liq(vehiculo_id,fecha_desde,fecha_hasta,monto){
    
        $('#fecha_desde').val(fecha_desde);
        $('#fecha_hasta').val(fecha_hasta);
        $('#monto').val(monto);
        _vehiculo_id = vehiculo_id;

        $('#myModal').modal('show');
    }
    

    function ingLiq(){
        var mon = $('#monto').val();
        var fdesde = $('#fecha_desde').val();
        var fhasta = $('#fecha_hasta').val();

        var url = "/vehiculos/liqrango/"+_vehiculo_id+"/"+fdesde+"/"+fhasta+"/"+mon;
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
            <?php echo $this->element('title', ['title' => __('Inicio - Liquidación' )]); ?>
            <?php //echo $this->element('default_search', ['type' => 'Vehiculo' ]); ?>
            <?php echo $this->element('loader'); ?>
            

             <div class="row form-estadisticas">
                                <?php echo $this->Form->create('Vehiculo', array('url' => array('action' => 'dash'), 'class' => 'get-data')); ?>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_ini', array('class' => 'form-control lg datepicker', 'label' => __('Desde'))); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_fin', array('class' => 'form-control lg datepicker', 'label' => __('Hasta'))); ?>
                                </div>

                                <div class="col-md-6">
                                    <?php echo $this->Form->input('hora_ini', array('class' => 'form-control lg', 'label' => __('Hora Inicial'), 'placeholder' => '00:00' )); ?>
                                </div>
                                 <div class="col-md-6">
                                    <?php echo $this->Form->input('hora_fin', array('class' => 'form-control lg', 'label' => __('Hora Final'), 'placeholder' => '00:00'   )); ?>
                                </div>

                                 <div class="col-md-6">
                                    <?php echo $this->Form->input('vid', array('class' => 'form-control lg', 'label' => __('Filtro Vehiculo'), 'placeholder' => '', 'value' => $vid   )); ?>
                                </div>

                                <div class="col-md-6">
                                </div>


                                <div class="col-md-6" style="margin-top:20px">
                                    <?php echo $this->Form->submit(__('Consultar')); ?>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>


            <div class="row">


                <div id="content" class="col-xs-12">
                    <?php //if (empty($vehiculos)) : ?>
                        <?php //echo $this->element('no_se_econtraron', ['not_found' => __('vehiculos')]); ?>
                    <?php //else: ?>
                        <table class="table table-hover table-striped">
                            <?php
                            //print_r($viajes);
                            $tableHeaders = $this->Html->tableHeaders(
                                array(
                                    __('Concepto'),
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

                            $totcom = 0;
                            $totpag = 0;

                            /*
                            foreach ($viajes as $viaje) {
                               $descripcion = $viaje[0]['descripcion'];       
                               $total = $viaje[0]['total'];            
                               
                                if ($descripcion=="TOTAL COMISIONES")
                                    $totcom = $total;
                                if ($descripcion=="TOTAL DE PAGOS RECIBIDOS")
                                    $totpag = $total;

                                if ($descripcion=="TOTAL POR COBRAR"){
                                    $rows[] = array(
                                        $descripcion,
                                        '$'.($totcom-$totpag)
                                       
                                    );

                                } else{
                                    $rows[] = array(
                                        $descripcion,
                                        '$'.$total
                                       
                                    );
                               }

                            }*/

                             $total_efe = 0;
                             $total_cc = 0;
                             $total_com = 0;
                             $total_pag = 0;
                             $total_cob = 0;

                             foreach ($vehiculos as $vehiculo) {
                                if ($vid != "" and $vid != $vehiculo["v"]["nro_registro"]) continue;
                                
                                $total_efe = $total_efe + $vehiculo[0]["monto"];
                                $total_cc = $total_cc + $vehiculo[0]["cc"];
                                $total_com = $total_com + ($vehiculo[0]["comision"]+$vehiculo[0]["cccoef"]);
                                $total_pag = $total_pag + $vehiculo[0]["pagos"];
                                $total_cob = $total_cob + ((($vehiculo[0]["comision"]+$vehiculo[0]["cccoef"])-$vehiculo[0]["cc"]) - $vehiculo[0]["pagos"]);

                            }

                             $rows[] = array(
                                        "TOTAL EFECTIVO",
                                        '$'.$total_efe
                                       
                                    );
                            $rows[] = array(
                                        "TOTAL CUENTA CORRIENTE ",
                                        '$'.$total_cc
                                       
                                    );
                            $rows[] = array(
                                        "TOTAL COMISIONES",
                                        '$'.$total_com
                                       
                                    );
                            $rows[] = array(
                                        "TOTAL DE PAGOS RECIBIDOS",
                                        '$'.$total_pag
                                       
                                    );
                            $rows[] = array(
                                        "TOTAL POR COBRAR",
                                        '$'.$total_cob
                                       
                                    );

                            echo $this->Html->tableCells($rows, array('id' => 'filas'), array('id' => 'filas'));
                            
                            ?>
                        </table>
                        <?php //echo $this->element('paginator'); ?>
                    <?php //endif; ?>
                </div>
            </div>

            <h2>Detalle por vehiculo</h2>


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
                                    __('Movil'),
                                    __('Efectivo'),
                                    __('Cta. Cte.'),
                                    __('Total'),
                                    __('Comision'),
                                     __('A pagar'),
                                    __('Pagos'),
                                    __('Saldo'),
                                     __('Operaciones'),
                                   
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
                               //$descripcion = $viaje[0]['descripcion'];       
                               //$total = $viaje[0]['total'];            
                               //if ($i==0) print_r($vehiculo);
                               $i++;
                               if ($vid != "" and $vid != $vehiculo["v"]["nro_registro"]) continue;
                                //$liq = "<a href='/vehiculos/liquidacion/".$vehiculo["v"]["id"]."'>Liquidar</a>"; 
                                $liq = "<a href='javascript:liq(".$vehiculo["v"]["id"].",".'"'.$fini.'"'.",".'"'.$ffin.'"'.",".($vehiculo[0]["comision"] - $vehiculo[0]["pagos"]).")'>Liquidar</a>&nbsp;
                                    <a href='/vehiculos/liquidacion/".$vehiculo["v"]["id"]."'>Detalles</a>"; 

                                $rows[] = array(
                                    'Movil '.$vehiculo["v"]["nro_registro"],
                                    '$ '.$vehiculo[0]["monto"],
                                    '$ '.$vehiculo[0]["cc"],
                                    '$ '.($vehiculo[0]["monto"]+$vehiculo[0]["cc"]),
                                    '$ '.($vehiculo[0]["comision"]+$vehiculo[0]["cccoef"]),
                                    '$ '.(($vehiculo[0]["comision"]+$vehiculo[0]["cccoef"])-$vehiculo[0]["cc"]),
                                    '$ '.$vehiculo[0]["pagos"],
                                    '$ '.((($vehiculo[0]["comision"]+$vehiculo[0]["cccoef"])-$vehiculo[0]["cc"]) - $vehiculo[0]["pagos"]),
                                    $liq
                                   
                                );
                               

                            }

                            echo $this->Html->tableCells($rows, array('id' => 'filas'), array('id' => 'filas'));
                            
                            ?>
                        </table>
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
            <label for="fecha">Fecha Inicial:</label>
            <input type="datetime" class="form-control" id="fecha_desde" name="fecha_desde" placeholder="fecha" value = "" readonly>

        
          </div>

            <div class="form-group">
            <label for="fecha">Fecha Final:</label>
            <input type="datetime" class="form-control" id="fecha_hasta" name="fecha_hasta" placeholder="fecha" value = "" readonly>
          </div>

           <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="number" class="form-control" name="monto" id="monto"  step="0.01">
          </div> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="ingLiq()">Ingresar</button>
      </div>
    </div>
  </div>
</div>



    </section>
<?php echo $this->Js->writeBuffer(); ?>