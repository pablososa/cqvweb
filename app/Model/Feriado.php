<?php
App::uses('AppModel', 'Model');
/**
 * Feriado Model
 *
 */
class Feriado extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'fecha' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Ya existe un feriado en esa fecha',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'date' => array(
				'rule' => array('date'),
				'message' => 'Fecha incorrecta',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
