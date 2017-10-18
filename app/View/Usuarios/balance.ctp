<div class="row">
    <div class="col-xs-12">
        <h2><?php echo __('Balance'); ?></h2>
    </div>
    <div class="col-xs-12">
        <?php if (empty($pagos)): ?>
            <table class="table table-hover table-striped">
                <tr>
                    <td><?php echo __('No hay informacion para mostrar'); ?></td>
                </tr>
            </table>
        <?php else: ?>
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo $this->Paginator->sort('fecha_hora', __('Fecha')); ?></th>
                    <th><?php echo $this->Paginator->sort('id', __('Nro. Liquidacion')); ?></th>
                    <th><?php echo $this->Paginator->sort('usuario', __('Usuario')); ?></th>
                    <th><?php echo $this->Paginator->sort('monto', __('Monto')); ?></th>
                    <th><?php echo $this->Paginator->sort('detalle', __('Detalle')); ?></th>
                </tr>
                <?php foreach ($pagos as $pago): ?>
                    <tr>
                        <td><?php echo Utils::datetimetize($pagos[0]['apptaxi_ivr_clientes_pagos']['fecha']); ?></td>
                        <td>#00<?php echo $pagos[0]['apptaxi_ivr_clientes_pagos']['id']; ?></td>
                        <td><?php echo $usuario['Usuario']['email']; ?></td>
                        <td>$<?php echo $pagos[0]['apptaxi_ivr_clientes_pagos']['monto']; ?></td>
                        <td><?php echo '<a href = "/usuarios/history">Detalle</a>'; ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                        <td>SALDO</td>
                        <td></td>
                        <td></td>
                        <td>-</td>
                    </tr>

            </table>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->element('paginator'); ?>
