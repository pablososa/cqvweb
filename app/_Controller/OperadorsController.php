<?php

App::uses('AppController', 'Controller');

/**
 * Operadors Controller
 *
 * @property Operador $Operador
 * @property PaginatorComponent $Paginator
 */
class OperadorsController extends AppController
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
            'Operador' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'usuario',
                    )
                )
            )
        );
    }

    public function index()
    {
        $empresa = $this->Session->read('Empresa');

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();

        $this->Paginator->settings['Operador']['conditions']['empresa_id'] = $empresa['Empresa']['id'];
        //$this->Paginator->settings['Operador']['conditions']['tipo'] = 'operador';

        $operadors = $this->Paginator->paginate('Operador');
        $this->set(compact('empresa', 'operadors'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $empresa = $this->Session->read('Empresa');
        if ($this->request->is('post')) {
            if ($this->request->data['Operador']['password'] == $this->request->data['Operador']['password2']) {
                $this->request->data['Operador']['password'] = md5($this->request->data['Operador']['password']);
                $this->request->data['Operador']['empresa_id'] = $empresa['Empresa']['id'];
                $this->request->data['Operador']['tipo'] = 'operador';
                $this->Operador->create();
                $result = $this->Operador->begin();
                $result &= $this->Operador->save($this->request->data);
                foreach($this->request->data['KeyTelefono'] as $keyTelefono) {
                    if (!empty($keyTelefono['key_telefono']) && !empty($keyTelefono['n_linea'])) {
                        $this->Operador->KeyTelefono->clear();
                        $keyTelefono['operador_id'] = $this->Operador->id;
                        $result &= $this->Operador->KeyTelefono->save($keyTelefono);
                    }
                }
                if ($result) {
                    $this->Operador->commit();
                    $this->Session->setFlash(__('El operador ha sido creado.'), 'success');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Operador->rollback();
                    $this->Session->setFlash(__('El operador no pudo ser creado intente nuevamente.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Las contraseñas deben coincidir'), 'error');
            }
        } else {
            $this->request->data['KeyTelefono'] = array();
            for($i=0;$i<4;$i++) {
                $keyTelefono = array(
                    'key_telefono' => '',
                    'n_linea' => '',
                );
                $this->request->data['KeyTelefono'][] = $keyTelefono;
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
    public function edit($id = null)
    {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'Operador.' . $this->Operador->primaryKey => $id,
                'empresa_id' => $empresa['Empresa']['id'],
                //'tipo' => 'operador'
            ),
            'contain' => array(
                'KeyTelefono'
            )
        );
        $operador = $this->Operador->find('first', $options);
//        pr($operador);die;
        if (empty($operador)) {
            $this->Session->setFlash(__('Operador inexistente'), 'error');
        } elseif ($this->request->is(array('post', 'put'))) {
            if ($this->request->data['Operador']['password'] == $this->request->data['Operador']['password2']) {
                if (!empty($this->request->data['Operador']['password'])) {
                    $this->request->data['Operador']['password'] = md5($this->request->data['Operador']['password']);
                } else {
                    unset($this->request->data['Operador']['password']);
                }
                $this->request->data['Operador']['empresa_id'] = $empresa['Empresa']['id'];
                $this->request->data['Operador']['tipo'] = 'operador';
                $this->request->data['Operador']['id'] = $id;
                $result = $this->Operador->begin();
                $result &= $this->Operador->save($this->request->data);
                foreach ($this->request->data['KeyTelefono'] as $keyTelefono) {
                    $this->Operador->KeyTelefono->clear();
                    if (!empty($keyTelefono['key_telefono']) && !empty($keyTelefono['n_linea'])) {
                        $result &= $this->Operador->KeyTelefono->save($keyTelefono);
                    } else {
                        if (!empty($keyTelefono['id'])) {
                            $result &= $this->Operador->KeyTelefono->delete($keyTelefono['id']);
                        }
                    }
                }
                if ($result) {
                    $this->Operador->commit();
                    $this->Session->setFlash(__('El operador ha sido editado.'), 'success');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Operador->rollback();
                    $this->Session->setFlash(__('El operador no pudo ser editado intente nuevamente.'), 'error');
                    $this->request->data['Operador']['password'] = $this->request->data['Operador']['password2'];
                }
            } else {
                $this->Session->setFlash(__('Las contraseñas deben coincidir'), 'error');
            }
        } else {
            $options = array(
                'conditions' => array(
                    'Operador.' . $this->Operador->primaryKey => $id,
                    'empresa_id' => $empresa['Empresa']['id'],
                    'tipo' => 'operador'
                ),
                'contain' => array(
                    'KeyTelefono'
                ),
                'fields' => array(
                    'id',
                    'usuario',
                    'tipo',
                )
            );
            $this->request->data = $this->Operador->find('first', $options);
            $count = count($this->request->data['KeyTelefono']);
            if ($count < 4) {
                $left = 4 - $count;
                for ($i = 0; $i < $left; $i++) {
                    $keyTelefono = array(
                        'operador_id' => $this->request->data['Operador']['id'],
                        'key_telefono' => '',
                        'n_linea' => '',
                    );
                    $this->request->data['KeyTelefono'][] = $keyTelefono;
                }
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
        $this->request->onlyAllow('post', 'delete');
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'Operador.' . $this->Operador->primaryKey => $id,
                'empresa_id' => $empresa['Empresa']['id'],
                'tipo' => 'operador'
            )
        );
        $operador = $this->Operador->find('first', $options);

        if (empty($operador)) {
            $this->Session->setFlash(__('Operador inexistente'), 'error');
        } elseif ($this->Operador->delete($id)) {
            $this->Session->setFlash(__('El operador ha sido eliminado.'), 'success');
        } else {
            $this->Session->setFlash(__('El operador no pudo ser eliminado. Por favor intente nuevamente.'), 'error');
        }
        return $this->redirect(array('action' => 'index'));
    }

    function habilitar($id)
    {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'Operador.' . $this->Operador->primaryKey => $id,
                'empresa_id' => $empresa['Empresa']['id'],
                'tipo' => 'operador'
            )
        );
        $operador = $this->Operador->find('first', $options);
        if (!empty($operador)) {
            if ($this->Operador->activar($id)) {
                $this->Session->setFlash(__('El operador ha sido habilitado.'), 'success');
            } else {
                $this->Session->setFlash(__('El operador no pudo ser habilitado. Por favor, inténte nuevamente.'), 'error');
            }
        } else {
            $this->Session->setFlash(__('No existe el operador'), 'error');
        }
        $this->redirect();
    }

    function deshabilitar($id)
    {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'Operador.' . $this->Operador->primaryKey => $id,
                'empresa_id' => $empresa['Empresa']['id'],
                'tipo' => 'operador'
            )
        );
        $operador = $this->Operador->find('first', $options);
        if (!empty($operador)) {
            if ($this->Operador->desactivar($id)) {
                $this->Session->setFlash(__('El operador ha sido deshabilitado.'), 'success');
            } else {
                $this->Session->setFlash(__('El operador no pudo ser deshabilitado. Por favor, inténte nuevamente.'), 'error');
            }
        } else {
            $this->Session->setFlash(__('No existe el operador'), 'error');
        }
        $this->redirect();
    }

    function editConfigs($id = null)
    {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'Operador.' . $this->Operador->primaryKey => $id,
                'empresa_id' => $empresa['Empresa']['id']
            )
        );
        $operador = $this->Operador->find('first', $options);
        if (empty($operador)) {
            $this->Session->setFlash(__('No existe el operador'), 'error');
            $this->redirect();
        } elseif ($this->request->is(array('post', 'put'))) {
            $this->request->data['Operador']['configs']['puede_asignar_moviles_determinados'] = (bool)$this->request->data['Operador']['configs']['puede_asignar_moviles_determinados'];
            
            if ((bool)$this->request->data['Operador']['configs']['puede_modificar_vehiculos_conductores'])
                $this->request->data['Operador']['tipo'] = 'admin';
            else
                $this->request->data['Operador']['tipo'] = 'operador';


            if ($this->Operador->save($this->request->data)) {
                $this->Session->setFlash(__('Las configuraciones han sido editadas con éxito.'), 'success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Las configuraciones no pudieron ser editadas intente nuevamente.'), 'error');
            }
        } else {
            $this->request->data = $operador;
        }
        $si_no = array(
            '0' => __('No'),
            '1' => __('Si')
        );
        $this->set(compact('empresa', 'si_no'));
    }

}
