<?php
 	
App::uses('AppController', 'Controller');

class CalificacionsController extends AppController{

	function puntuarViaje( $id = null ){
		if( !is_null( $id ) ){
			$usuario = $this->Session->read('Usuario');
			$this->set('usuario',$usuario);
			if( $this->request->data ){
				$this->request->data['Calificacion']['viaje_id'] = $id;
				$this->request->data['Calificacion']['usuario_id'] = $usuario['Usuario']['id'];
				$this->Calificacion->create();
				$result = $this->Calificacion->begin();
				$calificacion = $this->Calificacion->save( $this->request->data );
				$result &= $calificacion;
				if( $result ){
					$this->Calificacion->commit();
					$this->Session->setFlash('Su puntaje a sido guardado','success');
					return $this->redirect( array( 'controller'=>'usuarios' , 'action'=>'history' ) );
				}else{
					$this->Calificacion->rollback();
					$this->Session->setFlash('Su puntaje no ha podido ser guardado. Por favor, inténte nuevamente.','error');
				}
			}
		}else{
			$this->Session->setFlash('Viaje no válido.','error');
			return $this->redirect( array( 'controller'=>'usuarios' , 'action'=>'myReservs' ) );
		}		
	}

}

?>