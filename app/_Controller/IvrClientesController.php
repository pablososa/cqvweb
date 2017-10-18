<?php

App::uses('AppController', 'Controller');

/**
 * IvrClientes Controller
 *
 * @property IvrCliente $IvrCliente
 * @property PaginatorComponent $Paginator
 */
class IvrClientesController extends AppController {

    private function response($response) {
        $this->autoRender = false;
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!empty($this->request->params['is_api_call'])) {
            $empresa_key = empty($this->request->params['empresa_key']) ? '-1' : $this->request->params['empresa_key'];
            $options = array(
                'conditions' => array(
                    'empresa_key' => $empresa_key
                )
            );
            $this->empresa = $this->IvrCliente->Empresa->find('first', $options);
            if (empty($this->empresa)) {
                $url = FULL_BASE_URL . '/api/ivr/{{clave_de_la_empresa}}/' . $this->request->params['action'] . '/...';
                throw new NotFoundException(__('Error empresa no encontrada. La url debe ser %s', array($url)));
            }
        }
    }
    
    public function getCliente() {
        $response = array(
            'error' => false,
            'existe' => false,
        );
        if (empty($this->request->params['named']['telefono'])) {
            $url = FULL_BASE_URL . '/api/ivr/' . $this->empresa['Empresa']['empresa_key'] . '/' . $this->request->params['action'] . '/telefono:{{nro_de_teléfono}}';
            throw new NotFoundException(__('Error parámetro teléfono no encontrado. La url debe ser %s', array($url)));
        }
        $telefono = $this->request->params['named']['telefono'];
        $key_telefono = empty($this->request->params['named']['key_telefono']) ? null : $this->request->params['named']['key_telefono'];
        $cliente = $this->IvrCliente->IvrDomicilio->findByEmpresaAndTelefono($this->empresa['Empresa']['id'], $telefono);
        if (!empty($cliente['IvrDomicilio']['domicilio'])) {
            $response['existe'] = true;
            $response['domicilio_completo'] = explode(',', $cliente['IvrDomicilio']['domicilio']);
            $response['domicilio'] = $response['domicilio_completo'][0];
        } else {
            $this->IvrCliente->Empresa->IvrLlamadaEntrante->insert($this->empresa['Empresa']['id'], $telefono, $key_telefono);
            SocketClient::sendNodeEventEmpresa($this->empresa['Empresa']['id'], NODE_EVENT_ivr_llamada_entrante);
        }
        $this->response($response);
    }

    public function presiona1() {
        $response = array(
            'error' => true,
            'message' => ''
        );
        $telefono = $this->request->params['named']['telefono'];

        $domicilio_principal = $this->IvrCliente->IvrDomicilio->findPrincipalByEmpresaAndTelefono($this->empresa['Empresa']['id'], $telefono);
        if (!empty($domicilio_principal)) {
            $data = array(
                'Viaje' => array(
                    'ivr_domicilio_id' => $domicilio_principal['IvrDomicilio']['id'],
                    'dir_origen' => $domicilio_principal['IvrDomicilio']['domicilio'],
                    'observaciones' => $domicilio_principal['IvrDomicilio']['observaciones'],
                    'estado' => 'Despacho_pendiente',
                )
            );
            $result = $this->IvrCliente->IvrDomicilio->Viaje->begin();
            $response['viaje'] = $this->IvrCliente->IvrDomicilio->Viaje->add($this->empresa, $data);
            $result &= $response['viaje'];
            $response['error'] = empty($result);
            $response['message'] = $this->IvrCliente->IvrDomicilio->Viaje->message;
            if ($result) {
                $result = $this->IvrCliente->IvrDomicilio->Viaje->commit();
                SocketClient::sendNodeEventEmpresa($this->empresa['Empresa']['id'], NODE_EVENT_ivr_despacho_pendiente);
            } else {
                $result = $this->IvrCliente->IvrDomicilio->Viaje->rollback();
            }
        } else {
            $response['message'] = __('No existe domicilio principal para ese teléfono');
        }
        $this->response($response);
    }

    public function presiona2() {
        $response = array(
            'error' => false,
            'message' => __('Su llamado esta siendo transferido')
        );
        $telefono = $this->request->params['named']['telefono'];
        $key_telefono = empty($this->request->params['named']['key_telefono']) ? null : $this->request->params['named']['key_telefono'];
        $this->IvrCliente->Empresa->IvrLlamadaEntrante->insert($this->empresa['Empresa']['id'], $telefono, $key_telefono);
        SocketClient::sendNodeEventEmpresa($this->empresa['Empresa']['id'], NODE_EVENT_ivr_llamada_entrante);
        $this->response($response);
    }

    private function configureFilter() {
        $this->Filter->configuration = array(
            'IvrCliente' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'telefono',
                        'nombre',
                        'apellido',
                        'razon_social',
                        'nombre_de_fantasia',
                        'telefono_alternativo',
                        'email'
                    )
                )
            )
        );
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $empresa = $this->Session->read('Empresa');
        $this->IvrCliente->recursive = -1;

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
        $this->Paginator->settings['IvrCliente']['conditions']['empresa_id'] = $empresa['Empresa']['id'];

        $ivrClientes = $this->Paginator->paginate('IvrCliente');

        $this->set(compact('ivrClientes'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param null $telefono
     * @return void
     */
    public function view($telefono = null) {
        $empresa = $this->Session->read('Empresa');
        if (!empty($telefono)) {
            $this->IvrCliente->IvrLlamadaEntrante->markAsAtendido($empresa['Empresa']['id'], $telefono);
        }
        $domicilios = array();
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa['Empresa']['id'],
                'telefono' => $telefono
            )
        );
        $cliente = $this->IvrCliente->find('first', $options);
        if (!empty($cliente)) {
            $options = array(
                'conditions' => array(
                    'ivr_cliente_id' => $cliente['IvrCliente']['id']
                ),
                'order' => array(
                    'es_principal' => 'desc'
                )
            );
            $domicilios = $this->IvrCliente->IvrDomicilio->find('all', $options);
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['IvrCliente']['empresa_id'] = $empresa['Empresa']['id'];
            if ($this->IvrCliente->save($this->request->data)) {
                $this->Session->setFlash(__('The ivr cliente has been saved.'), 'success');
                $this->redirect();
            } else {
                $this->Session->setFlash(__('The ivr cliente could not be saved. Please, try again.'), 'error');
            }
        } else {
            $this->request->data = $cliente;
        }

        //historial
        $this->Viaje = ClassRegistry::init('Viaje');
        $this->Viaje->virtualFields['created'] = 'CONCAT_WS(" ", fecha, hora)';
        
        $this->Paginator->settings['Viaje']['joins'] = array(
            array(
                'alias' => 'Usuario',
                'table' => 'usuarios',
                'type' => 'LEFT',
                'conditions' => array(
                    'Usuario.id = Viaje.usuario_id'
                )
            ),
            array(
                'alias' => 'Conductor',
                'table' => 'conductors',
                'type' => 'LEFT',
                'conditions' => array(
                    'Conductor.id = Viaje.conductor_id'
                )
            ),
            array(
                'alias' => 'Vehiculo',
                'table' => 'vehiculos',
                'type' => 'LEFT',
                'conditions' => array(
                    'Viaje.vehiculo_id = Vehiculo.id'
                )
            ),
            array(
                'alias' => 'Localizacion',
                'table' => 'localizacions',
                'type' => 'LEFT',
                'conditions' => array(
                    'Localizacion.vehiculo_id = Vehiculo.id'
                )
            ),
            array(
                'alias' => 'IvrDomicilio',
                'table' => 'ivr_domicilios',
                'type' => 'LEFT',
                'conditions' => array(
                    'IvrDomicilio.id = Viaje.ivr_domicilio_id'
                )
            ),
            array(
                'alias' => 'IvrCliente',
                'table' => 'ivr_clientes',
                'type' => 'LEFT',
                'conditions' => array(
                    'IvrCliente.id = IvrDomicilio.ivr_cliente_id'
                )
            )
        );

        $this->Paginator->settings['Viaje']['conditions']['Viaje.empresa_id'] = $empresa['Empresa']['id'];
        
        $this->Paginator->settings['Viaje']['conditions']['IvrCliente.telefono'] = $telefono;

        $this->Paginator->settings['Viaje']['order']['Viaje.id'] = 'desc';
        $this->Paginator->settings['Viaje']['recursive'] = -1;
        $this->Paginator->settings['Viaje']['fields'] = '*';
        $this->Paginator->settings['Viaje']['maxLimit'] = $this->Paginator->settings['Viaje']['limit'] = 10;

        $viajes = $this->Paginator->paginate('Viaje');
        foreach ($viajes as &$viaje) {
            $viaje['Viaje']['atrasado'] = $this->Viaje->isAtrasado($viaje);
        }

        $this->set(compact('empresa', 'telefono', 'cliente', 'domicilios', 'viajes'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $empresa = $this->Session->read('Empresa');
        if ($this->request->is('post')) {
            $this->IvrCliente->create();
            $this->request->data['IvrCliente']['empresa_id'] = $empresa['Empresa']['id'];
            if ($this->IvrCliente->save($this->request->data)) {
                $this->Session->setFlash(__('The ivr cliente has been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
                return;
            } else {
                $this->Session->setFlash(__('The ivr cliente could not be saved. Please, try again.'), 'error');
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $empresa = $this->Session->read('Empresa');
        if (!$this->IvrCliente->exists($id)) {
            throw new NotFoundException(__('Invalid ivr cliente'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['IvrCliente']['empresa_id'] = $empresa['Empresa']['id'];
            if ($this->IvrCliente->save($this->request->data)) {
                $this->Session->setFlash(__('The ivr cliente has been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
                return;
            } else {
                $this->Session->setFlash(__('The ivr cliente could not be saved. Please, try again.'), 'error');
            }
        } else {
            $options = array('conditions' => array('IvrCliente.' . $this->IvrCliente->primaryKey => $id));
            $this->request->data = $this->IvrCliente->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->IvrCliente->id = $id;
        if (!$this->IvrCliente->exists()) {
            throw new NotFoundException(__('Invalid ivr cliente'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->IvrCliente->delete()) {
            $this->Session->setFlash(__('The ivr cliente has been deleted.'));
        } else {
            $this->Session->setFlash(__('The ivr cliente could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
