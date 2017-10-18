<?php

/* TOOLSET BOX */

class Calculo {

    /**
     * Dada una direccion me devuelve las coordenadas (lat y long) de la misma.
     * @param string $direccion
     * @return array(lat, long)
     */
    public static function getCordenates($direccion) {
        $result = [
            0 => false,
            1 => false,
            'lat' => false,
            'long' => false
        ];
        if(!empty($direccion)) {
            $address = urlencode($direccion);
            $region = "ARG";
            $json = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDWz5paGiK-oElR-T2B8agIYktwhTEQvJA&address=$address&region=$region"));

            if($json->status === 'OK') {
                $result[0] = $result['lat'] = $json->results['0']->geometry->location->lat;
                $result[1] = $result['long'] = $json->results['0']->geometry->location->lng;
            }
        }

        return $result;
    }
}
