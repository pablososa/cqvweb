<?php
App::uses('AppController', 'Controller');
/**
 * ViajesHistorials Controller
 *
 * @property ViajesHistorial $ViajesHistorial
 * @property PaginatorComponent $Paginator
 */
class ViajesHistorialsController extends AppController {

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
		$this->ViajesHistorial->recursive = 0;
		$this->set('viajesHistorials', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ViajesHistorial->exists($id)) {
			throw new NotFoundException(__('Invalid viajes historial'));
		}
		$options = array('conditions' => array('ViajesHistorial.' . $this->ViajesHistorial->primaryKey => $id));
		$this->set('viajesHistorial', $this->ViajesHistorial->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ViajesHistorial->create();
			if ($this->ViajesHistorial->save($this->request->data)) {
				$this->Session->setFlash(__('The viajes historial has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The viajes historial could not be saved. Please, try again.'));
			}
		}
		$viajes = $this->ViajesHistorial->Viaje->find('list');
		$vehiculos = $this->ViajesHistorial->Vehiculo->find('list');
		$this->set(compact('viajes', 'vehiculos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ViajesHistorial->exists($id)) {
			throw new NotFoundException(__('Invalid viajes historial'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ViajesHistorial->save($this->request->data)) {
				$this->Session->setFlash(__('The viajes historial has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The viajes historial could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ViajesHistorial.' . $this->ViajesHistorial->primaryKey => $id));
			$this->request->data = $this->ViajesHistorial->find('first', $options);
		}
		$viajes = $this->ViajesHistorial->Viaje->find('list');
		$vehiculos = $this->ViajesHistorial->Vehiculo->find('list');
		$this->set(compact('viajes', 'vehiculos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ViajesHistorial->id = $id;
		if (!$this->ViajesHistorial->exists()) {
			throw new NotFoundException(__('Invalid viajes historial'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ViajesHistorial->delete()) {
			$this->Session->setFlash(__('The viajes historial has been deleted.'));
		} else {
			$this->Session->setFlash(__('The viajes historial could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
