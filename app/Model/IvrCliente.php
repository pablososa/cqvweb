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





    public function getLiquidacion($id){


 $qry = <<<SQL
select  
v.fecha, 
round(v.tarifa,2) as total , 
concat(u.apellido,' ',u.nombre) as usuario,
u.id as usuario_id,
u.cliente as cliente_id,
ifnull(sum(p.monto),0.00) as pagos,
ifnull(p.fecha,'No reaizado') as pago 
from apptaxi_viajes v 
inner join apptaxi_usuarios u on u.id = v.usuario_id
left join apptaxi_ivr_clientes_pagos p on p.usuario_id = v.usuario_id
where u.cliente = {$id}
SQL;

        $viajes = $this->query($qry);
        return $viajes;

    }

    public function setLiquidacion($cliente_id,$usuario_id,$monto){

 $qry = <<<SQL
        INSERT INTO apptaxi_ivr_clientes_pagos (cliente_id,usuario_id,fecha,monto) values({$cliente_id},'{$usuario_id}',NOW(),{$monto})
SQL;

        $this->query($qry);
        
        return true;

    }

    public function crear_usuario($ivr){
     $telefono = $ivr['telefono'];
     $email = $ivr['email'];
     $id = $ivr['id'];
     $clave = md5($ivr['clave']);

 $qry = <<<SQL
INSERT INTO apptaxi_usuarios (apellido, nombre, telefono, direccion, localidad_id, email, pass, codigo, 
    estado, habilitado, fecha_nac, cod_promocion_id, saldo_viajes, pago_nonce, customer_id, payment_token, cliente) 
VALUES (' ', ' ', '{$telefono}', ' ', '0', '{$email}', '{$clave}', ' ', '1', '1', '0000-00-00', '0', '0', ' ', '0', 
    'directo', '{$id}');

SQL;

        $this->query($qry);
        
        return true;

    }





}
