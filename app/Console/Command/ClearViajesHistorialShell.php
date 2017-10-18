<?php
App::uses('AppShell', 'Console/Command');

/**
 * Class ClearViajesHistorialShell
 * @author lucs
 */
class ClearViajesHistorialShell extends AppShell
{

    public $uses = array('Viaje');

    public function main()
    {
        $this->markIni();
        $this->Viaje->query("TRUNCATE apptaxi_viajes_historial;");
        $this->markEnd();
    }

}
