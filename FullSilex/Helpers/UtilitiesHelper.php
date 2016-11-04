<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com)
 * Date: 7/21/16
 * Time: 11:28 AM
 */

namespace FullSilex\Helpers;


class UtilitiesHelper
{
    public static function toCamelCase($dashedString, $ucFirst = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $dashedString)));
        if (!$ucFirst) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }

    public static function toHash($password, $salt, $globalSalt) {
        return md5($password . $salt . $globalSalt);
    }
}