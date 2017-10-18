<?php

App::uses('AppModel', 'Model');

/**
 * Estadistica Model
 *
 * @property Empresa $Empresa
 */
class Estadistica extends AppModel {

    protected $regenerating = false;

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
        'fecha' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'n' => array(
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
    
    /**
     * checks if daily cache has to be regenerated right now
     * as the app is over multiserver architecture y regenerate daily
     * statistics by a cronjob passing force to true
     * so this always returns false
     * @return boolean
     */
    protected function hasToRegenerateFull() {
        return Cache::read('regenerate_full', 'estadisticas_full') === false;
    }
    
    protected function hasToRegeneratePartial() {
        return Cache::read('regenerate_full', 'estadisticas_partial') === false;
    }

    public function regenerateCache($force = false) {
        $result = true;
        if (!$this->regenerating) {
            $this->regenerating = true;
//            $result_full = $this->hasToRegenerateFull() || $force;
            $result_full = $force;
            $result_partial = $this->hasToRegeneratePartial();
            if ($result_full) {
                Cache::write('regenerate_full', true, 'estadisticas_full');
                Cache::write('regenerate_full', true, 'estadisticas_partial');
                $from = new DateTime('2000-01-01');
                $this->query("TRUNCATE TABLE {$this->tablePrefix}{$this->useTable}; ");
            } elseif ($result_partial) {
                Cache::write('regenerate_full', true, 'estadisticas_partial');
                $from = new DateTime('1 day ago');
                $options = array(
                    'fecha >=' => $from->format('Y-m-d')
                );
                $this->deleteAll($options);
            }
            
            if ($result_full || $result_partial) {
                $no_atendidos_estados = '"' . implode('", "', array('Cancelado_sistema_no_disponible', 'Despacho_pendiente')) . '"';
                $query = <<<SQL
                INSERT INTO {$this->tablePrefix}{$this->useTable} (empresa_id, creador, fecha, n, n_turno_1, n_turno_2, n_turno_3, n_atendidos, n_no_atendidos)
                SELECT empresa_id, creador, fecha, COUNT(id), 
                    SUM(hora < '08:00:00'), 
                    SUM(hora >= '08:00:00' && hora < '16:00:00'), 
                    SUM(hora >= '16:00:00'),
                    SUM(estado NOT IN ({$no_atendidos_estados})),
                    SUM(estado IN ({$no_atendidos_estados}))
                FROM {$this->tablePrefix}viajes
                WHERE fecha >= '{$from->format('Y-m-d')}'
                GROUP BY empresa_id, fecha, creador
SQL;
                
                $this->query($query);
                $result = $this->getAffectedRows() > 0;
                $this->regenerating = false;
            }
        }
        return $result;
    }

    public function beforeFind($query) {
        parent::beforeFind($query);
        $this->regenerateCache();
    }

}
