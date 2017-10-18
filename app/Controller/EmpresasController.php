<?php

class EmpresasController extends AppController
{

    var $name = 'Empresas';
    var $helpers = array('Time');
    var $uses = array('Empresa', 'Localizacion', 'Historialvc');

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->Session->check('Admin')) {
            $admin = $this->Session->read('Admin');
            $this->set('admin', $admin);
        }
        if ($this->Session->check('Empresa')) {
            $empresa = $this->Session->read('Empresa');
            $this->set('empresa', $empresa);
        }
    }

    private function configureFilter()
    {
        $this->Filter->configuration = array(
            'Empresa' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'nombre',
                        'email',
                        'telefono',
                    )
                )
            )
        );
    }

    private function configureFilterViewRelationships()
    {
        $this->Filter->configuration = array(
            'Conductor' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'Conductor.nombre',
                        'Conductor.apellido',
                        'Vehiculo.patente',
                        'Vehiculo.nro_registro'
                        /*,
                        'Historialvcs.fecha_ini',
                        'Historialvcs.hora_ini'*/
                    )
                )
            ),
        );
    }

    private function configureFilterViewConductors()
    {
        $this->Filter->configuration = array(
            'Conductor' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'nombre',
                        'apellido'
                    )
                )
            )
        );
    }

    function index()
    {
        $empresa = $this->Session->read('Empresa');
        $this->set('empresa', $empresa);
        if ($empresa) {
            $this->redirect(
                    array(
                        'action' => 'visualization'
                    )
            );
        }
    }

    /**
     * cambiado
     */
    function login()
    {
        if ($this->request->data) {
            $options = array(
                'conditions' => array(
                    'Operador.usuario' => $this->request->data['Empresa']['email'],
                    'Operador.password' => md5($this->request->data['Empresa']['pass']),
                ),
                'contain' => array(
                    'Tipoempresa',
                    'Localidad',
                    'Operador' => array('KeyTelefono')
                )
            );
            $empresa = $this->Empresa->find('first', $options);
            $empresa['Operador']['key_telefono'] = array();
            foreach($empresa['Operador']['KeyTelefono'] as $keyTelefono) {
                $empresa['Operador']['key_telefono'][$keyTelefono['key_telefono']] = $keyTelefono['n_linea'];
            }
            //me fijo si existe
            if (!$empresa) {
                $this->Session->setFlash(__('Usuario o contraseña incorrectos.'), 'error');
            } elseif (strtolower($empresa['Empresa']['estado']) != 'habilitado') {
                $this->Session->setFlash(__('Su empresa no ha sido habilitada.'), 'error');
            } elseif (strtolower($empresa['Operador']['estado']) != 'habilitado') {
                $this->Session->setFlash(__('Su operador no ha sido habilitado.'), 'error');
            } else {
                $this->Session->write('Empresa', $empresa);
                if ($empresa['Operador']['tipo'] == 'admin') {
                    $this->Session->write('EmpresaAdmin', true);
                }
                $this->redirect(array('controller' => 'empresas', 'action' => 'visualization'));
            }
        }
    }

    function logout()
    {
        $empresa = $this->Session->read('Empresa');
        //me fijo si hay una empresa logueada
        if ($empresa) {
            //si esta elimino la sesion
            $this->Session->delete('Empresa');
            $this->Session->delete('EmpresaAdmin');
        } else {
            //si no informo por pantalla
            $this->Session->setFlash(__('No has iniciado sesión'), 'error');
        }
        //me fijo si esta el admin logueado para saber a donde redirigir
        if ($this->Session->read('Admin')) {
            $this->redirect(array('action' => 'view'));
        }
        //si no es el admin al index de empresas
        $this->redirect('/');
    }

    function miPerfil()
    {
        $empresa = $this->Session->read('Empresa');
        //me fijo si esta la empresa logueada
        if (!$empresa) {
            //si no esta informo por pantalla
            $this->Session->setFlash(__('No has iniciado sesión.'), 'error');
            $this->redirect(
                    array(
                        'action' => 'index'
                    )
            );
        }
        //si esta logueada paso sus datos a la vista
        $this->set('empresa', $this->Empresa->findById($empresa['Empresa']['id']));
    }

    function view()
    {
        $this->Empresa->recursive = -1;
        $this->configureFilter();
        $this->Filter->makeConditions();
        $empresas = $this->Paginator->paginate('Empresa');
        $this->set(compact('empresas'));
    }

    public function viewConductors()
    {
        $empresa = $this->Session->read('Empresa');
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);
        //me fijo si el admin esta logueado

        $this->configureFilterViewConductors();
        $this->Filter->controller->modelClass = 'Conductor';
        $this->Filter->makeConditions();

        $this->Paginator->settings['Conductor']['conditions']['empresa_id'] = $empresa['Empresa']['id'];
        $this->Paginator->settings['Conductor']['recursive'] = -1;
        if (!$this->Session->check('Admin')) {
            $this->Paginator->settings['Conductor']['conditions']['estado'] = 'Habilitado';
        }
        $this->Paginator->settings['Conductor']['order']['Conductor.apellido'] = 'asc';
        
        $conductors = $this->Paginator->paginate('Conductor');
        $calificacion = array();
        foreach ($conductors as $conductor) {
            $calificacion[$conductor['Conductor']['id']] = $this->Empresa->Conductor->calificacion($conductor['Conductor']['id']);
        }
        $this->set('conductores', $conductors);
        $this->set('calificacion', $calificacion);
    }

    public function viewRelationships()
    {
        $empresa = $this->Session->read('Empresa');

        $this->Empresa->Conductor->recursive = -1;
        $this->Empresa->Conductor->virtualFields['name'] = 'CONCAT_WS(", ", Conductor.apellido, Conductor.nombre)';
        $this->Empresa->Conductor->virtualFields['fecha_hora_inicio'] = 'CONCAT_WS(" ", Historialvcs.fecha_ini, Historialvcs.hora_ini)';
        $this->Empresa->Conductor->additionalFields[] = 'nro_registro';
        $this->Empresa->Conductor->additionalFields[] = 'patente';

        $this->Paginator->settings['Conductor']['joins'] = array(
            array(
                'table' => 'historialvcs',
                'alias' => 'Historialvcs',
                'type' => 'INNER',
                'conditions' => 'Historialvcs.conductor_id = Conductor.id'
            ),
            array(
                'table' => 'vehiculos',
                'alias' => 'Vehiculo',
                'type' => 'INNER',
                'conditions' => 'Historialvcs.vehiculo_id = Vehiculo.id'
            ),
            array(
                'table' => 'localizacions',
                'alias' => 'Localizacion',
                'type' => 'LEFT',
                'conditions' => 'Localizacion.vehiculo_id = Vehiculo.id'
            ),
        );

        $this->configureFilterViewRelationships();
        //$this->Filter->controller = $this;
        $this->Filter->controller->modelClass = 'Conductor';

        $this->Filter->makeConditions();
        $this->Paginator->settings = $this->Filter->controller->Paginator->settings;
        $this->Paginator->settings['Conductor']['conditions'][]['OR'] = [
            'Historialvcs.fecha_fin IS NULL',
            'Historialvcs.fecha_fin' => '0000-00-00'
        ];
        $this->Paginator->settings['Conductor']['conditions']['Conductor.empresa_id'] = $empresa['Empresa']['id'];
//        $this->Paginator->settings['Conductor']['conditions']['Localizacion.estado !='] = 'Fuera_de_linea';
        $this->Paginator->settings['Conductor']['fields'] = array('Conductor.*', 'Historialvcs.*', 'Vehiculo.*');
        $this->Paginator->settings['Conductor']['order']['Vehiculo.nro_registro'] = 'asc';
        $this->Paginator->settings['Vehiculo']['order']['Vehiculo.nro_registro'] = 'asc';

        $relaciones = $this->Paginator->paginate('Conductor');
        $this->set(compact('relaciones'));
    }

    function history($id = null)
    {
        $this->Empresa->id = $id;
        if (empty($this->request->data)) {
            $historial = $this->Historialvc->query(' select * from apptaxi_historialvcs h
													 INNER JOIN apptaxi_conductors c ON h.conductor_id = c.id
													 INNER JOIN apptaxi_vehiculos v ON h.vehiculo_id = v.id
													 WHERE v.empresa_id = ' . $id . ' AND c.empresa_id = ' . $id . '; ');
            $this->set('historial', $historial);
        }
    }

    /**
     * cambiado
     */
    function add()
    {
        //me dijo si se envio un formulario
        if ($this->request->data) {
            //me fijo si coinciden las contraseñas ingresadas
            if ($this->request->data['Empresa']['pass'] == $this->request->data['Empresa']['pass1']) {
                //inicio la transaccion
                $this->Empresa->create();
                //si coinciden creo la empresa
                $result = $this->Empresa->begin();
                //pregunto si se guardaron los datos correctamente
                $result &= $this->Empresa->save($this->request->data);
                if ($result) {
                    //creo el admin de esa empresa
                    $this->request->data['Operador']['usuario'] = $this->request->data['Empresa']['email'];
                    $this->request->data['Operador']['password'] = md5($this->request->data['Empresa']['pass']);
                    $this->request->data['Operador']['empresa_id'] = $this->Empresa->id;
                    $this->request->data['Operador']['estado'] = 'deshabilitado';
                    $this->request->data['Operador']['tipo'] = 'admin';
                    $result &= $this->Empresa->Operador->save($this->request->data);
                }
                if ($result) {
                    $this->request->data['Tipoempresa']['empresa_id'] = $this->Empresa->id;
                    $result &= $this->Empresa->Tipoempresa->save($this->request->data);
                    //si asi fue, me fijo si se envio una foto
                    if (isset($this->request->data['Empresa']['file']['error']) && $this->request->data['Empresa']['file']['error'] == 0) {
                        //si envio una foto me pregunto si se guardo
                        if ($this->Empresa->uploadThumb($this->request->data['Empresa']['file'], $this->Empresa->id)) {
                            //si se guardo, confirmo la transaccion
                            $this->Empresa->commit();
                            //informo por pantalla
                            $this->Session->setFlash(__('La empresa ha sido guardado exitosamente.'), 'success');
                            $this->redirect(
                                    array(
                                        'controller' => 'empresas',
                                        'action' => 'view'
                                    )
                            );
                        }
                    } else {
                        //no mando una foto para el perfil, confirmo la transaccion
                        $this->Empresa->commit();
                        //informo por pantalla
                        $this->Session->setFlash(__('La empresa ha sido guardado exitosamente.'), 'success');
                        $this->redirect(
                                array(
                                    'controller' => 'empresas',
                                    'action' => 'view'
                                )
                        );
                    }
                }
                //si ocurrio algun error, deshago la transaccion
                $this->Empresa->rollback();
                //informo por pantalla
                $this->Session->setFlash(__('Ha ocurrido un error. Por favor, intente nuevamente.'), 'error');
            } else {
                //informo por pantalla
                $this->Session->setFlash(__('Las contraseñas no coinciden.'), 'error');
                unset($this->request->data['Empresa']['pass']);
                unset($this->request->data['Empresa']['pass1']);
            }
        }
        $localidades = $this->Empresa->Localidad->find('list');
        $this->set(compact('localidades'));
    }

    /**
     * cambiado
     */
    function edit($id = null)
    {
        //busco la empresa
        if ($id==null){
            $empresa = $this->Session->read('Empresa');
            $id = $empresa["Empresa"]["id"];
        }

        $this->Empresa->recursive = 0;
        $empresa = $this->Empresa->findById($id);
        //me fijo que exista
        if (!$empresa) {
            $this->Session->setFlash(__('La empresa no existe.'), 'error');
            $this->redirect(array('controller' => 'empresas', 'action' => 'view'));
        }
        //me fijo si se enviaron datos
        if ($this->request->data) {
            //si se enviaron, inicio la transaccion
            $this->Empresa->begin();
            $result = $this->Empresa->save($this->request->data);
            $this->request->data['Tipoempresa']['empresa_id'] = $this->Empresa->id;
            $result &= $this->Empresa->Tipoempresa->save($this->request->data);
            if ($result) {
                $options = array(
                    'conditions' => array(
                        'empresa_id' => $this->Empresa->id,
                        'tipo' => 'admin'
                    )
                );
                $operador = $this->Empresa->Operador->find('first', $options);
                $operador['Operador']['usuario'] = $this->request->data['Empresa']['email'];
                $result &= $this->Empresa->Operador->save($operador);
            }
            if ($result && isset($this->request->data['Empresa']['file']['error']) && $this->request->data['Empresa']['file']['error'] == 0) {
                $this->Empresa->resetThumb($empresa['Empresa']['id']);
                $result &= $this->Empresa->uploadThumb($this->request->data['Empresa']['file'], $empresa['Empresa']['id']);
            }
            if ($result) {
                $this->Empresa->commit();
                $this->Session->setFlash(__('The changes have been saved successfully.'), 'success');
                $this->redirect(array('controller' => 'empresas', 'action' => 'view'));
            } else {
                $this->Empresa->rollback();
                $this->Session->setFlash(__('Ha ocurrido un error. Por favor, intente nuevamente.'), 'error');
            }
        } else {
            //si no se enviaron, completo el formulario con los datos viejos
            $this->request->data = $empresa;
        }
        $localidades = $this->Empresa->Localidad->find('list');
        $this->set(compact('localidades'));
    } 


 

 function config($id = null)
    {
        //busco la empresa
        if ($id==null){
            $empresa = $this->Session->read('Empresa');
            $id = $empresa["Empresa"]["id"];
        }
        
        $this->Empresa->recursive = 0;
        $empresa = $this->Empresa->findById($id);
        //me fijo que exista
        if (!$empresa) {
            $this->Session->setFlash(__('La empresa no existe.'), 'error');
            $this->redirect(array('controller' => 'empresas', 'action' => 'visualization'));
        }
        //me fijo si se enviaron datos
        if ($this->request->data) {
            //si se enviaron, inicio la transaccion
            $this->Empresa->begin();
            $result = $this->Empresa->save($this->request->data);
            $this->request->data['Tipoempresa']['empresa_id'] = $this->Empresa->id;
            $result &= $this->Empresa->Tipoempresa->save($this->request->data);
            if ($result) {
                $options = array(
                    'conditions' => array(
                        'empresa_id' => $this->Empresa->id,
                        'tipo' => 'admin'
                    )
                );
                $operador = $this->Empresa->Operador->find('first', $options);
                $operador['Operador']['usuario'] = $this->request->data['Empresa']['email'];
                $result &= $this->Empresa->Operador->save($operador);
            }
            if ($result && isset($this->request->data['Empresa']['file']['error']) && $this->request->data['Empresa']['file']['error'] == 0) {
                $this->Empresa->resetThumb($empresa['Empresa']['id']);
                $result &= $this->Empresa->uploadThumb($this->request->data['Empresa']['file'], $empresa['Empresa']['id']);
            }
            if ($result) {
                $this->Empresa->commit();
                $this->Session->setFlash(__('The changes have been saved successfully.'), 'success');
                $this->redirect(array('controller' => 'empresas', 'action' => 'visualization'));
            } else {
                $this->Empresa->rollback();
                $this->Session->setFlash(__('Ha ocurrido un error. Por favor, intente nuevamente.'), 'error');
            }
        } else {
            //si no se enviaron, completo el formulario con los datos viejos
            $this->request->data = $empresa;
        }
        $localidades = $this->Empresa->Localidad->find('list');
        $this->set(compact('localidades'));
    }
    /**
     * cambiar no se usa
     */
    function delete($id = null)
    {
        $admin = $this->Session->read('Admin');
        if ($admin) {
            $this->Empresa->id = $id;
            if (!$this->Empresa->exists()) {
                $this->Session->SetFlash('Empresa inexistente.', 'error');
                $this->redirect(
                        array(
                            'action' => 'index'
                        )
                );
            } else {
                $result = $this->Empresa->begin();
                $result &= $this->Empresa->delete();
                if ($result) {
                    $this->Session->setFlash('La empresa ' . $this->data['Empresa']['nombre'] . ' ha sido borrada', 'success');
                    $this->Empresa->commit();
                    $this->redirect(
                            array(
                                'controller' => 'empresas',
                                'action' => 'view'
                            )
                    );
                } else {
                    $this->Empresa->rollback();
                    $this->Session->setFlash('Ha ocurrido un error. Intente nuevamente.', 'error');
                }
            }
        } else {
            $this->Session->setFlash('Usted no tiene acceso a este área.', 'error');
            $this->redirect(
                    array(
                        'controller' => 'empresas',
                        'action' => 'index'
                    )
            );
        }
    }

    /**
     * cambiado
     */
    public function logInAsEmpresa($empresa_id = null)
    {
        //me fijo si el admin esta logueado
        if (!$this->Session->check('Empresa')) {
            $options = array(
                'conditions' => array(
                    'Empresa.id' => $empresa_id,
                    'Operador.tipo' => 'admin'
                ),
                'contain' => array(
                    'Tipoempresa',
                    'Localidad',
                    'Operador' => array('KeyTelefono')
                )
            );
            $empresa = $this->Empresa->find('first', $options);
            $empresa['Operador']['key_telefono'] = array();
            foreach($empresa['Operador']['KeyTelefono'] as $keyTelefono) {
                $empresa['Operador']['key_telefono'][$keyTelefono['key_telefono']] = $keyTelefono['n_linea'];
            }
            if (!empty($empresa)) {
                $this->Session->write('Empresa', $empresa);
                $this->Session->write('EmpresaAdmin', true);
                $this->Session->setFlash(__('Se ha logueado como la empresa ') . $empresa['Empresa']['nombre'], 'success');
            } else {
                $this->Session->setFlash(__('Empresa inexistente'), 'error');
                $this->redirect();
            }
        } else {
            $this->Session->setFlash(__('Ya se encuentra logueado como una empresa'), 'error');
        }
        $this->redirect(array('action' => 'visualization'));
    }

    public function visualization()
    {
        $empresa = $this->Session->read('Empresa');

        $this->Empresa->Vehiculo->recursive = -1;
        $this->Empresa->Vehiculo->contain('Localizacion');
        $vehiculos = $this->Empresa->Vehiculo->findAllByEmpresaIdAndHabilitado($empresa['Empresa']['id'], 'Habilitado');
        if (!empty($this->request->params['named']['zoom_to'])) {
            $this->request->data['Vehiculo']['mobile'] = $this->request->params['named']['zoom_to'];
        }
         if (!empty($this->request->params['named']['event_to'])) {
            $this->request->data['Vehiculo']['event_to'] = $this->request->params['named']['event_to'];
        }
        $this->set(compact('vehiculos', 'empresa'));
    }

    function reservation()
    {
        //me fijo si hay una empresa logeada
        $empresa = $this->Session->read('Empresa');
        //si no hay
        if (empty($empresa)) {
            $this->Session->setFlash('No has iniciado sesión.', 'error');
            //redirijo al login
            $this->redirect(
                    array(
                        'action' => 'index'
                    )
            );
        } else {
            $this->set('empresa', $empresa);
            $reservas = $this->Empresa->Viaje->viajesEmpresa($empresa['Empresa']['id']);
            $this->set('reservas', $reservas);
        }
    }
    function getReservasDif()
    {
        $this->autoRender = false;
        //me fijo si hay una empresa logeada
        $empresa = $this->Session->read('Empresa');
        $res = null;
        //si no hay
        $hayresdif = 0;
        $difm = 0;
        $c = 0;
        $iguales = 0;
        if (empty($empresa)) {
            $res = array(
                'error' => '1',
                'hayresdif' => '0'
                );


        } else {
            $this->set('empresa', $empresa);
            $reservas = $this->Empresa->Viaje->viajesEmpresa($empresa['Empresa']['id']);
            $this->set('reservas', $reservas);
            $resdifs = $reservas;
            $hayresdif = 0;
            $c = count($resdifs);
            $horamin = date('H')*60+date('i');
            $actual = date('Y-m-d');
            for ($i=0;$i<$c;$i++){
                if ($resdifs[$i]['Viaje']['empresa_id']==$empresa['Empresa']['id']){
                    $fres = $resdifs[$i]['Viaje']['fecha'];
                    $horamindb = ($resdifs[$i]['Viaje']['hora'][0].$resdifs[$i]['Viaje']['hora'][1])*60 + ($resdifs[$i]['Viaje']['hora'][3].$resdifs[$i]['Viaje']['hora'][4]) ;
                    if ($fres == $actual){
                        $difmin = $horamin - $horamindb;
                        if ($difmin<0 and $difmin>(-30)){
                            $hayresdif = 1;
                        }
                    }
                }

            } 
            $res = array(
                'error' => '0',
                'hayresdif' => $hayresdif

            );


        }

        header('Content-Type: application/json');
        return json_encode($res);
    }

    function habilitar($id = null)
    {
        if ($this->Empresa->activate($id)) {
            $this->Session->setFlash('La empresa ha sido habilitada', 'success');
        } else {
            $this->Session->setFlash('La empresa no pudo ser habilitada', 'error');
        }
        $this->redirect();
    }

    function deshabilitar($id = null)
    {
        if ($this->Empresa->deshabilitar($id)) {
            $this->Session->setFlash('La empresa ha sido deshabilitada', 'success');
        } else {
            $this->Session->setFlash('La empresa no pudo ser deshabilitada', 'error');
        }
        $this->redirect();
    }

    /**
     * cambiar
     */
    public function recover()
    {
        if ($this->request->data) {
            $contain_options = array(
                'Operador',
            );
            $this->Empresa->contain($contain_options);
            $options = array(
                'conditions' => array(
                    'Operador.usuario' => $this->request->data['Empresa']['email'],
                    'Operador.tipo' => 'admin',
                )
            );
            $empresa = $this->Empresa->find('first', $options);
            //me fijo que exista
            if (!$empresa) {
                //si no existe el usuario, informo por pantalla
                $this->Session->setFlash(__('Empresa inexistente.'), 'error');
            } else {
                //si el usuario existe, pregunto si se le envio el mail de recuperacion de contraseña
                if ($this->sendRecoveryMail($empresa)) {
                    //si se envio, informo por pantalla
                    $this->Session->setFlash(__('Se le ha enviado un correo para recuperar su contraseña'), 'success');
                    $this->redirect(array('action' => 'login'));
                } else {
                    //si ocurrio un error, informo por pantalla
                    $this->Session->setFlash(__('Ha ocurrido un error. Por favor, intente nuevamente.'), 'error');
                }
            }
        }
    }

    private function sendRecoveryMail($empresa)
    {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('recoverEmpresa');
        $hash = $this->Empresa->makeHash($empresa);
        $Email->viewVars(compact('empresa', 'hash'));
        $Email->subject('Recuperación de contraseña');
        $Email->emailFormat('html');
        $Email->to($empresa['Operador']['usuario']);
        try {
            $result = $Email->send();
        } catch (Exception $ex) {
            $result = false;
        }
        return $result;
    }

    /**
     * cambiar
     * http://conquienviajo_test.local/empresas/doRecover/27/df846d329de733bc529245b3beef4c3b
     */
    public function doRecover($id, $hash)
    {
        $contain_options = array(
            'Operador',
        );
        $this->Empresa->contain($contain_options);
        $empresa = $this->Empresa->findById($id);
        //verifico que sea el dueño de la cuenta
        if ($hash != $this->Empresa->makeHash($empresa)) {
            //si no es el dueño, error, informo por pantalla
            $this->Session->setFlash(__('La recuperación no pudo llevarse adelante. Por favor genere nuevamente la solicitud.'), 'error');
            $this->redirect(array('action' => 'recover'));
        } elseif ($this->RequestHandler->isPost()) {
            //si es post, pregunto si son distintas las contraseñas ingresadas
            if ($this->request->data['Empresa']['pass1'] != $this->request->data['Empresa']['pass2']) {
                //si son distintas informo por pantalla
                $this->Session->setFlash(__('Las contraseñas deben coincidir.'), 'error');
            } else {
                //si coinciden selecciono el usuario
                $this->Empresa->Operador->id = $empresa['Operador']['id'];
                //comienzo la transaccion
                $this->Empresa->begin();
                //pregunto si se realizo correctamente el cambio de contraseña
                if ($this->Empresa->Operador->saveField('password', md5($this->request->data['Empresa']['pass1']))) {
                    $this->Empresa->commit();
                    $this->Session->setFlash(__('Su contraseña ha sido cambiada'), 'success');
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Empresa->rollback();
                    $this->Session->setFlash(__('Ha ocurrido un error. Por favor, intente nuevamente.'), 'error');
                }
            }
        }
    }

    public function getThumb($id = -1)
    {
        parent::__getThumb($id, PATH_EMPRESA_THUMBS, PATH_DEFAULT_EMPRESA_THUMB);
    }

    public function resetThumb($id)
    {
        $result = true;
        if (!$this->Empresa->resetThumb($id)) {
            $result = false;
        }
        return $result;
    }

    function existe($id)
    {
        $path = PATH_EMPRESA_THUMBS . DS . $id . DS . 'thumb.png';
        return file_exists($path);
    }

    /**
     * cambiar
     */
    public function ChangePassword()
    {
        $empresa = $this->Session->read('Empresa');
        if (!empty($this->request->data)) {
            if (md5($this->request->data['Empresa']['password_old']) != $empresa['Empresa']['pass'] && !$this->Session->check('Admin')) {
                $this->Session->setFlash(__('Debe ingresar su contraseña previa.'), 'error');
            } elseif ($this->request->data['Empresa']['password1'] != $this->request->data['Empresa']['password2']) {
                $this->Session->setFlash(__('Las dos contraseñas deben ser iguales.'), 'error');
            } elseif (empty($this->request->data['Empresa']['password1'])) {
                $this->Session->setFlash(__('La contraseña no puede ser vacia.'), 'error');
            } elseif (strlen($this->request->data['Empresa']['password1']) < 6) {
                $this->Session->setFlash(__('La contraseña debe tener al menos 6 caracteres'), 'error');
            } else {
                $this->Empresa->id = $empresa['Empresa']['id'];
                if ($this->Empresa->saveField('pass', md5($this->request->data['Empresa']['password1']))) {
                    $this->Session->setFlash(__('La contraseña ha sido modificada con exito.'), 'success');
                    $this->Session->write('Empresa.Empresa.pass', md5($this->request->data['Empresa']['password1']));
                    $this->redirect(array('action' => 'miPerfil'));
                } else {
                    $this->Session->setFlash(__('La contraseña no pudo ser modificada.'), 'error');
                }
            }
        }
        $this->set('empresa', $empresa);
    }

    public function apiKey($empresa_id = null)
    {
        if (!$this->Session->check('Admin')) {
            $empresa_id = $this->Session->read('Empresa.Empresa.id');
        } elseif (empty($empresa_id)) {
            $empresa_id = $this->Session->read('Empresa.Empresa.id');
        }
        $this->Empresa->recursive = -1;
        $options = array(
            'conditions' => array(
                'Empresa.id' => $empresa_id
            )
        );
        $empresa = $this->Empresa->find('first', $options);
        echo $this->Api->getSecretKey($empresa);
        die;
    }

}
