<?php
/**
 * Created by PhpStorm.
 * User: bobbystenlyirawan
 * Date: 11/19/16
 * Time: 1:33 PM
 */

namespace FullSilex\Helpers;


class BaseApplicationHelper
{
    protected $app;

    public function  __construct($app) {
        $this->app = $app;
    }

    public function setApp($app){
        $this->app = $app;
    }
}