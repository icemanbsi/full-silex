<?php
/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 8/12/16
 * Time: 11:51 AM
 */

namespace FullSilex\Twig\Functions;


class UrlFunction
{
    public static function baseUrl($context, $string, $params = array()){
        /** @var \App\Application $app */
        $app = $context['app'];
        if(empty($string)){
            $string = "homepage";
        }
        $paths = explode("/", $string);
        if(count($paths) > 1) {
            $params["method"] = array_pop($paths);
            $route = implode("/", $paths);
        }
        else{
            $route = $string;
        }
        return $app->url($route, $params);
    }

    public static function publicUrl($context, $string, $params = array()){
        /** @var \App\Application $app */
        $app = $context['app'];
        return $app->url("homepage") . "public/" . $string . "?" . http_build_query($params);
    }
}