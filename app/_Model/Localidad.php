<?php

App::uses('AppModel', 'Model');

class Localidad extends AppModel {

    var $name = 'Localidad';
    var $useTable = 'localidades';
    var $belongsTo = array(
        'Provincia' => array('className' => 'Provincia', 'foreignKey' => 'provincia_id')
    );
    
}