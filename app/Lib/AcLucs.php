<?php

/**
 * Description of AcLucs
 *
 * @author Lucas Moretti
 * morettilucas@hotmail.com
 */

class AcLucs {

    private static $allow_everything = false;
    public static $fall_back_url = '/';
    public static $user_allowed_actions = array();
    public static $allowed_user_types = array();
    public static $user_types; /** logged user_types **/

    /**
     * checkeo si el tipo de usuario actual tiene permiso sobre esa acción
     * @param $controller
     * @param null $action
     * @param null $prefix
     * @return bool
     */
    public static function haveAccess($controller, $action = null, $prefix = null) {
        if (!is_array($controller)) {
            $urls = array(
                array(
                    'controller' => $controller,
                    'action' => $action
                )
            );
        } else {
            $urls = $controller;
            $prefix = $action;
        }
        $prefix = empty($prefix) ? '' : "{$prefix}_";
        foreach(AcLucs::$user_types as $user_type) {
            $user_type = strtolower($user_type);
            foreach ($urls as $url) {
                $controller = $url['controller'];
                $action = $prefix . $url['action'];
                if (isset(AcLucs::$user_allowed_actions[$user_type]) and isset(AcLucs::$user_allowed_actions[$user_type][$controller])) {
                    if (in_array($action, AcLucs::$user_allowed_actions[$user_type][$controller]) or in_array('*', AcLucs::$user_allowed_actions[$user_type][$controller])) {
                        return true;
                    }
                }
            }
        }
        return AcLucs::$allow_everything;
    }

}
