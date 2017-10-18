<?php

App::uses('AppModel', 'Model');

/**
 * IvrDomicilio Model
 *
 * @property IvrCliente $IvrCliente
 */
class IvrDomicilio extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'ivr_cliente_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'domicilio' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Por favor ingrese un domicilio válido',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'es_principal' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                'message' => 'Por favor seleccione una opción',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
//        'observaciones' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//            //'message' => 'Your custom message here',
//            //'allowEmpty' => false,
//            //'required' => false,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'IvrCliente' => array(
            'className' => 'IvrCliente',
            'foreignKey' => 'ivr_cliente_id',
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
        'Viaje' => array(
            'className' => 'Viaje',
            'foreignKey' => 'ivr_domicilio_id',
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
    );
    public function save($data = null, $validate = true, $fieldList = array()) {
        $result = true;
        if(empty($data['IvrDomicilio']['ivr_cliente_id'])) {
            $result &= $this->IvrCliente->save($data);
            if($result) {
                $data['IvrDomicilio']['ivr_cliente_id'] = $this->IvrCliente->id;
            }
        }
        if($result) {
            $options = array(
                'conditions' => array(
                    'ivr_cliente_id' => $data['IvrDomicilio']['ivr_cliente_id'],
                    'es_principal' => true
                )
            );
            if(!empty($data['IvrDomicilio']['id'])) {
                $options['conditions']['IvrDomicilio.id !='] = $data['IvrDomicilio']['id'];
            }
            $domicio_principal_existente = $this->find('first', $options);
            if(empty($domicio_principal_existente)) {//no tiene ninguno principal
                $data['IvrDomicilio']['es_principal'] = true;
            } elseif($data['IvrDomicilio']['es_principal'] == true) {//si ya tiene uno y quiero que el nuevo sea principal
                $result &= $this->updateAll(array('es_principal' => false), $options['conditions']);
            }
            $result &= parent::save($data, $validate, $fieldList);
        }
        return $result;
    }
    
    public function delete($id = null, $cascade = true) {
        $domicilio = $this->findById($id);
        if($domicilio['IvrDomicilio']['es_principal']) {
            $options = array(
                'conditions' => array(
                    'es_principal' => false
                )
            );
            $new_principal = $this->find('first', $options);
            if(!empty($new_principal)) {
                $new_principal['IvrDomicilio']['es_principal'] = true;
            }
        }
        $result = parent::delete($id, $cascade);
        if(!empty($new_principal)) {
            $result &= $this->save($new_principal);
        }
        return $result;
    }

    public function findPrincipalByEmpresaAndTelefono($empresa_id, $telefono) {
        $options = array(
            'conditions' => array(
                'IvrDomicilio.es_principal' => true
            )
        );
        return $this->findByEmpresaAndTelefono($empresa_id, $telefono, $options);
    }
    
    public function findByEmpresaAndTelefono($empresa_id, $telefono, $options_p = array()) {
        $options = array(
            'conditions' => array(
                'IvrCliente.empresa_id' => $empresa_id,
                'IvrCliente.telefono' => $telefono,
                'IvrDomicilio.es_principal' => true
            ),
            'joins' => array(
                array(
                    'table' => 'ivr_clientes',
                    'alias' => 'IvrCliente',
                    'type' => 'INNER',
                    'conditions' => array(
                        'IvrCliente.id = IvrDomicilio.ivr_cliente_id'
                    )
                )
            ),
            'fields' => array('IvrCliente.*', 'IvrDomicilio.*')
        );
        $options = array_replace_recursive($options, $options_p);
        return $this->find('first', $options);
    }

}
