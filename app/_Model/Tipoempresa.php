<?php

class Tipoempresa extends AppModel {

    var $name = 'Tipoempresa';
    var $belongsTo = array(
        'Empresa' => array(
            'className' => 'Empresa',
            'foreignKey' => 'empresa_id'
        )
    );
    
    var $validate = array(
        'bajada' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar precio de la bajada de bandera.'
            ),
            'tipo' => array(
                'rule' => array(
                    'custom',
                    '<[0-9.]+>'
                ),
                'message' => 'Debe contener sólo números.'
            )
        ),
        'ficha' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar precio de la ficha.'
            ),
            'tipo' => array(
                'rule' => array(
                    'custom',
                    '<[0-9.]+>'
                ),
                'message' => 'Debe contener sólo números.'
            )
        ),
        'metros' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar los metros por ficha.'
            ),
            'tipo' => array(
                'rule' => array(
                    'custom',
                    '<[0-9.]+>'
                ),
                'message' => 'Debe contener sólo números.'
            )
        ),
    );

    public function getOne($empresa_id) {
        $tipoempresa = null;
        if(!empty($empresa_id)) {
            $options = array(
                'conditions' => array(
                    'empresa_id' => $empresa_id
                ),
                'recursive' => -1
            );
            $tipoempresa = $this->find('first', $options);
        }
        if(empty($tipoempresa)) {
            $this->virtualFields['bajada'] = 'AVG(bajada)';
            $this->virtualFields['ficha'] = 'AVG(ficha)';
            $this->virtualFields['metros'] = 'AVG(metros)';
            $options = array(
                'fields' => array(
                    'bajada',
                    'ficha',
                    'metros'
                ),
                'recursive' => -1
            );
            $tipoempresa = $this->find('first', $options);
        }
        return $tipoempresa;
    }

}
