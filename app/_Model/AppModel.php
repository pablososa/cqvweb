<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    public $recursive = -1;
    public $actsAs = array('Containable');
    public $additionalFields = array();
    public static $__currentQueryType = null;

    public function sqlDump() {
        return $this->getDataSource()->getLog(false, false);
    }

    public function find($type = 'first', $query = array()) {
        AppModel::$__currentQueryType = $type;
        $result = parent::find($type, $query);
        AppModel::$__currentQueryType = null;
        return $result;
    }

    public function hasField($name, $checkVirtual = false) {
        if (is_array($name)) {
            return parent::hasField($name, $checkVirtual);
        }
        return parent::hasField($name, $checkVirtual) || in_array($name, $this->additionalFields);
    }

    protected function __uploadThumb($file, $entity_id, $path, $width = 80, $height = 80) {
        $result = false;
        if (Image::checkMimeType($file['type'])) {
            $path = $path . "/{$entity_id}/thumb.png";
            $data = Image::cropResize($file['tmp_name'], false, $width, $height);
            $this->File = ClassRegistry::init('File');
            $file = $this->File->findByPath($path);
            if (empty($file)) {
                $file = array('File' => array('path' => $path));
            }
            $file['File']['data'] = $data;
            $result = $this->File->save($file);
        }

        return $result;
    }


    public function activate($id) {
        $this->id = $id;
        return $this->saveField('estado', 'Habilitado');
    }

    public function deactivate($id) {
        $this->id = $id;
        return $this->saveField('estado', 'Deshabilitado');
    }
}
