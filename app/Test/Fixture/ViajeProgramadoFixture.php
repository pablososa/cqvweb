<?php
/**
 * ViajeProgramadoFixture
 *
 */
class ViajeProgramadoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'hora' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'lunes' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'martes' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'miercoles' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'jueves' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'viernes' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'sabado' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'domingo' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'respeta_feriados' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'fecha_desde' => array('type' => 'date', 'null' => false, 'default' => null),
		'fecha_hasta' => array('type' => 'date', 'null' => true, 'default' => null),
		'activo' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'empresa_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'dir_origen' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'latitud_origen' => array('type' => 'float', 'null' => false, 'default' => null),
		'longitud_origen' => array('type' => 'float', 'null' => false, 'default' => null),
		'dir_destino' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'latitud_destino' => array('type' => 'float', 'null' => false, 'default' => null),
		'longitud_destino' => array('type' => 'float', 'null' => false, 'default' => null),
		'localidad' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'observaciones' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ivr_domicilio_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'empresa_id' => array('column' => 'empresa_id', 'unique' => 0),
			'ivr_domicilio_id' => array('column' => 'ivr_domicilio_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'hora' => 1,
			'lunes' => 1,
			'martes' => 1,
			'miercoles' => 1,
			'jueves' => 1,
			'viernes' => 1,
			'sabado' => 1,
			'domingo' => 1,
			'respeta_feriados' => 1,
			'fecha_desde' => '2017-01-27',
			'fecha_hasta' => '2017-01-27',
			'activo' => 1,
			'empresa_id' => 1,
			'dir_origen' => 'Lorem ipsum dolor sit amet',
			'latitud_origen' => 1,
			'longitud_origen' => 1,
			'dir_destino' => 'Lorem ipsum dolor sit amet',
			'latitud_destino' => 1,
			'longitud_destino' => 1,
			'localidad' => 'Lorem ipsum dolor sit amet',
			'observaciones' => 'Lorem ipsum dolor sit amet',
			'ivr_domicilio_id' => 1
		),
	);

}
