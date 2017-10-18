<?php

class Conductor extends AppModel {

    var $name = 'Conductor';
    var $belongsTo = array(
        'Empresa' => array(
            'className' => 'Empresa',
            'foreignKey' => 'empresa_id'
        )
    );
    var $hasMany = array(
        'Historialvc' => array(
            'className' => 'Historialvc',
            'foreignKey' => 'conductor_id',
            'dependent' => true
        ),
        'Viaje' => array(
            'className' => 'Viaje',
            'foreignKey' => 'conductor_id',
            'dependent' => true
        )
    );
    public $validate = array(
        'apellido' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el apellido del conductor.'
            ),
            'expresion' => array(
                'rule' => array(
                    'custom',
                    '<[0-9a-zA-ZñÑ\s]{2,50}>'
                ),
                'message' => 'Sus apellidos deben contener solo letras.'
            )
        ),
        'nombre' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el nombre del conductor.'
            ),
            'expresion' => array(
                'rule' => array(
                    'custom',
                    '<[0-9a-zA-ZñÑ\s]{2,50}>'
                ),
                'message' => 'Sus nombres deben contener solo letras.'
            )
        ),
        'dni' => array(
            'expresion' => array(
                'rule' => array(
                    'custom',
                    '<\d{6,8}>'
                ),
                'allowEmpty' => true,
                'message' => 'Debe ingresar un dni válido.'
            ),
            'es_unico' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'message' => 'El DNI introducido está siendo usado por otro conductor.'
            ),
        ),
        'telefono' => array(
            'expresion' => array(
                'rule' => array(
                    'custom',
                    '<\d{10}>'
                ),
                'allowEmpty' => true,
                'message' => 'Su número debe seguir la siguiente estructura caracteristica+numero.'
            )
        ),
        /*
        'cuil' => array(
            'expresion' => array(
                'rule' => array(
                    'validarCuil'
                ),
                'allowEmpty' => true,
                'message' => 'Su cuil debe seguir la siguiente estructura XX-DNI-X.'
            )
        ),*/
        'email' => array(
            'tipo' => array(
                'rule' => 'email',
                'allowEmpty' => true,
                'message' => 'Debe ingresar un email válido.'
            ),
            'es_unico' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'message' => 'El email introducido está siendo utilizado por otro conductor.'
            )
        ),
        'fecha_nac' => array(
            'rule' => 'date',
            'message' => 'Debe ingresar una fecha válida.',
            'allowEmpty' => true
        ),
        'usuario' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el usuario del conductor.'
            ),
            'tipo' => array(
                'rule' => 'alphaNumeric',
                'message' => 'El usuario puede contener únicamente números o letras.'
            ),
            'es_unico' => array(
                'rule' => 'isUnique',
                'message' => 'El nombre de usuario introducido está siendo utilizado por otro conductor.'
            )
        ),
        'pass' => array(
            'validatePasswords' => array(
                'rule' => array('validatePasswords'),
                'message' => 'Las dos passwords deben coincidir',
            ),
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el pass del conductor.'
            ),
            'tipo' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Su contraseña puede contener únicamente números o letras.'
            ),
            'minimo' => array(
                'rule' => array(
                    'minLength',
                    '6'
                ),
                'message' => 'Su contraseña debe contener al menos 6 caracteres.'
            )
        ),
        'pass1' => array(
            'validatePasswords' => array(
                'rule' => array('validatePasswords'),
                'message' => 'Las dos passwords deben coincidir',
            ),
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el pass del conductor.'
            ),
            'tipo' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Su contraseña puede contener únicamente números o letras.'
            ),
            'minimo' => array(
                'rule' => array(
                    'minLength',
                    '6'
                ),
                'message' => 'Su contraseña debe contener al menos 6 caracteres.'
            )
        )
    );

    public function validatePasswords($check) {
        if (isset($this->data[$this->alias]['pass'])) {
            return $this->data[$this->alias]['pass'] === $this->data[$this->alias]['pass1'];
        }
        return true;
    }

    public function beforeSave($options = array()) {
        parent::beforeSave();
        //pregunto si el conductor no tiene id (Si tiene , es un update. sino un insert)
        if (!isset($this->data['Conductor']['id'])) {
            //pongo el estado en habilitado
            $this->data['Conductor']['estado'] = 'Habilitado';
            //encripto la pass
            $this->data['Conductor']['pass'] = md5($this->data['Conductor']['pass']);
        }
        return true;
    }

    public function uploadThumb($file, $conductor_id) {
        return parent::__uploadThumb($file, $conductor_id, PATH_CONDUCTOR_THUMBS, 160, 160);
    }

    public function resetThumb($conductor_id) {
        $result = true;
        $path = PATH_CONDUCTOR_THUMBS . DS . $conductor_id . DS . 'thumb.png';
        if (file_exists($path)) {
            $result = unlink($path);
        }
        return $result;
    }

    function validarCuil() {
        $bandera = false;
        $datos = explode('-', $this->data['Conductor']['cuil']);
        if (isset($datos[1]) && $datos[1] == $this->data[$this->alias]['dni']) {
            $bandera = true;
        }
        return $bandera;
    }

    public $recursive = -1;

    function activar($id) {
        $this->id = $id;
        return $this->saveField('estado', 'Habilitado');
    }

    function desactivar($id) {
        $this->id = $id;
        return $this->saveField('estado', 'Deshabilitado');
    }

    public function calificacion($id) {
        $viajes = $this->Viaje->findByConductorId($id);
        $calificacion = 0;
        foreach ($viajes as $viaje):
            $calificacion += $this->Viaje->calificacionConductor($viaje['id']);
        endForeach;
        if (count($viajes) != 0) {
            $calificacion /= count($viajes);
        }
        return $calificacion;
    }

    public function conductorVehiculo($id) {
        $relacion = $this->Historialvc->conductorVehiculo($id);
        if (!is_null($relacion)) {
            $relacion['Conductor'] = $this->nombreConductor($relacion['conductor_id']);
            unset($relacion['conductor_id']);
        }
        return $relacion;
    }

    public function nombreConductor($id) {
        $conductor = $this->findById($id);
        return $conductor['Conductor']['apellido'] . ', ' . $conductor['Conductor']['nombre'];
    }
    
    public function findFreeConductors($empresa_id, $type = 'all', $options = array()) {
        $defaults = array(
            'conditions' => array(
                'OR' => array(
                    'Historialvcs.fecha_fin IS NULL',
                    'Historialvcs.fecha_fin' => '0000-00-00'
                ),
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
                        'OR' => array(
                            'Historialvcs.fecha_fin IS NULL',
                            'Historialvcs.fecha_fin' => '0000-00-00'
                        )
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
        if(!empty($empresa_id)) {
            $defaults['conditions']['Conductor.empresa_id'] = $empresa_id;
        }
        $options = array_replace_recursive($defaults, $options);
        $conductors =  $this->find($type, $options);
        
        return $conductors;
    }

    public function findConductors($empresa_id, $type = 'all', $options = array()) {
        App::import('Model', 'Vehiculo'); // mention at top
        $cond = new Vehiculo;

        $options = array(
            'conditions' => array(
                'Vehiculo.empresa_id' => $empresa_id,
                'Vehiculo.habilitado' => 'Habilitado'
            ),'order' => array(
                'Vehiculo.nro_registro' => 'asc',
            )
        );
        $vehiculos = $cond->find('all', $options);
        
        return $vehiculos;
    }
    
    /**
     * retrona el vehiculo de un conductor en ese momento
     * @param type $vehiculo_id
     */
    public function getByVehiculoId($vehiculo_id) {
        $options = array('conditions' => array('Vehiculo.id' => $vehiculo_id));
        $conductor = $this->findFreeConductors(null, 'first', $options);
        return $conductor;
    }

}
