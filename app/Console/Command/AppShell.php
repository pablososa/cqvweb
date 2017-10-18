<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppShell
 *
 * @author lucs
 */

App::import('Lib', 'Utils');

class AppShell extends Shell
{
    protected $runHash = '';
    
    public function startup()
    {
        $this->runHash = Utils::randomStr(8);
        $this->start();
    }

    public function start() {

    }

    protected function write($text, $decorate = false)
    {
        $decorations = $decorate ? $this->runHash . ' ' . str_pad('', 80, '-') . PHP_EOL : '';
        echo $decorations . $this->runHash . ' - ' . date('Y-m-d H:i:s') . ' - ' . $text . PHP_EOL . $decorations;
    }
    
    protected function markIni() {
        $this->write(__CLASS__ . ' started', true);
    }
    
    protected function markEnd() {
        $this->write(__CLASS__ . ' finished', true);
    }

}
