<?php
App::uses('AppModel', 'Model');

/**
 * ViajeProgramado Model
 *
 * @property Empresa $Empresa
 * @property IvrDomicilio $IvrDomicilio
 * @property Viaje $Viaje
 */
class ViajeProgramado extends AppModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'hora' => array(
            'boolean' => array(
                'rule' => array('time'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'lunes' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'martes' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'miercoles' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'jueves' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'viernes' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'sabado' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'domingo' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'respeta_feriados' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fecha_desde' => array(
            'date' => array(
                'rule' => array('date'),
                'message' => 'Fecha incorrecta',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'activo' => array(
            'boolean' => array(
                'rule' => array('boolean'),
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
        'dir_origen' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'latitud_origen' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'longitud_origen' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dir_destino' => array(
//            'notEmpty' => array(
//                'rule' => array('allowEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
        ),
        'latitud_destino' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                //'allowEmpty' => false,
//                //'required' => false,
//                //'last' => false, // Stop validation after this rule
//                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
        ),
        'longitud_destino' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                //'allowEmpty' => false,
//                //'required' => false,
//                //'last' => false, // Stop validation after this rule
//                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
        ),
        'localidad' => array(
//			'notEmpty' => array(
//				'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
        ),
        'observaciones' => array(
//			'notEmpty' => array(
//				'rule' => array('notEmpty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
        ),
        'ivr_domicilio_id' => array(
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
        ),
        'IvrDomicilio' => array(
            'className' => 'IvrDomicilio',
            'foreignKey' => 'ivr_domicilio_id',
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
            'foreignKey' => 'viaje_programado_id',
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

    public function getByTime($datetime, $lapse, $getTemporariInactive = false) {
        $dateFrom = $datetime;
        $dateTo = date("Y-m-d H:i:s", strtotime($datetime) + $lapse * 60);

        $options = [
            'conditions' => $this->getConditionsByDatetime($dateFrom, $dateTo, $getTemporariInactive),
        ];

        $result = $this->find('all', $options);
        $dump = $this->sqlDump();
        if(!empty($dump['log'][1]['query'])) {
            CakeLog::write('viajes_programados_cron_query_log', $dump['log'][1]['query']);
            CakeLog::write('viajes_programados_cron_query_log', print_r($result, true));
        }
        return $result;
    }

    public function getDayName($date) {
        $days = [
            1 => 'lunes',
            2 => 'martes',
            3 => 'miercoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sabado',
            7 => 'domingo',
        ];
        return $days[date("N", strtotime($date))];
    }

    public function getConditionsByDatetime($dateFrom, $dateTo, $getTemporariInactive=false) {
        $day = $this->getDayName($dateFrom);
        $today = date("Y-m-d", strtotime($dateFrom));
        $horaFrom = date("H:i:s", strtotime($dateFrom));
        $horaTo = date("H:i:s", strtotime($dateTo));
        $conditions = [
            $day => true,
            'activo' => true,
            'hora >= ' =>$horaFrom,
            'hora <' => $horaTo,
            'fecha_desde <=' => $today,
            [
                'OR' => [
                    'fecha_hasta >=' => $today,
                    'fecha_hasta' => null
                ]
            ]
        ];
        if($this->isFeriado($today)) {
            $conditions[] = 'NOT respeta_feriados';
        }
        if(empty($getTemporariInactive)) {
            $conditions[] = [
                'OR' => [
                    [
                        'inactivo_desde IS NOT NULL',
                        'inactivo_hasta IS NOT NULL',
                        'inactivo_desde >' => $today,
                        'inactivo_hasta >' => $today,
                    ],
                    [
                        'inactivo_desde IS NOT NULL',
                        'inactivo_hasta IS NOT NULL',
                        'inactivo_desde <' => $today,
                        'inactivo_hasta <' => $today,
                    ],
                    [
                        'inactivo_desde IS NULL',
                        'inactivo_hasta IS NOT NULL',
                        'inactivo_hasta <' => $today,
                    ],
                    [
                        'inactivo_desde IS NOT NULL',
                        'inactivo_hasta IS NULL',
                        'inactivo_desde >' => $today,
                    ],
                    [
                        'inactivo_desde IS NULL',
                        'inactivo_hasta IS NULL'
                    ]
                ]
            ];
        }
        return $conditions;
    }

    private function isFeriado($fecha) {
        if(empty($this->Feriado)) {
            $this->Feriado = ClassRegistry::init('Feriado');
        }
        $options = [
            'conditions' => [
                'fecha' => $fecha
            ]
        ];
        $result = $this->Feriado->find('first', $options);
        return !empty($result);
    }

}
