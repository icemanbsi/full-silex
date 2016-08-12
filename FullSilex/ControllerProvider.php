<?php

/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 7/15/16
 * Time: 9:53 AM
 */

namespace FullSilex;

use Silex\Application as SilexApplication;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerProvider implements ControllerProviderInterface
{
    protected $app;

    //method to override
    protected function setUrlRules( $controllers ){
        /*
        EXAMPLE :
        --------------------
        $controllers
            ->match('/users/{method}', 'App\\Controllers\\Api\\UsersController::action')
            ->method('GET|POST');
        $controllers
            ->match('/campaigns/{method}', 'App\\Controllers\\Api\\CampaignsController::action')
            ->method('GET|POST');
        $controllers
            ->match('/workshops/{method}', 'App\\Controllers\\Api\\WorkshopsController::action')
            ->method('GET|POST');
        $controllers
            ->match('/utilities/{method}', 'App\\Controllers\\Api\\UtilitiesController::action')
            ->method('GET|POST');
        */
    }
    //--- end of method to override

    public function connect(SilexApplication $app)
    {
        $this->app = $app;

        $app->error([$this, 'error']);

        $controllers = $app['controllers_factory'];

        $this->setUrlRules($controllers);

        return $controllers;
    }

    public function error(\Exception $e, Request $request, $code){
        echo $code . " : " . $e->getMessage();
    }
}