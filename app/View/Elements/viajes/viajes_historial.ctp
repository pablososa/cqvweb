
<table class="table table-condensed table-admin-pendientes">
    <?php foreach ($viajeHistorials as $viajeHistorial): ?>
        <tr>
            <td><?php echo Utils::datetimetize($viajeHistorial['fecha']); ?></td>
            <td><?php echo $viajeHistorial['estado']; ?></td>
            <td><?php echo $viajeHistorial['nro_registro']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>