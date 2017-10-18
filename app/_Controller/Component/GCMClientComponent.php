<?php

class GCMClientComponent extends Component
{

    private $Gcm = null;

    public function initialize(Controller $controller)
    {
        App::import('Lib', 'GCMClient');
        App::import('Model', 'Gcm');
        $this->Gcm = new Gcm();
    }

    private function sendNotification($type, $id, $title, $data)
    {
        $options = array(
            'conditions' => array(
                $type == 'vehicle' ? 'vehiculo_id' : 'usuario_id' => $id
            )
        );
        $gcm = $this->Gcm->find('first', $options);
		
		//get key
		
		$empresa = $this->Session->read('Empresa');
		$key = $empresa['Empresa']['fcm_key'];
		
        if (!empty($gcm['Gcm']['id_gcm'])) {
            $result = GCMClient::sendNotification($gcm['Gcm']['id_gcm'], $title, $data ,$key);

            if (is_string($result)) {
                $gcm['Gcm']['id_gcm'] = $result;
                $this->Gcm->save($gcm);
            }
        } else {
            $result = false;
        }
        return !!$result;
    }

    private function sendNotificationVehicle($vehicle_id, $title, $data)
    {
        return $this->sendNotification('vehicle', $vehicle_id, $title, $data);
    }

    private function sendNotificationUser($user_id, $title, $data)
    {
        return $this->sendNotification('user', $user_id, $title, $data);
    }

    public function sendNotificationVehicle_NuevoViaje($viaje, $vehicle_id = null)
    {
        $vehicle_id = empty($vehicle_id) ? $viaje['Viaje']['vehiculo_id'] : $vehicle_id;
        $data = array();
        $data['IdViaje'] = $viaje['Viaje']['id'];
        $data['Observaciones'] = !empty($viaje['Viaje']['observaciones']) ? $viaje['Viaje']['observaciones'] : '';
        $data['IdCercanos'] = explode(',', $viaje['Viaje']['cercanos']);

        $options = array(
            'conditions' => array(
                'vehiculo_id' => $data['IdCercanos']
            ),
            'fields' => array(
                'vehiculo_id',
                'id_gcm'
            )
        );
//        $data['IdGCMCercanos'] = $this->Gcm->find('list', $options);
//        $idgcmc = null;
//
//        for ($i=0;$i<count($data['IdCercanos']);$i++){
//            $idgcmc[] = $data['IdGCMCercanos'][$data['IdCercanos'][$i]];
//        }
//        /*foreach($data['IdGCMCercanos'] as $key => $value){
//              $idgcmc[] = $value;
//        }*/
//
//         if ($idgcmc!=null)
//            $data['IdGCMCercanos'] = implode(',', $idgcmc);

        // Refactorizando lo comentado aca arriba
        $data['IdGCMCercanos'] = implode(',', $this->Gcm->find('list', $options));

        $options = array(
            'conditions' => array(
                'usuario_id' => $data['IdCercanos']
            ),
            'fields' => array(
                'usuario_id',
                'id_gcm'
            )
        );

//        $data['IdGCMPasajero'] = $this->Gcm->find('list', $options);
//        $idgcmp = null;
//
//        if ($data['IdGCMPasajero'] != null) {
//            foreach ($data['IdGCMPasajero'] as $key => $value) {
//                $idgcmp[] = $value;
//            }
//            $data['IdGCMPasajero'] = implode(',', $idgcmp);
//        }

        // Refactorizando lo comentado aca arriba
        $data['IdGCMPasajero'] = implode(',', $this->Gcm->find('list', $options));

        $data['IdCercanos'] = $viaje['Viaje']['cercanos'];

        return $this->sendNotificationVehicle($vehicle_id, 'NuevoViaje', $data);
    }

    public function sendNotificationVehicle_ViajeCanceladoPasajero($viaje, $vehicle_id = null)
    {
        $vehicle_id = empty($vehicle_id) ? $viaje['Viaje']['vehiculo_id'] : $vehicle_id;
        $data = array(
            'IdViaje' => $viaje['Viaje']['id']
        );
        return $this->sendNotificationVehicle($vehicle_id, 'ViajeCanceladoPasajero', $data);
    }

    public function sendNotificationVehicle_NuevoMensaje($mensaje, $vehicle_id)
    {
        //$vehicle_id = empty($vehicle_id) ? $mensaje['Mensaje']['vehiculo_id'] : $vehicle_id;
        return $this->sendNotificationVehicle($vehicle_id, 'NuevoMensaje', $mensaje);
    }

}
