<?php

/**
 * Description of AcLucsComponent
 *
 * @author Lucas Moretti
 * morettilucas@hotmail.com
 */
App::import('Lib', 'AcLucs');

class AcLucsComponent extends Component {

    function initialize(Controller $controller) {
        $this->controller = $controller;
                
        AcLucs::$allowed_user_types = array(
            'Admin',
            'Empresa',
            'EmpresaAdmin',
            'Usuario'
        );
        
        //======================================================================
        //public
        //======================================================================
        AcLucs::$user_allowed_actions['public'][''][] = '';
        AcLucs::$user_allowed_actions['public']['admin'][] = 'index';
        AcLucs::$user_allowed_actions['public']['admin'][] = 'login';
        AcLucs::$user_allowed_actions['public']['admin'][] = 'logout';
        AcLucs::$user_allowed_actions['public']['empresas'][] = 'index';
        AcLucs::$user_allowed_actions['public']['empresas'][] = 'login';
        AcLucs::$user_allowed_actions['public']['empresas'][] = 'logout';
        AcLucs::$user_allowed_actions['public']['empresas'][] = 'doRecover';
        AcLucs::$user_allowed_actions['public']['empresas'][] = 'recover';
        AcLucs::$user_allowed_actions['public']['empresas'][] = 'getThumb';
        AcLucs::$user_allowed_actions['public']['pages'][] = 'display';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'activate';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'add';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'doRecover';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'index';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'login';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'logout';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'recover';
        AcLucs::$user_allowed_actions['public']['usuarios'][] = 'getThumb';
        AcLucs::$user_allowed_actions['public']['conductors'][] = 'getThumb';
        AcLucs::$user_allowed_actions['public']['vehiculos'][] = 'getThumb';
        AcLucs::$user_allowed_actions['public']['api'][] = '*';
        AcLucs::$user_allowed_actions['public']['api'][] = 'clients';
        AcLucs::$user_allowed_actions['public']['api'][] = 'pendingViajes';
        AcLucs::$user_allowed_actions['public']['ivr_clientes'][] = 'getCliente';
        AcLucs::$user_allowed_actions['public']['ivr_clientes'][] = 'presiona1';
        AcLucs::$user_allowed_actions['public']['ivr_clientes'][] = 'presiona2';
        //======================================================================
        //usuario
        //======================================================================
        AcLucs::$user_allowed_actions['usuario']['calificacions'][] = 'puntuarViaje';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'add';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'changePass';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'edit';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'history';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'miPerfil';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'myReservs';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'reservation';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'resetThumb';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'uploadThumb';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'view';
        AcLucs::$user_allowed_actions['usuario']['usuarios'][] = 'delete';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'actualizar';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'add';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'cancelarReserva';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'cancelarViaje';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'cercanos';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'view';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'ajax_checkForPending';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'viewPending';
        AcLucs::$user_allowed_actions['usuario']['viajes'][] = 'canceled';
        //======================================================================
        //empresa
        //======================================================================
        AcLucs::$user_allowed_actions['empresa']['calificacions'][] = 'calificacionConductor';
        
        AcLucs::$user_allowed_actions['empresa']['conductors'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['conductors'][] = 'changePass';
        AcLucs::$user_allowed_actions['empresa']['conductors'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['conductors'][] = 'history';
        
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'habilitar';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'history';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'miPerfil';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'reservation';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'getReservasDif';

        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'resetThumb';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'uploadThumb';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'viewConductors';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'viewRelationships';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'visualization';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'apiKey';
        AcLucs::$user_allowed_actions['empresa']['empresas'][] = 'ChangePassword';

        AcLucs::$user_allowed_actions['empresa']['mapaTermicos'][] = 'index';
        AcLucs::$user_allowed_actions['empresa']['mapaTermicos'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['mapaTermicos'][] = 'delete';
        AcLucs::$user_allowed_actions['empresa']['mapaTermicos'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['mapaTermicos'][] = 'getEvents';
        
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'index';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'delete';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'getVehiculos';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'getIcon';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'mensajes';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'deshabilitar';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'habilitar';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'liquidacion';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'liquidar';
        AcLucs::$user_allowed_actions['empresa']['vehiculos'][] = 'inicio';

        AcLucs::$user_allowed_actions['empresa']['usuarios'][] = 'customerHistory';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'customerHistory';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'history';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'historyLast';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'historyDia';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'adminAdd';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'adminHistory';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'reasignar';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'adminCancelarViaje';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'createFromPendiente';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'ajaxGetDespachoPendientes';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'createFromDespachoPendiente';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'deleteDespachoPendiente';
        AcLucs::$user_allowed_actions['empresa']['viajes'][] = 'getIVRLlamadasEntrantes';
        AcLucs::$user_allowed_actions['empresa']['historialvcs'][] = 'closeSession';
        AcLucs::$user_allowed_actions['empresa']['localizacions'][] = 'panico';
        AcLucs::$user_allowed_actions['empresa']['localizacions'][] = 'resdif';
        AcLucs::$user_allowed_actions['empresa']['localizacions'][] = 'removePanico';
        AcLucs::$user_allowed_actions['empresa']['mensajes'][] = 'getMensajes';
        AcLucs::$user_allowed_actions['empresa']['mensajes'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['mensajes'][] = 'ajaxGetMensajes';
        AcLucs::$user_allowed_actions['empresa']['mensajes'][] = 'ajaxAceptarMensajes';
        AcLucs::$user_allowed_actions['empresa']['mjspredefinidos'][] = 'index';
        AcLucs::$user_allowed_actions['empresa']['mjspredefinidos'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['mjspredefinidos'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['mjspredefinidos'][] = 'delete';

        AcLucs::$user_allowed_actions['empresa']['ivr_clientes'][] = 'index';
        AcLucs::$user_allowed_actions['empresa']['ivr_clientes'][] = 'view';
        AcLucs::$user_allowed_actions['empresa']['ivr_clientes'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['ivr_clientes'][] = 'add';

        AcLucs::$user_allowed_actions['empresa']['ivr_domicilios'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['ivr_domicilios'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['ivr_domicilios'][] = 'delete';

        AcLucs::$user_allowed_actions['empresa']['viaje_programados'][] = 'index';
        AcLucs::$user_allowed_actions['empresa']['viaje_programados'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['viaje_programados'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['viaje_programados'][] = 'delete';

        AcLucs::$user_allowed_actions['empresa']['viaje_diferidos'][] = 'index';
        AcLucs::$user_allowed_actions['empresa']['viaje_diferidos'][] = 'add';
        AcLucs::$user_allowed_actions['empresa']['viaje_diferidos'][] = 'edit';
        AcLucs::$user_allowed_actions['empresa']['viaje_diferidos'][] = 'delete';
        //======================================================================
        //empresaAdmin
        //======================================================================
        AcLucs::$user_allowed_actions['empresaadmin']['operadors'][] = 'index';
        AcLucs::$user_allowed_actions['empresaadmin']['operadors'][] = 'add';
        AcLucs::$user_allowed_actions['empresaadmin']['operadors'][] = 'edit';
        AcLucs::$user_allowed_actions['empresaadmin']['operadors'][] = 'delete';
        AcLucs::$user_allowed_actions['empresaadmin']['operadors'][] = 'habilitar';
        AcLucs::$user_allowed_actions['empresaadmin']['operadors'][] = 'deshabilitar';
        AcLucs::$user_allowed_actions['empresaadmin']['operadors'][] = 'editConfigs';
        AcLucs::$user_allowed_actions['empresaadmin']['estadisticas'][] = 'index';
        AcLucs::$user_allowed_actions['empresaadmin']['estadisticas'][] = 'getData';
        //======================================================================
        //admin
        //======================================================================
        //AcLucs::$user_allowed_actions['admin'] = array_merge(AcLucs::$user_allowed_actions['usuario'], AcLucs::$user_allowed_actions['empresa']);
        AcLucs::$user_allowed_actions['admin']['usuarios'][] = 'deshabilitar';
        AcLucs::$user_allowed_actions['admin']['usuarios'][] = 'habilitar';
        AcLucs::$user_allowed_actions['admin']['conductors'][] = 'habilitar';
        AcLucs::$user_allowed_actions['admin']['conductors'][] = 'deshabilitar';
        AcLucs::$user_allowed_actions['admin']['empresas'][] = 'add';
        AcLucs::$user_allowed_actions['admin']['empresas'][] = 'deshabilitar';
        AcLucs::$user_allowed_actions['admin']['empresas'][] = 'habilitar';
        AcLucs::$user_allowed_actions['admin']['empresas'][] = 'edit';
        AcLucs::$user_allowed_actions['admin']['empresas'][] = 'view';
        AcLucs::$user_allowed_actions['admin']['empresas'][] = 'logInAsEmpresa';
        AcLucs::$user_allowed_actions['admin']['usuarios'][] = 'view';
        AcLucs::$user_allowed_actions['admin']['usuarios'][] = 'reservation';
        AcLucs::$user_allowed_actions['admin']['vehiculos'][] = 'deshabilitar';
        AcLucs::$user_allowed_actions['admin']['vehiculos'][] = 'habilitar';
        AcLucs::$user_allowed_actions['admin']['vehiculos'][] = 'liquidacion';
        AcLucs::$user_allowed_actions['admin']['vehiculos'][] = 'liquidar';
        AcLucs::$user_allowed_actions['admin']['vehiculos'][] = 'inicio';

        AcLucs::$user_allowed_actions['admin']['feriados'][] = 'index';
        AcLucs::$user_allowed_actions['admin']['feriados'][] = 'add';
        AcLucs::$user_allowed_actions['admin']['feriados'][] = 'edit';
        AcLucs::$user_allowed_actions['admin']['feriados'][] = 'delete';
        AcLucs::$user_allowed_actions['admin']['mantenimientos'][] = 'index';
        AcLucs::$user_allowed_actions['admin']['mantenimientos'][] = 'add';
        AcLucs::$user_allowed_actions['admin']['mantenimientos'][] = 'edit';
        AcLucs::$user_allowed_actions['admin']['mantenimientos'][] = 'delete';
        AcLucs::$user_allowed_actions['admin']['mantenimientos'][] = 'habilitar';
        AcLucs::$user_allowed_actions['admin']['mantenimientos'][] = 'deshabilitar';
        AcLucs::$user_allowed_actions['admin']['estadisticas'][] = 'regenerate';
        AcLucs::$user_allowed_actions['admin']['admin'][] = 'env';
        
    }

    function startup(Controller $controller) {
        if($controller->name != 'CakeError') {
            AcLucs::$user_types = $this->__getUserType();
            if (!AcLucs::haveAccess($controller->params['controller'], $controller->params['action'])) {
                if (Configure::read('debug') == 2) {
                    pr('<a href="' . AcLucs::$fall_back_url . '">' . AcLucs::$fall_back_url . '</a>');
                    foreach(AcLucs::$user_types as $user_type){
                        pr(sprintf("AcLucs::\$user_allowed_actions['%s']['%s'][] = '%s';", $user_type, $controller->params['controller'], $controller->params['action']));
                    }
                    pr($controller->params);
                    die('Acceso denegado');
                }
                $controller->Session->setFlash(__('Acceso denegado. Ud. no tiene acceso a esa area del sistema'), 'error');
                $controller->redirect(AcLucs::$fall_back_url);
            }
        }
    }

    private function __getUserType() {
        $user_types = array('public');
        foreach (AcLucs::$allowed_user_types as $type) {
            if ($this->controller->Session->check($type)){
                $user_types[] = strtolower($type);
            }
        }
        return $user_types;
    }

}
