<?php

App::uses('AppModel', 'Model');

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $hasMany = array(
        'Viaje' => array('className' => 'Viaje', 'foreignKey' => 'usuario_id'),
        'Calificacion' => array('className' => 'Calificacion', 'foreignKey' => 'usuario_id')
    );
    var $belongsTo = array(
        'Localidad' => array('className' => 'Localidad', 'foreignKey' => 'localidad_id')
    );
    public $validate = array(
        'fecha_nac' => array(
            'not_empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar su fecha de nacimiento.'
            ),
            'mayor_de_18' => array(
                'rule' => array('checkForAge'),
                'message' => 'Debe ser mayor a 18 años'
            )
        ),
        'apellido' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar su apellido.'
            ),
            'expresion' => array(
                'rule' => array(
                    'custom',
                    '<[a-zA-ZñÑ\s]{2,50}>'
                ),
                'message' => 'Sus apellidos deben contener solo letras.'
            )
        ),
        'nombre' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar su nombre.'
            ),
            'expresion' => array(
                'rule' => array(
                    'custom',
                    '<[a-zA-ZñÑ\s]{2,50}>'
                ),
                'message' => 'Sus nombres deben contener solo letras.'
            )
        ),
        'telefono' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar su número de teléfono.'
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
                'message' => 'El número de teléfono introducido está siendo usado por otro usuario.'
            )
        ),
        'email' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar su email.'
            ),
//            'tipo' => array(
//                'rule' => array(
//                    'email',
//                    true
//                ),
//                'message' => 'Debe ingresar un email válido.'
//            ),
            'es_unico' => array(
                'rule' => 'isUnique',
                'message' => 'El email introducido está siendo utilizado por otro usuario.'
            )
        ),
        'pass' => array(
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

    public function checkForAge($check) {
        return strtotime(reset($check)) < strtotime('-18 year', time());
    }
    
    public function beforeSave($options = array()) {
        parent::beforeSave();
        //me fijo si existe un id (Si existe, es porq es un update, no un insert )
        if (!isset($this->data['Usuario']['id'])) {
            //si no existe encripto la pass
            $this->data['Usuario']['pass'] = md5($this->data['Usuario']['pass']);
        }
        return true;
    }

    public function nombreUsuario($id) {
        $return = '';
        $usuario = $this->findById($id);
        if (!empty($usuario)) {
            $return = $usuario['Usuario']['apellido'] . ', ' . $usuario['Usuario']['nombre'];
        }
        return $return;
    }

    public function makeHash($user) {
        return md5($user['Usuario']['id'] . 'i71uEyRf8uih347t' . $user['Usuario']['email'] . 'rQfge3r8dsÑ0f7');
    }

    public function penalizar($id) {
        $usuario = $this->findById($id);
        $usuario['Usuario']['estado'] = 2;
        return $this->save($usuario);
    }

    /**
     * 0 inactivo
     * 1 activo app
     * 2 activo web
     * 3 activo app y web
     * @param type $id
     * @return boolean
     */
    public function activate($id) {
        $user = $this->findById($id);
        $status_map = array(
            0 => 2,
            1 => 3,
            2 => 2,
            3 => 3,
        );
        if(!empty($user) && in_array($user['Usuario']['estado'], array_keys($status_map))) {
            $this->id = $id;
            return $this->saveField('estado', $status_map[$user['Usuario']['estado']]);
        }
        return false;
    }

    public function deshabilitar($id) {
        $this->id = $id;
        return $this->saveField('habilitado', false);
    }

    public function habilitar($id) {
        $this->id = $id;
        return $this->saveField('habilitado', true);
    }

//    public function uploadThumb($file, $user_id, $path) {
//        $result = false;
//        if (Image::checkMimeType($file['type'])) {
//            $path = PATH_USER_THUMBS . "/{$user_id}/thumb.png";
//            $data = Image::cropResize($file['tmp_name'], false, 80, 80);
//            $this->File = ClassRegistry::init('File');
//            $file = $this->File->findByPath($path);
//            if(empty($file)) {
//                $file = array(
//                    'path' => $path,
//                );
//            }
//            $file['data'] = $data;
//            $this->File->save($file);
//        }
//        return $result;
//    }
    
    public function uploadThumb($file, $user_id) {
        return parent::__uploadThumb($file, $user_id, PATH_USER_THUMBS, 160, 160);
    }

    public function resetThumb($user_id) {
        $result = false;
        $path = PATH_USER_THUMBS . DS . $user_id . DS . 'thumb.png';
        if (file_exists($path)) {
            $result = unlink($path);
        }
        return $result;
    }

        public function getClientes(){


 $qry = <<<SQL
select * from apptaxi_ivr_clientes where empresa_id = 50
SQL;

        $clientes = $this->query($qry);
        return $clientes;

    }


        public function getLiquidacion($id){


 $qry = <<<SQL
select 
v.fecha, 
0 as total , 
0 as comision,
0 as pagos,
'' as fecha
SQL;

        $viajes = $this->query($qry);
        return $viajes;

    }

    public function setRel($user,$cli){

 $qry = <<<SQL
        UPDATE apptaxi_usuarios SET cliente={$cli} WHERE id={$user}
SQL;

        $this->query($qry);
        
        return true;

    }

}