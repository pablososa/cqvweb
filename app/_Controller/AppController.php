<?php

App::import('Lib', 'Utils');

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $uses = array('File', 'Mantenimiento');
    public $components = array('Session', 'AcLucs', 'Mantenimientos', 'RequestHandler', 'Paginator', 'Filter', 'Geoip', 'GCMClient');
    public $helpers = array('Form', 'Html', 'Js' => 'Jquery');
    public $paginate = array(
        'page' => 1,
        'limit' => 25,
        'maxLimit' => 50,
        'paramType' => 'named'
    );
    protected $superEmpresaAction = array();
    protected $extra_classes = array();

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->isIframe = false;
        $this->paginate = array(
            'page' => 1,
            'limit' => 25,
            'maxLimit' => 50,
            'paramType' => 'named'
        );
        if (!empty($this->request->params['named']['isIframe'])) {
            $this->isIframe = true;
            $this->layout = 'iframe';
            $this->extra_classes[] = 'is-iframe';
        }
        $this->set('isIframe', $this->isIframe);
        $this->set('sessionUser', $this->Session->read('Usuario'));
        $this->set('sessionAdmin', $this->Session->read('Admin'));
        $this->set('sessionEmpresa', $this->Session->read('Empresa'));
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $this->set('extra_classes', implode(' ', $this->extra_classes));
    }

    protected function __getThumb($entity_id, $path, $default_path)
    {
        $path = $path . "/{$entity_id}/thumb.png";
        $thumb = $this->File->findByPath($path);
        header('Content-Type: image/png');
        if (empty($thumb)) {
            echo file_get_contents($default_path);
        } else {
            echo $thumb['File']['data'];
        }
        die;
    }

    public function redirect($url = null, $status = null, $exit = true)
    {
        if ($this->isIframe) {
            if (!empty($url)) {
                $url = Router::url($url);
            }
            echo '<script type="text/javascript">top.window.apptaxiweb.redirect("' . $url . '");</script>';
            exit;
        } else {
            if (empty($url)) {
                $url = $this->referer();
            }
            parent::redirect($url, $status, $exit);
        }
    }

}
