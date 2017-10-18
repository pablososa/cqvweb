<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecicleDummySessionsShell
 *
 * @author lucs
 */
class UpdateEstadisticasTableShell extends AppShell
{

    public $uses = array('Estadistica');

    public function main()
    {
        $this->markIni();
        
        $result = $this->Estadistica->regenerateCache(true);
        if($result) {
            $this->write('Table estadisticas was fully refilled');
        } else {
            $this->write('Table estadisticas could not refilled');
        }
        
        $this->markEnd();
    }

}
