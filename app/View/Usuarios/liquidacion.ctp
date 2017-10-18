<?php echo $this->element('menus/empresas', array('active' => 'usuarios:index')) ?>
<script type="text/javascript">

    var _vehiculo_id;
    var _fecha;

    function liq(vehiculo_id,fecha,monto){
        $('#fecha').val(fecha);
        $('#monto').val(monto);
        _fecha = fecha;
        _vehiculo_id = vehiculo_id;

        $('#myModal').modal('show');
    }

    function ingLiq(){
        mon = $('#monto').val();
        var url = "/usuarios/liquidar/"+_vehiculo_id+"/"+_fecha+"/"+mon;
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
            <?php echo $this->element('title', ['title' => __('Liquidación - Usuario '.$usuario['Usuario']['nombre'].' '.$usuario['Usuario']['apellido'] )]); ?>
            <?php //echo $this->element('default_search', ['type' => 'Vehiculo' ]); ?>
            <?php echo $this->element('loader'); ?>
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
                                    __('Fecha'),
                                    __('Total'),
                                    __('Comisión'),
                                    __('Pagos'),
                                    __('Saldo'),
                                    __('F.Pago'),
                                    __('Detalle'),
                                    __('Operaciones')
                                   
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
                            $pag = 0;


                             $rows[] = array(
                                    'TOTALES',
                                    '$'.$tot,
                                    '$'.$com,
                                    '$'.$pag,
                                    '$'.$sal,
                                    '',
                                    ''
                                );
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
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" placeholder="fecha" value = "" readonly>
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