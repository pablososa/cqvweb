<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

class ViajesController extends AppController
{

    var $name = 'Viajes';
    var $uses = array('Viaje', 'Localizacion');
    var $components = array('Calculo', 'String');

    function beforeFilter()
    {
        parent::beforeFilter();
        $usuario = $this->Session->read('Usuario');
        $this->set('usuario', $usuario);
    }

    private function configureFilterCustomerHistory()
    {
        $this->Filter->configuration = array(
            'Viaje' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'dir_origen',
                        'dir_destino',
                        'estado'
                    )
                )
            )
        );
    }

    private function configureFilterHistory()
    {
        $this->Filter->configuration = array(
            'Viaje' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'Usuario.nombre',
                        'Usuario.apellido',
                        'Conductor.nombre',
                        'Conductor.apellido',
                        'Viaje.dir_origen',
                        'Viaje.dir_destino',
                        'Viaje.fecha',
                        'Viaje.hora',
                        'Viaje.estado',
                    )
                )
            )
        );
    }

    private function _add($empresa, $data, $telefono = null)
    {
        if (empty($empresa['Operador']['configs']['puede_asignar_moviles_determinados'])) {
            $data['Viaje']['vehiculo_id'] = false;
        }
        $this->Viaje->begin();
        $viaje = $this->Viaje->add($empresa, $data);
        if (!empty($telefono)) {
            $this->IvrDomicilio->IvrCliente->IvrLlamadaEntrante->deleteByEmpresaAndTelefono($empresa['Empresa']['id'], $telefono);
        }
        if (!empty($viaje)) {
            $this->Viaje->commit();
            if ($viaje['Viaje']['estado'] == 'Pendiente') {
                $this->GCMClient->sendNotificationVehicle_NuevoViaje($viaje);
            }
        } else {
            $this->Viaje->rollback();
        }
        return $viaje;
    }

    public function add()
    {
        $this->autoRender = false;
        if (!empty($this->request->data)) {
            $usuario = $this->Session->read('Usuario');
            $viaje = $this->Viaje->getPending($usuario['Usuario']['id']);
            if(empty($viaje)) {
                $data = [
                    'Viaje' => []
                ];
                $data['Viaje']['dir_origen'] = $this->request->data['Viaje']['dir_origen'];
                $data['Viaje']['dir_destino'] = $this->request->data['Viaje']['dir_destino'];
                $data['Viaje']['observaciones'] = $this->request->data['Viaje']['observaciones'];
                $data['Viaje']['usuario_id'] = $usuario['Usuario']['id'];
                $data['Viaje']['creador'] = 'Usuario';
                $viaje = $this->_add(IUNIKE_EMPRESA_ID, $data);
                if (!empty($viaje)) {
                    SocketClient::sendNodeEventEmpresa($viaje['Viaje']['empresa_id'], NODE_EVENT_viaje_created);
                    $this->Session->setFlash($this->Viaje->message, 'success');
                    $this->redirect(array('action' => 'viewPending'));
                } else {
                    $this->Session->setFlash($this->Viaje->message, 'error');
                    $this->_view(null);
                }
            } else {
                $this->Session->setFlash("Ya posee un viaje en curso. Para crear uno nuevo cancele el anterior", 'error');
                $this->redirect(array('action' => 'viewPending'));
            }
        }
    }

    public function adminAdd($vehiculo_id = null, $lat = null, $lng = null, $telefono = null)
    {
        $empresa = $this->Session->read('Empresa');

        if (!empty($this->request->data)) {
            $result = $this->_add($empresa, $this->request->data, $telefono);
            if ($result) {
                $this->Session->setFlash($this->Viaje->message, 'success');
            } else {
                $this->Session->setFlash($this->Viaje->message, 'error');
            }
            if ($this->isIframe || !empty($this->request->data['Viaje']['back_to_referer'])) {
                $this->redirect();
            } else {
                $this->redirect(array('action' => 'adminHistory'));
            }
        }

        $conductors = $this->getFreeConductorsSelect($empresa['Empresa']['id'], $vehiculo_id);
        $select_value = $conductors['select_value'];
        $conductors = $conductors['conductors'];

        if (!empty($select_value)) {
            $this->request->data['Viaje']['vehiculo_id'] = $select_value;
        }
        if (!empty($lat) && !empty($lng)) {
            $this->request->data['Viaje']['dir_origen'] = $this->Calculo->getAddress($lat, $lng);
        }
        $this->set(compact('conductors', 'empresa', 'vehiculo_id'));
    }

    public function reasignar($viaje_id)
    {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'Historialvcs.fecha_fin IS NULL',
                'Conductor.empresa_id' => $empresa['Empresa']['id'],
                'Localizacion.estado' => 'Libre',
                'Vehiculo.habilitado' => "Habilitado"
            ),
            'joins' => array(
                array(
                    'table' => 'historialvcs',
                    'alias' => 'Historialvcs',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Historialvcs.conductor_id = Conductor.id',
                        'Historialvcs.fecha_fin IS NULL'
                    )
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
                    'type' => 'INNER',
                    'conditions' => array(
                        'Localizacion.vehiculo_id = Vehiculo.id'
                    )
                ),
            ),
            'fields' => '*'
        );
        if (!$empresa['Operador']['configs']['puede_asignar_moviles_determinados']) {
            $this->request->data['Viaje']['vehiculo_id'] = null;
            $this->request->data['Viaje']['id'] = $viaje_id;
        }
        $conductor = null;
        if (!empty($this->request->data)) {
            $options_v = array(
                'conditions' => array(
                    'id' => $this->request->data['Viaje']['id']
                )
            );
            $viaje = $this->Viaje->find('first', $options_v);
            if (empty($this->request->data['Viaje']['vehiculo_id'])) {
                $cercanos = $this->Viaje->Vehiculo->Localizacion->getCercanos($viaje, 10, false);
                if (empty($cercanos)) {
                    $this->Session->setFlash(__('No hay vehículos disponibles'), 'error');
                    $this->redirect();
                }


                $viaje['Viaje']['cercanos'] = implode(',', $cercanos);
                $this->request->data['Viaje']['vehiculo_id'] = reset($cercanos);
                $options['conditions']['Vehiculo.id'] = $this->request->data['Viaje']['vehiculo_id'];
                $this->Viaje->Conductor->recursive = -1;
                $conductor = $this->Viaje->Conductor->find('first', $options);
                $this->request->data['Viaje']['conductor_id'] = $conductor['Conductor']['id'];
            } else {
                list($this->request->data['Viaje']['vehiculo_id'], $this->request->data['Viaje']['conductor_id']) = explode(':', $this->request->data['Viaje']['vehiculo_id']);
            }

            $this->Viaje->begin();
            $historialvlc = $this->Viaje->Vehiculo->Localizacion->getByVehiculoId($viaje['Viaje']['vehiculo_id']);
            $this->Viaje->Vehiculo->Localizacion->id = $historialvlc['Localizacion']['id'];
            $this->Viaje->Vehiculo->Localizacion->saveField('estado', 'Libre');

            $historialvlc = $this->Viaje->Vehiculo->Localizacion->getByVehiculoId($this->request->data['Viaje']['vehiculo_id']);
            $this->Viaje->Vehiculo->Localizacion->id = $historialvlc['Localizacion']['id'];
            $this->Viaje->Vehiculo->Localizacion->saveField('estado', 'En_peticion');

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $this->Viaje->id = $viaje_id;
            $this->Viaje->saveField('estado', 'DelegandoAdmin');

            $this->request->data['Viaje']['estado'] = 'Pendiente';
            $this->request->data['Viaje']['fecha'] = date("Y-m-d");
            $this->request->data['Viaje']['hora'] = date("H:i:s");
            $this->request->data['Viaje']['horareasig'] = date("H:i:s");
            //$cerc = $this->Viaje->Vehiculo->Localizacion->getCercanos($viaje, 10, true);
            //ver
            $this->request->data['Viaje']['cercanos'] = $viaje['Viaje']['cercanos'];
            $result = $this->Viaje->save($this->request->data);

            if ($result) {
                $this->Viaje->commit();
                $this->GCMClient->sendNotificationVehicle_NuevoViaje($this->request->data);
                $this->Session->setFlash(__('El viaje fue reasignado'), 'success');
                if(!empty($viaje['Viaje']['usuario_id'])) {
                    SocketClient::sendNodeEventViaje($viaje['Viaje']['id'], NODE_EVENT_viaje_status_changed);
                }
                $this->redirect(array('action' => 'adminHistory'));
            } else {
                $this->Viaje->rollback();
                $this->Session->setFlash(__('El viaje no pudo ser reasignado'), 'error');
            }
        } else {
            $this->request->data['Viaje']['id'] = $viaje_id;
        }

        $conductors = $this->getFreeConductorsSelect($empresa['Empresa']['id']);
        if (empty($conductors)) {
            $this->Session->setFlash(__('No hay vehículos disponibles'), 'error');
            $this->redirect(array('action' => 'adminHistory'));
        }
        $this->set(compact('conductors', 'empresa'));
    }

    /**
     * REFACTORIZAR: MUY mal escrito tiene una tendencia a tirar
     * fatal errors increibles cuando no hay vehiculos disponibles
     * ¿Porque se pasa el id si desde el ya invocador se tiene el viaje?
     * ¿Porque es una función "public" en un "controlador"?
     * @param $viaje_id
     */
    public function reasignar2($viaje_id)
    {

        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'Historialvcs.fecha_fin IS NULL',
                'Conductor.empresa_id' => $empresa['Empresa']['id'],
                'Localizacion.estado' => 'Libre',
                'Vehiculo.habilitado' => "Habilitado"
            ),
            'joins' => array(
                array(
                    'table' => 'historialvcs',
                    'alias' => 'Historialvcs',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Historialvcs.conductor_id = Conductor.id',
                        'Historialvcs.fecha_fin IS NULL'
                    )
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
                    'type' => 'INNER',
                    'conditions' => array(
                        'Localizacion.vehiculo_id = Vehiculo.id'
                    )
                ),
            ),
            'fields' => '*'
        );
        $this->request->data['Viaje']['id'] = $viaje_id;

        $conductor = null;
        if (!empty($this->request->data)) {
            $options_v = array(
                'conditions' => array(
                    'id' => $this->request->data['Viaje']['id']
                )
            );
            $viaje = $this->Viaje->find('first', $options_v);
            //if (empty($this->request->data['Viaje']['vehiculo_id'])) {
            //$cercanos = $this->Viaje->Vehiculo->Localizacion->getCercanos($viaje, 10, false);

            $viaje['Viaje']['reasignated'] = $viaje['Viaje']['fecha'] . " " . $viaje['Viaje']['horareasig'];
            if (strtotime($viaje['Viaje']['reasignated']) > (time() - 35))
                return;


            if ($viaje['Viaje']['estado'] == 'Pendiente' and $viaje['Viaje']['cercanos'] == '') return;

            if ($viaje['Viaje']['creador'] != 'Admin' or $viaje['Viaje']['estado'] != 'Pendiente' or $viaje['Viaje']['dir_origen'] == '') {
                //$this->Session->setFlash(__('No hay vehículos disponibles'), 'error');
                //$this->redirect();
                return;
            }

            $cercanos = explode(",", $viaje['Viaje']['cercanos']);
            //if (count($cercanos)==1 and $viaje['Viaje']['cercanos']!="126")
            //{
            //  return;

            //}

              if ((count($cercanos) == 1 and $viaje['Viaje']['vehiculo_id'] != "126")){
                $cercanos = $this->Viaje->Vehiculo->Localizacion->getCercanos($viaje, 10, false);
                $cercanosdb = implode(',', $cercanos);
                $this->Viaje->id = $viaje_id;
                $this->Viaje->saveField('cercanos', $cercanosdb);

                return;
              }

            if ((count($cercanos) == 1 and $viaje['Viaje']['cercanos'] == "126") or $viaje['Viaje']['cercanos'] == '' or count($cercanos) == 2) {
                $cercanos = $this->Viaje->Vehiculo->Localizacion->getCercanos($viaje, 10, false);
                //$this->Viaje->id = $viaje_id;
                //$this->Viaje->saveField('estado', 'Cancelado_sistema_no_disponible');;
                //return;
                //if (count($cercanos)<=1){ return; }

            }
            //borro el primero

            array_splice($cercanos, 0, 1);


            $viaje['Viaje']['cercanos'] = implode(',', $cercanos);

            if ($viaje['Viaje']['cercanos'] == '') {
                $cercanos = $this->Viaje->Vehiculo->Localizacion->getCercanos($viaje, 10, false);
                $viaje['Viaje']['cercanos'] = implode(',', $cercanos);
            }

            $this->request->data['Viaje']['vehiculo_id'] = reset($cercanos);
            $options['conditions']['Vehiculo.id'] = $this->request->data['Viaje']['vehiculo_id'];

            if ($viaje['Viaje']['cercanos'] != '') {
                $this->request->data['Viaje']['cercanos'] = $viaje['Viaje']['cercanos'];
            }
            //$this->Viaje->Conductor->recursive = -1;
            $conductor = $this->Viaje->Conductor->find('first', $options);
            if (!empty($conductor['Conductor']['id'])) {
                $this->request->data['Viaje']['conductor_id'] = $conductor['Conductor']['id'];
            } elseif(!empty($viaje['Viaje']['conductor_id'])) {
                $this->request->data['Viaje']['conductor_id'] = $viaje['Viaje']['conductor_id'];
            } else {
                $this->request->data['Viaje']['conductor_id'] = null;
            }

            $this->Viaje->begin();

            $historialvlc = $this->Viaje->Vehiculo->Localizacion->getByVehiculoId($this->request->data['Viaje']['vehiculo_id']);
            $this->Viaje->Vehiculo->Localizacion->id = $historialvlc['Localizacion']['id'];
            if ($historialvlc['Localizacion']['estado'] == 'Libre') {
                $this->Viaje->Vehiculo->Localizacion->saveField('estado', 'En_peticion');
            }
            $viaje['Viaje']['vehiculo_id'] = $this->request->data['Viaje']['vehiculo_id'];

            $this->request->data['Viaje']['fecha'] = date("Y-m-d");
            $this->request->data['Viaje']['horareasig'] = date("H:i:s");
            $this->request->data['Viaje']['hora'] = $viaje['Viaje']['hora'];

            $options_v = array(
                'conditions' => array(
                    'id' => $viaje_id
                )
            );
            $viajetmp = $this->Viaje->find('first', $options_v);


            if ($viajetmp['Viaje']['estado'] == 'Pendiente') {
                $this->Viaje->id = $viaje_id;
                //a$this->Viaje->saveField('estado', 'DelegandoAuto');

                $this->request->data['Viaje']['latitud_origen'] = $viajetmp['Viaje']['latitud_origen'];
                $this->request->data['Viaje']['longitud_origen'] = $viajetmp['Viaje']['longitud_origen'];
                $this->request->data['Viaje']['dir_origen'] = $viajetmp['Viaje']['dir_origen'];
                $this->request->data['Viaje']['localidad'] = $viajetmp['Viaje']['localidad'];
                $this->request->data['Viaje']['dir_destino'] = $viajetmp['Viaje']['dir_destino'];
                $this->request->data['Viaje']['latitud_destino'] = $viajetmp['Viaje']['latitud_destino'];
                $this->request->data['Viaje']['longitud_destino'] = $viajetmp['Viaje']['longitud_destino'];
                $this->request->data['Viaje']['estado'] = $viajetmp['Viaje']['estado'];

                $result = $this->Viaje->save($this->request->data);
            } else
                return;

            $this->Viaje->commit();


            $viajetmp = $this->Viaje->find('first', $options_v);
            if ($result) {
                if ($viajetmp['Viaje']['estado'] == 'Pendiente') {
                    $this->GCMClient->sendNotificationVehicle_NuevoViaje($this->request->data);

                    return;
                }
            } else {
                $this->Viaje->rollback();

            }
        }
    }

    private function getFreeConductorsSelect($empresa_id = null, $vehiculo_id = false)
    {
        $conductors_tmp = $this->Viaje->Conductor->findFreeConductors($empresa_id);
        $conductors = array();
        $select_value = null;
        foreach ($conductors_tmp as $conductor) {
            $key = $conductor['Vehiculo']['id'] . ':' . $conductor['Conductor']['id'];
            $conductors[$key] = trim($conductor['Vehiculo']['nro_registro']) . ' - ' . $conductor['Conductor']['apellido'] . ', ' . $conductor['Conductor']['nombre'];
            if ($conductor['Vehiculo']['id'] === $vehiculo_id) {
                $select_value = $key;
            }
        }
        if ($vehiculo_id !== false) {
            return compact('conductors', 'select_value');

        }
        return $conductors;
    }

    public function ajaxGetDespachoPendientes()
    {
        $this->layout = 'ajax';
        $empresa = $this->Session->read('Empresa');
        $this->Viaje->disableFilterDespachoPendientes();
        $options = array(
            'conditions' => array(
                'Viaje.empresa_id' => $empresa['Empresa']['id'],
                'Viaje.estado' => 'Despacho_pendiente',
                'Viaje.fecha >= ' => date('Y-m-d', strtotime('30 minutes ago')),
                'Viaje.hora >= ' => date('H:i:s', strtotime('30 minutes ago')),
            ),
            'contain' => array(
                'Usuario',
                'IvrDomicilio' => array(
                    'IvrCliente'
                )
            )
        );
        $despacho_pendientes = $this->Viaje->find('all', $options);

        //despacho automatico
        /*
        foreach ($despacho_pendientes as $despacho_pendiente) {

            $this->Viaje->id = $despacho_pendiente['Viaje']['id'];
            $this->Viaje->saveField('estado', 'Pendiente');
            $this->GCMClient->sendNotificationVehicle_NuevoViaje($despacho_pendiente);
        }
*/
        $this->set(compact('despacho_pendientes'));
    }

    public function deleteDespachoPendiente($viaje_id)
    {
        $empresa = $this->Session->read('Empresa');
        $this->Viaje->disableFilterDespachoPendientes();
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa['Empresa']['id'],
                'id' => $viaje_id,
                'estado' => 'Despacho_pendiente',
            )
        );
        $viaje = $this->Viaje->find('first', $options);
        if (!empty($viaje)) {
            $viaje['Viaje']['estado'] = 'Cancelado_conductor';
            if ($this->Viaje->save($viaje)) {
                $this->Session->setFlash('Viaje pendiente de despacho eliminado.', 'success');
            } else {
                $this->Session->setFlash('El viaje pendiente de despacho no pudo ser eliminado.', 'error');
            }
        } else {
            $this->Session->setFlash('El viaje pendiente de despacho no pudo ser eliminado.', 'error');
        }
        $this->redirect();
    }

    public function createFromDespachoPendiente($viaje_id)
    {
//        permitir que pueda cambiar la dirección de origen y mostrar teléfono
        $empresa = $this->Session->read('Empresa');

        if (!empty($this->request->data)) {
            if (!$empresa['Operador']['configs']['puede_asignar_moviles_determinados']) {
                $this->request->data['Viaje']['vehiculo_id'] = false;
            }
            $result = $this->Viaje->begin();
            $viaje = $this->Viaje->add($empresa, $this->request->data);
            $result &= $viaje;

            if ($result) {
                $this->Viaje->commit();
                if ($viaje['Viaje']['estado'] == 'Pendiente') {
                    $this->GCMClient->sendNotificationVehicle_NuevoViaje($viaje);
                }
                $this->Session->setFlash($this->Viaje->message, 'success');
            } else {
                $this->Viaje->rollback();
                $this->Session->setFlash($this->Viaje->message, 'error');
            }
            $this->redirect();
        } else {
            $this->Viaje->disableFilterDespachoPendientes();
            $options = array(
                'conditions' => array(
                    'empresa_id' => $empresa['Empresa']['id'],
                    'id' => $viaje_id
                )
            );
            $this->request->data = $this->Viaje->find('first', $options);
            if (empty($this->request->data)) {
                $this->redirect();
            }

            /*
            $conductors = $this->getFreeConductorsSelect($empresa['Empresa']['id']);
            if (empty($conductors)) {
                $this->Session->setFlash(__('No hay vehículos disponibles'), 'error');
                $this->redirect(array('action' => 'adminHistory'));
            }
            */
            $this->request->data['Viaje']['dir_origen'] = $this->request->data['Viaje']['dir_origen'] . ', ' . $this->request->data['Viaje']['localidad'];

            $this->set(compact('conductors', 'empresa'));
        }
    }

    public function canceled()
    {
        $this->Session->setFlash("Su viaje ha sido cancelado", 'error');
        $this->redirect(['controller' => 'viajes', 'action' => 'viewPending']);
    }

    public function viewPending()
    {
        $usuario = $this->Session->read('Usuario');
        $viaje = $this->Viaje->getPending($usuario['Usuario']['id']);
        return $this->_view($viaje);
    }

    public function view($id = null)
    {
        $usuario = $this->Session->read('Usuario');
        $options = array(
            'conditions' => array(
                'Viaje.id' => $id,
                'Viaje.usuario_id' => $usuario['Usuario']['id']
            ),
            'contain' => array(
                'Conductor',
                'Vehiculo',
                'Empresa'
            )
        );
        $viaje = $this->Viaje->find('first', $options);
        return $this->_view($viaje);
    }

    /**
     * @param $viaje
     */
    private function _view($viaje)
    {
        $this->autoRender = false;
        $this->layout = 'usuario';

        if (empty($viaje)) {
//            $this->Session->setFlash(__('Viaje incorrecto'), 'error');
//            $this->redirect(array('controller' => 'usuarios', 'action' => 'reservation'));
        } else {
            $data = $viaje;
            $data['Info'] = [];
            $data['Info']['creation'] = time();
            $data['Info']['error'] = false;
            $data['Info']['distancia'] = PHP_INT_MAX;
            $data['Info']['su_taxi_ha_llegado'] = false;

            $data['Contadores'] = array();
            $data['Contadores']['n_actualizaciones'] = 0;
            $data['Contadores']['wating_for_pendiente'] = 0;
            $this->Session->write('ViewingTravelData', $data);
        }
        $this->request->data = $viaje;
        $renderReservationForm = true;
        $options = [
            'conditions' => [
                'Empresa.id' => IUNIKE_EMPRESA_ID
            ],
            'contain' => [
                'Tipoempresa'
            ]
        ];
        $empresa = $this->Viaje->Empresa->find('first', $options);
        $this->set(compact('viaje', 'renderReservationForm', 'empresa'));
        $this->render('view');
    }

    /**
     * mantine el estado de un viaje
     * @return type
     */
    function actualizar() {
        $usuario = $this->Session->read('Usuario');
        $data = [];
        $viaje = $this->Viaje->getPending($usuario['Usuario']['id']);
        if(!empty($viaje)) {
            $data['Viaje'] = [
                'id' => $viaje['Viaje']['id'],
                'estado' => $viaje['Viaje']['estado'],
                'latitud_origen' => $viaje['Viaje']['latitud_origen'],
                'longitud_origen' => $viaje['Viaje']['longitud_origen']
            ];
            $data['Conductor'] = [
                'apellido' => $viaje['Conductor']['apellido'],
                'nombre' => $viaje['Conductor']['nombre']
            ];
            $data['Vehiculo'] = [
                'nombre' => $viaje['Vehiculo']['marca'],
                'modelo' => $viaje['Vehiculo']['modelo'],
                'patente' => $viaje['Vehiculo']['patente']
            ];
            $data['Conductor'] = $viaje['Conductor'];
            $data['Vehiculo'] = $viaje['Vehiculo'];
            if ($viaje['Viaje']['estado'] != 'Pendiente') {
                $localizacion = $this->Viaje->Vehiculo->Localizacion->find('first', array('conditions' => array('vehiculo_id' => $viaje['Viaje']['vehiculo_id']), 'recursive' => -1));
                $data['Localizacion'] = [
                    'latitud' => $localizacion['Localizacion']['latitud'],
                    'longitud' => $localizacion['Localizacion']['longitud']
                ];
                $data['Info'] = [];
                $distancia = $this->Calculo->distanceBetweenCoordinates($viaje['Viaje']['latitud_origen'], $viaje['Viaje']['longitud_origen'], $data['Localizacion']['latitud'], $data['Localizacion']['longitud']);
                $data['Info']['distancia'] = is_nan($distancia) ? null : $distancia;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    function actualizar_viejo()
    {
        $this->autoRender = false;

        $usuario = $this->Session->read('Usuario');
        $data = $this->Session->read('ViewingTravelData');
        $data['Contadores']['n_actualizaciones']++;
        if (strtotime($data['Viaje']['fecha'] . ' ' . $data['Viaje']['hora']) > time() - 1800) {
            if (!empty($data)) {
                $data['Info']['error'] = false;
                $options = array(
                    'conditions' => array(
                        'Viaje.id' => $data['Viaje']['id'],
                        'Viaje.usuario_id' => $usuario['Usuario']['id']
                    ),
                    'contain' => array(
                        'Conductor',
                        'Vehiculo',
                        'Empresa'
                    )
                );
                $viaje = $this->Viaje->find('first', $options);
                if ($viaje['Viaje']['estado'] != 'Pendiente') {
                    $localizacion = $this->Viaje->Vehiculo->Localizacion->find('first', array('conditions' => array('vehiculo_id' => $viaje['Viaje']['vehiculo_id']), 'recursive' => -1));
                    $data['Localizacion'] = $localizacion['Localizacion'];
                    $data['Info']['distancia'] = $this->Calculo->distanceBetweenCoordinates($viaje['Viaje']['latitud_origen'], $viaje['Viaje']['longitud_origen'], $data['Localizacion']['latitud'], $data['Localizacion']['longitud']);
                } else {
                    $data['Contadores']['wating_for_pendiente']++;
                }
                //cambio de cercano
                if ($data['Contadores']['wating_for_pendiente'] > 3) {
                    $data['Contadores']['wating_for_pendiente'] = 0;
                    $cercanos = explode(',', $viaje['Viaje']['cercanos']);
                    $current_key = array_search($viaje['Viaje']['vehiculo_id'], $cercanos);
                    if ($current_key == count($cercanos) - 1) {// si es último del array
                        $cercanos = $this->Viaje->Vehiculo->Localizacion->getCercanos($viaje, 10, false);
                        $viaje['Viaje']['cercanos'] = implode(',', $cercanos);
                        $current_key = -1;
                    }
                    if (count($cercanos) == 0) {
                        $this->Session->setFlash(__('No hay vehículos disponibles en este momento'), 'error');
                        $data['Info']['error'] = true;
                    } else {
                        $viaje['Viaje']['vehiculo_id'] = $cercanos[$current_key + 1];
                    }
                    $viaje = $this->Viaje->desnormalizeRow($viaje);
                    $this->Viaje->save($viaje);
                }

                $new_viaje = $this->Viaje->find('first', $options);
                $data['Info']['su_taxi_ha_llegado'] = $new_viaje['Viaje']['estado'] == 'Llegado' || $data['Info']['distancia'] < 50;
                $data = array_replace_recursive($data, $new_viaje);
                $this->Session->write('ViewingTravelData', $data);
            } else {
                $this->Session->setFlash(__('Viaje erroneo.'), 'error');
                $data = array(
                    'Info' => array(
                        'error' => true
                    )
                );
            }
        } else {
            $this->Viaje->id = $data['Viaje']['id'];
            $this->Viaje->saveField('estado', 'Cancelado_sistema_no_disponible');
            $this->Session->setFlash(__('No hay móviles disponibles en este momento. Por favor intente nuevamente. Gracias.'), 'error');
            $data = array(
                'Info' => array(
                    'error' => true
                )
            );
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    function _actualizar()
    {
        $usuario = $this->Session->read('Usuario');
        $this->autoRender = false;
        $viaje = $this->Viaje->find('first', array('conditions' => array('usuario_id' => $usuario['Usuario']['id']), 'order' => 'id DESC', 'recursive' => -1));
        $taxi = $this->Localizacion->find('first', array('conditions' => array('vehiculo_id' => $viaje['Viaje']['vehiculo_id']), 'recursive' => -1));
        //$taxi = $this->Viaje->Vehiculo->Localizacion->findByVehiculoId($viaje['Viaje']['vehiculo_id']);
        $array['latitud'] = $taxi['Localizacion']['latitud'];
        $array['longitud'] = $taxi['Localizacion']['longitud'];
        $distancia = $this->Calculo->distance(array($viaje['Viaje']['latitud_origen'], $viaje['Viaje']['longitud_origen']), $array);
        return $taxi['Localizacion']['latitud'] . ',' . $taxi['Localizacion']['longitud'] . ',' . $viaje['Viaje']['latitud_origen'] . ',' . $viaje['Viaje']['longitud_origen'] . ',' . $distancia . ',' . $viaje['Viaje']['estado'];
    }

    function cancelarReserva($id)
    {
        $viaje = $this->Viaje->findByIdAndEstado($id, 'reserva');
        if (empty($viaje)) {
            $this->Session->setFlash('Viaje inválido', 'error');
        } else {
            $this->Viaje->id = $viaje['Viaje']['id'];
            $this->Viaje->begin();
            $result = $this->Viaje->saveField('estado', 'cancelado_usuario');
            if ($result) {
                $this->Viaje->commit();
                $this->Session->setFlash('Su viaje a sido cancelado', 'success');
            } else {
                $this->Viaje->rollback();
                $this->Session->setFlash('Su viaje no se ha podido cancelar. Por favor, intente nuevamente.', 'error');
            }
        }
        $this->redirect(array(
            'controller' => 'usuarios',
            'action' => 'myReservs'
        ));
    }

    public function adminCancelarViaje($id = null)
    {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'id' => $id,
                'empresa_id' => $empresa['Empresa']['id']
            )
        );
        $this->Viaje->recursive = -1;
        $viaje = $this->Viaje->find('first', $options);
        if ($viaje) {
            $result = $this->Viaje->begin();
            $result &= $this->Viaje->cancelar($viaje);

            if ($result) {
                $this->Viaje->commit();
                $this->GCMClient->sendNotificationVehicle_ViajeCanceladoPasajero($viaje);
                if(!empty($viaje['Viaje']['usuario_id'])) {
                    SocketClient::sendNodeEventViaje($viaje['Viaje']['id'], NODE_EVENT_viaje_status_changed);
                }
                $this->Session->setFlash(__('Viaje cancelado'), 'success');
            } else {
                $this->Viaje->rollback();
                $this->Session->setFlash(__('El viaje no pudo ser cancelado'), 'error');
            }
        } else {
            $this->Session->setFlash(__('Viaje incorrecto'), 'error');
        }
        $this->redirect();
    }

    public function adminResDif($id = null)
    {
        $empresa = $this->Session->read('Empresa');
        $options = array(
            'conditions' => array(
                'id' => $id,
                'empresa_id' => $empresa['Empresa']['id']
            )
        );
        $this->Viaje->recursive = -1;
        $viaje = $this->Viaje->find('first', $options);
        if ($viaje) {
            $viaje['Viaje']['estado'] = 'Pendiente';
            $result = $this->Viaje->begin();
            $result &= $this->Viaje->save($viaje);

            if ($result) {
                $this->Viaje->commit();
                $this->GCMClient->sendNotificationVehicle_NuevoViaje($viaje);
                $this->Session->setFlash(__('Reserva diferida enviada'), 'success');
            } else {
                $this->Viaje->rollback();
                $this->Session->setFlash(__('El viaje no pudo ser enviado'), 'error');
            }
        } else {
            $this->Session->setFlash(__('Viaje incorrecto'), 'error');
        }
        $this->redirect(array('action' => 'adminHistory'));
    }

    function cancelarViaje()
    {
        $this->autoRender = false;
        $usuario = $this->Session->read('Usuario');
        $viaje = $this->Viaje->getPending($usuario['Usuario']['id']);
        if (!empty($viaje)) {
            $result = $this->Viaje->begin();
            $result &= $this->Viaje->cancelar($viaje);

            if ($result) {
                $this->Viaje->commit();
                $this->Viaje->addVirtualDate();
                $options = [
                    'conditions' => [
                        'usuario_id' => $usuario['Usuario']['id'],
                        'estado' => 'Cancelado_usuario',
                        'date >=' => date('Y-m-d H:i:s', strtotime('1 week ago')),
                    ]
                ];
                /*
                $count = $this->Viaje->find('count', $options);
                if ($count >= 5) {
                    $this->Viaje->Usuario->deshabilitar($usuario['Usuario']['id']);
                    $this->Session->setFlash('Su usuario fué deshabilitado', 'error');
                    return $this->redirect(['controller'=>'usuarios', 'action'=>'logout']);
                }
                $this->Session->setFlash('Su reserva ha sido cancelada.', 'success');
                */
                $this->GCMClient->sendNotificationVehicle_ViajeCanceladoPasajero($viaje);
                $this->canceled();

                return $this->redirect(['controller' => 'usuarios', 'action' => 'history']);
            } else {
                $this->Viaje->rollback();
                $this->Session->setFlash('No se ha podido cancelar su reserva.', 'error');
            }
        } else {
            $this->Session->setFlash('No existe el viaje.', 'error');
        }
        return $this->redirect();
    }

    function ajax_checkForPending()
    {
        $usuario = $this->Session->read('Usuario');
        $admin = $this->Session->read('Admin');
        $result = array(
            'redirect_url' => false,
        );
        if (!$admin) {
            if ($usuario) {
                $viaje = $this->Viaje->getPending($usuario['Usuario']['id']);
                if (!empty($viaje)) {
                    $this->Session->setFlash(__('Para reservar otro viaje primero debes cancelar el pendiente'), 'error');
                    $result['redirect_url'] = Router::url(array('action' => 'view', $viaje['Viaje']['id']));
                }
            } else {
                $result['redirect_url'] = '/';
            }
        }
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function adminHistory()
    {
        $empresa = $this->Session->read('Empresa');
        $this->Viaje->virtualFields['created'] = 'CONCAT_WS(" ", fecha, hora)';
        $this->Viaje->virtualFields['reasignated'] = 'CONCAT_WS(" ", fecha, horareasig)';
        $creadors = array(
            'Usuario' => __('Usuario'),
            'Admin' => __('Admin')
        );

        $this->configureFilterHistory();

        $this->Paginator->settings['Viaje']['joins'] = array(
            array(
                'alias' => 'Usuario',
                'table' => 'usuarios',
                'type' => 'LEFT',
                'conditions' => array(
                    'Usuario.id = Viaje.usuario_id'
                )
            ),
            array(
                'alias' => 'Conductor',
                'table' => 'conductors',
                'type' => 'LEFT',
                'conditions' => array(
                    'Conductor.id = Viaje.conductor_id'
                )
            ),
            array(
                'alias' => 'Vehiculo',
                'table' => 'vehiculos',
                'type' => 'LEFT',
                'conditions' => array(
                    'Viaje.vehiculo_id = Vehiculo.id'
                )
            ),
            array(
                'alias' => 'Localizacion',
                'table' => 'localizacions',
                'type' => 'LEFT',
                'conditions' => array(
                    'Localizacion.vehiculo_id = Vehiculo.id'
                )
            )
        );

        $this->Filter->controller = $this;
        $this->Filter->makeConditions();

        $this->Paginator->settings['Viaje']['conditions']['Viaje.empresa_id'] = $empresa['Empresa']['id'];
        $this->Paginator->settings['Viaje']['conditions']['Viaje.estado'] = array(
            'Pendiente',
            'Delegando',
            'DelegandoAdmin',
            'DelegandoAuto',
            'Aceptado',
            'Cancelado_sistema_no_disponible',
            'Llegado',
            'Pasajero_ausente',
            'He_llegado',
            'Ya_voy',
            'En_viaje',
            'Error_conexion_internet'
//            'Finalizado',
        );
        $this->Paginator->settings['Viaje']['conditions']['Viaje.creador'] = 'Admin';
//        $this->Paginator->settings['Viaje']['conditions']['Viaje.fecha'] = date('Y-m-d');
        $this->Paginator->settings['Viaje']['order']['Viaje.id'] = 'desc';
        $this->Paginator->settings['Viaje']['recursive'] = -1;
        $this->Paginator->settings['Viaje']['fields'] = '*';
        $this->Paginator->settings['Viaje']['maxLimit'] = $this->Paginator->settings['Viaje']['limit'] = 100;
        $this->Paginator->settings['Viaje']['contain'] = ['ViajesHistorial'];
//        $this->Viaje->contain('ViajesHistorial');

        $viajes = $this->Paginator->paginate('Viaje');

        foreach ($viajes as &$viaje) {
            $viaje['Viaje']['atrasado'] = $this->Viaje->isAtrasado($viaje);
            $reas = $this->Viaje->isReasignar($viaje);
            $viaje['Viaje']['reasignar'] = '';
            if ($reas and !$viaje['Viaje']['atrasado']) {
                $viaje['Viaje']['reasignated'] = time();
                $this->reasignar2($viaje['Viaje']['id']);
                $viaje['Viaje']['reasignar'] = $reas;
            }
//            if ($viaje['Viaje']['estado']=='Pendiente' or $viaje['Viaje']['estado']=='Aceptado' or $viaje['Viaje']['estado']=='En_viaje'){
//                if ($viaje['Viaje']['observaciones']!="")
//                     $viaje['Viaje']['observaciones'] .= '</br>';
//
//                $viaje['Viaje']['observaciones'] .= 'Historial:';
//            }

        }
        //$viajes = $this->Paginator->paginate('Viaje');

        $is_ajax = $this->request->isAjax;

        $conductors = $this->getFreeConductorsSelect($empresa['Empresa']['id']);

        $ivr_llamada_entrantes = $this->__getIVRLlamadasEntrantes($empresa);

        $tipos_de_auto = [
            'Regular' => 'Gama Media',
            'Max' => 'Gama Alta'
        ];
        $this->set(compact('empresa', 'creadors', 'viajes', 'conductors', 'is_ajax', 'ivr_llamada_entrantes', 'tipos_de_auto'));
    }

    public function getIVRLlamadasEntrantes()
    {
        $empresa = $this->Session->read('Empresa');
        $ivr_llamada_entrantes = $this->__getIVRLlamadasEntrantes($empresa);
        $this->set(compact('empresa', 'ivr_llamada_entrantes'));
    }

    private function __getIVRLlamadasEntrantes($empresa)
    {
        $options = array(
            'conditions' => array(
                'IvrLlamadaEntrante.empresa_id' => $empresa['Empresa']['id'],
            ),
            'order' => array(
                'IvrLlamadaEntrante.id' => 'DESC'
            ),
            'fields' => array(
                'IvrLlamadaEntrante.*'
            ),
            'group' => array(
                'IvrLlamadaEntrante.telefono'
            )
        );
        if ($empresa['Operador']['tipo'] !== 'admin') {
            $options['conditions']['OR'] = array(
                array('IvrLlamadaEntrante.key_telefono' => array_keys($empresa['Operador']['key_telefono'])),
                array('IvrLlamadaEntrante.key_telefono' => null)
            );
        }
        $ivr_llamada_entrantes = $this->Viaje->Empresa->IvrLlamadaEntrante->find('all', $options);
        foreach ($ivr_llamada_entrantes as &$ivr_llamada_entrante) {
            if (!empty($ivr_llamada_entrante['IvrLlamadaEntrante']['ivr_cliente_id'])) {
                $ivr_llamada_entrante_viaje_options = array(
                    'conditions' => array(
                        'empresa_id' => $empresa['Empresa']['id'],
                        'IvrDomicilo.ivr_cliente_id' => $ivr_llamada_entrante['IvrLlamadaEntrante']['ivr_cliente_id']
                    ),
                    'joins' => array(
                        array(
                            'alias' => 'IvrDomicilo',
                            'table' => 'ivr_domicilios',
                            'type' => 'LEFT',
                            'conditions' => array(
                                'IvrDomicilo.id = Viaje.ivr_domicilio_id'
                            )
                        )
                    ),
                    'order' => array(
                        'Viaje.id' => 'DESC'
                    ),
                    'fields' => array(
                        'Viaje.*',
                    )
                );
                $ivr_llamada_entrante_viaje = $this->Viaje->find('first', $ivr_llamada_entrante_viaje_options);
                if (!empty($ivr_llamada_entrante_viaje)) {
                    $ivr_llamada_entrante = array_merge($ivr_llamada_entrante, $ivr_llamada_entrante_viaje);
                }
            }
        }
        return $ivr_llamada_entrantes;
    }

    public function historyLast()
    {
        $this->history(1);
        $this->render('history');
    }
    

    public function historyDia($vehiculo,$fecha)
    {
        $this->history(2,$fecha,$vehiculo);
        $this->render('history');
    }


    public function history($last = false,$fecha = null,$vid = null)
    {
        $empresa = $this->Session->read('Empresa');
        $creadors = array(
            'Usuario' => __('Usuario'),
            'Admin' => __('Admin')
        );

        $this->configureFilterHistory();
        $this->Viaje->virtualFields['date'] = 'CONCAT_WS(" ", Viaje.fecha, Viaje.hora)';

        $this->Paginator->settings['Viaje']['joins'] = array(
            array(
                'alias' => 'Usuario',
                'table' => 'usuarios',
                'type' => 'LEFT',
                'conditions' => array(
                    'Usuario.id = Viaje.usuario_id'
                )
            ),
            array(
                'alias' => 'Conductor',
                'table' => 'conductors',
                'type' => 'LEFT',
                'conditions' => array(
                    'Conductor.id = Viaje.conductor_id'
                )
            )
        );

        $this->Filter->controller = $this;
        $this->Filter->makeConditions();

        $this->Paginator->settings['Viaje']['conditions']['Viaje.empresa_id'] = $empresa['Empresa']['id'];
        $this->Paginator->settings['Viaje']['conditions']['Viaje.estado <>'] = 'Cancelado_usuario';
        if ($last==1) {
            $this->Paginator->settings['Viaje']['conditions']['Viaje.date >= '] = date('Y-m-d H:i:s', strtotime('1 day ago'));
        }
         if ($last==2) {
            $this->Paginator->settings['Viaje']['conditions']['Viaje.fecha = '] = $fecha;
            $this->Paginator->settings['Viaje']['conditions']['Viaje.vehiculo_id = '] = $vid;
        }
        $this->Paginator->settings['Viaje']['order']['Viaje.date'] = 'desc';
        $this->Paginator->settings['Viaje']['recursive'] = -1;
        $this->Paginator->settings['Viaje']['fields'] = '*';
        $this->Paginator->settings['Viaje']['contain'] = ['ViajesHistorial'];

        $viajes = $this->Paginator->paginate('Viaje');
//        pr($viajes);
        $this->set(compact('empresa', 'creadors', 'viajes', 'last'));
    }

    function customerHistory($user_id = null)
    {
        $empresa = $this->Session->read('Empresa');
        if (empty($user_id)) {
            $this->redirect();
        }
        $this->Viaje->recursive = -1;

        $this->configureFilterCustomerHistory();

        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
        $this->Paginator->settings['Viaje']['conditions']['Viaje.empresa_id'] = $empresa['Empresa']['id'];
        $this->Paginator->settings['Viaje']['conditions']['Viaje.usuario_id'] = $user_id;
        $this->Paginator->settings['Viaje']['order'] = array(
            'Viaje.id' => 'desc'
        );

        $viajes = $this->Paginator->paginate('Viaje');

        $this->set(compact('viajes', 'empresa'));
    }

}
