<?php

App::uses('AppModel', 'Model');

class Provincia extends AppModel {

    var $name = 'Provincia';
    var $hasMany = array(
        'Localidad' => array('className' => 'Localidad')
    );
    
}