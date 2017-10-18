<div class="container pt15 pb15 cont-table-llamadas-entrantes">
    <table class="table table-condensed table-llamadas-entrantes">
        <?php if (!empty($ivr_llamada_entrantes)) : ?>
            <tr>
                <th><?php echo __('Telefono'); ?></th>
                <th><?php echo __('Fecha'); ?></th>
                <?php if ($empresa['Operador']['tipo'] == 'admin') : ?>
                    <th><?php echo __('Clave teléfono'); ?></td>
                <?php endif; ?>
                <th><?php echo __('linea'); ?></th>
                <th class="actions"><?php echo __('Acciones') ?></th>
            </tr>
            <?php foreach ($ivr_llamada_entrantes as $ivr_llamada_entrante) : ?>
                <?php
                $classes = array();
                if (!empty($ivr_llamada_entrante['Viaje']['estado'])) {
                    $classes[] = 'viaje-' . strtolower($ivr_llamada_entrante['Viaje']['estado']);
                }
                if ($ivr_llamada_entrante['IvrLlamadaEntrante']['atendido'] == 'yes') {
                    $classes[] = 'atendido';
                }
                $classes = implode(' ', $classes);
                ?>
                <tr class="<?php echo $classes; ?>">
                    <td><?php echo $ivr_llamada_entrante['IvrLlamadaEntrante']['telefono']; ?></td>
                    <td><?php echo Utils::datetimetize($ivr_llamada_entrante['IvrLlamadaEntrante']['fecha']); ?></td>
                    <?php if ($empresa['Operador']['tipo'] == 'admin') : ?>
                        <td><?php echo $ivr_llamada_entrante['IvrLlamadaEntrante']['key_telefono']; ?></td>
                    <?php endif; ?>
                    <td>
                        <?php
                        if (!empty($empresa['Operador']['key_telefono'][$ivr_llamada_entrante['IvrLlamadaEntrante']['key_telefono']])) {
                            echo $empresa['Operador']['key_telefono'][$ivr_llamada_entrante['IvrLlamadaEntrante']['key_telefono']];
                        }
                        ?>
                    </td>
                    <td class="actions">
                        <?php 
//echo $this->Html->link(__('Atender'), array('controller' => 'ivr_clientes', 'action' => 'view', $ivr_llamada_entrante['IvrLlamadaEntrante']['telefono'])); 
echo $this->Html->link(__('Atender'), array('controller' => 'ivr_domicilios', 'action' => 'add', $ivr_llamada_entrante['IvrLlamadaEntrante']['telefono']));
?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>