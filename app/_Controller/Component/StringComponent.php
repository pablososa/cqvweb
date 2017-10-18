<?php

class StringComponent extends Component {

    function generate($numerodeletras = 10) {
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
        $cadena = ""; //variable para almacenar la cadena generada
        for ($i = 0; $i < $numerodeletras; $i++) {
            $cadena .= substr($caracteres, rand(0, strlen($caracteres)), 1); /* Extraemos 1 caracter de los caracteres 
              entre el rango 0 a Numero de letras que tiene la cadena */
        }
        return $cadena;
    }

    function horario() {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $hora = date("h");
        $minuto = date("i");
        $meridiano = date("a");
        return array($hora, $minuto, $meridiano);
    }

    function fecha() {
        $dia = date("d");
        $mes = date("m");
        $año = date("Y");
        return array($dia, $mes, $año);
    }

    //valida que no se use una hora que ya paso
    function validar($reservah, $reservaf) {
        list($añor, $mesr, $diar) = split('[/.-]', $reservaf);
        list($horar, $minr) = split('[:]', $reservah);
        list($dia, $mes, $año) = $this->fecha();
        list($hora, $min, $mer) = $this->horario();

        $result = false;
        $hoy = false;

        //es una fecha valida?
        if (($añor >= $año) && ($mesr >= $mes) && ($diar >= $dia)) {
            //es hoy?
            if (($añor == $año) && ($mesr == $mes) && ($diar == $dia)) {
                $hoy = true;
            }
            if ($hoy) {
                //es hoy
                //verifico que sea una hora valida, y no una que ya pasó.
                if (($horar >= $hora) || ($horar == $hora && $minr > $min)) {
                    $result = true;
                }
            } else {
                //es otro dia
                $result = true;
            }
        }
        return $result;
    }

}
