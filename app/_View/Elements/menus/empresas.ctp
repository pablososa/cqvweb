<?php
$menus = [];

$menus[__('Inicio')] = array(
    'url' => array('controller' => 'vehiculos', 'action' => 'inicio'),
    'icon' => 'tachometer'
);
$menus[__('Clientes')] = array(
    'url' => array('controller' => 'ivr_clientes', 'action' => 'index'),
    'icon' => 'users'
);
$menus[__('Historial de clientes')] = array(
    'url' => array('controller' => 'usuarios', 'action' => 'customerHistory'),
    'icon' => 'users'
);
$menus[__('Viajes Diferidos')] = array(
    'url' => array('controller' => 'viaje_diferidos', 'action' => 'index'),
    'icon' => 'clock-o'
);
$menus[__('Viajes Programados')] = array(
    'url' => array('controller' => 'viaje_programados', 'action' => 'index'),
    'icon' => 'calendar-check-o'
);
if (CakeSession::check('EmpresaAdmin')) {
    $menus[__('Conductores')] = array(
        'url' => array('controller' => 'empresas', 'action' => 'viewConductors'),
        'icon' => 'user'
    );
    $menus[__('Vehiculos')] = array(
        'url' => array('controller' => 'vehiculos', 'action' => 'index'),
        'icon' => 'car'
    );
}

//$menus[__('Reservas')] = array(
//    'url' => array('controller' => 'empresas', 'action' => 'reservation'),
//    'icon' => 'map-marker'
//);
$menus[__('Vehiculo/Conductor')] = array(
    'url' => array('controller' => 'empresas', 'action' => 'viewRelationships'),
    'icon' => 'taxi'
);
$menus[__('Visualización')] = array(
    'url' => array('controller' => 'empresas', 'action' => 'visualization'),
    'icon' => 'eye'
);
//$menus[__('Thermal Map - Events')] = array(
//    'url' => array('controller' => 'mapaTermicos', 'action' => 'index'),
//    'icon' => 'globe'
//);
$menus[__('Historial de viajes')] = array(
    'url' => array('controller' => 'viajes', 'action' => 'history'),
    'icon' => 'calendar'
);
/*
$menus[__('Viajes Último día')] = array(
    'url' => array('controller' => 'viajes', 'action' => 'historyLast'),
    'icon' => 'clock-o'
);*/
$menus[__('Crear Viaje')] = array(
    'url' => array('controller' => 'viajes', 'action' => 'adminHistory'),
    'icon' => 'location-arrow'
);
$menus[__('Mensajes')] = array(
    'url' => array('controller' => 'vehiculos', 'action' => 'mensajes'),
    'icon' => 'envelope'
);
$menus[__('Mensajes Predefinidos')] = array(
    'url' => array('controller' => 'mjspredefinidos', 'action' => 'index'),
    'icon' => 'folder-open'
);
if (CakeSession::check('EmpresaAdmin')) {
    $menus[__('Estadísticas')] = array(
        'url' => array('controller' => 'estadisticas', 'action' => 'index'),
        'icon' => 'bar-chart'
    );
    $menus[__('Operadores')] = array(
        'url' => array('controller' => 'operadors', 'action' => 'index'),
        'icon' => 'users'
    );
}
$menus[__('Mi Perfil')] = array(
    'url' => array('controller' => 'empresas', 'action' => 'miPerfil'),
    'icon' => 'user'
);
$menus[__('Cerrar sesión')] = array(
    'url' => array('controller' => 'empresas', 'action' => 'logout'),
    'icon' => 'key'
);

echo $this->element('menus' . DS . '__render_menu', compact('active', 'menus'));

//echo $this->element('mensajes');