<?php
$menus[__('Empresas')] = array(
    'url' => array('controller' => 'empresas', 'action' => 'view'),
    'icon' => 'building'
);
$menus[__('Usuarios')] = array(
    'url' => array('controller' => 'usuarios', 'action' => 'view'),
    'icon' => 'users'
);
$menus[__('Mantenimientos')] = array(
    'url' => array('controller' => 'mantenimientos', 'action' => 'index'),
    'icon' => 'life-ring'
);
$menus[__('Feriados')] = array(
    'url' => array('controller' => 'feriados', 'action' => 'index'),
    'icon' => 'calendar'
);
$menus[__('Cerrar sesión')] = array(
    'url' => array('controller' => 'admin', 'action' => 'logout'),
    'icon' => 'key'
);

echo $this->element('menus' . DS . '__render_menu', compact('active', 'menus'));