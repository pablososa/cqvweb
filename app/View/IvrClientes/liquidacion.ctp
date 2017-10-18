<?php echo $this->element('menus/empresas', array('active' => 'clientes:index')) ?>
<script type="text/javascript">

    var _cliente_id;
    var _usuario_id;

    function liq(cliente_id,usuario_id,monto,usuario){
        $('#usuario').val(usuario);
        $('#monto').val(monto);
        _cliente_id = cliente_id;
        _usuario_id = usuario_id;

        $('#myModal').modal('show');
    }

    function ingLiq(){
        mon = $('#monto').val();
        var url = "/ivr_clientes/liquidar/"+_cliente_id+"/"+_usuario_id+"/"+mon;
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
            <?php echo $this->element('title', ['title' => __('Liquidación - Cuenta Corriente' )]); ?>
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
                                    __('Usuario'),
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
                            $sal = 0;
                            $pag = 0;
                            
                            foreach ($viajes as $viaje) {
                                
                       
                                $fecha = $viaje['v']['fecha']; 

                                $viaje['v']['fecha'] = date("d-m-Y", strtotime($viaje['v']['fecha']));

                                if ($viaje['v']['fecha'] =='31-12-1969') continue;  
                                
                                $viaje[0]['saldo'] = $viaje[0]['total'] - $viaje[0]['pagos'];
                                $monto = $viaje[0]['saldo'];
                                //$liq = $this->Html->link(__('Liquidar'), ['controller' => 'vehiculos', 'action' => 'liquidar', $vehiculo['Vehiculo']['id'], $fecha , $monto ], [], '¿Está seguro que desea liquidar el período correspondiente al día '.$viaje['v']['fecha'].' ?');

                                $liq = "<a href='javascript:liq(".$viaje['u']['cliente_id'].",".$viaje['u']['usuario_id'].",".$monto.",".'"'.$viaje[0]['usuario'].'"'.")'>Liquidar</a>"; 

                                if ($viaje[0]['saldo'] == 0 ) $liq = "-";
                                //else {
                                     $tot = $tot + $viaje[0]['total'];
                                     $pag = $pag + $viaje[0]['pagos'];
                                     $sal = $sal + $viaje[0]['saldo'];
                                //}
                                 $det = $this->Html->link(__('Detalle'), ['controller' => 'viajes', 'action' => 'customerHistory', $viaje['u']['usuario_id'] ] );


                                $rows[] = array(
                                    $viaje['v']['fecha'],
                                    '$'.$viaje[0]['total'],
                                    $viaje[0]['usuario'],
                                    '$'.$viaje[0]['pagos'],
                                    '$'.$viaje[0]['saldo'],
                                    $viaje[0]['pago'],
                                     $det,
                                    $liq
                                );
                               

                            }


                             $rows[] = array(
                                    'TOTALES',
                                    '$'.$tot,
                                    '-',
                                    '$'.$pag,
                                    '$'.$sal,
                                    '',
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
            <label for="usuario">Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario" value = "" readonly>
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