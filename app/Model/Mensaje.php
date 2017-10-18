<?php

App::uses('AppModel', 'Model');

/**
 * Mensaje Model
 *
 * @property Vehiculo $Vehiculo
 */
class Mensaje extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'texto' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fecha' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'operador' => array(
            'boolean' => array(
                'rule' => array('boolean'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'visto' => array(
            'boolean' => array(
                'rule' => array('boolean'),
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
        'Vehiculo' => array(
            'className' => 'Vehiculo',
            'foreignKey' => 'vehiculo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function aceptarMensaje($empresa_id, $ids) {
        $this->recursive = -1;
        $fields = array(
            'Mensaje.visto' => true
        );
        $conditions = array(
            'Mensaje.id' => $ids
        );
        return $this->updateAll($fields, $conditions);
    }

}
