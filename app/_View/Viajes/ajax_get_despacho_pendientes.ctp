<?php if (!empty($despacho_pendientes)):?>
    <h4><?php echo __('Pendientes'); ?></h4>
    <table class="table table-condensed table-admin-pendientes">
        <tr>
            <th><?php echo __('Usuario'); ?></th>
            <th><?php echo __('Origen'); ?></th>
            <th><?php echo __('Destino'); ?></th>
            <th><?php echo __('Fecha'); ?></th>
            <th class="actions"><?php echo __('Acción'); ?></th>
        </tr>
        <?php foreach($despacho_pendientes as $despacho_pendiente) : ?>
            <tr>
                <td>
                    <?php
                    if(!empty($despacho_pendiente['IvrDomicilio']['IvrCliente']['telefono'])) {
                        echo $this->Html->link($despacho_pendiente['IvrDomicilio']['IvrCliente']['telefono'], array('controller' => 'ivr_clientes', 'action' => 'view', $despacho_pendiente['IvrDomicilio']['IvrCliente']['telefono']));
                    } elseif(!empty($despacho_pendiente['Usuario']['nombre'])) {
                        echo $despacho_pendiente['Usuario']['nombre'];
                    } else {
                        echo '&nbsp;';
                    }
                    ?>
                </td>
                <td><?php echo $despacho_pendiente['Viaje']['dir_origen']?></td>
                <td><?php echo $despacho_pendiente['Viaje']['dir_destino']?></td>
                <td><?php echo Utils::datetimetize($despacho_pendiente['Viaje']['fecha'] . ' ' . $despacho_pendiente['Viaje']['hora']); ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Detalles'), '#', array('class' => 'slide-down-fixed')); ?>
                    <?php echo $this->Html->link(__('Eliminar'), array('action' => 'deleteDespachoPendiente', $despacho_pendiente['Viaje']['id']), array(), __('¿Desea eliminar el viaje pendiente?')); ?>
                    <?php echo $this->Html->link(__('Crear Viaje'), array('controller' => 'viajes', 'action' => 'createFromDespachoPendiente', $despacho_pendiente['Viaje']['id']), array('class' => 'js-create-viaje')); ?>
                </td>
            </tr>
            <tr class="hidden-fixed-slide-down">
                <td>
                    <div>
                        <?php echo empty($despacho_pendiente['IvrDomicilio']['IvrCliente']['telefono']) ? '' : 'Telefono: ' . $despacho_pendiente['IvrDomicilio']['IvrCliente']['telefono']; ?>
                        <hr>
                        <?php echo $despacho_pendiente['Viaje']['observaciones']; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script type="text/javascript">
//        $(document).ready(function () {
//            $('.details').fixedSlideDown();
//        });
    </script>
<?php endif; ?>