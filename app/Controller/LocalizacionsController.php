<?php

class LocalizacionsController extends AppController {

    var $name = 'Localizacions';
    var $components = array(
        'Calculo'
    );

    function add($id = null) {
        $result = true;
        $empresa = $this->Session->read('Empresa');
        //me fijo si hay una empresa logueada
        if (!$empresa) {
            //si no hay error
            return false;
        }
        //establezco el id del vehiculo
        $this->Localizacion->Vehiculo->id = $id[0];
        //pregunto si existe el vehiculo
        if (!$this->Localizacion->Vehiculo->exists()) {
            //si no existe, error
            return false;
        }
        //si existe inicio la transaccion
        $this->Localizacion->begin();
        $localizacion['Localizacion']['vehiculo_id'] = $id[0];
        $localizacion['Localizacion']['estado'] = 'Fuera_de_linea';
        $localizacion['Localizacion']['localidad'] = 'Santa Fe';
        $coordenadas = $this->Calculo->getCordenates($empresa['Empresa']['direccion']);
        $localizacion['Localizacion']['latitud'] = $coordenadas[0];
        $localizacion['Localizacion']['longitud'] = $coordenadas[1];
        if ($this->Localizacion->save($localizacion)) {
            $this->Localizacion->commit();
            return true;
        } else {
            $this->Localizacion->rollback();
            return false;
        }
    }

    function getLocalization($id = null) {
        if (!is_null($id)) {
            $posicion = $this->query('select latitud, longitud from apptaxi_localizations where vehiculo_id = ' . $id . '; ');
            return $posicion;
        }
    }
    function resdif() {
        $empresa = $this->Session->read('Empresa');
        if(!empty($this->request->data)) {
            $this->Localizacion->verPanico($empresa['Empresa']['id'], $this->request->data['Vehiculo']['ids']);
//            $this->Localizacion->aceptarPanico($empresa['Empresa']['id'], ($this->request->data['Vehiculo']['ids']));
            $vehiculo_id = reset($this->request->data['Vehiculo']['ids']);
            $vehiculo_in_panic = $this->Localizacion->Vehiculo->findById($vehiculo_id);
            $this->redirect(array('controller' => 'empresas', 'action' => 'visualization', 'zoom_to' => $vehiculo_in_panic['Vehiculo']['nro_registro']));
        }
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa['Empresa']['id'],
                'panico' => true
            ),
            'joins' => array(
                array(
                    'alias' => 'Vehiculo',
                    'table' => 'vehiculos',
                    'type' => 'LEFT',
                    'conditions' => 'Vehiculo.id = Localizacion.vehiculo_id',
                )
            ),
            'fields' => array(
                'Localizacion.*',
                'Vehiculo.*'
            )
        );
        $this->Localizacion->recursive = -1;
        $vehiculos = $this->Localizacion->find('all', $options);
        $this->set(compact('empresa', 'vehiculos'));
    } 
    
    function panico() {
        $empresa = $this->Session->read('Empresa');
        if(!empty($this->request->data)) {
            $this->Localizacion->verPanico($empresa['Empresa']['id'], $this->request->data['Vehiculo']['ids']);
//            $this->Localizacion->aceptarPanico($empresa['Empresa']['id'], ($this->request->data['Vehiculo']['ids']));
            $vehiculo_id = reset($this->request->data['Vehiculo']['ids']);
            $vehiculo_in_panic = $this->Localizacion->Vehiculo->findById($vehiculo_id);
            $this->redirect(array('controller' => 'empresas', 'action' => 'visualization', 'zoom_to' => $vehiculo_in_panic['Vehiculo']['nro_registro']));
        }
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa['Empresa']['id'],
                'panico' => true
            ),
            'joins' => array(
                array(
                    'alias' => 'Vehiculo',
                    'table' => 'vehiculos',
                    'type' => 'LEFT',
                    'conditions' => 'Vehiculo.id = Localizacion.vehiculo_id',
                )
            ),
            'fields' => array(
                'Localizacion.*',
                'Vehiculo.*'
            )
        );
        $this->Localizacion->recursive = -1;
        $vehiculos = $this->Localizacion->find('all', $options);
        $this->set(compact('empresa', 'vehiculos'));
    }
    
    function removePanico($vehiculo_id) {
        $empresa = $this->Session->read('Empresa');
        if(!empty($this->request->data)) {
            $this->Localizacion->aceptarPanico($empresa['Empresa']['id'], $this->request->data['Vehiculo']['ids']);
            $this->redirect();
        }
        $options = array(
            'conditions' => array(
                'empresa_id' => $empresa['Empresa']['id'],
                'vehiculo_id' => $vehiculo_id,
                'panico' => true
            ),
            'joins' => array(
                array(
                    'alias' => 'Vehiculo',
                    'table' => 'vehiculos',
                    'type' => 'LEFT',
                    'conditions' => 'Vehiculo.id = Localizacion.vehiculo_id',
                )
            ),
            'fields' => array(
                'Localizacion.*',
                'Vehiculo.*'
            )
        );
        $this->Localizacion->recursive = -1;
        $vehiculos = $this->Localizacion->find('all', $options);
        $this->set(compact('empresa', 'vehiculos'));
    }
    
}