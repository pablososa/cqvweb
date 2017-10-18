<?php

/**
 * Description of MantenimientoComponent
 *
 * @author Lucas Moretti
 * morettilucas@hotmail.com
 */
App::import('Lib', 'AcLucs');

class MantenimientosComponent extends Component {

    function beforeRender(Controller $controller) {
        $showable_mantenimientos = array();
        if($controller->Session->check('Empresa') || !empty($controller->params['named']['mantenimiento_preview'])) {
            $mantenimiento_preview = null;
            if(!empty($controller->params['named']['mantenimiento_preview'])) {
                $mantenimiento_preview = $controller->params['named']['mantenimiento_preview'];
            }
            $showable_mantenimientos = $controller->Mantenimiento->getShowables($mantenimiento_preview);
        }
        $controller->set(compact('showable_mantenimientos'));
    }

}
