<?php
App::import('Lib', 'Calculo');

class CalculoComponent extends Component {

    //calcula la tarifa aproximada
    function price($distancia) {
        $bandera = 9;

        return $bandera + ($distancia / 100) * 0.9;
    }

    // persona es un arreglo que tiene la latitud y la longitud de la ubicacion de la persona
    // taxis es un arreglo con todos los taxis libres, y de cada uno tiene los datos del vehiculo, la posicion y los datos del conductor

    function assignTaxi($persona, $taxis) {
        foreach ($taxis as $taxi):
            // distancia es un arreglo que tiene los datos del vehiculo, del conductor, de la posicion y la distancia hacia el lugar
            // donde se hizo el pedido 
            $distancias[] = array($taxi['v']['id'], $this->distance($persona['0'], $taxi['l']));
        endforeach;

        // minimun me devuelve el elemento cuya distancia sea la mas corta
        $taxi = $this->minimun($distancias);
        $resultado = array();
        $resultado['vehiculo_id'] = $taxi['0'];
        $resultado['distancia'] = $taxi['1'];

        return $resultado;
    }

    //devuelve los datos del taxi que este mas cerca
    function minimun($distancias) {
        // la distancia esta en el tercer elemento es decir $distancias[]['2']
        $minimo = array($distancias['0']['0'], $distancias['0']['1']);
        foreach ($distancias as $distancia) {
            if ($distancia['1'] < $minimo['1']) {
                $minimo['0'] = $distancia['0'];
                $minimo['1'] = $distancia['1'];
            }
        }
        return $minimo;
    }

    // calcula el tiempo de espera
    function timeOut($persona, $taxi) {
        $distancia = $this->distance($persona, $taxi);
        //distancia es la distancia desde el taxi hasta la casa desde la cual se efectua la reserva dada en metros.
        // 1 kh/h equivalen a 1/3.6 m/s
        //Velocidad en metros/segundo

        $velocidad = 40 * (1 / 3.6);

        $tiempo = $distancia / $velocidad;

        $tiempo += 60 * ($distancia / 200);

        $minutos = intval($tiempo / 60);

        $segundos = $tiempo % 60;

        return array($minutos, $segundos);

        //Calculado teniendo en cuenta que un taxi iría en promedio a una velocidad de 40 km/h
    }
    
    public function distanceBetweenCoordinates($lat_origen, $lng_origen, $lat_destino, $lng_destino) {
        $distancia = 0;
        if($lat_origen != $lat_destino || $lng_origen != $lng_destino) {// si los dos puntos coinciden la formula falla
            $lat_org = $lat_origen * pi() / 180;
            $long_org = $lng_origen * pi() / 180;

            $lat_des = $lat_destino * pi() / 180;
            $long_des = $lng_destino * pi() / 180;

            //Calculo la distancia
            $distancia = 6371000 * acos(sin($lat_des) * sin($lat_org) + cos($lat_des) * cos($lat_org) * cos($long_des - $long_org));
        }

        return $distancia;
    }

    //calcula la distancia entre $origen y $destino en metros
    public function distanceBetweenDirections($origen, $destino) {
        $cor_origen = $this->getCordenates($origen);
        $cor_destino = $this->getCordenates($destino);

        return $this->distanceBetweenCoordinates($cor_origen['0'], $cor_origen['1'], $cor_destino['0'], $cor_destino['1']);
    }

    // devuelve las cordenadas (latitud y longitud) de una direccion
    function getCordenates($direccion) {
        return Calculo::getCordenates($direccion);
        //dada una direccion me devuelve las coordenadas (lat y long) de la misma.

        $address = str_replace(" ", "+", $direccion);
        $region = "ARG";
        $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDWz5paGiK-oElR-T2B8agIYktwhTEQvJA&address=$address&sensor=false&region=$region");
        $json = json_decode($json);
        $lat = $json->{'results'}['0']->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}['0']->{'geometry'}->{'location'}->{'lng'};

        return array(
            0 => $lat,
            1 => $long,
            'lat' => $lat,
            'long' => $long
        );
    }

    /**
     * Devuelve la dirección de una cordenadas (latitud y longitud)
     * @param int $lat
     * @param int $lng
     * @return string
     */
    function getAddress($lat, $lng) {
        $latlng = $lat . ',' . $lng;
        $region = "ARG";
        $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDWz5paGiK-oElR-T2B8agIYktwhTEQvJA&latlng=$latlng&sensor=false&region=$region");
        $json = json_decode($json);

        $result = null;
        if (!empty($json->results[0]->formatted_address)) {
            $result = $json->results[0]->formatted_address;
            preg_match('/[0-9]{1,5}-[0-9]{1,5}/', $result, $altura);
            $altura = array_shift($altura);
            if (!empty($altura)) {
                $mid = explode('-', $altura);
                $mid = array_sum($mid) / count($mid);
                $result = str_replace($altura, $mid, $result);
            }
            $parts = explode(',', $result);
            if (count($parts) > 3) {
                unset($parts[2]);
                $result = implode(',', $parts);
            }
        }
        return $result;
    }

    //valida que una direccion exista
    function validateDirections($direction1, $direction2) {
        if (empty($direction1) || empty($direction2)) {
            return false;
        }

        $coor_org = $this->getCordenates($direction1);
        $coor_des = $this->getCordenates($direction2);

        if ($coor_org['0'] == null || $coor_org['1'] == null || $coor_des['0'] == null || $coor_des['1'] == null) {
            return false;
        } else {
            return true;
        }
    }

}
