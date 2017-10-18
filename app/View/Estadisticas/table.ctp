<table class="table table-hover table-striped">
    <tr>
        <td><?php echo __('Total Pedidos'); ?></td>
        <td><?php echo $totales['totales']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Pedidos Por Aplicación IUNIKE'); ?></td>
        <td><?php echo $totales['app_total']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Pedidos Por Administrador'); ?></td>
        <td><?php echo $totales['admin']; ?></td>
    </tr>
</table>
<table class="table table-hover table-striped">
    <tr>
        <td rowspan="2"><?php echo __('Fecha'); ?></td>
        <td rowspan="2"><?php echo __('Administrador'); ?></td>
        <td colspan="2"><?php echo __('Aplicación IUNIKE'); ?></td>
        <td rowspan="2"><?php echo __('Totales'); ?></td>
        <td colspan="3"><?php echo __('Administrador'); ?></td>
        <td colspan="3"><?php echo __('Aplicación IUNIKE'); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Totales'); ?></td>
        <td><?php echo __('No Atendidos'); ?></td>
        <td><?php echo __('0 a 8 Hs'); ?></td>
        <td><?php echo __('8 a 16 Hs'); ?></td>
        <td><?php echo __('16 a 24 Hs'); ?></td>
        <td><?php echo __('0 a 8 Hs'); ?></td>
        <td><?php echo __('8 a 16 Hs'); ?></td>
        <td><?php echo __('16 a 24 Hs'); ?></td>
    </tr>
    <?php echo $this->Html->tableCells($estadisticas); ?>
</table>