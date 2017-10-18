<?php
App::uses('ViajeProgramado', 'Model');

/**
 * ViajeProgramado Test Case
 *
 */
class ViajeProgramadoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.viaje_programado',
		'app.empresa',
		'app.localidad',
		'app.provincia',
		'app.tipoempresa',
		'app.operador',
		'app.key_telefono',
		'app.vehiculo',
		'app.localizacion',
		'app.viaje',
		'app.conductor',
		'app.historialvc',
		'app.usuario',
		'app.calificacion',
		'app.ivr_domicilio',
		'app.ivr_cliente',
		'app.ivr_llamada_entrante'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ViajeProgramado = ClassRegistry::init('ViajeProgramado');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ViajeProgramado);

		parent::tearDown();
	}

}
