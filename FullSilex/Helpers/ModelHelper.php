<?php
/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 7/20/16
 * Time: 5:26 PM
 */

namespace FullSilex\Helpers;


use FullSilex\Models\BaseModel;

class ModelHelper
{
    /**
     * @param Array $objects
     * @return array
     */
    public static function objectsToArray($objects){
        $result = array();
        /** @var BaseModel $object */
        foreach($objects as $object){
            $result[] = $object->to_array();
        }

        return $result;
    }
}