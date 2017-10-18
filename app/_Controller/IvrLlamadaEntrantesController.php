<?php
App::uses('AppController', 'Controller');
/**
 * IvrLlamadaEntrantes Controller
 *
 * @property IvrLlamadaEntrante $IvrLlamadaEntrante
 * @property PaginatorComponent $Paginator
 */
class IvrLlamadaEntrantesController extends AppController {

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
	public function index() {
		$this->IvrLlamadaEntrante->recursive = 0;
		$this->set('ivrLlamadaEntrantes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->IvrLlamadaEntrante->exists($id)) {
			throw new NotFoundException(__('Invalid ivr llamada entrante'));
		}
		$options = array('conditions' => array('IvrLlamadaEntrante.' . $this->IvrLlamadaEntrante->primaryKey => $id));
		$this->set('ivrLlamadaEntrante', $this->IvrLlamadaEntrante->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->IvrLlamadaEntrante->create();
			if ($this->IvrLlamadaEntrante->save($this->request->data)) {
				$this->Session->setFlash(__('The ivr llamada entrante has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ivr llamada entrante could not be saved. Please, try again.'));
			}
		}
		$ivrClientes = $this->IvrLlamadaEntrante->IvrCliente->find('list');
		$empresas = $this->IvrLlamadaEntrante->Empresa->find('list');
		$this->set(compact('ivrClientes', 'empresas'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->IvrLlamadaEntrante->exists($id)) {
			throw new NotFoundException(__('Invalid ivr llamada entrante'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->IvrLlamadaEntrante->save($this->request->data)) {
				$this->Session->setFlash(__('The ivr llamada entrante has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ivr llamada entrante could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('IvrLlamadaEntrante.' . $this->IvrLlamadaEntrante->primaryKey => $id));
			$this->request->data = $this->IvrLlamadaEntrante->find('first', $options);
		}
		$ivrClientes = $this->IvrLlamadaEntrante->IvrCliente->find('list');
		$empresas = $this->IvrLlamadaEntrante->Empresa->find('list');
		$this->set(compact('ivrClientes', 'empresas'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->IvrLlamadaEntrante->id = $id;
		if (!$this->IvrLlamadaEntrante->exists()) {
			throw new NotFoundException(__('Invalid ivr llamada entrante'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->IvrLlamadaEntrante->delete()) {
			$this->Session->setFlash(__('The ivr llamada entrante has been deleted.'));
		} else {
			$this->Session->setFlash(__('The ivr llamada entrante could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
