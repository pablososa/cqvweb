<?php

App::uses('AppController', 'Controller');

class UsuariosController extends AppController
{

    var $components = array('Calculo', 'String', 'Email', 'Paginator', 'RequestHandler');
    var $helpers = array('GoogleMap', 'Js' => 'Jquery');
    var $uses = array('Usuario', 'Empresa', 'Calificacion');

    private function configureFilter()
    {
        $this->Filter->configuration = array(
            'Usuario' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'apellido',
                        'nombre',
                        'email',
                        'direccion'
                    )
                )
            )
        );
    }

    private function configureFilterCustomerHistory()
    {
        $this->Filter->configuration = array(
            'Usuario' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'apellido',
                        'nombre'
                    )
                )
            )
        );
    }

    private function configureFilterEmpresa()
    {
        $this->Filter->configuration = array(
            'Empresa' => array(
                'nombre' => array(
                    'function' => 'like'
                )
            ),
            'Tipoempresa' => array(
                'join' => array(
                    'type' => 'left',
                    'conditions' => 'fk_in_the_other_table'
                )
            )
        );
    }

    function index()
    {
        if ($this->Session->check('Usuario')) {
            return $this->redirect(['controller' => 'viajes', 'action' => 'viewPending']);
        } else {
            return $this->redirect(['controller' => 'usuarios', 'action' => 'login']);
        }
    }

    function login()
    {
        $this->layout = 'usuario_login';
        if ($this->request->data) {
            $this->Usuario->recursive = -1;
            $usuario = $this->Usuario->findByEmailAndPass($this->request->data['Usuario']['email'], md5($this->request->data['Usuario']['pass']));
            if (!$usuario || $usuario['Usuario']['estado'] == 5) { //pregunto si hay un usuario registrado con ese correo
                $this->Session->setFlash(__('Usuario o contraseña incorrectos.'), 'error');
            } elseif (!$usuario['Usuario']['habilitado']) { //pregunto si el usuario está habilitado
                $this->Session->setFlash(__('Usuario deshabilitado.'), 'error');
            } elseif ($usuario['Usuario']['estado'] == 0) { //si existe verifica que haya activado su cuenta
                $this->Session->setFlash(__('Usted no ha activado su cuenta.'), 'error');
            } elseif ($usuario['Usuario']['estado'] == 1) { //si existe verifica que este habilitado
//                    $this->Session->setFlash(__('Bienvenido a ConQuienViajo, para utilizar los servicios web usted debe activar su cuenta.'), 'success');
                if ($this->sendActivationMail($usuario)) {
                    $this->Session->setFlash(__('Se le ha enviado un correo para activar su cuenta.'), 'success');
                } else {
                    $this->Session->setFlash(__('Ha ocurrido un error al enviar el correo de activación. Por favor, inténte nuevamente.'), 'error');
                }
            } elseif ($usuario['Usuario']['estado'] == 4) {
                $this->Session->setFlash(__('Usted no está habilitado para utilizar el servicio.'), 'error');
            } elseif ($usuario['Usuario']['estado'] == 2 || $usuario['Usuario']['estado'] == 3) {
                $this->Session->write('Usuario', $usuario);
                return $this->redirect(['controller' => 'viajes', 'action' => 'viewPending']);
            }
        }
    }

    function logout()
    {
        $this->Session->delete('Usuario');
        $this->redirect(['action' => 'login']);
    }

    function add()
    {
        $this->layout = 'usuario_login';
        //pregunto si se enviaron datos en el formulario
        if (!empty($this->request->data)) {
            if ($this->request->data['Usuario']['pass'] == $this->request->data['Usuario']['pass1']) {
                //establezo con celular como la caracteristica mas el numero
                $this->request->data['Usuario']['telefono'] = $this->request->data['Usuario']['caracteristica'] . $this->request->data['Usuario']['numero'];
                //pongo el estado en 0 = 'No verificado'
                $this->request->data['Usuario']['estado'] = 0;
                //creo el usuario
                $this->Usuario->create();
                $result = $this->Usuario->begin();
                $user = $this->Usuario->save($this->request->data);
//                pr($this->request->data['Usuario']['telefono']);
//                pr($this->Usuario->validationErrors);
//                exit;
                $result &= $user;
                if ($result) {
                    if (isset($this->request->data['Usuario']['file']['error']) && $this->request->data['Usuario']['file']['error'] == 0) {
                        $this->Usuario->uploadThumb($this->request->data['Usuario']['file'], $this->Usuario->id);
                    }
                }
                if ($result && $this->sendActivationMail($user)) {
                    //confirmo las acciones antes hechas.
                    $this->Usuario->commit();
                    //informo por pantalla
                    $this->Session->setFlash(__('Se le ha enviado un correo electrónico con un link para que active su cuenta.'), 'success');
                    $this->redirect(array('action' => 'index'));
                } else {
                    //Si hubo algun error, deshago todas las acciones.
                    $this->Usuario->rollback();
                    //error al enviar el mail de confirmacion.
                    $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Las contraseñas no coinciden.'), 'error');
            }
        } else {
            $this->request->data['Usuario']['fecha_nac'] = '';
        }
        $localidades = $this->Usuario->Localidad->find('list');
        $this->set(compact('localidades'));
    }

    /* OMITIDO POR AHORA
      function myReservs(){
      if( $this->RequestHandler->isAjax() ){
      $this->set('reservas',$this->Paginator->paginate('Viaje'));
      }
      $usuario = $this->Session->read('Usuario');
      if( !$usuario ){
      $this->Session->setFlash(__('No has iniciado sesión.'),'error');
      $this->redirect(
      array(
      'action' => 'index'
      )
      );
      }
      $this->set('usuario',$usuario);
      $this->Paginator->settings = array(
      'order' => array(
      'fecha' => 'desc',
      'hora' => 'desc'
      ),
      'conditions' => array(
      'usuario_id' => $usuario['Usuario']['id'],
      'estado' => 'reserva'
      ),
      'recursive' => -1,
      'limit' => 10
      );
      $this->set('reservas',$this->Paginator->paginate('Viaje'));
      }
     */

    function edit($id = null)
    {
        $usuario = $this->Session->read('Usuario');
        //pregunto si esta logueado el usuario
        if (!$usuario) {
            //si no inicio sesion, informo por pantalla
            $this->Session->setFlash(__('No has iniciado sesión.'), 'error');
            $this->redirect(
                array(
                    'action' => 'index'
                )
            );
        }
        //si esta, paso los datos del usuario a la vista
        $this->set('usuario', $usuario);
        //me fijo si esta el admin logueado
        $admin = $this->Session->read('Admin');
        if ($admin) {
            //si esta logueado paso sus datos a la vista
            $this->set('admin', $admin);
        }
        //me fijo si el usuario no envio un formulario
        if ($this->request->data) {
            //si envio datos en el formulrio
            //comienza la transaccion
            $result = $this->Usuario->begin();
            $result &= $this->Usuario->save($this->request->data);
            //pregunto si se guardaron exitosamente
            if ($result) {
                if (isset($this->request->data['Usuario']['file']['error']) && $this->request->data['Usuario']['file']['error'] == 0) {
                    $this->Usuario->uploadThumb($this->request->data['Usuario']['file'], $this->request->data['Usuario']['id']);
                }
            }
            if ($result) {
                $this->Usuario->commit();
                //informo por pantalla
                $this->Session->setFlash(__('Los cambios han sido guardados exitosamente.'), 'success');
                $this->redirect(array('action' => 'miPerfil'));
            } else {
                $this->Usuario->rollback();
                //informo por pantalla el error.
                $this->Session->setFlash(__('No se han podido guardar los cambios. Por favor, inténte nuevamente.'), 'error');
            }
        } else {
            //completo el form, con los datos almacenados en la bd
            $this->request->data = $this->Usuario->findById($usuario['Usuario']['id']);
        }
    }

//    function delete()
//    {
//        //Me fijo si hay un usuario logeado
//        $usuario = $this->Session->read('Usuario');
//
//        $this->Usuario->id = $usuario['Usuario']['id'];
//        $result = $this->Usuario->begin();
//        //modifico su estado a eliminado
//        $result &= $this->Usuario->saveField('estado', 5);
//        if ($result) {
//            //si se guardo bien, confirmo las acciones
//            $this->Usuario->commit();
//            //informo por pantalla
//            $this->Session->SetFlash(__('Su cuenta ha sido eliminada'), 'success');
//            $this->redirect(array('action' => 'logout'));
//        } else {
//            //Si hubo algun error, deshago las acciones
//            $this->Usuario->rollback();
//            //informo que ocurrio un error
//            $this->Session->SetFlash('Ha ocurrido un error. Por favor, inténte nuevamente.', 'error');
//            $this->redirect(array('action' => 'miPerfil'));
//        }
//    }

    function view()
    {
        $this->Usuario->recursive = -1;
        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
//        pr($this->Paginator->settings);
//        exit;
        $usuarios = $this->Paginator->paginate();
        $this->set(compact('usuarios'));
    }

    function miPerfil()
    {
        $this->layout = 'usuario';
        $usuario = $this->Session->read('Usuario');
        if(!empty($this->request->data)) {
            $this->request->data['Usuario']['id'] = $usuario['Usuario']['id'];
            $data = $this->request->data;
            unset($data['Usuario']['email']);
            if($this->Usuario->save($data)) {
                $this->Session->setFlash('Los datos de su perfil  han sido actualizados.', 'success');
                return $this->redirect();
            } else {
                $this->Session->setFlash('Los datos de su perfil no pudieron actualizarce. Intente nuevamente.', 'error');
            }
        } else {
            $this->request->data = $this->Usuario->findById($usuario['Usuario']['id']);
            $this->request->data['Usuario']['pais'] = 'Argentina';
            $this->request->data['Usuario']['idioma'] = 'Español';
        }
        $this->set(compact('usuario'));
    }

    function changePass()
    {
        $this->layout = 'usuario';
        $usuario = $this->Session->read('Usuario');
        //me dijo si se envio algun formulario
//        pr($this->request->data);
//        exit;
        if (!empty($this->request->data)) {
            //me fijo que coincida la contraseña vieja con la del usuario logueado
            if (md5($this->request->data['Usuario']['pass']) == $usuario['Usuario']['pass']) {
                //si coincide, me fijo que la constraseña nueva haya sido confirmada
                if ($this->request->data['Usuario']['pass1'] == $this->request->data['Usuario']['pass2']) {
                    //si fue confirmada, establezco el id del usuario
                    $this->Usuario->id = $usuario['Usuario']['id'];
                    //inicio la transaccion
                    $this->Usuario->begin();
                    //pregunto si los cambios se guardaron exitosamente
                    exit;
                    if ($this->Usuario->saveField('pass', md5($this->request->data['Usuario']['pass2']))) {
                        //se guardaron exitosamente
                        //cambio la pass del usuario en la variable, para mandar el mail con la pass nueva sin encriptar
                        $usuario['Usuario']['pass'] = $this->request->data['Usuario']['pass2'];
                        //pregunto si se envio el mail al usuario
                        if ($this->sendMail($usuario)) {
                            //si se envio, confirmo la transaccion
                            $this->Usuario->commit();
                            //informo por pantalla
                            $this->Session->SetFlash(__('Se le a enviado un correo electrónico informando el cambio de contraseña.'), 'success');
                            $this->redirect(
                                array(
                                    'action' => 'miPerfil'
                                )
                            );
                        }
                    }
                    //si ocurrio algun error, deshago la transaccion
                    $this->Usuario->rollback();
                    //informo por pantalla
                    $this->Session->SetFlash(__('Ha ocurrido un error. Por favor, intente nuevamente.'), 'error');
                } else {
                    //si no coincidieron las contraseñas, informo por pantalla
                    $this->Session->setFlash(__('Las contraseñas no coinciden.'), 'error');
                }
            } else {
                //si no coincide informo
                $this->Session->setFlash(__('Contraseña incorrecta.'), 'error');
            }
        }
//        exit;
        $this->set('usuario', $usuario);
    }

    function history($id = null)
    {
        $this->layout = 'usuario';
        $usuario = $this->Session->read('Usuario');

        $this->Viaje = ClassRegistry::init('Viaje');
        $this->Viaje->virtualFields['fecha_hora'] = 'CONCAT_WS(" ", Viaje.fecha, Viaje.hora)';
        $this->Paginator->settings['Viaje'] = [
            'order' => [
                'fecha' => 'desc',
                'hora' => 'desc'
            ],
            'conditions' => [
                'estado' => 'Finalizado',
                'usuario_id' => $usuario['Usuario']['id']
            ]
        ];
//        $calificado = array();
//        foreach ($this->Paginator->paginate('Viaje') as $viaje) {
//            $calificado[$viaje['Viaje']['id']] = $this->Usuario->Viaje->Calificacion->calificado($viaje['Viaje']['id']);
//        }
//        $this->set('calificado', $calificado);
        $viajes = $this->Paginator->paginate('Viaje');
//        pr($viajes);
//        exit;
        $this->set(compact('viajes'));
    }

//
// 	function reservation( $id = null ){
//        //leo la variable de sesion usuario y la hago accesible en $usuario
//        $usuario = $this->Session->read('Usuario');
//        //leo la variable de sesion admin y la hago accesible en $admin
//        $admin = $this->Session->read('Admin');
//        //me fijo que almenos 1 este logueado
// 		if( !$admin && !$usuario ){
// 			$this->Session->SetFlash( __('No has iniciado sesión.') , 'error' );
//            $this->redirect(
//                    array(
//                        'action' => 'index'
//                    )
//            );
//        }
//        //me fijo si el admin esta logueado
// 		if( $admin ){
//            //si esta logueado paso los datos a la vista
// 			$this->set( 'admin' , $admin );
//            //me fijo si ya no lo logie al usuario
//            $usuario = $this->Session->read('Usuario');
// 			if( !$usuario ){
//                //busco los datos del usuario
//	 			$usuario = $this->Usuario->findById( $id );
//                //me fijo que exista
//	 			if( !$usuario ){
//                    //si no existe, informo por pantalla
//	 				$this->Session->SetFlash( __('Usuario no encontrado.') , 'error' );
//                    $this->redirect(
//                            array(
//                                'action' => 'view'
//                            )
//                    );
//                }
//                //logueo al usuario
//	 			$this->Session->write( 'Usuario' ,$usuario );
//            }
//        }
//        //paso sus datos a la vista
//		$this->set( 'usuario' , $usuario );
//        //busco las empresas habilitadas
//        $empresas = array();
//		if( !$this->request->data ){
//            //configuro la paginacion
//            $this->Paginator->settings = array(
//                'Empresa' => array(
//                    'order' => array(
//                        'nombre' => 'asc'
//                    ),
//                    'conditions' => array(
//                        'estado' => 'Habilitado'
//                    ),
//                    'limit' => 10,
//                    'recursive' => -1
//                )
//            );
//            //creo un arreglo para poner las calificaciones de las empresas
//            $datos = array();
//			foreach( $this->Paginator->paginate('Empresa') as $empresa ){
//                //por cada empresa calculo el raiting
//				$notas = $this->Calificacion->raiting( $empresa['Empresa']['id'] );
//                //lo guardo en el arreglo
//                $datos[$empresa['Empresa']['id']] = $notas;
//            }
//            //paso los raitings a la vista
//			$this->set('datos',$datos);
//            //paso las empresas a la vista
//			$this->set('empresas',$this->Paginator->paginate('Empresa'));
//        }
//    }

    function viewK()
    {
        $this->Usuario->recursive = -1;
        $this->configureFilter();
        $this->Filter->makeConditions();
        $usuarios = $this->Paginator->paginate('Usuario');
        $this->set(compact('usuarios'));
    }

    function reservation($id = null)
    {
        //leo la variable de sesion usuario y la hago accesible en $usuario
        $usuario = $this->Session->read('Usuario');
        //leo la variable de sesion admin y la hago accesible en $admin
        $admin = $this->Session->read('Admin');
        //me fijo si el admin esta logueado
        if ($admin) {
            //si esta logueado paso los datos a la vista
            $this->set('admin', $admin);
            //me fijo si ya no lo logie al usuario
            $usuario = $this->Session->read('Usuario');
            if (!$usuario) {
                //busco los datos del usuario
                $usuario = $this->Usuario->findById($id);
                //me fijo que exista
                if (!$usuario) {
                    //si no existe, informo por pantalla
                    $this->Session->SetFlash(__('Usuario no encontrado.'), 'error');
                    $this->redirect(
                        array(
                            'action' => 'view'
                        )
                    );
                }
                //logueo al usuario
                $this->Session->write('Usuario', $usuario);
            }
        }
        //paso sus datos a la vista
        $this->set('usuario', $usuario);

        $this->Empresa->addRatingVirtualField();
        $this->Empresa->addVotosVirtualField();
        $this->Empresa->recursive = -1;
        $this->Paginator->settings['Empresa']['joins'][] = array(
            'table' => 'tipoempresas',
            'alias' => 'Tipoempresa',
            'type' => 'LEFT',
            'conditions' => 'Tipoempresa.empresa_id = Empresa.id',
        );
        $this->Filter->controller->Paginator->settings = $this->Paginator->settings;
        $this->Filter->controller->modelClass = 'Empresa';
        $this->configureFilterEmpresa();
        $this->Filter->makeConditions();

        $this->Paginator->settings['Empresa']['fields'] = 'Empresa.*, Tipoempresa.*';
        $this->Paginator->settings['Empresa']['order']['rating'] = 'desc';
        $this->Paginator->settings['Empresa']['conditions']['estado'] = 'Habilitado';
        $this->Paginator->settings['Empresa']['conditions']['localidad_id'] = $usuario['Usuario']['localidad_id'];

        $empresas = $this->Paginator->paginate('Empresa');
        $tipos = array(
            '' => 'Tipo',
            'Taxi' => 'Taxi',
            'Remis' => 'Remis',
        );
        //paso las empresas a la vista
        $this->set(compact('empresas', 'tipos'));
    }

    public function doRecover($id, $hash)
    {
        $this->layout = 'usuario_login';
        //busco el usuario con el $id
        $usuario = $this->Usuario->findById($id);
        //verifico que sea el dueño de la cuenta
        if ($hash != $this->Usuario->makeHash($usuario)) {
            //si no es el dueño, error, informo por pantalla
            $this->Session->setFlash(__('La recuperación no pudo llevarse adelante.'), 'error');
            $this->redirect(
                array(
                    'action' => 'index'
                )
            );
        } else {
            //pregunto si es post la peticion http
            if ($this->RequestHandler->isPost()) {
                //si es post, pregunto si son distintas las contraseñas ingresadas
                if ($this->request->data['Usuario']['pass1'] != $this->request->data['Usuario']['pass2']) {
                    //si son distintas informo por pantalla
                    $this->Session->setFlash(__('Las contraseñas deben coincidir.'), 'error');
                } else {
                    //si coinciden selecciono el usuario
                    $this->Usuario->id = $id;
                    //comienzo la transaccion
                    $this->Usuario->begin();
                    //pregunto si se realizo correctamente el cambio de contraseña
                    if ($this->Usuario->saveField('pass', md5($this->request->data['Usuario']['pass1']))) {
                        //si fue asi, confirmo la transaccion
                        $this->Usuario->commit();
                        //informo por pantalla
                        $this->Session->setFlash(__('Su contraseña ha sido cambiada'), 'success');
                        $this->redirect(
                            array(
                                'action' => 'index'
                            )
                        );
                    } else {
                        //si ocurrio algun error, deshago la transaccion
                        $this->Usuario->rollback();
                        //informo por pantalla
                        $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
                    }
                }
            }
        }
    }

    public function recover()
    {
        $this->layout = 'usuario_login';
        if ($this->request->data) {
            //busco el usuario que quiere recuperar la contraseña
            $usuario = $this->Usuario->findByEmail($this->request->data['Usuario']['email']);
            //me fijo que exista
            if (!$usuario) {
                //si no existe el usuario, informo por pantalla
                $this->Session->setFlash(__('Usuario inexistente.'), 'error');
            } else {
                //si el usuario existe, pregunto si se le envio el mail de recuperacion de contraseña
                if ($this->sendRecoveryMail($usuario)) {
                    //si se envio, informo por pantalla
                    $this->Session->setFlash(__('Se le ha enviado un correo para recuperar su contraseña'), 'success');
                    $this->redirect(
                        array(
                            'action' => 'index'
                        )
                    );
                } else {
                    //si ocurrio un error, informo por pantalla
                    $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
                }
            }
        }
    }

    function penalizar($id = null)
    {
        $admin = $this->Session->read('Admin');
        if ($admin) {
            if ($this->Usuario->penalizar($id)) {
                $this->Session->setFlash(__('El usuario ha sido penalizado'), 'success');
            } else {
                $this->Session->setFlash(__('El usuario no pudo ser penalizado'), 'error');
            }
        } else {
            $this->Session->setFlash(__('Área restringida'), 'error');
        }
        $this->redirect(
            array(
                'action' => 'view'
            )
        );
        $this->autoRender = false;
    }

    function habilitar($id = null)
    {
        //si esta pregunto si se puedo activar el usuario
        if ($this->Usuario->habilitar($id)) {
            //si se pudo, informo por pantalla
            $this->Session->setFlash(__('El usuario ha sido habilitado'), 'success');
            $this->sendHabilitado($id);
        } else {
            //si no se pudo, informo por pantalla
            $this->Session->setFlash(__('El usuario no pudo ser habilitado'), 'error');
        }
        $this->redirect();
    }

    public function deshabilitar($id = null)
    {
        //si esta pregunto si se pudo deshabilitar el usuario
        if ($this->Usuario->deshabilitar($id)) {
            //si se pudo, informo por pantalla
            $this->Session->setFlash(__('El usuario ha sido deshabilitado'), 'success');
            $this->sendDeshabilitado($id);
        } else {
            //si no se pudo, informo por pantalla
            $this->Session->setFlash(__('El usuario no pudo ser deshabilitado'), 'error');
        }
        $this->redirect();
    }

    private function sendRecoveryMail($user)
    {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('recoverUsuario');
        $hash = $this->Usuario->makeHash($user);
        $Email->viewVars(compact('user', 'hash'));
        $Email->subject('Recuperacion de contraseña');
        $Email->emailFormat('html');
        $Email->to($user['Usuario']['email']);
        return $Email->send();
    }

    private function sendHabilitado($id)
    {
        $user = $this->Usuario->findById($id);
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('usuario_habilitado');
        $Email->viewVars(compact('user'));
        $Email->subject('Usuario habilitado');
        $Email->emailFormat('html');
        $Email->to($user['Usuario']['email']);
        return $Email->send();
    }

    private function sendDeshabilitado($id)
    {
        $user = $this->Usuario->findById($id);
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('usuario_deshabilitado');
        $Email->viewVars(compact('user'));
        $Email->subject('Usuario deshabilitado');
        $Email->emailFormat('html');
        $Email->to($user['Usuario']['email']);
        return $Email->send();
    }

    private function sendActivationMail($user)
    {
        $hash = $this->Usuario->makeHash($user);
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('activate');
        $Email->viewVars(compact('user', 'hash'));
        $Email->subject('Usuario de IUNIKE');
        $Email->emailFormat('html');
        $Email->to($user['Usuario']['email']);
        return $Email->send();
    }

    private function sendMail($user)
    {
        $hash = $this->Usuario->makeHash($user);
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template('changePass');
        $Email->viewVars(compact('user'));
        $Email->subject('Usuario de ' . 'CQV');
        $Email->emailFormat('html');
        $Email->to($user['Usuario']['email']);
        return $Email->send();
    }

    public function activate($id, $hash)
    {
        $user = $this->Usuario->findById($id);

        if ($hash != $this->Usuario->makeHash($user)) {
            $this->Session->setFlash(__('La activación es incorrecta.'), 'error');
        } else {
            if ($this->Usuario->activate($id)) {
                $this->Session->setFlash(__('Activación exitosa. Ingrese su e-mail y contraseña.'), 'success');
            } else {
                $this->Session->setFlash(__('La activación no pudo realizarse. Intenta nuevamente.'), 'error');
            }
        }
        $this->redirect(
            array(
                'action' => 'index'
            )
        );
    }

    public function getThumb($id = -1)
    {
        parent::__getThumb($id, PATH_USER_THUMBS, PATH_DEFAULT_USER_THUMB);
    }

    public function resetThumb($id)
    {
        $result = true;
        if (!$this->Usuario->resetThumb($id)) {
            $result = false;
        }
        return $result;
    }

    public function customerHistory()
    {
        $empresa = $this->Session->read('Empresa');
        $this->set('empresa', $empresa);

        $this->Usuario->recursive = -1;
        $this->Usuario->virtualFields['name'] = 'CONCAT_WS(", ", Usuario.apellido, Usuario.nombre)';
        $this->Usuario->virtualFields['n_viajes'] = 'SUM(Viaje.estado = "Finalizado")';

        $this->Paginator->settings['Usuario']['joins'] = array(
            array(
                'table' => 'viajes',
                'alias' => 'Viaje',
                'type' => 'INNER',
                'conditions' => 'Viaje.usuario_id = Usuario.id'
            ),
        );

        $this->configureFilterCustomerHistory();
//        $this->Filter->controller->modelClass = 'Usuario';

        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
        $this->Paginator->settings = $this->Filter->controller->Paginator->settings;
        $this->Paginator->settings['Usuario']['conditions']['Viaje.empresa_id'] = $empresa['Empresa']['id'];
        $this->Paginator->settings['Usuario']['fields'] = array('*');
        $this->Paginator->settings['Usuario']['group'] = array('Usuario.id');

        $usuarios = $this->Paginator->paginate('Usuario');

        $this->set(compact('usuarios'));
    }
}