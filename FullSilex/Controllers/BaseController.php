<?php
/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 7/19/16
 * Time: 10:30 AM
 */

namespace FullSilex\Controllers;

use FullSilex\Application as FullSilexApplication;
use Symfony\Component\HttpFoundation\Request;

class BaseController
{
    /** @var \FullSilex\Application $app  */
    protected $app;
    /** @var Request $request */
    protected $request;
    /** @var  String $currentAction */
    protected $currentAction;

    public function action(Request $request, FullSilexApplication $app, $method){
        $this->app = $app;
        $this->request = $request;

        if(empty($method)){
            $method = "index";
        }

        $this->currentAction =  $method;

        if (method_exists($this, $method)){
            $res = $this->beforeAction();
            if(empty($res)) {
                return $this->$method();
            }
            else{
                return $res;
            }
        }
        else{
            return $this->notFound();
        }
    }

    protected function notFound(){
        return "Method Not Found";
    }

    //Overrides Methods
    protected function beforeAction(){
        return "";
    }
}