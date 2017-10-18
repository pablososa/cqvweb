<?php

App::uses('AppModel', 'Model');

/**
 * Mantenimiento Model
 *
 */
class Mantenimiento extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'mensaje' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'desde' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'hasta' => array(
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

    public function getShowables($id = null) {
        $now = date('Y-m-d H:i:s');
        if (empty($id)) {
            $tmp_showables = Cache::read('showables', 'mantenimientos');
            if ($tmp_showables === false) {
                $options = array(
                    'conditions' => array(
                        'Mantenimiento.desde <=' => $now,
                        'Mantenimiento.hasta >=' => $now,
                        'Mantenimiento.estado' => 'Habilitado',
                    )
                );
                $tmp_showables = $this->find('all', $options);
                foreach($tmp_showables as &$showable) {
                    $showable['Mantenimiento']['expire_time'] = strtotime($showable['Mantenimiento']['hasta']);
                }
                Cache::write('showables', $tmp_showables, 'mantenimientos');
            }
            $time = time();
            $showables = array();
            foreach($tmp_showables as &$showable) {
                if($showable['Mantenimiento']['expire_time'] >= $time) {
                    $showables[] = $showable;
                }
            }
        } else {
            $options = array(
                'conditions' => array(
                    'Mantenimiento.id' => $id
                )
            );
            $showables = $this->find('all', $options);
        }
        return $showables;
    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        $this->clearCache();
    }

    public function afterDelete() {
        $this->clearCache();
    }
    
    public function clearCache() {
        Cache::delete('showables', 'mantenimientos');
    }
}
