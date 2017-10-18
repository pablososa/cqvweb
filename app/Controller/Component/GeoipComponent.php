<?php

/**
 * Description of ApiComponent
 * Handles requests and responses of a simple api server for conquienviajeo.com.ar
 * @author Lucas Moretti
 * morettilucas@hotmail.com
 */
require_once APP . 'Vendor' . DS . 'autoload.php';
use GeoIp2\Database\Reader;

class GeoipComponent extends Component {

    private $ip;
    private $city_class;

    public function beforeRender(Controller $controller) {
//        CakeSession::delete('city_class');
        if(!CakeSession::check('city_class')) {
            $reader = new Reader(APP . 'Vendor' . DS . 'GeoLite2-City.mmdb');
            $this->ip = $controller->request->clientIp(false);
//            $this->ip = '190.57.235.2';
            try {
                $record = $reader->city($this->ip);
                $city = $record->city->name;
                $city = strtolower($city);
                $city = str_replace(' ', '-', $city);
            } catch (Exception $ex) {
                $city = '';
            }
            CakeSession::write('city_class', $city);
        }
        $this->city_class = CakeSession::read('city_class');
        $this->city_class = empty($this->city_class) ? $this->city_class : ' ' . $this->city_class;
        $controller->set('city_class', $this->city_class);
    }

}
