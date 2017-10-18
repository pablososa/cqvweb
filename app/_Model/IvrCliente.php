<?php

App::uses('AppModel', 'Model');

/**
 * IvrCliente Model
 *
 * @property Empresa $Empresa
 * @property IvrDomicilio $IvrDomicilio
 * @property IvrLlamadaEntrante $IvrLlamadaEntrante
 */
class IvrCliente extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
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
        'telefono' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
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

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'IvrDomicilio' => array(
            'className' => 'IvrDomicilio',
            'foreignKey' => 'ivr_cliente_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'IvrLlamadaEntrante' => array(
            'className' => 'IvrLlamadaEntrante',
            'foreignKey' => 'ivr_cliente_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public function findByEmpresaAndTelefono($empresa_id, $telefono) {
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa_id,
                'telefono' => $telefono
            )
        );
        return $this->find('first', $options);
    }
}
