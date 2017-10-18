<?php
App::uses('AppController', 'Controller');

/**
 * Feriados Controller
 *
 * @property Feriado $Feriado
 * @property PaginatorComponent $Paginator
 */
class FeriadosController extends AppController
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
            'Feriado' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'fecha',
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
        $this->Feriado->recursive = -1;

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();

        $feriados = $this->Paginator->paginate();

        $this->set(compact('feriados'));
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
        if (!$this->Feriado->exists($id)) {
            throw new NotFoundException(__('Invalid feriado'));
        }
        $options = array('conditions' => array('Feriado.' . $this->Feriado->primaryKey => $id));
        $this->set('feriado', $this->Feriado->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Feriado->create();
            if ($this->Feriado->save($this->request->data)) {
                $this->Session->setFlash(__('El feriado fue guardado con exito.'), 'success');
                $this->redirect(array('action' => 'index'));
                return;
            } else {
                $this->Session->setFlash(__('El feriado no pudo ser guardado.'), 'error');
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
    public function edit($id = null)
    {
        if (!$this->Feriado->exists($id)) {
            throw new NotFoundException(__('Invalid feriado'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Feriado->save($this->request->data)) {
                $this->Session->setFlash(__('El feriado fue guardado con exito.'), 'success');
                $this->redirect(array('action' => 'index'));
                return;
            } else {
                $this->Session->setFlash(__('El feriado no pudo ser guardado.'), 'error');
            }
        } else {
            $options = array('conditions' => array('Feriado.' . $this->Feriado->primaryKey => $id));
            $this->request->data = $this->Feriado->find('first', $options);
        }
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
        $this->Feriado->id = $id;
        if (!$this->Feriado->exists()) {
            throw new NotFoundException(__('Invalid feriado'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Feriado->delete()) {
            $this->Session->setFlash(__('El feriado fué eliminado con exito.'), 'success');
        } else {
            $this->Session->setFlash(__('El feriado no pudo ser eliminado.'), 'error');
        }
        return $this->redirect(array('action' => 'index'));
    }
}
