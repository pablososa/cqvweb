<?php
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('Controller', 'Controller');
App::uses('GCMClientComponent', 'Controller/Component');

/**
 * Class ViajesProgramadosAViajesShell
 * @author lucs
 */
class AsignarViajesSinVehiculoShell extends AppShell
{

    public $uses = array('Viaje');

    public function start()
    {
        $collection = new ComponentCollection();
        $this->GCMClient = new GCMClientComponent($collection);
        $controller = new Controller();
        $this->GCMClient->initialize($controller);
    }

    public function main()
    {
        $this->markIni();

        $options = [
            'conditions' => [
                'vehiculo_id' => SIN_VEHICULO_EN_ZONA,
                'estado' => 'Pendiente'
            ]
        ];
        $viajes = $this->Viaje->find('all', $options);

        foreach($viajes as $viaje) {
            $viaje['Viaje']['vehiculo_id'] = null;
            $this->Viaje->add($viaje['Viaje']['empresa_id'], $viaje);
            $this->GCMClient->sendNotificationVehicle_NuevoViaje($viaje);
        }

        $this->markEnd();
    }

}
