<?php

/**
 * Description of ApiComponent
 * Handles requests and responses of a simple api server for conquienviajeo.com.ar
 * @author Lucas Moretti
 * morettilucas@hotmail.com
 */
App::import('Lib', 'AcLucs');
App::uses('HttpSocket', 'Network/Http');

class ApiComponent extends Component {

    private $server = false;
    public $results = array();
    public $errors = array();
    public $serverUrl = '';

    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
        if (!empty($settings['type']) && $settings['type'] == 'server') {
            $this->server = true;
        } else {
            if(!empty($settings['serverUrl'])) {
                $this->serverUrl = $settings['serverUrl'];
            } else {
                trigger_error('You need to privide serverUrl to the ApiComponent or set type parameter to server', E_USER_WARNING);
            }
        }
    }

    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    public function startup(Controller $controller) {
        if ($this->server) {
            if(!empty($controller->request->params['named']['empresa_id'])) {
                $this->empresa_id = $controller->request->params['named']['empresa_id'];
            } else {
                $this->errors[] = 'Missing parameter empresa_id';
                $this->renderResponse();
            }
            if(!empty($controller->request->params['named']['signature'])) {
                $this->signature = $controller->request->params['named']['signature'];
            } else {
                $this->errors[] = 'Missing parameter signature';
                $this->renderResponse();
            }
            $this->Empresa = $controller->Empresa;
            $this->setEmpresa();
            if ($this->authorizeRequest()) {
                $this->publicKey = $controller->request;
            } else {
                $this->errors[] = 'Unauthorized request';
                $this->renderResponse();
            }
        }
    }

    private function setEmpresa() {
        $options = array(
            'conditions' => array(
                'Empresa.id' => $this->empresa_id
            ),
            'recursive' => -1
        );
        $this->empresa_db = $this->Empresa->find('first', $options);
    }

    public function beforeRender(Controller $controller) {
        if ($this->server) {
            $this->renderResponse();
        }
    }

    public function getSecretKey($empresa_base = null) {
        if (empty($empresa_base)) {
            $empresa_base = $this->empresa_db;
        }
        $empresa = array(
            'id' => $empresa_base['Empresa']['id'],
            'email' => $empresa_base['Empresa']['email'],
            'fecha_ini_act' => $empresa_base['Empresa']['fecha_ini_act'],
        );
        return sha1(implode(Configure::read('Security.api.salt'), $empresa));
    }

    public function getSiganture($params) {
        if($this->server) {
            $secret_key = $this->getSecretKey();
        } else {
            $secret_key = $this->secretKey;
        }
        $keys = array(date('Y-m-d'));
        foreach ($params as $param_key => $param_value) {
            if (is_array($param_value)) {
                foreach ($param_value as $key => $value) {
                    if ($key !== 'signature') {
                        $keys[] = $key . '' . $value;
                    }
                }
            } else {
                $keys[] = $param_key . $param_value;
            }
        }
        $key = implode($secret_key, $keys);
        return sha1($key);
    }

    public function authorizeRequest() {
        $spected_signature = $this->getSiganture($this->controller->request->params);
        return $spected_signature == $this->signature;
    }

    public function parseResponse($response) {
        $response = unserialize($response);
        $this->results = $response['results'];
        $this->errors = $response['errors'];
        
        return $this->results;
    }
    
    public function renderResponse() {
        $result = array(
            'results' => $this->results,
            'errors' => $this->errors
        );
        echo serialize($result);
        exit;
    }

    public function makeRequest($url) {
        $params = array(
            'plugin' => '',
            'controller' => '',
            'action' => '',
            'named' => array(),
            'pass' => array(),
            'isAjax' => '',
        );
        foreach ($url as $name => $value) {
            if ($name === 'controller') {
                $params['controller'] = $value;
            } elseif ($name === 'action') {
                $params['action'] = $value;
            } elseif (is_numeric($name)) {
                $params['pass'][] = $value;
            } else {
                $params['named'][$name] = $value;
            }
        }
        $url['signature'] = $this->getSiganture($params);
        return $url;
    }
    
    public function doRequest($url) {
        $url = $this->makeRequest($url);
        $url = $this->serverUrl . Router::url($url);
        $HttpSocket = new HttpSocket();
        $response = $HttpSocket->get($url);
        return unserialize($response->body);
    }
}
