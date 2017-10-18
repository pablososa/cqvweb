<?php

class Calificacion extends AppModel{
	var $name = 'Calificacion';
	
	var $belongsTo = array('Viaje' => array('className' => 'Viaje','foreignKey' => 'viaje_id'),
							'Usuario' => array('className'=>'Usuario','foreignKey'=>'usuario_id'));
	
	public function calificado( $id ){
		$bandera = true;
		$calificacion = $this->findByViajeId( $id );
		if( empty( $calificacion ) ){
			$bandera = false;
		}
		return $bandera;
	}
	
	public function raiting( $id ){
		$nota = $this->query( 'select (sum(puntaje_conductor)) "conductor", (sum(puntaje_vehiculo)) "vehiculo", count( DISTINCT viaje_id ) "viajes" from apptaxi_calificacions ca
							   INNER JOIN apptaxi_viajes v ON v.id = ca.viaje_id
							   WHERE v.empresa_id = '.$id.';'
							);
		$votos = $nota[0][0]['viajes'];
		if( $votos != 0 ){
			$puntaje = ($nota[0][0]['conductor']+$nota[0][0]['vehiculo'])/(2*$votos);
		}else{
			$puntaje = 0;
		}
		return array($puntaje,$votos);
	}
	
	public function calificacionConductor( $id ){
		$calificacion = $this->findByViajeId( $id ); 
		if( empty( $calificacion ) ){
			$calificacion['Calificacion']['puntaje_conductor'] = 0;
		}
		return $calificacion['Calificacion']['puntaje_conductor'];
	}
	
	public function calificacionVehiculo( $id ){
		$calificacion = $this->findByViajeId( $id );
		if( empty( $calificacion ) ){
			$calificacion['Calificacion']['puntaje_vehiculo'] = 0;
		}
		return $calificacion['Calificacion']['puntaje_vehiculo'];
	}			   
}

?>