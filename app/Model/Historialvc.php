<?php

class Historialvc extends AppModel {

    var $name = 'Historialvc';
    var $belongsTo = array(
        'Conductor' => array('className' => 'Conductor', 'foreignKey' => 'conductor_id'),
        'Vehiculo' => array('className' => 'Vehiculo', 'foreignKey' => 'vehiculo_id')
    );
    public $recursive = -1;

    public function conductorVehiculo($id) {
        $relacion = $this->findByConductorIdAndFechaFin($id, null);
        if (empty($relacion)) {
            $relacion = null;
        } else {
            $vehiculo = $this->Vehiculo->findById($relacion['Historialvc']['vehiculo_id']);
            unset($relacion['Historialvc']['vehiculo_id']);
            $relacion['Historialvc']['Vehiculo'] = $vehiculo['Vehiculo']['patente'];
        }
        return $relacion['Historialvc'];
    }

    public function vehiculoConductor($id) {
        $relacion = $this->findByVehiculoIdAndFechaFin($id, null);
        if (empty($relacion)) {
            $relacion = null;
        } else {
            $conductor = $this->Conductor->findById($relacion['Historialvc']['conductor_id']);
            unset($relacion['Historialvc']['conductor_id']);
            $relacion['Historialvc']['Conductor'] = $conductor['Conductor']['apellido'] . ', ' . $conductor['Conductor']['nombre'];
        }
        return $relacion['Historialvc'];
    }

    public function closeSession($id, $empresa) {
        $options = array(
            'conditions' => array(
                'Historialvc.id' => $id,
                'Vehiculo.empresa_id' => $empresa['Empresa']['id']
            ),
            'joins' => array(
                array(
                    'alias' => 'Vehiculo',
                    'table' => 'vehiculos',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Vehiculo.id = Historialvc.vehiculo_id'
                    )
                ),
                array(
                    'alias' => 'Localizacion',
                    'table' => 'localizacions',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Vehiculo.id = Localizacion.vehiculo_id'
                    )
                )
            ),
            'fields' => '*'
        );
        $historialvlc = $this->find('first', $options);
        $result = false;
        if (!empty($historialvlc)) {
            $historialvlc['Historialvc']['id'] = $id;
            $historialvlc['Historialvc']['fecha_fin'] = date('Y-m-d');
            $historialvlc['Historialvc']['hora_fin'] = date('H:i:s');

            $result = $this->save($historialvlc['Historialvc']);
            $historialvlc['Localizacion']['estado'] = 'Fuera_de_linea';
            $result &= $this->Vehiculo->Localizacion->save($historialvlc['Localizacion']);
        }
        return $result;
    }

}

?>