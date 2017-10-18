<?php

App::uses('AppModel', 'Model');

/**
 * IvrLlamadaEntrante Model
 *
 * @property IvrCliente $IvrCliente
 * @property Empresa $Empresa
 */
class IvrLlamadaEntrante extends AppModel {

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
        ),
        'Empresa' => array(
            'className' => 'Empresa',
            'foreignKey' => 'empresa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function beforeFind($query) {
        if (empty($this->cleaning)) {
            $this->cleaning = true;
            $from = new DateTime('5 minutes ago');
            $options = array(
                'fecha <' => $from->format('Y-m-d H:i:s')
            );
            $this->deleteAll($options);
            $this->cleaning = false;
        }
        return parent::beforeFind($query);
    }

    public function insert($empresa_id, $telefono, $key_telefono = null) {
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa_id,
                'telefono' => $telefono
            )
        );
        $ivr_llamada_entrante = $this->find('first', $options);
        if (empty($ivr_llamada_entrante)) {
            $ivr_llamada_entrante = array(
                'IvrLlamadaEntrante' => array(
                    'empresa_id' => $empresa_id,
                    'telefono' => $telefono
                )
            );
        }
        $ivr_cliente = $this->IvrCliente->findByEmpresaAndTelefono($empresa_id, $telefono);
        if(!empty($ivr_cliente['IvrCliente']['id'])) {
            $ivr_llamada_entrante['IvrLlamadaEntrante']['ivr_cliente_id'] = $ivr_cliente['IvrCliente']['id'];
        }
        $ivr_llamada_entrante['IvrLlamadaEntrante']['fecha'] = date('Y-m-d H:i:s');
        $ivr_llamada_entrante['IvrLlamadaEntrante']['key_telefono'] = $key_telefono;
        $ivr_llamada_entrante['IvrLlamadaEntrante']['atendido'] = 'no';
        return $this->save($ivr_llamada_entrante);
    }

    public function deleteByEmpresaAndTelefono($empresa_id, $telefono) {
        $conditions = array(
            'IvrLlamadaEntrante.empresa_id' => $empresa_id,
            'IvrLlamadaEntrante.telefono' => $telefono,
        );
        return $this->deleteAll($conditions, false);
    }
    
    public function markAsAtendido($empresa_id, $telefono) {
        $fields = array(
            'IvrLlamadaEntrante.atendido' => '"yes"'
        );
        $conditions = array(
            'IvrLlamadaEntrante.empresa_id' => $empresa_id,
            'IvrLlamadaEntrante.telefono' => $telefono,
            'IvrLlamadaEntrante.atendido' => 'no'
        );
        return $this->updateAll($fields, $conditions);
    }
}
