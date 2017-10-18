<?php

class Empresa extends AppModel {

    var $name = 'Empresa';
    var $hasMany = array(
        'Vehiculo' => array(
            'className' => 'Vehiculo',
            'foreignKey' => 'empresa_id',
            'dependent' => true
        ),
        'Conductor' => array(
            'className' => 'Conductor',
            'foreignKey' => 'empresa_id',
            'dependent' => true
        ),
        'Viaje' => array(
            'className' => 'Viaje',
            'foreignKey' => 'empresa_id',
            'dependent' => true
        ),
        'IvrLlamadaEntrante' => array(
            'className' => 'IvrLlamadaEntrante',
            'foreignKey' => 'empresa_id',
            'dependent' => true
        )
    );
    var $hasOne = array(
        'Tipoempresa' => array(
            'className' => 'Tipoempresa',
            'foreignKey' => 'empresa_id',
            'dependent' => true
        ),
        'Operador' => array(
            'className' => 'Operador',
            'foreignKey' => 'empresa_id',
            'dependent' => true
        ),
    );
    var $belongsTo = array(
        'Localidad' => array('className' => 'Localidad', 'foreignKey' => 'localidad_id')
    );
    var $validate = array(
        'nombre' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el nombre de la empresa.'
            ),
            'tipo' => array(
                'rule' => array(
                    'custom',
                    '<[a-zA-ZñÑ0-9\s]{2,50}>'
                ),
                'message' => 'El nombre debe contener sólo letras y números.'
            )
        ),
        'direccion' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar la dirección de la empresa.'
            )
        ),
        'pass' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar la contraseña para la empresa.'
            ),
            'tipo' => array(
                'rule' => 'alphaNumeric',
                'message' => 'La contraseña debe contener sólo letras y números.'
            ),
            'minimo' => array(
                'rule' => array(
                    'minLength',
                    '6'
                ),
                'message' => 'La contraseña debe contener al menos 6 caracteres.'
            )
        ),
        'email' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar su email.'
            ),
            'tipo' => array(
                'rule' => 'email',
                'message' => 'Debe ingresar un email válido.'
            ),
            'es_unico' => array(
                'rule' => 'isUnique',
                'message' => 'Ya existe una empresa registrada con ese email.'
            )
        ),
        'telefono' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el teléfono de la empresa.'
            ),
            'expresion' => array(
                'rule' => array(
                    'custom',
                    '<\d{10}>'
                ),
                'message' => 'Su número debe seguir la siguiente estructura caracteristica+numero.'
            ),
            'es_unico' => array(
                'rule' => 'isUnique',
                'message' => 'Ya existe una empresa registrada con ese teléfono.'
            )
        ),
        'cuit' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar su cuit.'
            ),
            'expresion' => array(
                'rule' => array(
                    'validarCuit'
                ),
                'message' => 'Ingrese un cuit válido. (XX-XXXXXXXX-X)'
            )
        ),
        'empresa_key' => array(
            'min_length' => array(
                'rule' => array('minLength', 20),
                'allowEmpty' => true,
                'message' => 'Debe tener por lo menos 20 caracteres o vacio'
            )
        )
    );

    public function makeHash($empresa) {
        return md5($empresa['Empresa']['id'] . 'i71uEyRf8uih347t' . $empresa['Operador']['usuario'] . 'rQfge3r8dsÑ0f7' . date('y-m-d'));
    }

    function validarCuit() {
        //tengo que comprobar que cada parte del cuit ingresado sean numeros, pongo una bandera en true
        $es_numerico = true;
        //parto el cuit en los guiones y los guardo en datos(array)
        $datos = explode('-', $this->data['Empresa']['cuit']);
        foreach ($datos as $dato) {
            //por cada parte del cuit me fijo que sea numerico
            if (!is_numeric($dato)) {
                //si no es pongo la bandera en false
                $es_numerico = false;
            }
        }
        //debo comprobar las longitudes de las tres partes
        $longitud0 = true;
        $longitud1 = $longitud0;
        $longitud2 = $longitud1;
        //la primer parte son 2 numeros, si la longitud es distinta de 2 hay un error
        if (!isset($datos[0]) || strlen($datos[0]) != 2) {
            //longitud distinta de 2, pongo la bandera en false
            $longitud0 = false;
        }
        //la segunda parte son 8 numeros, si la longitud es distinta de 8 u 7 hay un error
        if (!isset($datos[1]) || !in_array(strlen($datos[1]), array(7, 8))) {
            //longitud distinta de 8, pongo la bandera en false
            $longitud1 = false;
        }
        //la tercer parte es 1 digito, si la longitud es distinta de 1 hay un error
        if (!isset($datos[2]) || strlen($datos[2]) != 1) {
            //longitud distinta de 1, pongo la bandera en false
            $longitud2 = false;
        }
        //un cuit es valido, si todas las banderas llegan a este punto en true
        return ($es_numerico && $longitud0 && $longitud1 && $longitud2);
    }

    public function beforeSave($options = array()) {
        parent::beforeSave();
        //me fijo si existe un id (Si existe, es porq es un update, no un insert )
        if (!isset($this->data['Empresa']['id'])) {
            //pongo la fecha de inicio de actividad
            $this->data['Empresa']['fecha_ini_act'] = date("Y-m-d");
            //deshabilito la empresa
            $this->data['Empresa']['estado'] = 'Deshabilitado';
            //si no existe encripto la pass
            $this->data['Empresa']['pass'] = md5($this->data['Empresa']['pass']);
        }
        return true;
    }

    public function uploadThumb($file, $empresa_id) {
        return parent::__uploadThumb($file, $empresa_id, PATH_EMPRESA_THUMBS, 160, 160);
    }

    public function resetThumb($empresa_id) {
        $result = false;
        $path = PATH_EMPRESA_THUMBS . DS . $empresa_id . DS . 'thumb.png';
        if (file_exists($path)) {
            $result = unlink($path);
        }
        return $result;
    }

    public function nombreEmpresa($id) {
        $empresa = $this->findById($id);
        return $empresa['Empresa']['nombre'];
    }

    public function activate($id) {
        $empresa = $this->findById($id);
        $empresa['Empresa']['estado'] = 'Habilitado';
        return $this->save($empresa);
    }

    public function deshabilitar($id) {
        $empresa = $this->findById($id);
        $empresa['Empresa']['estado'] = 'Deshabilitado';
        return $this->save($empresa);
    }

    public function addRatingVirtualField() {
        $this->virtualFields['rating'] = <<<SQL
                SELECT (sum(puntaje_conductor) + sum(puntaje_vehiculo)) / (2 * count( DISTINCT viaje_id ))
                FROM apptaxi_calificacions ca
                INNER JOIN apptaxi_viajes v ON v.id = ca.viaje_id
                WHERE v.empresa_id = {$this->name}.id
SQL;
    }

    public function addVotosVirtualField() {
        $this->virtualFields['votos'] = <<<SQL
                SELECT count( DISTINCT viaje_id )
                FROM apptaxi_calificacions ca
                INNER JOIN apptaxi_viajes v ON v.id = ca.viaje_id
                WHERE v.empresa_id = {$this->name}.id
SQL;
    }

}

?>