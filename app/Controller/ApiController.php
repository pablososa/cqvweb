<?php

class ApiController extends AppController {

    public $components = array('Api' => array('type' => 'server', 'serverUrl' => 'http://conquienviajo_test.local'));
    public $uses = array('Empresa', 'Viaje', 'Conductor', 'Vehiculo');
    private $apiCallLimit = 25;

    public function pendingViajes($from = 0) {
        $this->Viaje->recursive = -1;
        $options = array(
            'conditions' => array(
                'Viaje.id >' => $from,
                'Viaje.empresa_id' => $this->request->params['named']['empresa_id']
            ),
            'contain' => array(),
        );
        $this->Api->results = $this->Viaje->find('count', $options);
    }

    public function viajes($from = 0) {
        $this->Viaje->recursive = -1;
        $options = array(
            'conditions' => array(
                'Viaje.id >' => $from,
                'Viaje.empresa_id' => $this->request->params['named']['empresa_id']
            ),
            'contain' => array('Usuario', 'Conductor', 'Vehiculo'),
            'limit' => $this->apiCallLimit
        );
        $this->Api->results = $this->Viaje->find('all', $options);
    }

    public function pendingConductors($from = 0) {
        $this->Conductor->recursive = -1;
        $options = array(
            'conditions' => array(
                'Conductor.id >' => $from,
                'Conductor.empresa_id' => $this->request->params['named']['empresa_id']
            ),
        );
        $this->Api->results = $this->Conductor->find('count', $options);
    }

    public function conductors($from = 0) {
        $this->Conductor->recursive = -1;
        $options = array(
            'conditions' => array(
                'Conductor.id >' => $from,
                'Conductor.empresa_id' => $this->request->params['named']['empresa_id']
            ),
            'limit' => $this->apiCallLimit
        );
        $this->Api->results = $this->Conductor->find('all', $options);
    }

    public function pendingVehiculos($from = 0) {
        $this->Vehiculo->recursive = -1;
        $options = array(
            'conditions' => array(
                'Vehiculo.id >' => $from,
                'Vehiculo.empresa_id' => $this->request->params['named']['empresa_id']
            ),
        );
        $this->Api->results = $this->Vehiculo->find('count', $options);
    }

    public function vehiculos($from = 0) {
        $this->Vehiculo->recursive = -1;
        $options = array(
            'conditions' => array(
                'Vehiculo.id >' => $from,
                'Vehiculo.empresa_id' => $this->request->params['named']['empresa_id']
            ),
            'limit' => $this->apiCallLimit
        );
        $this->Api->results = $this->Vehiculo->find('all', $options);
    }

}
