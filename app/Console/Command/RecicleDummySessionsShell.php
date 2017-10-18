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
class RecicleDummySessionsShell extends AppShell
{

    public $uses = array('CakeSessionModel');

    public function main()
    {
        $this->markIni();
        $timeout = Configure::read('Session.timeout') * 60;
        $durationOfAnnonimusSession = 5 * 60;
        
        $tableName = $this->CakeSessionModel->tablePrefix . $this->CakeSessionModel->useTable;
        $expires = time() - $durationOfAnnonimusSession + $timeout;
        $qry = "DELETE FROM {$tableName} WHERE expires < {$expires} AND data LIKE '%s:9:\"userAgent\";s:0:\"\";%'";
        
        $this->CakeSessionModel->query($qry);
        
        $this->write('All dummy sessions erased successfuly.');
        
        $this->markEnd();
    }

}
