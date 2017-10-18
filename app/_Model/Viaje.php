<?php
App::import('Lib', 'Calculo');

class Viaje extends AppModel
{

    var $name = 'Viaje';
    var $belongsTo = array(
        'Conductor' => array('className' => 'Conductor', 'foreignKey' => 'conductor_id'),
        'Empresa' => array('className' => 'Empresa', 'foreignKey' => 'empresa_id'),
        'Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id'),
        'Vehiculo' => array('className' => 'Vehiculo', 'foreignKey' => 'vehiculo_id'),
        'IvrDomicilio' => array('className' => 'IvrDomicilio', 'foreignKey' => 'ivr_domicilio_id'),
        'ViajeProgramado' => array('className' => 'ViajeProgramado', 'foreignKey' => 'viaje_programado_id'),
    );
    var $hasMany = array(
        'ViajesHistorial' => array(
            'className' => 'ViajesHistorial',
            'foreignKey' => 'viaje_id',
            'dependent' => true
        )
    );
    var $hasOne = array('Calificacion' => array('className' => 'Calificacion', 'foreignKey' => 'viaje_id', 'dependent' => true));
    public $recursive = -1;
    public $message = '';

    protected $filterDespachoPendientes = true;

    /**
     * 'Despacho_pendiente' estado en el que un viaje no existe para la app_web, esto es porque en
     * bs as los usuarios desde la app_mobile no pueden pedir viajes directamente
     * entonces se crean en este estado
     * @param array $qry
     * @return array
     */
    public function beforeFind($qry)
    {
        if (!empty($filterDespachoPendientes)) {
            $qry['conditions'] = array(
                'AND' => array(
                    $qry['conditions'],
                    array('Viaje.estado !=' => 'Despacho_pendiente')
                )
            );
        }
        return $qry;
    }

    public function disableFilterDespachoPendientes()
    {
        $this->filterDespachoPendientes = false;
    }

    public function calificacionConductor($id)
    {
        return $this->Calificacion->calificacionConductor($id);
    }

    public function calificacionVehiculo($id)
    {
        return $this->Calificacion->calificacionVehiculo($id);
    }

    public function viajesEmpresa($id)
    {
        //$viajes = $this->findAllByEmpresaIdAndEstado($id, 'Reserva');
        $viajes = $this->findAllByEmpresaIdAndEstado($id, 'Despacho_diferido');

        if (empty($viajes)) {
            $viajes = null;
        } else {
            for ($i = 0; $i < count($viajes); $i++) {
                $viajes[$i]['Viaje']['usuario'] = $this->Usuario->nombreUsuario($viajes[$i]['Viaje']['usuario_id']);
                unset($viajes[$i]['Viaje']['usuario_id']);
            }
        }
        return $viajes;
    }

    public function usuarios($id)
    {
        $viajes = $this->find('all', array('conditions' => array('Viaje.empresa_id' => $id), 'fields' => array('DISTINCT Viaje.usuario_id')));
        for ($i = 0; $i < count($viajes); $i++) {
            $viajes[$i]['Viaje']['usuario'] = $this->Usuario->nombreUsuario($viajes[$i]['Viaje']['usuario_id']);
            $viajes[$i]['Viaje']['viajes'] = $this->find('count', array('conditions' => array('AND' => array('Viaje.usuario_id' => $viajes[$i]['Viaje']['usuario_id'], 'Viaje.empresa_id' => $id, 'Viaje.estado' => 'Finalizado'))));
        }
        return $viajes;
    }

    public function viajesUsuarios($idemp, $idusu)
    {
        $viajes = $this->find('all', array('conditions' => array('AND' => array('Viaje.empresa_id' => $idemp, 'Viaje.usuario_id' => $idusu))));
        $usuario = $this->Usuario->nombreUsuario($idusu);
        return array($usuario, $viajes);
    }

    public function parseCeranos(&$viaje)
    {
        $cercanos_old = array();
        if (isset($viaje['Viaje']['cercanos'])) {
            $cercanos_old = $viaje['Viaje']['cercanos'];
        } elseif (isset($viaje['cercanos'])) {
            $cercanos_old = $viaje['cercanos'];
        } else {
            $cercanos_old = '';
        }
        $cercanos = explode(',', $cercanos_old);

        return $cercanos;
    }

    public function add($empresa, $data)
    {
        $this->message = '';
        if (!empty($empresa['Empresa']['id'])) {
            $empresa = $empresa['Empresa']['id'];
        }
        $data['Viaje']['empresa_id'] = $empresa;

        if (empty($data['Viaje']['distancia'])) {
            $data['Viaje']['distancia'] = 0;
        }
        if ($this->checkIfViajeHasChangedOrigin($data)) {
            $data['Viaje']['latitud_origen'] = null;
            $data['Viaje']['longitud_origen'] = null;
        }

        if (empty($data['Viaje']['dir_origen'])) {
            $this->message = __('Error al ingresar direccion de origen. Intente nuevamente');
            return false;
        }

        //calculo las coordenadas de la dirección de origen
        if (empty($data['Viaje']['latitud_origen']) || empty($data['Viaje']['longitud_origen'])) {
            $cord_o = Calculo::getCordenates($data['Viaje']['dir_origen']);
            if (empty($data['Viaje']['longitud_origen'])) {
                $data['Viaje']['latitud_origen'] = $cord_o['lat'];
            }
            if (empty($data['Viaje']['longitud_origen'])) {
                $data['Viaje']['longitud_origen'] = $cord_o['long'];
            }

        }
        if (empty($data['Viaje']['latitud_origen']) || empty($data['Viaje']['longitud_origen'])) {
            $this->message = "Dirección de origen incorrecta";
            return false;
        }

        if (empty($data['Viaje']['localidad'])) {
            $data_origen = explode(',', $data['Viaje']['dir_origen']);
            $data['Viaje']['dir_origen'] = isset($data_origen[0]) ? trim($data_origen[0]) : '';
            $data['Viaje']['localidad'] = isset($data_origen[1]) ? trim($data_origen[1]) : '';
        }

        if (empty($data['Viaje']['dir_destino'])) {
            $data['Viaje']['dir_destino'] = '';
            $data['Viaje']['latitud_destino'] = 0;
            $data['Viaje']['longitud_destino'] = 0;
        } else {
            if (empty($data['Viaje']['latitud_destino']) || empty($data['Viaje']['longitud_destino'])) {
                $cord_d = Calculo::getCordenates($data['Viaje']['dir_destino']);
                if (empty($data['Viaje']['latitud_destino'])) {
                    $data['Viaje']['latitud_destino'] = $cord_d['lat'];
                }
                if (empty($data['Viaje']['longitud_destino'])) {
                    $data['Viaje']['longitud_destino'] = $cord_d['long'];
                }
            }
            $data_destino = explode(',', $data['Viaje']['dir_destino']);
            $data['Viaje']['dir_destino'] = isset($data_destino[0]) ? trim($data_destino[0]) : '';
        }
        if (empty($data['Viaje']['fecha'])) {
            $data['Viaje']['fecha'] = date("Y-m-d");
        }
        if (empty($data['Viaje']['hora'])) {
            $data['Viaje']['hora'] = date("H:i:s");
        }
        if (empty($data['Viaje']['horareasig'])) {
            $data['Viaje']['horareasig'] = $data['Viaje']['hora'];
        }
        $data['Viaje']['estado'] = isset($data['Viaje']['estado']) ? $data['Viaje']['estado'] : 'Pendiente';
        $data['Viaje']['usuario_id'] = isset($data['Viaje']['usuario_id']) ? $data['Viaje']['usuario_id'] : null;
        $data['Viaje']['ivr_domicilio_id'] = isset($data['Viaje']['ivr_domicilio_id']) ? $data['Viaje']['ivr_domicilio_id'] : null;
        $data['Viaje']['creador'] = isset($data['Viaje']['creador']) ? $data['Viaje']['creador'] : 'Admin';

        if (empty($data['Viaje']['vehiculo_id'])) {
            $cercanos = $this->Vehiculo->Localizacion->getCercanos($data, 10, false);
            if (empty($cercanos)) {
                $this->message = __('No hay coches disponibles');
                return false;
            }
            $data['Viaje']['cercanos'] = implode(',', $cercanos);
            $data['Viaje']['vehiculo_id'] = reset($cercanos);
            if ($data['Viaje']['vehiculo_id'] != SIN_VEHICULO_EN_ZONA) {
                $data = $this->desnormalizeRow($data);
            }
        } else {
            list($data['Viaje']['vehiculo_id'], $data['Viaje']['conductor_id']) = explode(':', $data['Viaje']['vehiculo_id']);
            $cercanos = $this->Vehiculo->Localizacion->getCercanos($data, 10, false);

            if ($cercanos[0] == $data['Viaje']['vehiculo_id']) {
                $data['Viaje']['cercanos'] = implode(',', $cercanos);
            } else {
                $data['Viaje']['cercanos'] = $data['Viaje']['vehiculo_id'] . ',' . implode(',', $cercanos);
            }
        }

        $this->create();
        $viaje = $this->save($data);
        if (!empty($viaje)) {
            $historialvlc = $this->Vehiculo->Localizacion->getByVehiculoId($viaje['Viaje']['vehiculo_id']);
            $this->Vehiculo->Localizacion->id = $historialvlc['Localizacion']['id'];
//            ver esto creo está mal
            $this->Vehiculo->Localizacion->saveField('estado', 'En_peticion');
            $this->message = __('Viaje creado');
        } else {
            $this->message = __('Se ha producido un error. Intente nuevamente.');
        }

        return $viaje;
    }

    public function checkIfViajeHasChangedOrigin($data)
    {
        $result = false;
        if (!empty($data['Viaje']['id'])) {
            $dbViaje = $this->findById($data['Viaje']['id']);
            $result = $dbViaje['Viaje']['dir_origen'] != $data['Viaje']['dir_origen'];
        }
        return $result;
    }

    /**
     * crea un viaje igual que add pero la separa para debugear mas rapido
     * la idea es unirlas en el futuro.
     * @param type $data
     * @return boolean
     */
    public function userAdd($data)
    {
        $this->message = '';

        if (empty($data['Viaje']['distancia'])) {
            $data['Viaje']['distancia'] = 0;// podria calcularse
        }
        //calculo las coordenadas de la direccion de origen
        $cord_o = Calculo::getCordenates($data['Viaje']['dir_origen']);
        $data['Viaje']['latitud_origen'] = $cord_o['lat'];
        $data['Viaje']['longitud_origen'] = $cord_o['long'];

        $data_origen = explode(',', $data['Viaje']['dir_origen']);

        $data['Viaje']['dir_origen'] = isset($data_origen[0]) ? trim($data_origen[0]) : '';
        $data['Viaje']['localidad'] = isset($data_origen[1]) ? trim($data_origen[1]) : '';

        if (empty($data['Viaje']['dir_destino'])) {
            $data['Viaje']['dir_destino'] = '';
            $data['Viaje']['latitud_destino'] = 0;
            $data['Viaje']['longitud_destino'] = 0;
        } else {
            $cord_d = Calculo::getCordenates($data['Viaje']['dir_destino']);
            $data['Viaje']['latitud_destino'] = $cord_d['lat'];
            $data['Viaje']['longitud_destino'] = $cord_d['long'];
            $data_destino = explode(',', $data['Viaje']['dir_destino']);
            $data['Viaje']['dir_destino'] = empty($data_destino[0]) ? '' : $data_destino[0];
        }
        $data['Viaje']['fecha'] = date("Y-m-d");
        $data['Viaje']['hora'] = date("H:i:s");
        $data['Viaje']['estado'] = isset($data['Viaje']['estado']) ? $data['Viaje']['estado'] : 'Pendiente';
        $data['Viaje']['usuario_id'] = isset($data['Viaje']['usuario_id']) ? $data['Viaje']['usuario_id'] : null;
        $data['Viaje']['ivr_domicilio_id'] = isset($data['Viaje']['ivr_domicilio_id']) ? $data['Viaje']['ivr_domicilio_id'] : null;
        $data['Viaje']['creador'] = isset($data['Viaje']['creador']) ? $data['Viaje']['creador'] : 'Usuario';

        $cercanos = $this->Vehiculo->Localizacion->getCercanos($data, 10, false);
        if (empty($cercanos)) {
            $this->message = __('No hay vehiculos disponibles. Por favor espere unos minutos e intente nuevamente.');
            return false;
        }
        $data['Viaje']['cercanos'] = implode(',', $cercanos);
        $data['Viaje']['vehiculo_id'] = reset($cercanos);
        $data = $this->desnormalizeRow($data);

        $this->create();
        $viaje = $this->save($data);
        if (!empty($viaje)) {
            $historialvlc = $this->Vehiculo->Localizacion->getByVehiculoId($viaje['Viaje']['vehiculo_id']);
            $this->Vehiculo->Localizacion->id = $historialvlc['Localizacion']['id'];
            $this->Vehiculo->Localizacion->saveField('estado', 'En_peticion');
            $this->message = __('Su móvil está en camino.');
        } else {
            $this->message = __('Se ha producido un error. Intente nuevamente.');
        }

        return $viaje;
    }

    /**
     * pone la empresa, conductor y demas de acuerdo al vehiculo_id
     * se usa cuando hay que rotar el vehiculo con los cercanos y para creación
     * @param array $data
     * @return mixed
     */
    public function desnormalizeRow($data)
    {
        if (!empty($data['Viaje']['vehiculo_id'])) {
            $conductor = $this->Conductor->getByVehiculoId($data['Viaje']['vehiculo_id']);
            $data['Viaje']['conductor_id'] = !empty($conductor['Conductor']['id']) ? $conductor['Conductor']['id'] : null;
            //$data['Viaje']['empresa_id'] = $conductor['Conductor']['empresa_id'];
        }
        return $data;
    }

    public function isAtrasado($viaje)
    {
        return in_array($viaje['Viaje']['estado'], array('Pendiente', 'Aceptado')) && strtotime($viaje['Viaje']['created']) < (time() - 600);
    }

    public function isAceptadoTarde($viaje)
    {
        return in_array($viaje['Viaje']['estado'], array('Aceptado')) && strtotime($viaje['Viaje']['created']) < (time() - 900);
    }

    public function isReasignar($viaje)
    {
        $viaje['Viaje']['reasignated'] = $viaje['Viaje']['fecha'] . " " . $viaje['Viaje']['horareasig'];

        return in_array($viaje['Viaje']['estado'], array('Pendiente')) && strtotime($viaje['Viaje']['reasignated']) < (time() - 35);
    }

    public function addVirtualDate() {
        $this->virtualFields['date'] = "STR_TO_DATE(CONCAT_WS(' ', Viaje.fecha, Viaje.hora), '%Y-%m-%d %H:%i:%s')";
    }

    public function cancelar($viaje)
    {
        if(is_int($viaje)) {
            $viaje = $this->findById($viaje);
        }

        $viaje['Viaje']['estado'] = 'Cancelado_usuario';
        $result = $this->save($viaje);

        $historialvlc = $this->Vehiculo->Localizacion->getByVehiculoId($viaje['Viaje']['vehiculo_id']);
        if(!empty($historialvlc['Localizacion']['id'])) {
            $this->Vehiculo->Localizacion->id = $historialvlc['Localizacion']['id'];
            $result &= $this->Vehiculo->Localizacion->saveField('estado', 'Libre');
        }
        return $result;
    }

    public function getPending($usuario_id)
    {
        $this->recursive = -1;
        $this->addVirtualDate();
        $options = [
            'conditions' => [
                'Viaje.estado' => [
                    'DelegadoApp',
                    'Pendiente',
                    'Aceptado',
                    'Ya_voy',
                    'Llegado',
                    'En_viaje'
                ],
                'date >=' => date('Y-m-d H:i:s', strtotime('1 hour ago')),
                'Viaje.usuario_id' => $usuario_id
            ],
            'contain' => [
                'Conductor',
                'Vehiculo',
            ],
            'order' => [
                'date' => 'DESC'
            ]
        ];
        $viaje = $this->find('first', $options);

        return $viaje;
    }
}
