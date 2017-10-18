<?php

class VehiculosController extends AppController {

    var $name = 'Vehiculos';
    var $uses = array(
        'Vehiculo',
        'Conductor'
    );
    var $helpers = array(
        'Html',
        'Form'
    );
    var $components = array(
        'Calculo'
    );

    public function beforeFilter() {
//        $this->superEmpresaAction[] = 'index';
        parent::beforeFilter();
    }

    private function configureFilter() {
        $this->Filter->configuration = array(
            'Vehiculo' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'patente',
                        'nro_registro',
                        'marca',
                        'modelo',
                        'tipo_de_auto',
                    )
                )
            )
        );
    }

    public function index() {
        $empresa = $this->Session->read('Empresa');
        $admin = $this->Session->check('Admin');

        $this->Vehiculo->virtualFields['nro_registro_numeric'] = 'CAST(Vehiculo.nro_registro as UNSIGNED)';

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
        $this->Paginator->settings['Vehiculo']['conditions']['empresa_id'] = $empresa['Empresa']['id'];
        if (!$admin) {
            $this->Paginator->settings['Vehiculo']['conditions']['habilitado'] = array('Habilitado', 'Deshabilitado');
        }

        $vehiculos = $this->Paginator->paginate('Vehiculo');
        //los paso a la vista
        $this->set(compact('empresa', 'vehiculos'));
    }

    public function mensajes() {
        $empresa = $this->Session->read('Empresa');
        //me fijo si el admin esta logueado
        $admin = $this->Session->read('Admin');
        $this->Vehiculo->recursive = -1;
        $this->Vehiculo->additionalFields[] = 'Mensaje.id';
        $this->Vehiculo->virtualFields['nro_registro_numeric'] = 'CAST(Vehiculo.nro_registro as UNSIGNED)';

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
        if (!$admin) {
            $this->Paginator->settings['Vehiculo']['conditions']['habilitado'] = 'Habilitado';
        }
        $this->Paginator->settings['Vehiculo']['conditions']['empresa_id'] = $empresa['Empresa']['id'];
        $this->Paginator->settings['Vehiculo']['joins'] = array(
            array(
                'alias' => 'Mensaje',
                'table' => 'mensajes',
                'type' => 'LEFT',
                'conditions' => 'Mensaje.vehiculo_id = Vehiculo.id',
            )
        );
        $this->Paginator->settings['Vehiculo']['group'] = array('Vehiculo.id');
        $this->Paginator->settings['Vehiculo']['order'] = array('Mensaje.id' => 'DESC');
        $this->Paginator->settings['Vehiculo']['fields'] = array('Vehiculo.*', 'Mensaje.*');

        $vehiculos = $this->Paginator->paginate('Vehiculo');
        $options = array(
            'conditions' => array('empresa_id' => $empresa['Empresa']['id'])
        );
        $vehiculos_list = $this->Vehiculo->find('list', $options);
//        pr($vehiculos);
        $this->set(compact('empresa', 'vehiculos', 'vehiculos_list'));
    }

    public function add() {
        $empresa = $this->Session->read('Empresa');
        if ($this->request->data) {
            $this->request->data['Vehiculo']['patente'] = strtoupper($this->request->data['Vehiculo']['patente']);
            $this->request->data['Vehiculo']['empresa_id'] = $empresa['Empresa']['id'];
            $this->request->data['Vehiculo']['direccion'] = $empresa['Empresa']['direccion'];
            $this->request->data['Vehiculo']['habilitado'] = 'Deshabilitado';

                    if (isset($this->request->data['Vehiculo']['file2']['error']) && $this->request->data['Vehiculo']['file2']['error'] == 0){
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file2'], $this->Vehiculo->id."veh");
                    } 
                    if (isset($this->request->data['Vehiculo']['file3']['error']) && $this->request->data['Vehiculo']['file3']['error'] == 0){
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file3'], $this->Vehiculo->id."f3");
                    } 
                    if (isset($this->request->data['Vehiculo']['file4']['error']) && $this->request->data['Vehiculo']['file4']['error'] == 0){
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file4'], $this->Vehiculo->id."f4");
                    } 
                    if (isset($this->request->data['Vehiculo']['file5']['error']) && $this->request->data['Vehiculo']['file5']['error'] == 0){
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file5'], $this->Vehiculo->id."f5");
                    } 


            if ($this->Vehiculo->save($this->request->data)) {
//                $this->sendActivationMail($this->request->data['Vehiculo'], $empresa['Empresa']);
                $this->Session->SetFlash(__('Se ha dado de alta el vehiculo.'), 'success');
                $this->redirect(array('controller' => 'vehiculos', 'action' => 'index'));
            } else {
                $this->Session->SetFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
            }
        }
        $this->set('empresa', $empresa);
    }

    function edit($id = null) {
        $empresa = $this->Session->read('Empresa');
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);

        $vehiculo = $this->Vehiculo->findById($id);
        //me fijo si se enviaron datos en el formulario
        if ($this->request->data) {
              if (isset($this->request->data['Vehiculo']['file2']['error']) && $this->request->data['Vehiculo']['file2']['error'] == 0){
                        $this->Vehiculo->resetThumb($vehiculo['Vehiculo']['id']."veh");
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file2'], $vehiculo['Vehiculo']['id']."veh");
                    } 
            if (isset($this->request->data['Vehiculo']['file3']['error']) && $this->request->data['Vehiculo']['file3']['error'] == 0){
                        $this->Vehiculo->resetThumb($vehiculo['Vehiculo']['id']."f3");
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file3'], $vehiculo['Vehiculo']['id']."f3");
                    }
            if (isset($this->request->data['Vehiculo']['file4']['error']) && $this->request->data['Vehiculo']['file4']['error'] == 0){
                        $this->Vehiculo->resetThumb($vehiculo['Vehiculo']['id']."f4");
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file4'], $vehiculo['Vehiculo']['id']."f4");
                    } 
            if (isset($this->request->data['Vehiculo']['file5']['error']) && $this->request->data['Vehiculo']['file5']['error'] == 0){
                        $this->Vehiculo->resetThumb($vehiculo['Vehiculo']['id']."f5");
                        $this->Vehiculo->uploadThumb($this->request->data['Vehiculo']['file5'], $vehiculo['Vehiculo']['id']."f5");
                    } 


            //pregunto si se guardaron exitosamente los cambios
            if ($this->Vehiculo->save($this->request->data)) {
                //informo por pantalla
                $this->Session->SetFlash(__('Los datos del vehiculo fueron guardados con éxito.'), 'success');
                $this->redirect(array('controller' => 'vehiculos', 'action' => 'index'));
            } else {
                $this->Session->SetFlash(__('Ha ocurrido un error. Por favor, intente nuevamente.'), 'error');
            }
        } else {
            //si no se envio ningun formulario, lo lleno con los datos del vehiculo
            $this->request->data = $this->Vehiculo->findById($id);
        }
    }

    function liquidar($id = null,$fecha,$monto) {
         $empresa = $this->Session->read('Empresa');
        //pregunto si hay una empresa logueada
        if (!$empresa) {
            //si no hay una empresa logueada, informo
            $this->Session->setFlash(__('No has iniciado sesión.'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'index'
                    )
            );
        }

        //establezco que el vehiculo tiene el id pasado por parametro
        $this->Vehiculo->id = $id;

        $fechatxt = date("d-m-Y", strtotime($fecha) );

        $res = $this->Vehiculo->setLiquidacion($id,$fecha,$monto);

        if ($res)
            $this->Session->setFlash(__('Se ha liquidado correctamente el período correspondiente a '.$fechatxt), 'success');
        else
            $this->Session->setFlash(__('Error al ingresar la liquidacion correspondiente a '.$fechatxt), 'error');
        
        $this->redirect('/vehiculos/liquidacion/'.$id);

    }

    function delete($id = null) {
        $empresa = $this->Session->read('Empresa');
        //pregunto si hay una empresa logueada
        if (!$empresa) {
            //si no hay una empresa logueada, informo
            $this->Session->setFlash(__('No has iniciado sesión.'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'index'
                    )
            );
        }
        //establezco que el vehiculo tiene el id pasado por parametro
        $this->Vehiculo->id = $id;
        //pregunto si existe ese vehiculo
        if ($this->Vehiculo->exists()) {
            //inicio la transaccion
            $this->Vehiculo->begin();
            //pregunto si se guardo correctamente
            if ($this->Vehiculo->saveField('habilitado', 'Eliminado')) {
                //confirmo la transaccion
                $this->Vehiculo->commit();
                //informo por pantalla
                $this->Session->setFlash(__('El vehiculo ha sido eliminado'), 'success');
            } else {
                //si ocurrio un error al guardar
                $this->Vehiculo->rollback();
                //informo por pantalla
                $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
            }
        } else {
            //si no existe informo
            $this->Session->setFlash(__('El vehiculo no existe.'), 'error');
        }
        $this->redirect();
    }

    private function sendActivationMail($vehiculo, $empresa) {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('habilitarVehiculo');
        $Email->viewVars(compact('vehiculo', 'empresa'));
        $Email->subject('Alta vehiculo CQV');
        $Email->emailFormat('html');
        $Email->to(ADMIN_EMAIL);
        return $Email->send();
    }

    function habilitar($id) {
        $this->Vehiculo->id = $id;
        if ($this->Vehiculo->exists()) {
            if ($this->Vehiculo->activar($id)) {
                $this->Session->setFlash(__('El vehiculo ha sido habilitado.'), 'success');
            } else {
                $this->Session->setFlash(__('El vehiculo no pudo ser habilitado. Por favor, inténte nuevamente.'), 'error');
            }
        } else {
            $this->Session->setFlash(__('No existe el vehiculo'), 'error');
        }
        $this->redirect();
    }

    function deshabilitar($id) {
        $this->Vehiculo->id = $id;
        if ($this->Vehiculo->exists()) {
            if ($this->Vehiculo->desactivar($id)) {
                $this->Session->setFlash(__('El vehiculo ha sido deshabilitado.'), 'success');
            } else {
                $this->Session->setFlash(__('El vehiculo no pudo ser deshabilitado. Por favor, inténte nuevamente.'), 'error');
            }
        } else {
            $this->Session->setFlash(__('No existe el vehiculo'), 'error');
        }
        $this->redirect();
    }

    public function liquidacion($id){
        $empresa = $this->Session->read('Empresa');
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);
        $vehiculo = $this->Vehiculo->findById($id);

        $viajes = $this->Vehiculo->getLiquidacion($id);
        //los paso a la vista
        $this->set(compact('empresa', 'vehiculo' , 'viajes' ));

        //lista mde viajes por dia

    }

        public function inicio(){
        $empresa = $this->Session->read('Empresa');
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);

         if ($this->request->data) {

            $fini = $this->request->data['Vehiculo']['fecha_ini']; 
            $ffin = $this->request->data['Vehiculo']['fecha_fin'];

            $viajes = $this->Vehiculo->getFacturacion($fini,$ffin);
         }else
            $viajes = $this->Vehiculo->getInicio();
        //los paso a la vista
        $this->set(compact('empresa', 'viajes', 'fini', 'ffin' ));

        //lista mde viajes por dia

    }

    public function getVehiculos() {
        $this->autoRender = false;
        $id = $this->Session->read('Empresa.Empresa.id');
        $this->Vehiculo->recursive = -1;
        $options = array(
            'conditions' => array(
                'Vehiculo.empresa_id' => $id
            ),
            'joins' => array(
                array(
                    'table' => 'historialvcs',
                    'alias' => 'Historialvcs',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Historialvcs.vehiculo_id = Vehiculo.id',
                        '(Historialvcs.fecha_fin = "0000-00-00" OR Historialvcs.fecha_fin IS NULL)'
                    )
                ),
            ),
            'contain' => array('Localizacion'),
            'fields' => array(
                'Vehiculo.id',
                'Vehiculo.nro_registro',
                'Vehiculo.marca',
                'Vehiculo.modelo',
                'Vehiculo.patente',
                'Localizacion.id',
                'Localizacion.estado',
                'Localizacion.latitud',
                'Localizacion.longitud',
                'Localizacion.panico',
                'Historialvcs.id',
                'Historialvcs.fecha_fin',
            )
        );
        $vehiculos = $this->Vehiculo->find('all', $options);
        $map_estado_imagen = array(
            'libre' => 'verde',
            'no_disponible' => 'amarillo',
            'no_disponble' => 'amarillo',
            'en_peticion' => 'amarillo',
            'ocupado' => 'rojo',
            'asignado' => 'azul',
            'panico' => 'panico'
        );
        foreach ($vehiculos as &$vehiculo) {
            $estado = strtolower($vehiculo['Localizacion']['estado']);
            if(!empty($vehiculo['Localizacion']['panico'])) {
                $estado = 'panico';
            }
            $vehiculo['Vehiculo']['color'] = 'verde';
            if (isset($map_estado_imagen[$estado])) {
                $vehiculo['Vehiculo']['color'] = $map_estado_imagen[$estado];
            }
            $vehiculo['Historialvcs']['fecha_fin'] = $vehiculo['Historialvcs']['fecha_fin'] == '0000-00-00' ? null : $vehiculo['Historialvcs']['fecha_fin'];
            $vehiculo['Vehiculo']['visible'] = !empty($vehiculo['Historialvcs']['id']) && empty($vehiculo['Historialvcs']['fecha_fin']);
            if ($vehiculo['Vehiculo']['visible']) {
                if (!empty($estado)) {
                    $vehiculo['Localizacion']['estado'] = $estado;
                    if (!isset($map_estado_imagen[$estado])) {
                        $vehiculo['Vehiculo']['visible'] = false;
                    }
                } else {
                    $vehiculo['Vehiculo']['visible'] = false;
                }
            }
        }
        header('Content-Type: application/json');
        return json_encode($vehiculos);
    }

    public function getIcon($nro_registro, $estado) {
        header("Cache-Control: max-age=864000");
        header('Content-Type: image/png');
        if(in_array($estado, array('amarillo', 'azul', 'rojo', 'verde', 'panico'))) {
            Image::getVehiculoThumb($nro_registro, $estado);
        }
        die;
    }

        public function getThumb($id = -1) {
        parent::__getThumb($id, PATH_CONDUCTOR_THUMBS, PATH_DEFAULT_CONDUCTOR_THUMB);
    }

    function existe($id) {
        $path = PATH_CONDUCTOR_THUMBS . DS . $id . DS . 'thumb.png';
        return file_exists($path);
    }

}
