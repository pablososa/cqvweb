        <?php echo $this->element('menus/empresas', array('active' => 'empresas:reservation')) ?>

<script type = "text/javascript">
    $(document).ready(function() {

        actualizar();

        $('table tr').mouseover(function() {
            if ($(this).attr('id') != 'titulos') {
                $(this).toggleClass('success');
            }
        });
        $('table tr').mouseout(function() {
            if ($(this).attr('id') != 'titulos') {
                $(this).toggleClass('success');
            }
        });

        function actualizar() {
            $('table tr#filas').each(function() {
                var tiempo = $(this).children('#h').text().split(':');
                var date = new Date();
                var an = date.getFullYear();
                var mes = date.getMonth();
                mes += 1;
                var dia = date.getDate();
                var fecha = $(this).children('#f').text().split('-');
                var anr = fecha[0];
                var mesr = fecha[1];
                var diar = fecha[2];
                var h = date.getHours();
                var m = date.getMinutes();
                var hr = tiempo[0];
                var mr = tiempo[1];
                var hora, min;
                if ((parseInt(anr) - parseInt(an)) == 1 || (parseInt(mesr) - parseInt(mes)) == 1 || (parseInt(diar) - parseInt(dia)) == 1) {
                    var resto = 24 - parseInt(h);
                    hora = resto + parseInt(hr);
                } else {
                    hora = parseInt(hr - h);
                }
                min = parseInt(mr) - parseInt(m);
                if (min < 0) {
                    hora--;
                    min = 60 + min;
                }
                (min < 10) ? min = '0' + min : min;
                (hora < 10) ? hora = '0' + hora : hora;
                $(this).children('#tr').text(hora + ':' + min + ' hs');
            });
        }

        setInterval(actualizar, 60000);

    });
</script>

<div id="page-wrapper">

            <div class="container-fluid">




  <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo __('Reservas'); ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <?php echo __('Reservas'); ?>
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




    <div class="row">

        <section id = "content" class="col-md-9">
            <?php
            if (empty($reservas)) {
                echo __('No se encontraron reservas.');
            } else {
                ?>	
                <table class = "table table-hover table-striped" valign = "middle">
                    <tr id = "titulos">
                     <th> <?php echo __('Id'); ?> </th>
                        <th> <?php echo __('Pasajero'); ?> </th>
                        <th> <?php echo __('Origen'); ?> </th>
                        <th> <?php echo __('Destino'); ?> </th>
                        <th> <?php echo __('Fecha'); ?> </th>
                        <th> <?php echo __('Hora'); ?> </th>
                        <th> <?php echo __('Observaciones'); ?> </th>
                        <th> <?php echo __('Acciones'); ?> </th>
                    </tr>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr id = "filas" align = "center">
                            <td> <?php echo $reserva['Viaje']['id']; ?> </td>
                            <td> <?php echo $reserva['Viaje']['usuario']; ?> </td>
                            <td> <?php echo $reserva['Viaje']['dir_origen']; ?> </td>
                            <td> <?php echo $reserva['Viaje']['dir_destino']; ?> </td>
                            <td id = "f"> <?php echo $reserva['Viaje']['fecha']; ?> </td>
                            <td id = "h"> <?php echo $reserva['Viaje']['hora']; ?> </td>
                            <td> <?php echo $reserva['Viaje']['observaciones']; ?> </td>
                            <td> 
                            
                            <form accept-charset="utf-8" method="post" id="ViajeAdminResDif" action="/viajes/adminAdd" novalidate="novalidate">
                            <input type="hidden" value="<?php echo $reserva['Viaje']['dir_origen']; ?>" name="data[Viaje][dir_origen]">
                            <input type="hidden" value="<?php echo $reserva['Viaje']['dir_destino']; ?>" name="data[Viaje][dir_destino]">
                            <input type="hidden" value="<?php echo $reserva['Viaje']['observaciones']; ?> " name="data[Viaje][observaciones]">
                            <input type="hidden" value="<?php echo $reserva['Viaje']['id']; ?> " name="data[Viaje][id]">
                            <input type="hidden" value="" name="data[Viaje][vehiculo_id]">
                            <input type="submit" value="Dispatch" class="btn btn-sm btn-default" >
                            </form>


                            </td>
                        </tr>
                    <?php endforeach;
                } ?>
            </table>
        </section>
    </div>

    </div>
</div>

    </div>
</div>