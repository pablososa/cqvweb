<?php
App::uses('AppController', 'Controller');
App::import('Lib', 'Calculo');

/**
 * ViajeProgramados Controller
 *
 * @property ViajeProgramado $ViajeProgramado
 * @property PaginatorComponent $Paginator
 */
class NotificacionsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    private function configureFilter()
    {
        $this->Filter->configuration = array(
            'Notificacion' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        
                        'Notificacion.hora',
                        'Notificacion.fecha_desde',
                        'Notificacion.fecha_hasta',
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
    public function index()
    {
        $empresa = $this->Session->read('Empresa');
        $this->Notificacion->recursive = -1;

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();

        /*
        $this->Paginator->settings['Notificacion']['joins'] = array(
            array(
                'alias' => 'IvrDomicilio',
                'table' => 'ivr_domicilios',
                'type' => 'LEFT',
                'conditions' => 'IvrDomicilio.id = ViajeProgramado.ivr_domicilio_id',
            ),
            array(
                'alias' => 'IvrCliente',
                'table' => 'ivr_clientes',
                'type' => 'LEFT',
                'conditions' => 'IvrDomicilio.ivr_cliente_id = IvrCliente.id',
            ),
            array(
                'alias' => 'Vehiculo',
                'table' => 'vehiculos',
                'type' => 'LEFT',
                'conditions' => 'Vehiculo.id = ViajeProgramado.vehiculo_id',
            )
        );
        */
        $this->Paginator->settings['Notificacion']['conditions']['Notificacion.empresa_id'] = $empresa['Empresa']['id'];
        /*
        $fechaConditions = [
            'fecha_desde != fecha_hasta',
            'fecha_hasta IS NULL'
        ];*/

        $this->Paginator->settings['Notificacion']['fields'] = ['*'];
        $this->Paginator->settings['Notificacion']['order']['Notificacion.id'] = 'desc';
        $notificaciones = $this->Paginator->paginate();

        $this->set(compact('notificaciones'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $empresa = $this->Session->read('Empresa');

        $this->Notificacion->recursive = -1;
       
        if ($this->request->is('post')) {
            App::import('Lib', 'Calculo');
            $this->Notificacion->create();
            //print_r($this->request->data);
            //die();
            $this->request->data['Notificacion']['empresa_id'] = $empresa['Empresa']['id'];
           
            if ($this->Notificacion->save($this->request->data)) {
                $this->Session->setFlash(__('La notificacion ha sido guardada.'), 'success');
                $this->redirect(array('action' => 'index'));
                return;
            } else {
                $this->Session->setFlash(__('La notificacion no ha sido guardada.'), 'error');
            }
        } else {
            $this->request->data['Notificacion']['activo'] = true;
        }

      
        $this->set(compact('empresa'));
    }


 private function getConductorsSelect($empresa_id = null, $vehiculo_id = false)
    {
              
        App::import('Model', 'Conductor'); // mention at top
        $cond = new Conductor;

        $conductors_tmp = $cond->findConductors($empresa_id);
        $conductors = array();
        $select_value = null;
        foreach ($conductors_tmp as $conductor) {
            $key = $conductor['Vehiculo']['id'];
            $conductors[$key] = "Móvil ".$conductor['Vehiculo']['nro_registro'];
            if ($conductor['Vehiculo']['id'] === $vehiculo_id) {
                $select_value = $key;
            }
        }
        if ($vehiculo_id !== false) {
            return compact('conductors', 'select_value');

        }
        return $conductors;
    }



    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        $empresa = $this->Session->read('Empresa');
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Notificacion']['empresa_id'] = $empresa['Empresa']['id'];

         if ($this->Notificacion->save($this->request->data)) {
                $this->Session->setFlash(__('La notificacion ha sido guardada.'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('La notificacion no pudo ser guardada.'), 'error');
            }
        } else {
            $options = [
                'conditions' => [
                    'Notificacion.id' => $id,
                    'Notificacion.empresa_id' => $empresa['Empresa']['id']
                ]
            ];

            $this->request->data = $this->Notificacion->find('first', $options);
            if (empty($this->request->data)) {
                $this->Session->setFlash(__('Viaje programado incorrecto'), 'error');
                $this->redirect();
            }
        }


        $this->set(compact('empresa'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $empresa = $this->Session->read('Empresa');
        $options = [
            'conditions' => [
                'Notificacion.id' => $id,
                'Notificacion.empresa_id' => $empresa['Empresa']['id']
            ]
        ];
        if (!$this->Notificacion->find('first', $options)) {
            throw new NotFoundException(__('Notificacion inexistente'));
        }
        $this->Notificacion->id = $id;
        $this->request->onlyAllow('post', 'delete');
        if ($this->Notificacion->delete()) {
            $this->Session->setFlash(__('La notificacion ha sido eliminada con exito.'), 'success');
        } else {
            $this->Session->setFlash(__('La notificacion no pudo ser eliminada.'), 'error');
        }
        $this->redirect(array('action' => 'index'));
    }
}
