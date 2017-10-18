<?php
App::uses('AppModel', 'Model');
/**
 * ViajesHistorial Model
 *
 * @property Viaje $Viaje
 * @property Vehiculo $Vehiculo
 */
class ViajesHistorial extends AppModel {

	public $useTable = 'viajes_historial';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Viaje' => array(
			'className' => 'Viaje',
			'foreignKey' => 'viaje_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Vehiculo' => array(
			'className' => 'Vehiculo',
			'foreignKey' => 'vehiculo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
