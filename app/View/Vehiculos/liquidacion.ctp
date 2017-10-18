<?php echo $this->element('menus/empresas', array('active' => 'vehiculos:index')) ?>
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
        var url = "/vehiculos/liquidar/"+_vehiculo_id+"/"+_fecha+"/"+mon;
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
            <?php echo $this->element('title', ['title' => __('Liquidación - Vehiculo Nro '.$vehiculo['Vehiculo']['nro_registro'] )]); ?>
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
                            foreach ($viajes as $viaje) {
                                /*
                                if ($vehiculo['Vehiculo']['habilitado'] == 'Habilitado') {
                                    $estado = $this->Html->Link(
                                        __('Deshabilitar'), array(
                                            'controller' => 'vehiculos',
                                            'action' => 'deshabilitar',
                                            $vehiculo['Vehiculo']['id']
                                        )
                                    );
                                } elseif ($vehiculo['Vehiculo']['habilitado'] == 'Deshabilitado') {
                                    $estado = $this->Html->Link(
                                        __('Habilitar'), array(
                                            'controller' => 'vehiculos',
                                            'action' => 'habilitar',
                                            $vehiculo['Vehiculo']['id']
                                        )
                                    );
                                } else {
                                    $estado = __('Eliminado');
                                }

                                $actions = $this->Html->link(__('Ver multas'), 'http://www.santafe.gov.ar', ['target' => '_blank']);
                                if ($vehiculo['Vehiculo']['habilitado'] != 'Eliminado') {
                                    $actions .= $spacer . $this->Html->link(__('Editar'), ['controller' => 'vehiculos', 'action' => 'edit', $vehiculo['Vehiculo']['id']]);
                                    $actions .= $spacer . $this->Html->link(__('Eliminar'), ['controller' => 'vehiculos', 'action' => 'delete', $vehiculo['Vehiculo']['id']], [], '¿Está seguro que desea eliminar el vehiculo ' . $vehiculo['Vehiculo']['modelo'] . ' - ' . $vehiculo['Vehiculo']['patente'] . '?');
                                }
                                $actions .= $spacer . $estado;
                                $actions .= $spacer . $this->Html->link(__('Liquidación'), ['controller' => 'vehiculos', 'action' => 'liquidacion', $vehiculo['Vehiculo']['id']]);
                                */
                                //print_r($viaje);
                                $fecha = $viaje['v']['fecha'];            
                                $viaje['v']['fecha'] = date("d-m-Y", strtotime($viaje['v']['fecha']));
                                $viaje[0]['saldo'] = $viaje[0]['comision'] - $viaje[0]['pagos'];
                                $monto = $viaje[0]['saldo'];
                                //$liq = $this->Html->link(__('Liquidar'), ['controller' => 'vehiculos', 'action' => 'liquidar', $vehiculo['Vehiculo']['id'], $fecha , $monto ], [], '¿Está seguro que desea liquidar el período correspondiente al día '.$viaje['v']['fecha'].' ?');

                                $liq = "<a href='javascript:liq(".$vehiculo['Vehiculo']['id'].",".'"'.$fecha.'"'.",".$monto.")'>Liquidar</a>"; 

                                if ($viaje[0]['saldo'] <= 0 ) $liq = "-";
                                //else {
                                     $tot = $tot + $viaje[0]['total'];
                                     $com = $com + $viaje[0]['comision'];
                                     $pag = $pag + $viaje[0]['pagos'];
                                     $sal = $sal + $viaje[0]['saldo'];
                                //}
                                 $det = $this->Html->link(__('Detalle'), ['controller' => 'viajes', 'action' => 'historyDia', $vehiculo['Vehiculo']['id'] , $fecha ] );


                                $rows[] = array(
                                    $viaje['v']['fecha'],
                                    '$'.$viaje[0]['total'],
                                    '$'.$viaje[0]['comision'],
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