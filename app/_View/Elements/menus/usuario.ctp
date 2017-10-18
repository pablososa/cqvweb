<?php
//$menus[__('Reserva')] = array(
//    'url' => array('controller' => 'usuarios', 'action' => 'reservation'),
//    'icon' => 'users'
//);
$menus[__('Perfil')] = array(
    'url' => array('controller' => 'usuarios', 'action' => 'miPerfil'),
    'icon' => 'address-book',
    'info' => __('Actualizar tus datos personales, foto, email y contraseña')
);
$menus[__('Trayectos')] = array(
    'url' => array('controller' => 'usuarios', 'action' => 'history'),
    'icon' => 'map-marker',
    'info' => __('Ver todos tus trayectos ya realizados en detalle')
);
$menus[__('Balance')] = array(
    'url' => array('controller' => 'usuarios', 'action' => 'balance'),
    'icon' => 'balance-scale',
    'info' => __('Tu balance e historial de recibos, pagos y reembolsos')
);
//$menus[__('Cerrar sesión')] = array(
//    'url' => array('controller' => 'usuarios', 'action' => 'logout'),
//    'icon' => 'users'
//);

echo $this->element('menus' . DS . '__render_menu', compact('active', 'menus'));