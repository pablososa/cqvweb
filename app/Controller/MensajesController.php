<?php

App::uses('AppController', 'Controller');

/**
 * Mensajes Controller
 *
 * @property Mensaje $Mensaje
 * @property PaginatorComponent $Paginator
 */
class MensajesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    private function configureFilter() {
        $this->Filter->configuration = array(
            'Mensaje' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'Vehiculo.patente',
                        'Vehiculo.nro_registro',
                        'texto',
                    )
                )
            )
        );
    }

    public function ajaxGetMensajes($first_call = false) {
        $result = array(
            'has_unseen' => false,
            'messages' => array(),
            'panic' => false
        );
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'visto' => '0',
                'operador' => '0',
                'Vehiculo.empresa_id' => $empresa['Empresa']['id'],
                'fecha >=' => date('Y-m-d H:i:s', strtotime('5 minute ago'))
            ),
            'joins' => array(
                array(
                    'table' => 'vehiculos',
                    'alias' => 'Vehiculo',
                    'type' => 'INNER',
                    'conditions' => 'Mensaje.vehiculo_id = Vehiculo.id'
                ),
            ),
            'fields' => array(
                'id',
                'id'
            )
        );
        $unseen = $this->Mensaje->find('first', $options);
        $result['has_unseen'] = !!$unseen;
        if ($result['has_unseen'] || $first_call) {
            $options = array(
                'conditions' => array(
                    'Mensaje.operador' => '0',
                    'Vehiculo.empresa_id' => $empresa['Empresa']['id']
                ),
                'joins' => array(
                    array(
                        'table' => 'vehiculos',
                        'alias' => 'Vehiculo',
                        'type' => 'INNER',
                        'conditions' => 'Mensaje.vehiculo_id = Vehiculo.id'
                    ),
                ),
                'fields' => array('Mensaje.*', 'Vehiculo.*'),
                'order' => array(
                    'Mensaje.id' => 'DESC'
                )
            );
            if($result['has_unseen']) {
                $options['conditions']['Mensaje.id >= '] = $unseen['Mensaje']['id'];
            } else {
                $options['limit'] = 5;
            }
            $result['messages'] = $this->Mensaje->find('all', $options);
            foreach($result['messages'] as &$message) {
                $message['Mensaje']['fecha'] = date('d/m/Y H:i:s' , strtotime($message['Mensaje']['fecha']));
            }
            $result['messages'] = array_reverse($result['messages']);
        }
        $options = array(
            'conditions' => array(
                'Vehiculo.empresa_id' => $empresa['Empresa']['id'],
                'Localizacion.panico' => true,
                'Localizacion.panico_visto' => false,
            ),
            'joins'=> array(
                array(
                    'alias' => 'Vehiculo',
                    'table' => 'vehiculos',
                    'type' => 'INNER',
                    'conditions' => 'Vehiculo.id = Localizacion.vehiculo_id'
                )
            )
        );
        $this->Mensaje->Vehiculo->Localizacion->recursive = -1;
        $panic_count = $this->Mensaje->Vehiculo->Localizacion->find('first', $options);
        $result['panic'] = count($panic_count);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function getMensajes($vehiculo_id = null) {
        $empresa = $this->Session->read('Empresa');
        $mensajes = array();
        if (!empty($vehiculo_id)) {
            $this->Mensaje->additionalFields[] = 'Vehiculo.nro_registro';

            $this->Paginator->settings['Mensaje']['joins'] = array(
                array(
                    'table' => 'vehiculos',
                    'alias' => 'Vehiculo',
                    'type' => 'INNER',
                    'conditions' => 'Mensaje.vehiculo_id = Vehiculo.id'
                ),
            );

            $this->configureFilter();

            $this->Filter->makeConditions();
            $this->Paginator->settings = $this->Filter->controller->Paginator->settings;
            
            $this->Paginator->settings['Mensaje']['conditions']['Vehiculo.empresa_id'] = $empresa['Empresa']['id'];
            $this->Paginator->settings['Mensaje']['conditions']['Vehiculo.id'] = $vehiculo_id;
            $this->Paginator->settings['Mensaje']['fields'] = array('Mensaje.*', 'Vehiculo.*');
            $this->Paginator->settings['Mensaje']['order'] = array('Mensaje.id' => 'DESC');
            $this->Paginator->settings['Mensaje']['limit'] = 50;

            $mensajes = $this->Paginator->paginate('Mensaje');
        }
        $this->set(compact('mensajes', 'empresa', 'vehiculos', 'vehiculo_id'));
    }
    
    public function ajaxAceptarMensajes() {
        $this->autoRender = false;
        $empresa = $this->Session->read('Empresa');
        if(!empty($this->request->data)) {
            $this->Mensaje->aceptarMensaje($empresa['Empresa']['id'], ($this->request->data['Mensaje']['ids']));
        }
        exit;
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $empresa = $this->Session->read('Empresa');
            $vehiculos = $this->request->data['Mensaje']['vehiculo_id'];
            if (empty($vehiculos)) {
                $options = array(
                    'conditions' => array('empresa_id' => $empresa['Empresa']['id'])
                );
                $vehiculos = $this->Mensaje->Vehiculo->find('list', $options);
            } else {
                $vehiculos = array(
                    $vehiculos => $vehiculos
                );
            }
            $result = $this->Mensaje->begin();
            foreach ($vehiculos as $vehiculo_id => $vehiculo) {
                $mensaje = array('Mensaje' => array());
                $mensaje['Mensaje']['texto'] = $this->request->data['Mensaje']['texto'];
                $mensaje['Mensaje']['fecha'] = date('Y-m-d H:i:s');
                $mensaje['Mensaje']['operador'] = true;
                $mensaje['Mensaje']['vehiculo_id'] = $vehiculo_id;
                $mensaje['Mensaje']['visto'] = false;
                $this->Mensaje->create();
                $result &= $this->Mensaje->save($mensaje);
            }
            if ($result) {
                $this->Mensaje->commit();
                foreach ($vehiculos as $vehiculo_id => $vehiculo) {
                    $this->GCMClient->sendNotificationVehicle_NuevoMensaje($mensaje['Mensaje']['texto'], $vehiculo_id);
                }
                $this->Session->setFlash(__('El/los mensajes se han enviado con exito'), 'success');
            } else {
                $this->Mensaje->rollback();
                $this->Session->setFlash(__('El/los mensajes no se han podido enviar. Intente nuevamnete.'), 'error');
            }
        }
        $this->redirect();
    }

}
//ssh -L [local port]:[database host]:[remote port] \[username]@[remote host]
//ssh -L 44444:544ad88e4382ec5c4d0002b5-cqvtesting.rhcloud.com:52846 544ad8625973ca806f000016@apptaxiwebtesting-cqvtesting.rhcloud.com
//544ad8625973ca806f000016@apptaxiwebtesting-cqvtesting.rhcloud.com