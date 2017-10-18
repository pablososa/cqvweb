<?php

class Localizacion extends AppModel
{

    var $name = 'Localizacion';
    var $belongsTo = array('Vehiculo' => array('className' => 'Vehiculo', 'foreignKey' => 'vehiculo_id'));

    public function getCercanos($viaje, $limit = '10', $get_list = true)
    {
        $empresa_id_cond = empty($viaje['Viaje']['empresa_id']) ? '' : ' AND Vehiculo.empresa_id = ' . $viaje['Viaje']['empresa_id'];
        $qry_limit = empty($limit) ? '' : "LIMIT {$limit}";
        $tipo_de_auto = empty($viaje['Viaje']['tipo_de_auto']) ? '' : "AND Vehiculo.tipo_de_auto = '{$viaje['Viaje']['tipo_de_auto']}'";
        $rango_distancia = 300000000;
//        $rango_distancia = 30000000000;

        $qry = <<<SQL
        SELECT (acos(sin(latitud*pi()/180) * sin({$viaje['Viaje']['latitud_origen']} * pi()/180) + cos(latitud*pi()/180) * cos({$viaje['Viaje']['latitud_origen']} * pi()/180) * cos(longitud*pi()/180 - ({$viaje['Viaje']['longitud_origen']} )*pi()/180) ) * 6370947)  AS distancia, Vehiculo.*
        FROM apptaxi_localizacions AS Localizacion
        INNER JOIN apptaxi_vehiculos AS Vehiculo ON Localizacion.vehiculo_id = Vehiculo.id
        INNER JOIN apptaxi_historialvcs AS Historialvc ON Localizacion.vehiculo_id = Historialvc.vehiculo_id
        WHERE Localizacion.estado = "Libre"
            AND Vehiculo.habilitado = "Habilitado"
            {$tipo_de_auto}
            AND Historialvc.fecha_fin IS NULL
            AND (acos(sin(latitud*pi()/180) * sin({$viaje['Viaje']['latitud_origen']} * pi()/180) + cos(latitud*pi()/180) * cos({$viaje['Viaje']['latitud_origen']} * pi()/180) * cos(longitud*pi()/180 - ({$viaje['Viaje']['longitud_origen']} )*pi()/180) ) * 6370947) < {$rango_distancia}
        {$empresa_id_cond}
        ORDER BY distancia ASC
        {$qry_limit};
SQL;

        $vehiculos = $this->query($qry);

        $cercanos = array();
        foreach ($vehiculos as $vehiculo) {
            $cercanos[] = $vehiculo['Vehiculo']['id'];
        }
        if (empty($cercanos)) {
            $cercanos[] = "126";
        }

        if ($get_list) {
            $cercanos = implode(',', $cercanos);
        }
        return $cercanos;
    }

    public function getByVehiculoId($vehiculo_id)
    {
        $options = array(
            'conditions' => array(
                'vehiculo_id' => $vehiculo_id,
            )
        );
        return $this->find('first', $options);
    }

    public function verPanico($empresa_id, $ids)
    {
        $this->recursive = -1;
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa_id,
                'id' => $ids
            ),
            'fields' => array('id', 'id')
        );
        $vehiculo_ids = $this->Vehiculo->find('list', $options);

        $fields = array(
            'Localizacion.panico_visto' => true
        );
        $conditions = array(
            'Localizacion.vehiculo_id' => $vehiculo_ids
        );
        return $this->updateAll($fields, $conditions);
    }

    public function aceptarPanico($empresa_id, $ids)
    {
        $this->recursive = -1;
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa_id,
                'id' => $ids
            ),
            'fields' => array('id', 'id')
        );
        $vehiculo_ids = $this->Vehiculo->find('list', $options);

        $fields = array(
            'Localizacion.panico' => false,
            'Localizacion.panico_visto' => false
        );
        $conditions = array(
            'Localizacion.vehiculo_id' => $vehiculo_ids
        );
        return $this->updateAll($fields, $conditions);
    }

}
