<?php

App::uses('AppController', 'Controller');

/**
 * Estadisticas Controller
 *
 * @property Estadistica $Estadistica
 * @property PaginatorComponent $Paginator
 */
class EstadisticasController extends AppController {

    public function index() {
        $empresa = $this->Session->read('Empresa');
        $this->request->data['Estadistica']['fecha_ini'] = date('Y-m-d', strtotime('1 month ago'));
        $this->request->data['Estadistica']['fecha_fin'] = date('Y-m-d');
        $this->set(compact('empresa'));
    }

    public function getData($for = null) {
        if (empty($this->request->data['Estadistica']['fecha_ini'])) {
            $this->request->data['Estadistica']['fecha_ini'] = date('Y-m-d', strtotime('1 month ago'));
        }
        if (empty($this->request->data['Estadistica']['fecha_fin'])) {
            $this->request->data['Estadistica']['fecha_fin'] = date('Y-m-d');
        }
        if (strtotime($this->request->data['Estadistica']['fecha_ini']) < strtotime('2014-01-01 00:00:00')) {
            $this->request->data['Estadistica']['fecha_ini'] = '2014-01-01';
        }
        if (strtotime($this->request->data['Estadistica']['fecha_fin']) > time()) {
            $this->request->data['Estadistica']['fecha_fin'] = date('Y-m-d');
        }

        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'OR' => array(
                    'empresa_id' => $empresa['Empresa']['id'],
                    'empresa_id IS NULL',
                ),
                'fecha >=' => $this->request->data['Estadistica']['fecha_ini'],
                'fecha <=' => $this->request->data['Estadistica']['fecha_fin'],
                'creador' => array(
                    'admin',
                    'usuario'
                )
            ),
            'order' => array(
                'fecha' => 'asc'
            )
        );
        $estadisticas_db = $this->Estadistica->find('all', $options);

        $fecha_ini = new DateTime($this->request->data['Estadistica']['fecha_ini']);
        $fecha_fin = new DateTime($this->request->data['Estadistica']['fecha_fin']);

        $fechas = array();

        $current = $fecha_ini;
        while ($current <= $fecha_fin) {
            $fecha = $current->format('Y-m-d');
            $fechas[$fecha] = $current->format('d/m/Y');
            $current->add(new DateInterval('P1D'));
        }

        switch ($for) {
            case 'table':
                $this->__getDataForTable($estadisticas_db, $fechas);
                break;
            default:
            case 'graph':
                $this->__getDataForGraph($estadisticas_db, $fechas);
                break;
        }
    }

    private function __getDataForGraph($estadisticas_db, $fechas) {
        $map_tipos = array(
            'admin' => 'admin',
            'app_atendidos' => 'usuario',
            'app_no_atendidos' => 'usuario',
//            'conductor' => 'conductor'
        );
        $estadisticas = array();
        $creadores = array(
            'admin' => __('Administrador'),
            'app_no_atendidos' => __('No Atendidos (App)'),
            'app_atendidos' => __('Atendidos (App)'),
//            'conductor' => __('Conductor'),
        );

        $data = array_combine(array_keys($fechas), array_fill(0, count($fechas), 0));
        foreach ($creadores as $creador => $name) {
            $estadisticas[$creador] = array(
                'name' => $name,
                'data' => $data
            );
        }
        
        foreach ($estadisticas_db as $estadistica_db) {
            if ($estadistica_db['Estadistica']['creador'] == 'usuario') {
                $estadisticas['app_atendidos']['data'][$estadistica_db['Estadistica']['fecha']] += intval($estadistica_db['Estadistica']['n_atendidos']);
                $estadisticas['app_no_atendidos']['data'][$estadistica_db['Estadistica']['fecha']] += intval($estadistica_db['Estadistica']['n_no_atendidos']);
            } else {
                $estadisticas[$estadistica_db['Estadistica']['creador']]['data'][$estadistica_db['Estadistica']['fecha']] += intval($estadistica_db['Estadistica']['n']);
            }
        }

        foreach ($estadisticas as &$estadistica) {
            $estadistica['data'] = array_values($estadistica['data']);
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'fechas' => array_values($fechas),
            'data' => array_values($estadisticas)
        ));
        die;
    }

    private function __getDataForTable($estadisticas_db, $fechas) {
        $empresa = $this->Session->read('Empresa');
        $row = array(
            'fecha' => 0,
            'admin' => 0,
            'app_total' => 0,
            'app_no_atendidos' => 0,
            'totales' => 0,
            'admin_08' => 0,
            'admin_816' => 0,
            'admin_1624' => 0,
            'app_08' => 0,
            'app_816' => 0,
            'app_1624' => 0,
        );
        $estadisticas = array_combine(array_keys($fechas), array_fill(0, count($fechas), $row));
        
        foreach ($estadisticas as $fecha => &$estadistica) {
            $estadistica['fecha'] = $fechas[$fecha];
        }
//        pr($estadisticas_db);
        foreach ($estadisticas_db as &$estadistica_db) {
            $fecha = $estadistica_db['Estadistica']['fecha'];
            switch ($estadistica_db['Estadistica']['creador']) {
                case 'admin':
                    $estadisticas[$fecha]['admin'] += $estadistica_db['Estadistica']['n'];
                    $estadisticas[$fecha]['admin_08'] += $estadistica_db['Estadistica']['n_turno_1'];
                    $estadisticas[$fecha]['admin_816'] += $estadistica_db['Estadistica']['n_turno_2'];
                    $estadisticas[$fecha]['admin_1624'] += $estadistica_db['Estadistica']['n_turno_3'];
                    break;
                case 'usuario':
                    $estadisticas[$fecha]['app_total'] += $estadistica_db['Estadistica']['n'];
                    $estadisticas[$fecha]['app_no_atendidos'] += $estadistica_db['Estadistica']['n_no_atendidos'];
                    $estadisticas[$fecha]['app_08'] += $estadistica_db['Estadistica']['n_turno_1'];
                    $estadisticas[$fecha]['app_816'] += $estadistica_db['Estadistica']['n_turno_2'];
                    $estadisticas[$fecha]['app_1624'] += $estadistica_db['Estadistica']['n_turno_3'];
                    break;
                default://omito los de conductor
                    continue 2; //el 2 es porque el switch es conciderado a una estructura de looping
            }
            $estadisticas[$fecha]['totales'] += $estadistica_db['Estadistica']['n'];
        }
        $totales = $row;
        foreach ($estadisticas as &$estadistica) {
            foreach ($totales as $key => &$val) {
                $val += $estadistica[$key];
            }
            $estadistica = array_values($estadistica);
        }
        $estadisticas = array_values($estadisticas);
        array_shift($totales);
        array_unshift($totales, __('Totales'));
        $estadisticas[] = $totales;

        $this->set(compact('estadisticas', 'totales'));
        $this->render('table');
    }
    
    public function regenerate() {
        $this->Estadistica->regenerateCache(true);
        $this->Session->setFlash(__('Las estadísticas han sido regeneradas.'), 'success');
        $this->redirect(array('controller' => 'empresas', 'action' => 'view'));
    }

}
