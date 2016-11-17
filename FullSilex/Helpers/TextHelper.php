<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com)
 * Date: 7/19/16
 * Time: 3:50 PM
 */

namespace FullSilex\Helpers;


class TextHelper
{
    public static function camelCaseToSentenceCase($string){
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return ucfirst(implode(' ', $ret));
    }

    public static function isJson($string)
    {
        try {
            $json = json_decode($string, true);
            return !empty($json) && is_array($json);
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public static function modelTranslator($json, $lang){
        if (TextHelper::isJson($json)) {
            $array = json_decode($json, true);
            return isset($array[$lang]) ? $array[$lang] : "";
        }
        else {
            return $json;
        }
    }

}