<?php

class ConductorsController extends AppController {

    var $name = 'Conductors';
    var $uses = array('Conductor');
    var $helpers = array('Html', 'Form');

    function index() {
        //redirijo al index de empresa
        $this->redirect(
                array(
                    'controller' => 'empresas',
                    'action' => 'index'
                )
        );
    }

    function add() {
        $empresa = $this->Session->read('Empresa');
        $admin = $this->Session->read('Admin');
        if ($admin) {
            //si el admin esta logueado paso los datos a la vista
            $this->set('admin', $admin);
        }
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);
        //me fijo si se enviaron datos
        if ($this->request->data) {
            //si coinciden creo el conductor
            $this->Conductor->create();
            //inicio la transaccion
            $this->Conductor->begin();

            if (!empty($this->request->data['Conductor']['fecha_nac'])) {
                $this->request->data['Conductor']['fecha_nac'] = implode('-', array_reverse(explode('/', $this->request->data['Conductor']['fecha_nac'])));
            }
            //pregunto si se guardaron los datos correctamente
            if ($this->Conductor->save($this->request->data['Conductor'])) {
            	if (isset($this->request->data['Conductor']['file2']['error']) && $this->request->data['Conductor']['file2']['error'] == 0){
                        $this->Conductor->uploadThumb($this->request->data['Conductor']['file2'], $this->Conductor->id."lic");
                    } 

                //si asi fue, me fijo si se envio una foto
                if (isset($this->request->data['Conductor']['file']['error']) && $this->request->data['Conductor']['file']['error'] == 0) {
                    //si envio una foto me pregunto si se guardo
                    if ($this->Conductor->uploadThumb($this->request->data['Conductor']['file'], $this->Conductor->id)) {
                        //si se guardo, confirmo la transaccion
                        $this->Conductor->commit();
                        //informo por pantalla
                        $this->Session->setFlash(__('El conductor ha sido guardado exitosamente.'), 'success');
                        $this->redirect(
                                array(
                                    'controller' => 'empresas',
                                    'action' => 'viewConductors'
                                )
                        );
                    }
                } else {
                    //no mando una foto para el perfil, confirmo la transaccion
                    $this->Conductor->commit();
                    //informo por pantalla
                    $this->Session->setFlash(__('El conductor ha sido guardado exitosamente.'), 'success');
                    $this->redirect(
                            array(
                                'controller' => 'empresas',
                                'action' => 'viewConductors'
                            )
                    );
                }
            }
            //si ocurrio algun error, deshago la transaccion
            $this->Conductor->rollback();
            if (!empty($this->request->data['Conductor']['fecha_nac'])) {
                $this->request->data['Conductor']['fecha_nac'] = implode('/', array_reverse(explode('-', $this->request->data['Conductor']['fecha_nac'])));
            }
            //informo por pantalla
            $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
        }
    }

    function edit($id = null) {
        $empresa = $this->Session->read('Empresa');
        $admin = $this->Session->read('Admin');
        if ($admin) {
            //si el admin esta logueado paso los datos a la vista
            $this->set('admin', $admin);
        }
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);
        //busco el conductor
        $conductor = $this->Conductor->findById($id);
        //me fijo que exista
        if (!$conductor) {
            //si no existe informo por pantalla
            $this->Session->setFlash(__('El conductor no existe.'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'viewConductors'
                    )
            );
        }
        //me fijo si se enviaron datos
        if ($this->request->data) {
            //si se enviaron, inicio la transaccion
            $this->Conductor->begin();
            //pregunto si se guardaron los datos correctamente
            if (!empty($this->request->data['Conductor']['fecha_nac'])) {
                $this->request->data['Conductor']['fecha_nac'] = implode('-', array_reverse(explode('/', $this->request->data['Conductor']['fecha_nac'])));
            }
            $result = $this->Conductor->save($this->request->data);
            if ($result) {
            	    if (isset($this->request->data['Conductor']['file2']['error']) && $this->request->data['Conductor']['file2']['error'] == 0){
                        $this->Conductor->resetThumb($conductor['Conductor']['id']."lic");
                        $this->Conductor->uploadThumb($this->request->data['Conductor']['file2'], $conductor['Conductor']['id']."lic");
                    } 

                //si se guardaron correctamente, pregunto si envio una foto
                if (isset($this->request->data['Conductor']['file']['error']) && $this->request->data['Conductor']['file']['error'] == 0) {

                    //si existe, la borro
                    $this->Conductor->resetThumb($conductor['Conductor']['id']);
                    //si la borro, pregunto si guardo la nueva
                    if ($this->Conductor->uploadThumb($this->request->data['Conductor']['file'], $conductor['Conductor']['id'])) {
                        //si la guardo, confirmo la transaccion
                        $this->Conductor->commit();
                        //informo por pantalla
                        $this->Session->setFlash(__('The changes have been saved successfully.'), 'success');
                        $this->redirect(
                                array(
                                    'controller' => 'empresas',
                                    'action' => 'viewConductors'
                                )
                        );
                    }
                } else {
                    //si no envio foto, confirmo la transaccion
                    $this->Conductor->commit();
                    //informo por pantalla
                    $this->Session->setFlash(__('The changes have been saved successfully.'), 'success');
                    $this->redirect(
                            array(
                                'controller' => 'empresas',
                                'action' => 'viewConductors'
                            )
                    );
                }
            }
            //si ocurrio un error, deshago la transaccion
            $this->Conductor->rollback();
            //informo por pantalla
            $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
        } else {
            //si no se enviaron, completo el formulario con los datos viejos
            $this->request->data = $this->Conductor->findById($id);
            $fecha = explode('-', $this->request->data['Conductor']['fecha_nac']);
        }
        if (!empty($this->request->data['Conductor']['fecha_nac'])) {
            $this->request->data['Conductor']['fecha_nac'] = implode('/', array_reverse(explode('-', $this->request->data['Conductor']['fecha_nac'])));
        }
    }

    function changePass($id = null) {
        //leo la variable de session empresa
        $empresa = $this->Session->read('Empresa');
        //pregunto si hay una empresa logueada
        if (!$empresa) {
            //si no hay, informo
            $this->Session->setFlash(__('No has iniciado sesión'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'index'
                    )
            );
        }
        //paso los datos del conductor a la vista
        $this->set('empresa', $empresa);
        //si hay una empresa logueada, busco el conductor
        $conductor = $this->Conductor->findById($id);
        //pregunto si existe
        if (!$conductor) {
            //si no existe informo
            $this->Session->setFlash(__('No existe el conductor'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'viewConductors'
                    )
            );
        }
        //paso los datos del conductor a la vista
        $this->set('conductor', $conductor);
        //pregunto si se enviaron datos en el formulario
        if ($this->request->data) {
            //si se enviaron datos pregunto, si la contraseña vieja coincide con la ingresada
            //if (md5($this->request->data['Conductor']['pass']) == $conductor['Conductor']['pass']) {
                //si coinciden, verifico que la contraseña nueva coincida con la confirmacion
                if ($this->request->data['Conductor']['pass1'] == $this->request->data['Conductor']['pass2']) {
                    //si coinciden guardo los cambios
                    $this->Conductor->begin();
                    //selecciono el conductor
                    $this->Conductor->id = $conductor['Conductor']['id'];
                    //pregunto si se guardaron con exito
                    if ($this->Conductor->saveField('pass', md5($this->request->data['Conductor']['pass1']))) {
                        //si se guardo bien, confirmo las acciones
                        $this->Conductor->commit();
                        //informo por pantalla
                        $this->Session->setFlash(__('Los cambios fueron guardados.'), 'success');
                        $this->redirect(
                                array(
                                    'controller' => 'empresas',
                                    'action' => 'viewConductors'
                                )
                        );
                    } else {
                        //si ocurrio algun error, deshago la transaccion
                        $this->Conductor->rollback();
                        //informo por pantalla
                        $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
                    }
                } else {
                    //no coincidieron las contraseñas
                    $this->Session->setFlash(__('No coinciden las constraseñas.'), 'error');
                }
            /*} else {
                //la contraseña vieja fue incorrecta
                $this->Session->setFlash(__('Contraseña incorrecta.'), 'error');
            }*/
        }
    }


      function eliminar($id) {
        $this->Conductor->id = $id;
        //verifico si existe el conductor
        if (!$this->Conductor->exists()) {
            //no existe
            $this->Session->setFlash(__('No existe el Conductor'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'viewConductors'
                    )
            );
        }


         //inicio la transaccion
        $this->Conductor->begin();
         //pregunto si se guardo correctamente
        $result = $this->Conductor->delete();
        if ($result) {
            //confirmo la transaccion
            $this->Conductor->commit();
            //informo por pantalla
            $this->Session->setFlash(__('El conductor ha sido eliminado'), 'success');
        } else {
            //si ocurrio un error al guardar
            $this->Vehiculo->rollback();
            //informo por pantalla
            $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
        }

        $this->redirect(
                array(
                    'controller' => 'empresas',
                    'action' => 'viewConductors'
                )
        );
    }
    

    function delete($id = null) {
        $this->Conductor->id = $id;
        if (!$this->Conductor->exists()) {
            throw new NotFoundException(__('Conductor inválido'));
        }
        $result = $this->Conductor->begin();
        $result &= $this->Conductor->delete();
        if ($result) {
            $this->Conductor->commit();
            $this->Session->setFlash(__('El conductor ha sido eliminado con exito'), 'success');
        } else {
            $this->Conductor->rollback();
            $this->Session->setFlash(__('El conductor no pudo ser borrado. Por favor, intente nuevamente.'), 'error');
        }
        $this->redirect(array('controller' => 'empresas', 'action' => 'viewConductors'));
    }

    function history($id = null) {
        $empresa = $this->Session->read('Empresa');
        if (empty($empresa)) {
            $this->Session->setFlash('No has iniciado sesión.', 'error');
            $this->redirect(array('controller' => 'empresas', 'action' => 'index'));
        }
        if (is_null($id)) {
            $this->redirect(array('controller' => 'empresas', 'action' => 'viewConductors'));
        }
        $conductor = $this->Conductor->findById($id);
        if (empty($conductor)) {
            $this->Session->setFlash('No existe el conductor.', 'error');
            $this->redirect(array('controller' => 'empresas', 'action' => 'viewConductors'));
        }
        $viajes = $this->Conductor->Viaje->findAllByConductorId($id);
        for ($i = 0; $i < count($viajes); $i++) {
            $viajes[$i]['Viaje']['usuario'] = $this->Conductor->Viaje->Usuario->nombreUsuario($viajes[$i]['Viaje']['usuario_id']);
            unset($viajes[$i]['Viaje']['latitud_origen']);
            unset($viajes[$i]['Viaje']['latitud_destino']);
            unset($viajes[$i]['Viaje']['longitud_origen']);
            unset($viajes[$i]['Viaje']['longitud_destino']);
            unset($viajes[$i]['Viaje']['tarifa']);
            unset($viajes[$i]['Viaje']['distancia']);
            unset($viajes[$i]['Viaje']['id']);
            unset($viajes[$i]['Viaje']['localidad']);
            unset($viajes[$i]['Viaje']['cercanos']);
            unset($viajes[$i]['Viaje']['conductor_id']);
            unset($viajes[$i]['Viaje']['empresa_id']);
            unset($viajes[$i]['Viaje']['usuario_id']);
            unset($viajes[$i]['Viaje']['vehiculo_id']);
        }
        $this->set('empresa', $empresa);
        $this->set('conductor', $conductor['Conductor']['apellido'] . ', ' . $conductor['Conductor']['nombre']);
        $this->set('viajes', $viajes);
    }

    private function sendActivationMail($conductor, $empresa) {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('habilitarConductor');
        $Email->viewVars(compact('conductor', 'empresa'));
        $Email->subject('Usuario de ' . 'CQV');
        $Email->emailFormat('html');
        $Email->to('gabisanmartin12@gmail.com');
        return $Email->send();
    }

    //----------------------------------------- FUNCION DEL ADMIN ----------------------------------------------------------------------------
    function habilitar($id) {
        $this->Conductor->id = $id;
        //verifico si existe el conductor
        if (!$this->Conductor->exists()) {
            //no existe
            $this->Session->setFlash(__('No existe el Conductor'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'viewConductors'
                    )
            );
        }
        //si existe lo habilito
        if ($this->Conductor->activar($id)) {
            //exito
            $this->Session->setFlash(__('El Conductor ha sido habilitado.'), 'success');
        } else {
            //error
            $this->Session->setFlash(__('El Conductor no pudo ser habilitado. Por favor, inténte nuevamente.'), 'error');
        }
        $this->redirect(
                array(
                    'controller' => 'empresas',
                    'action' => 'viewConductors'
                )
        );
    }

//---------------------------------------------------------------------------------------------------------------------------------------	
    function deshabilitar($id) {
        $this->Conductor->id = $id;
        //verifico si existe el conductor
        if (!$this->Conductor->exists()) {
            //no existe
            $this->Session->setFlash(__('No existe el Conductor'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'viewConductors'
                    )
            );
        }
        //si existe lo deshabilito
        if ($this->Conductor->desactivar($id)) {
            //exito
            $this->Session->setFlash(__('El Conductor ha sido deshabilitado.'), 'success');
        } else {
            //error
            $this->Session->setFlash(__('El Conductor no pudo ser deshabilitado. Por favor, inténte nuevamente.'), 'error');
        }
        $this->redirect(
                array(
                    'controller' => 'empresas',
                    'action' => 'viewConductors'
                )
        );
    }

    public function getThumb($id = -1) {
        parent::__getThumb($id, PATH_CONDUCTOR_THUMBS, PATH_DEFAULT_CONDUCTOR_THUMB);
    }

    function existe($id) {
        $path = PATH_CONDUCTOR_THUMBS . DS . $id . DS . 'thumb.png';
        return file_exists($path);
    }

}

?>