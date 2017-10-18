<?php

/* TOOLSET BOX */

class Utils {

    public static function datetize($date) {
        if(empty($date)) {
            return '';
        }
        return date('d/m/Y', strtotime($date));
    }

    public static function datetimetize($date) {
        if(empty($date)) {
            return '';
        }
        return date('d/m/Y H:i:s', strtotime($date));
    }

    public static function orEmpty($string) {
        return !empty($string) ? $string : '';
    }

    public static function cut($string, $len = 50) {
        $dots = strlen($string) > ($len - 3) ? '...' : '';
        return substr($string, 0, $len - 3) . $dots;
    }
    
    public static function randomStr($len = 40, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $str = '';
        $max = strlen($chars) - 1;
        for($i = 0;$i<$len;$i++){
            $str .= $chars{rand(0, $max)};
        }
        return $str;
    }
}
