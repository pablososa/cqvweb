<?php

class HistorialvcsController extends AppController {

    var $name = 'Historialvcs';

    public function closeSession($id) {
        $empresa = $this->Session->read('Empresa');
        $this->Historialvc->begin();
        if($this->Historialvc->closeSession($id, $empresa)) {
            $this->Historialvc->commit();
            $this->Session->setFlash(__('Se cerro la sesión'), 'success');
        } else {
            $this->Historialvc->rollback();
            $this->Session->setFlash(__('La sesión no pudo cerrarse. Intente nuevamente.'), 'success');
        }
        $this->redirect();
    }
}
