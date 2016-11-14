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

    // Change "false" or "0" or '' to false, others to true (yes, -1 is true, see http://stackoverflow.com/questions/137487/null-vs-false-vs-0-in-php).
    public static function toBoolean($status) {
        if (in_array($status, array('', '0', 'false', 0, false, null), true)) {
            return false;
        }
        else {
            return true;
        }
    }
}