<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com).
 * Date: 11/8/16
 * Time: 8:56 AM
 */

namespace FullSilex\Twig\Filters;


use FullSilex\Helpers\TextHelper;

class TranslatorFilter
{
    public static function modelTranslator($context, $string, $lang = ""){
        /** @var \App\Application $app */
        $app = $context['app'];

        if(empty($lang)){
            $lang = $app->getLanguage();
        }

        return TextHelper::modelTranslator($string, $lang);
    }
}