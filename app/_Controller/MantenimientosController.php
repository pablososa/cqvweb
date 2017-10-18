<?php

App::uses('AppController', 'Controller');

/**
 * Mantenimientos Controller
 *
 * @property Mantenimiento $Mantenimiento
 * @property PaginatorComponent $Paginator
 */
class MantenimientosController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    private function configureFilter() {
        $this->Filter->configuration = array(
            'Mantenimiento' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'mensaje'
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
        $this->Mantenimiento->recursive = -1;
        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
        $mantenimientos = $this->Paginator->paginate();
        $this->set(compact('mantenimientos'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Mantenimiento->create();
            $man['Mantenimiento']['mensaje'] = $this->request->data['Mantenimiento']['mensaje'];
            $man['Mantenimiento']['desde'] = $this->request->data['Mantenimiento']['desde'] . ' ' . $this->request->data['Mantenimiento']['hora_desde'];
            $man['Mantenimiento']['hasta'] = $this->request->data['Mantenimiento']['hasta'] . ' ' . $this->request->data['Mantenimiento']['hora_hasta'];
            $man['Mantenimiento']['estado'] = 'habilitado';
            $result = $this->Mantenimiento->save($man);
            if ($result) {
                $this->Session->setFlash(__('El mantenimiento ha sido guardado.'), 'success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El mantenimiento no pudo ser guardado. Por favor intente nuevamente.'), 'error');
            }
        }
        $horas = $this->getHoras();
        $this->set(compact('horas'));
    }
    
    private function getHoras() {
        $horas = array();
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:00');
        for($i = 0; $i < 48; $i++) {
            $horas[$fecha->format('H:i:s')] = $fecha->format('H:i');
            $fecha = $fecha->add(new DateInterval('PT30M'));
        }
        return $horas;
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Mantenimiento->exists($id)) {
            throw new NotFoundException(__('Mantenimiento inválido'), 'error');
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->Mantenimiento->create();
            $man['Mantenimiento']['id'] = $this->request->data['Mantenimiento']['id'];
            $man['Mantenimiento']['mensaje'] = $this->request->data['Mantenimiento']['mensaje'];
            $man['Mantenimiento']['desde'] = $this->request->data['Mantenimiento']['desde'] . ' ' . $this->request->data['Mantenimiento']['hora_desde'];
            $man['Mantenimiento']['hasta'] = $this->request->data['Mantenimiento']['hasta'] . ' ' . $this->request->data['Mantenimiento']['hora_hasta'];
            $result = $this->Mantenimiento->save($man);
            if ($result) {
                $this->Session->setFlash(__('El mantenimiento ha sido guardado.'), 'success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El mantenimiento no pudo ser guardado. Por favor intente nuevamente.'), 'error');
            }
        } else {
            $options = array('conditions' => array('Mantenimiento.' . $this->Mantenimiento->primaryKey => $id));
            $this->request->data = $this->Mantenimiento->find('first', $options);
            $desde = DateTime::createFromFormat('Y-m-d H:i:s', $this->request->data['Mantenimiento']['desde']);
            $this->request->data['Mantenimiento']['desde'] = $desde->format('Y-m-d');
            $this->request->data['Mantenimiento']['hora_desde'] = $desde->format('H:i:s');
            $hasta = DateTime::createFromFormat('Y-m-d H:i:s', $this->request->data['Mantenimiento']['hasta']);
            $this->request->data['Mantenimiento']['hasta'] = $hasta->format('Y-m-d');
            $this->request->data['Mantenimiento']['hora_hasta'] = $hasta->format('H:i:s');
        }
        $estados = array(
            'Habilitado' => 'Habilitado',
            'Deshabilitado' => 'Deshabilitado',
        );
        $horas = $this->getHoras();
        $this->set(compact('estados', 'horas'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Mantenimiento->id = $id;
        if (!$this->Mantenimiento->exists()) {
            throw new NotFoundException(__('Invalid mantenimiento'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Mantenimiento->delete()) {
            $this->Session->setFlash(__('El mantenimiento ha sido eliminado'), 'success');
        } else {
            $this->Session->setFlash(__('El mantenimiento no pudo ser eliminado.'));
        }
        return $this->redirect();
    }


    function habilitar($id = null) {
        if ($this->Mantenimiento->activate($id)) {
            $this->Session->setFlash('El mantenimiento ha sido habilitado', 'success');
        } else {
            $this->Session->setFlash('El mantenimiento no pudo ser habilitado', 'error');
        }
        $this->redirect();
    }

    function deshabilitar($id = null) {
        if ($this->Mantenimiento->deactivate($id)) {
            $this->Session->setFlash('El mantenimiento ha sido deshabilitado', 'success');
        } else {
            $this->Session->setFlash('El mantenimiento no pudo ser deshabilitado', 'error');
        }
        $this->redirect();
    }
}
