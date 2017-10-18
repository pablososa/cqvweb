<?php

App::uses('AppController', 'Controller');

/**
 * IvrDomicilios Controller
 *
 * @property IvrDomicilio $IvrDomicilio
 * @property PaginatorComponent $Paginator
 */
class IvrDomiciliosController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->IvrDomicilio->recursive = 0;
        $this->set('ivrDomicilios', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->IvrDomicilio->exists($id)) {
            throw new NotFoundException(__('Invalid ivr domicilio'));
        }
        $options = array('conditions' => array('IvrDomicilio.' . $this->IvrDomicilio->primaryKey => $id));
        $this->set('ivrDomicilio', $this->IvrDomicilio->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($telefono = null)
    {
        $empresa = $this->Session->read('Empresa');
        if ($this->request->is('post')) {
            $this->IvrDomicilio->create();
            $this->IvrDomicilio->begin();
            $this->request->data['IvrCliente']['empresa_id'] = $empresa['Empresa']['id'];
            $result = $this->IvrDomicilio->save($this->request->data);
            if ($result) {
                $this->IvrDomicilio->commit();
                $this->Session->setFlash(__('El domicilio ha sido guardado.'), 'success');
                $this->redirect(array('controller' => 'ivr_clientes', 'action' => 'view', $telefono));
                return;
            } else {
                $this->IvrDomicilio->rollback();
                $this->Session->setFlash(__('El domicilio no pudo ser guardado. Por favor intente nuevamente.'), 'error');
            }
        } elseif (!empty($telefono)) {
            $ivrCliente = $this->IvrDomicilio->IvrCliente->findByEmpresaAndTelefono($empresa['Empresa']['id'], $telefono);
            if (empty($ivrCliente)) {
                $ivrCliente = [
                    'IvrCliente' => [
                        'telefono' => $telefono
                    ]
                ];
            }
            $this->request->data['IvrCliente'] = $ivrCliente['IvrCliente'];
        }
        $si_no = array(
            '' => __('Elija una opción'),
            0 => __('No'),
            1 => __('Si'),
        );
        $this->set(compact('empresa', 'si_no'));
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
        $options = array(
            'conditions' => array(
                'IvrDomicilio.' . $this->IvrDomicilio->primaryKey => $id,
                'empresa_id' => $empresa['Empresa']['id']
            ),
            'joins' => array(
                array(
                    'table' => 'ivr_clientes',
                    'alias' => 'IvrCliente',
                    'type' => 'INNER',
                    'conditions' => array(
                        'IvrCliente.id = IvrDomicilio.ivr_cliente_id'
                    )
                )
            ),
            'fields' => array('*')
        );
        $domicilio = $this->IvrDomicilio->find('first', $options);
        if (!empty($domicilio)) {
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['IvrDomicilio']['id'] = $id;
                $this->request->data['IvrDomicilio']['ivr_cliente_id'] = $domicilio['IvrDomicilio']['ivr_cliente_id'];
                if ($this->IvrDomicilio->save($this->request->data)) {
                    $this->Session->setFlash(__('El domicilio ha sido guardado.'), 'success');
                    return $this->redirect(array('controller' => 'ivr_clientes', 'action' => 'view', $domicilio['IvrCliente']['telefono']));
                } else {
                    $this->Session->setFlash(__('El domicilio no pudo ser guardado. Por favor intente nuevamente.'), 'error');
                }
            } else {
                $this->request->data = $domicilio;
            }
        }
        $si_no = array(
            0 => __('No'),
            1 => __('Si'),
        );
        $this->set(compact('empresa', 'si_no'));
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
        $options = array(
            'conditions' => array(
                'IvrDomicilio.' . $this->IvrDomicilio->primaryKey => $id,
                'empresa_id' => $empresa['Empresa']['id']
            ),
            'joins' => array(
                array(
                    'table' => 'ivr_clientes',
                    'alias' => 'IvrCliente',
                    'type' => 'INNER',
                    'conditions' => array(
                        'IvrCliente.id = IvrDomicilio.ivr_cliente_id'
                    )
                )
            ),
            'fields' => array('*')
        );
        $domicilio = $this->IvrDomicilio->find('first', $options);
        if (empty($domicilio)) {
            throw new NotFoundException(__('Invalid ivr domicilio'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->IvrDomicilio->delete($id)) {
            $this->Session->setFlash(__('El domicilio ha sido eliminado'), 'success');
        } else {
            $this->Session->setFlash(__('El domicilio no pudo ser eliminado. Por favor intente nuevemente.'), 'error');
        }
        return $this->redirect();
    }

}
