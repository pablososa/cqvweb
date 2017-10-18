<?php
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('Controller', 'Controller');
App::uses('GCMClientComponent', 'Controller/Component');

/**
 * Class ViajesProgramadosAViajesShell
 * @author lucs
 */
class ViajesProgramadosAViajesShell extends AppShell
{

    public $uses = array('Viaje');

    /**
     * cron frecuency (minutes)
     * @var int
     */
    private $frecuency = 5;

    /**
     * the cron creates the Viaje $timeBefore minutes before
     * @var int
     */
    private $timeBefore = 10;

    public function start()
    {
        $collection = new ComponentCollection();
        $this->GCMClient = new GCMClientComponent($collection);
        $controller = new Controller();
        $this->GCMClient->initialize($controller);

        $this->cronStarted = date("Y-m-d H:i:0", time() + $this->timeBefore * 60);
    }

    public function main()
    {
        $this->markIni();

        $viajesProgramados = $this->Viaje->ViajeProgramado->getByTime($this->cronStarted, $this->frecuency);

        foreach ($viajesProgramados as $viajeProgramado) {
            $this->Viaje->create();
            $empresa = [
                'Empresa' => [
                    'id' => $viajeProgramado['ViajeProgramado']['empresa_id']
                ]
            ];
            $data = [
                'Viaje' => [
                    'dir_origen' => $viajeProgramado['ViajeProgramado']['dir_origen'],
                    'latitud_origen' => $viajeProgramado['ViajeProgramado']['latitud_origen'],
                    'longitud_origen' => $viajeProgramado['ViajeProgramado']['longitud_origen'],
                    'dir_destino' => $viajeProgramado['ViajeProgramado']['dir_destino'],
                    'latitud_destino' => $viajeProgramado['ViajeProgramado']['latitud_destino'],
                    'longitud_destino' => $viajeProgramado['ViajeProgramado']['longitud_destino'],
                    'vehiculo_id' => $viajeProgramado['ViajeProgramado']['vehiculo_id'],
                    'cercanos' => $viajeProgramado['ViajeProgramado']['vehiculo_id'],
                    'observaciones' => "Hora viaje: ".$viajeProgramado['ViajeProgramado']['hora']." - ".$viajeProgramado['ViajeProgramado']['observaciones'].' '.$viajeProgramado['ViajeProgramado']['vehiculo_id']
//                    'viaje_programado_id' => $viajeProgramado['ViajeProgramado']['id']
                ]
            ];
            $viaje = $this->Viaje->add($empresa, $data);
            if(!empty($viaje)) {
                $this->write("Viaje {$viaje['Viaje']['id']} creado.");
                if($viajeProgramado['ViajeProgramado']['tipo'] == 'diferido') {
                    if($this->Viaje->ViajeProgramado->delete($viajeProgramado['ViajeProgramado']['id'])) {
                        $this->write("Viaje diferido {$viajeProgramado['ViajeProgramado']['id']} eliminado.");
                    }
                }
                $this->GCMClient->sendNotificationVehicle_NuevoViaje($viaje);
            } elseif(empty($this->Viaje->message)) {
                $this->write("ERROR: El Viaje correspondiente al ViajeProgramadno {$viajeProgramado['ViajeProgramado']['id']} pudo crearse por un error descnocido");
            } else {
                $this->write("ERROR: ViajeProgramadno {$viajeProgramado['ViajeProgramado']['id']}. {$this->Viaje->message}");
            }
        }

        $this->markEnd();
    }

}
