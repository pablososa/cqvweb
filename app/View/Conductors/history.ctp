<script>
    $(document).ready(function () {
        $('table tr').mouseover(function () {
            if ($(this).attr('id') != 'titulos') {
                $(this).toggleClass('success');
            }
        });
        $('table tr').mouseout(function () {
            if ($(this).attr('id') != 'titulos') {
                $(this).toggleClass('success');
            }
        });
        $('#volver').click(function () {
            document.location.href = 'empresas/viewConductors'
        });
    });
</script>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1> <?php echo __($empresa['Empresa']['nombre']); ?> </h1>
                <h4><i> <?php echo __('Trip history'); ?> </i></h4>
            </div>
            <div class="col-sm-6 hidden-xs">
                <ul id="navTrail">
                    <li><a href="empresas"> <?php echo __('Empresas'); ?> </a></li>
                    <li id="navTrailLast"> <?php echo __('travelHistory'); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container pt15 pb15">
    <div class="row">
        <?php echo $this->element('menus/empresas', array('active' => 'empresas:viewConductors')) ?>
        <section id="content1" class="col-md-9">
            <?php
            if (empty($viajes)){
                echo __('The conductor ' . $conductor . ' has not trips.');
            }else{
            ?>
            <h2> <?php echo __('Trips made by the driver: ' . $conductor); ?> </h2>
            <table class="table table-condensed">
                <tr id="titulos">
                    <th> Passenger</th>
                    <th> Date</th>
                    <!--th> Hora </th-->
                    <th> Origin</th>
                    <th> Destination</th>
                    <th> Estado</th>
                    <th> Observations</th>
                </tr>
                <?php foreach ($viajes as $viaje): ?>
                <tr>
                    <td> <?php echo $viaje['Viaje']['usuario']; ?> </td>
                    <td> <?php echo Utils::datetimetize($viaje['Viaje']['fecha'] . ' ' . $viaje['Viaje']['hora']); ?> </td>
                    <td> <?php echo $viaje['Viaje']['dir_origen']; ?> </td>
                    <td> <?php echo $viaje['Viaje']['dir_destino']; ?> </td>
                    <td> <?php echo $viaje['Viaje']['estado']; ?> </td>
                    <td> <?php echo $viaje['Viaje']['observaciones']; ?> </td>
                    <?php endforeach;
                    } ?>
            </table>
            <div class="row text-right">
                <div class="btn-group">
                    <button id="volver" class="btn btn-sm" type="submit"> Back</button>
                </div>
            </div>
        </section>
    </div>
</div>