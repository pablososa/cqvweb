<?php

App::uses('AppModel', 'Model');

/**
 * Operador Model
 *
 * @property Empresa $Empresa
 */
class Operador extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $defaultConfigs = array(
        'puede_asignar_moviles_determinados' => false , 
        'puede_modificar_vehiculos_conductores' => false

    );
    public $validate = array(
        'usuario' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => array('isUniqueUsuario'),
                'message' => 'Usuario inválido elija otro nombre',
            )
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'empresa_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Empresa' => array(
            'className' => 'Empresa',
            'foreignKey' => 'empresa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public $hasMany = array(
        'KeyTelefono' => array(
            'className' => 'KeyTelefono',
            'foreignKey' => 'operador_id',
            'dependent' => true
        ),
    );

    public function isUniqueUsuario($data) {
        $id = !empty($this->data['Operador']['id']) ? $this->data['Operador']['id'] : -1;
        $options = array(
            'conditions' => array(
                'Operador.usuario' => $data['usuario'],
                'Operador.id !=' => $id
            ),
        );
        $operador = $this->find('first', $options);
        return empty($operador);
    }

    public function activar($id) {
        $this->id = $id;
        return $this->saveField('estado', 'Habilitado');
    }

    public function desactivar($id) {
        $this->id = $id;
        return $this->saveField('estado', 'Deshabilitado');
    }
            
    public function afterFind($operadores, $primary = false) {
        $roll = false;
        if(in_array(AppModel::$__currentQueryType, array('all', 'first'))) {
            $operadores = parent::afterFind($operadores, $primary);
            if(!empty($operadores) && empty($operadores[0]['Operador'])) {
                $operadores = array(array('Operador' => $operadores));
                $roll = true;
            }
            foreach ($operadores as &$operador) {
                if (empty($operador['Operador']['configs'])) {
                    $operador['Operador']['configs'] = serialize($this->defaultConfigs);
                }
                if(is_string($operador['Operador']['configs'])) {
                    $operador['Operador']['configs'] = unserialize($operador['Operador']['configs']);
                }
                $operador['Operador']['configs'] = $this->completeConfigs($operador);
            }
        }
        if(!empty($roll)) {
            $operadores = $operadores[0]['Operador'];
        }
        return $operadores;
    }

    public function beforeSave($options = array()) {
        $result = parent::beforeSave($options);
        if (isset($this->data['Operador']['configs'])) {
            if (empty($this->data['Operador']['configs'])) {
                $this->data['Operador']['configs'] = $this->defaultConfigs;
            }
            $this->data['Operador']['configs'] = $this->completeConfigs($this->data);
            $this->data['Operador']['configs'] = serialize($this->data['Operador']['configs']);
        }

        return $result;
    }

    private function completeConfigs($operador) {
        foreach ($this->defaultConfigs as $key => $config) {
            if ($operador['Operador']['tipo'] == 'admin') {
                $operador['Operador']['configs'][$key] = true;
            } else {
                if (!isset($operador['Operador']['configs'][$key])) {
                    $operador['Operador']['configs'][$key] = $this->defaultConfigs[$key];
                }
            }
        }
        return $operador['Operador']['configs'];
    }

}
