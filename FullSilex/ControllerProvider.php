<?php

/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com)
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
            ->match('/users/{method}', 'App\\Controllers\\UsersController::action')
            ->method('GET|POST')
            ->bind('users');
        $controllers
            ->match('/products/{method}', 'App\\Controllers\\SomeDirectory\\ProductsController::action')
            ->method('GET|POST')
            ->bind('someDirectory/products');

        //to use translation, you can add the locale name inside your url with {_locale}
        $controllers
            ->match('/{_locale}/products/{method}', 'App\\Controllers\\SomeDirectory\\ProductsController::action')
            ->method('GET|POST')
            ->bind('someDirectory/products');
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