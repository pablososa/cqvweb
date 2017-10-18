<?php

App::uses('AppController', 'Controller');

/**
 * Mjspredefinidos Controller
 *
 * @property Mjspredefinido $Mjspredefinido
 * @property PaginatorComponent $Paginator
 */
class MjspredefinidosController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    private function configureFilter() {
        $this->Filter->configuration = array(
            'Mjspredefinido' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'texto'
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

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();

        $this->Paginator->settings['Mjspredefinido']['conditions']['empresa_id'] = $empresa['Empresa']['id'];

        $this->Mjspredefinido->recursive = -1;
        $mjspredefinidos = $this->Paginator->paginate('Mjspredefinido');

        $this->set(compact('mjspredefinidos', 'empresa'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $empresa = $this->Session->read('Empresa');
        if ($this->request->is('post')) {
            $this->Mjspredefinido->create();
            $this->request->data['Mjspredefinido']['empresa_id'] = $empresa['Empresa']['id'];
            if ($this->Mjspredefinido->save($this->request->data)) {
                $this->Session->setFlash(__('El mensaje predefinido ha sido guardado con exito.'), 'success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El mensaje predefinido no pudo ser guardado. Por favor intente nuevamente.'), 'error');
            }
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
    public function edit($id = null) {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'id' => $id,
                'empresa_id' => $empresa['Empresa']['id']
            )
        );
        $this->Mjspredefinido->recursive = -1;
        if ($this->Mjspredefinido->find('first', $options)) {
            if ($this->request->is(array('post', 'put'))) {
                if ($this->Mjspredefinido->save($this->request->data)) {
                    $this->Session->setFlash(__('El mensaje predefinido ha sido guardado con exito.'), 'success');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('El mensaje predefinido no pudo ser guardado. Por favor intente nuevamente.'), 'error');
                }
            } else {
                $options = array('conditions' => array('Mjspredefinido.' . $this->Mjspredefinido->primaryKey => $id));
                $this->request->data = $this->Mjspredefinido->find('first', $options);
            }
        } else {
            $this->Session->setFlash(__('El mensaje predefinido inexistente.'), 'error');
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
    public function delete($id = null) {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'id' => $id,
                'empresa_id' => $empresa['Empresa']['id']
            )
        );
        $this->Mjspredefinido->recursive = -1;
        if ($this->Mjspredefinido->find('first', $options)) {
            $this->request->onlyAllow('post', 'delete');
            $this->Mjspredefinido->id = $id;
            if ($this->Mjspredefinido->delete()) {
                $this->Session->setFlash(__('El mensaje predefinido se ha eliminado con éxito'), 'success');
            } else {
                $this->Session->setFlash(__('El mensaje predefinido no pudo ser eliminado. Por favor intente nuevamente.'), 'error');
            }
        } else {
            $this->Session->setFlash(__('El mensaje predefinido inexistente.'), 'error');
        }
        return $this->redirect();
    }

}
