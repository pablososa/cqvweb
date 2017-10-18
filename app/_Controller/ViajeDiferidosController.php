<?php
App::uses('AppController', 'Controller');
App::import('Lib', 'Calculo');

/**
 * ViajeProgramados Controller
 *
 * @property ViajeProgramado $ViajeProgramado
 * @property PaginatorComponent $Paginator
 */
class ViajeDiferidosController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    public $uses = array('ViajeProgramado');

    private function configureFilter()
    {
        $this->Filter->configuration = array(
            'ViajeProgramado' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'IvrDomicilio.domicilio',
                        'ViajeProgramado.hora',
                        'ViajeProgramado.fecha_desde',
                        'ViajeProgramado.fecha_hasta',
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
        $this->ViajeProgramado->recursive = -1;

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();

        $this->Paginator->settings['ViajeProgramado']['joins'] = array(
            array(
                'alias' => 'IvrDomicilio',
                'table' => 'ivr_domicilios',
                'type' => 'LEFT',
                'conditions' => 'IvrDomicilio.id = ViajeProgramado.ivr_domicilio_id',
            )
        );
        $this->Paginator->settings['ViajeProgramado']['conditions']['empresa_id'] = $empresa['Empresa']['id'];
        $this->Paginator->settings['ViajeProgramado']['conditions']['tipo'] = 'diferido';
        $this->Paginator->settings['ViajeProgramado']['fields'] = ['*'];

        $viajeProgramados = $this->Paginator->paginate();

        $this->set(compact('viajeProgramados'));
    }

//    /**
//     * view method
//     *
//     * @throws NotFoundException
//     * @param string $id
//     * @return void
//     */
//    public function view($id = null)
//    {
//        if (!$this->ViajeProgramado->exists($id)) {
//            throw new NotFoundException(__('Invalid viaje programado'));
//        }
//        $options = array('conditions' => array('ViajeProgramado.' . $this->ViajeProgramado->primaryKey => $id));
//        $this->set('viajeProgramado', $this->ViajeProgramado->find('first', $options));
//    }

    /**
     * add method
     *
     * @return void
     */
    public function add($domicilio_id)
    {
        $empresa = $this->Session->read('Empresa');

        $this->ViajeProgramado->IvrDomicilio->recursive = -1;
        $domicilioOptions = [
            'joins' => [ [
                    'alias' => 'IvrCliente',
                    'table' => 'ivr_clientes',
                    'type' => 'LEFT',
                    'conditions' => 'IvrDomicilio.ivr_cliente_id = IvrCliente.id',
                ]
            ],
            'conditions' => [
                'IvrDomicilio.id' => $domicilio_id,
                'IvrCliente.empresa_id' => $empresa['Empresa']['id']
            ]
        ];
        $domicilio = $this->ViajeProgramado->IvrDomicilio->find('first', $domicilioOptions);
        if(empty($domicilio)) {
            $this->Session->setFlash(__('Domicilio incorrecto'), 'error');
            $this->redirect();
            return;
        }

        if ($this->request->is('post')) {
            App::import('Lib', 'Calculo');
            $this->ViajeProgramado->create();
            $this->request->data['ViajeProgramado']['empresa_id'] = $empresa['Empresa']['id'];
            $this->request->data['ViajeProgramado']['tipo'] = 'diferido';
            $this->request->data['ViajeProgramado']['fecha_hasta'] = $this->request->data['ViajeProgramado']['fecha_desde'];
            $day = $this->ViajeProgramado->getDayName($this->request->data['ViajeProgramado']['fecha_desde']);
            $this->request->data['ViajeProgramado'][$day] = true;
            $this->request->data['ViajeProgramado']['respeta_feriados'] = false;
            $this->request->data['ViajeProgramado']['ivr_domicilio_id'] = $domicilio_id;
            $this->request->data['ViajeProgramado']['dir_origen'] = $domicilio['IvrDomicilio']['domicilio'];
            $cord_o = Calculo::getCordenates($domicilio['IvrDomicilio']['domicilio']);
            if (!empty($cord_o['lat'])) {
                $this->request->data['ViajeProgramado']['latitud_origen'] = $cord_o['lat'];
            }
            if (!empty($cord_o['long'])) {
                $this->request->data['ViajeProgramado']['longitud_origen'] = $cord_o['long'];
            }
            if(!empty($this->request->data['ViajeProgramado']['dir_destino'])) {
                $cord_d = Calculo::getCordenates($this->request->data['ViajeProgramado']['dir_destino']);
                if (!empty($cord_d['lat'])) {
                    $this->request->data['ViajeProgramado']['latitud_destino'] = $cord_d['lat'];
                }
                if (!empty($cord_d['long'])) {
                    $this->request->data['ViajeProgramado']['longitud_destino'] = $cord_d['long'];
                }
            } else {
                $this->request->data['ViajeProgramado']['longitud_destino'] = null;
                $this->request->data['ViajeProgramado']['latitud_destino'] = null;
            }
            if ($this->ViajeProgramado->save($this->request->data)) {
                $this->Session->setFlash(__('El viaje diferido ha sido guardado.'), 'success');
                $this->redirect(array('action' => 'index'));
                return;
            } else {
                $this->Session->setFlash(__('El viaje diferido no pudo ser guardado.'), 'error');
            }
        } else {
            $this->request->data['ViajeProgramado']['fecha_desde'] = date('Y-m-d');
        }
        $this->set(compact('empresa'));
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
            $this->request->data['ViajeProgramado']['empresa_id'] = $empresa['Empresa']['id'];
            $this->request->data['ViajeProgramado']['tipo'] = 'diferido';
            $this->request->data['ViajeProgramado']['fecha_hasta'] = $this->request->data['ViajeProgramado']['fecha_desde'];
            $this->request->data['ViajeProgramado']['lunes'] = false;
            $this->request->data['ViajeProgramado']['martes'] = false;
            $this->request->data['ViajeProgramado']['miercoles'] = false;
            $this->request->data['ViajeProgramado']['jueves'] = false;
            $this->request->data['ViajeProgramado']['viernes'] = false;
            $this->request->data['ViajeProgramado']['sabado'] = false;
            $this->request->data['ViajeProgramado']['domingo'] = false;
            $day = $this->ViajeProgramado->getDayName($this->request->data['ViajeProgramado']['fecha_desde']);
            $this->request->data['ViajeProgramado'][$day] = true;
            $this->request->data['ViajeProgramado']['respeta_feriados'] = false;
            if(!empty($this->request->data['ViajeProgramado']['dir_destino'])) {
                $cord_d = Calculo::getCordenates($this->request->data['ViajeProgramado']['dir_destino']);
                if (!empty($cord_d['lat'])) {
                    $this->request->data['ViajeProgramado']['latitud_destino'] = $cord_d['lat'];
                }
                if (!empty($cord_d['long'])) {
                    $this->request->data['ViajeProgramado']['longitud_destino'] = $cord_d['long'];
                }
            } else {
                $this->request->data['ViajeProgramado']['longitud_destino'] = null;
                $this->request->data['ViajeProgramado']['latitud_destino'] = null;
            }
            if ($this->ViajeProgramado->save($this->request->data)) {
                $this->Session->setFlash(__('El viaje diferido ha sido guardado.'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El viaje diferido no pudo ser guardado.'), 'error');
            }
        } else {
            $options = [
                'conditions' => [
                    'ViajeProgramado.id' => $id,
                    'ViajeProgramado.empresa_id' => $empresa['Empresa']['id']
                ]
            ];
            $this->request->data = $this->ViajeProgramado->find('first', $options);
            if(empty($this->request->data)) {
                $this->Session->setFlash(__('Viaje diferido incorrecto'), 'error');
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
                'ViajeProgramado.id' => $id,
                'ViajeProgramado.empresa_id' => $empresa['Empresa']['id'],
                'tipo' => 'diferido'
            ]
        ];
        if (!$this->ViajeProgramado->find('first', $options)) {
            throw new NotFoundException(__('Viaje diferido inexistente'));
        }
        $this->ViajeProgramado->id = $id;
        $this->request->onlyAllow('post', 'delete');
        if ($this->ViajeProgramado->delete()) {
            $this->Session->setFlash(__('El viaje diferido fue eliminado con exito.'), 'success');
        } else {
            $this->Session->setFlash(__('El viaje diferido no pudo ser eliminado.'), 'error');
        }
        $this->redirect(array('action' => 'index'));
    }
}
