<?php
App::uses('AppController', 'Controller');
/**
 * KeyTelefonos Controller
 *
 * @property KeyTelefono $KeyTelefono
 * @property PaginatorComponent $Paginator
 */
class KeyTelefonosController extends AppController {

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
		$this->KeyTelefono->recursive = 0;
		$this->set('keyTelefonos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->KeyTelefono->exists($id)) {
			throw new NotFoundException(__('Invalid key telefono'));
		}
		$options = array('conditions' => array('KeyTelefono.' . $this->KeyTelefono->primaryKey => $id));
		$this->set('keyTelefono', $this->KeyTelefono->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->KeyTelefono->create();
			if ($this->KeyTelefono->save($this->request->data)) {
				$this->Session->setFlash(__('The key telefono has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The key telefono could not be saved. Please, try again.'));
			}
		}
		$operadors = $this->KeyTelefono->Operador->find('list');
		$this->set(compact('operadors'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->KeyTelefono->exists($id)) {
			throw new NotFoundException(__('Invalid key telefono'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->KeyTelefono->save($this->request->data)) {
				$this->Session->setFlash(__('The key telefono has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The key telefono could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('KeyTelefono.' . $this->KeyTelefono->primaryKey => $id));
			$this->request->data = $this->KeyTelefono->find('first', $options);
		}
		$operadors = $this->KeyTelefono->Operador->find('list');
		$this->set(compact('operadors'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->KeyTelefono->id = $id;
		if (!$this->KeyTelefono->exists()) {
			throw new NotFoundException(__('Invalid key telefono'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->KeyTelefono->delete()) {
			$this->Session->setFlash(__('The key telefono has been deleted.'));
		} else {
			$this->Session->setFlash(__('The key telefono could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
