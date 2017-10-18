<?php
/* header('Content-Type: text/html; charset=UTF-8'); */
?>
<?php echo $this->Html->script('jquery-ui-1.8.23.custom.min'); ?>
<?php echo $this->Html->script('jquery.bgiframe-2.1.2'); ?>
<?php echo $this->Html->script('jquery.metadata'); ?>
<?php echo $this->fetch('script'); ?>
<script>
    $(document).ready(function() {

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

        $('table tr').click(function() {
            var div = $('<div id = "emerg" title = "Informacion del viaje" style = "display: none;">');
            var datos = $('<dl class = "dl-horizontal"> \ ');
            datos.append('<dt> Pasajero <dt> <dd> $(this).eq(0).text(); <dd> \ ');
            datos.append('</dl> \ ');
            div.append(datos);
            $('#content1').append(div);
            div.dialog();
        });
    });
</script>
<style type="text/css">

    div.htmltooltip{
        position: absolute; /*leave this and next 3 values alone*/
        z-index: 1000;
        left: -1000px;
        top: -1000px;
        background: #272727;
        border: 10px solid black;
        color: white;
        padding: 3px;
        width: 250px; /*width of tooltip*/
    }

</style>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo (isset($admin) ? 'Admin - ' : '') . $empresa['Empresa']['nombre']; ?> </h1>
                <h4><i> <?php echo __('Historial de viajes'); ?> </i> </h4>
            </div>
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class="row">
        <?php echo $this->element('menus/empresas', array('active' => 'empresas:travelHistory')) ?>
        <section id = "content1" class="col-md-9">
            <?php
            if (empty($viajes)) {
                echo __('No se encontraron viajes.');
            } else {
                echo $this->Paginator->options(
                        array(
                            'update' => '#content',
                            'before' => $this->Js->get('#loader')->effect(
                                    'fadeIn', array(
                                'buffer' => false
                                    )
                            ),
                            'complete' => $this->Js->get('#loader')->effect(
                                    'fadeOut', array(
                                'buffer' => false
                                    )
                            )
                        )
                );
                ?>
                <div class ="row text-center">
                <?php
                echo $this->Html->image(
                        'loader.gif', array(
                    'id' => 'loader',
                    'hidden' => 'hidden'
                        )
                );
                ?>
                </div>
                <div class="row">
                    <table class = "table table-condensed">
    <?php
    $tableHeaders = $this->Html->tableHeaders(
            array(
        __('Pasajero'),
        __('Conductor'),
        $this->Paginator->sort('fecha', __('Fecha')),
        $this->Paginator->sort('hora', __('Hora')),
        $this->Paginator->sort('distancia', __('Distancia')),
        $this->Paginator->sort('tarifa', __('Tarifa')),
        $this->Paginator->sort('dir_origen', __('Origen')),
        $this->Paginator->sort('dir_destino', __('Destino'))
            ), array(
        'id' => 'titulos'
            )
    );
    echo $tableHeaders;
    $rows = array();
    foreach ($viajes as $viaje) {
        $rows[] = array(
            $pasajeros[$viaje['Viaje']['id']],
            $conductores[$viaje['Viaje']['id']],
            $viaje['Viaje']['fecha'],
            $viaje['Viaje']['hora'],
            $viaje['Viaje']['distancia'],
            $viaje['Viaje']['tarifa'],
            $viaje['Viaje']['dir_origen'],
            $viaje['Viaje']['dir_destino']
        );
    }
    echo $this->Html->tableCells(
            $rows, array(
        'id' => 'filas'
            ), array(
        'id' => 'filas'
            )
    );
    ?>
                    </table>
                    <div class = "row text-center">
                        <ul class = 'pagination'>
                            <li>
                        <?php
                        echo $this->Paginator->prev('<<');
                        ?>
                            </li>
    <?php
    echo $this->Paginator->numbers(array(
        'tag' => 'li',
        'currentTag' => 'a',
        'currentClass' => 'active',
        'separator' => ''
    ));
    ?>
                            <li>
                            <?php
                            echo $this->Paginator->next('>>');
                        }
                        ?>
                        </li>
                    </ul>
                </div>
            </div>
                            <?php
                            echo $this->Js->writeBuffer();
                            ?>
        </section>
    </div>
</div>
