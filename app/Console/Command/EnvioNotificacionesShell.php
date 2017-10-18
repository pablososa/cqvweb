<?php
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('Controller', 'Controller');
App::uses('GCMClientComponent', 'Controller/Component');

/**
 * Class EnvioNotificacionesShell
 * @author lucs
 */
class EnvioNotificacionesShell extends AppShell
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

        $notificaciones = $this->Notificacion->getByTime($this->cronStarted, $this->frecuency);

        foreach ($notificaciones as $notificacion) {


            $this->GCMClient->sendNotificationAllUsers($notificacion['Notificacion']['mensaje'],$notificacion['Notificacion']['empresa_id']);

            //enviar notificaciones push a todos los usuarios de app cliente
            

        }

        $this->markEnd();
    }

}
