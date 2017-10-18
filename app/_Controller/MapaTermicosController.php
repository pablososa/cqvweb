<?php

class MapaTermicosController extends AppController {
    public $helpers = array ('Html','Form');   
    
    function index() {
        $empresa = $this->Session->read('Empresa');
        $admin = $this->Session->check('Admin');

        $this->configureFilter();
        $this->Filter->controller = $this;
        $this->Filter->makeConditions();
       
        $mapatermicos = $this->Paginator->paginate('MapaTermico');
        //los paso a la vista
        $this->set(compact('empresa', 'mapatermicos'));
    }

      private function configureFilter() {
        $this->Filter->configuration = array(
            'MapaTermico' => array(
                'buscar' => array(
                    'function' => 'multipleLike',
                    'fields' => array(
                        'descripcion',
                        'localidad',
                        'cant_personas'
                    )
                )
            )
        );
    }


function add() {
        $empresa = $this->Session->read('Empresa');
        $admin = $this->Session->read('Admin');
        if ($admin) {
            //si el admin esta logueado paso los datos a la vista
            $this->set('admin', $admin);
        }
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);
        //me fijo si se enviaron datos
        if ($this->request->data) {
            //si coinciden creo el conductor
            $this->MapaTermico->create();
            //inicio la transaccion
            $this->MapaTermico->begin();

            //coordenadas
            $direccion = $this->request->data['Evento']['direccion'];
            $lat = 0;
            $long = 0;
            $address = urlencode($direccion);
            $region = "";
            $json = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDWz5paGiK-oElR-T2B8agIYktwhTEQvJA&address=$address&sensor=false&region=$region"));
            
            if($json->status === 'OK') {
                $lat = $json->results['0']->geometry->location->lat;
                $long = $json->results['0']->geometry->location->lng;
            }

            $this->request->data['Evento']['latitud'] = $lat;
            $this->request->data['Evento']['longitud'] = $long;

            //pregunto si se guardaron los datos correctamente
            if ($this->MapaTermico->save($this->request->data['Evento'])) {
                    //no mando una foto para el perfil, confirmo la transaccion
                    $this->MapaTermico->commit();
                    //informo por pantalla
                    $this->Session->setFlash(__('El evento ha sido guardado exitosamente.'), 'success');
                    $this->redirect(
                            array(
                                'controller' => 'mapaTermicos',
                                'action' => 'index'
                            )
                    );
                
            }
            //si ocurrio algun error, deshago la transaccion
            $this->MapaTermico->rollback();
            //informo por pantalla
            $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
        }
    }

    

    function edit($id = null) {
        $empresa = $this->Session->read('Empresa');
        $admin = $this->Session->read('Admin');
        if ($admin) {
            //si el admin esta logueado paso los datos a la vista
            $this->set('admin', $admin);
        }
        //paso los datos de la empresa a la vista
        $this->set('empresa', $empresa);
        //busco el conductor
        $mapatermico = $this->MapaTermico->findById($id);
        //me fijo que exista
        if (!$mapatermico) {
            //si no existe informo por pantalla
            $this->Session->setFlash(__('El evento no existe.'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'mapaTermicos',
                        'action' => 'index'
                    )
            );
        }
        //me fijo si se enviaron datos
        if ($this->request->data) {
            //si se enviaron, inicio la transaccion
            $this->MapaTermico->begin();
           
            //coordenadas
            $direccion = $this->request->data['MapaTermico']['direccion'];
            $lat = 0;
            $long = 0;
            $address = urlencode($direccion);
            $region = "";
            $json = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDWz5paGiK-oElR-T2B8agIYktwhTEQvJA&address=$address&sensor=false&region=$region"));
            
            if($json->status === 'OK') {
                $lat = $json->results['0']->geometry->location->lat;
                $long = $json->results['0']->geometry->location->lng;
            }

            $this->request->data['MapaTermico']['latitud'] = $lat;
            $this->request->data['MapaTermico']['longitud'] = $long;

            $result = $this->MapaTermico->save($this->request->data);
            if ($result) {
                    $this->MapaTermico->commit();
                    //informo por pantalla
                    $this->Session->setFlash(__('The changes have been saved successfully.'), 'success');
                    $this->redirect(
                            array(
                                'controller' => 'mapaTermicos',
                                'action' => 'index'
                            )
                    );
                }
            
            //si ocurrio un error, deshago la transaccion
            $this->MapaTermico->rollback();
            //informo por pantalla
            $this->Session->setFlash(__('Ha ocurrido un error. Por favor, inténte nuevamente.'), 'error');
        } else {
            //si no se enviaron, completo el formulario con los datos viejos
            $this->request->data = $this->MapaTermico->findById($id);
   
        }
      
    }

    function delete($id = null) {
    $this->MapaTermico->id = $id;
        if (!$this->MapaTermico->exists()) {
            throw new NotFoundException(__('Evento inválido'));
        }
        $result = $this->MapaTermico->begin();
        $result &= $this->MapaTermico->delete();
        if ($result) {
            $this->MapaTermico->commit();
            $this->Session->setFlash(__('El evento ha sido eliminado con exito'), 'success');
        } else {
            $this->MapaTermico->rollback();
            $this->Session->setFlash(__('El evento no pudo ser borrado. Por favor, intente nuevamente.'), 'error');
        }
        $this->redirect(array('controller' => 'mapaTermicos', 'action' => 'index'));
   
    }

    function getEvents() {
      $this->autoRender = false;
      $res = $this->MapaTermico->find('all');

      header('Content-Type: application/json');
      return json_encode($res);
   
    }


}
