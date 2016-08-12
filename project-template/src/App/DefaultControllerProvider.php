<?php

/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 7/15/16
 * Time: 9:53 AM
 */

namespace App;

use Silex\Application as SilexApplication;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerProvider extends \FullSilex\ControllerProvider
{
    protected function setUrlRules($controllers)
    {
        $controllers
            ->match('/', 'App\\Controllers\\HomeController::action')
            ->method('GET|POST')
            ->bind('homepage');

        // $controllers
        //     ->match('/about/{method}', 'App\\Controllers\\AboutController::action')
        //     ->method('GET|POST')
        //     ->bind('about');
    }
}