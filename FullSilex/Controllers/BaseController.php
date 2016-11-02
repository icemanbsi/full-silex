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

    public function action(Request $request, FullSilexApplication $app, $method = ""){
        session_start();

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

    protected function setDefaultAssign(){

        $classes = explode("\\", get_called_class());
        $activeMainMenu = lcfirst(str_replace("Controller", "", $classes[count($classes) - 1]));

        return array(
            'baseUrl' => $this->app->url("homepage"),
            'publicUrl' => $this->app->url("homepage") . "public/",
            'clientConfig' => array(
                'baseUrl' => $this->app->url("homepage"),
                'publicUrl' => $this->app->url("homepage") . "public/",
            ),
            'activeMainMenu' => $activeMainMenu
        );
    }

    protected function render($templateName, $assign = array()){
        $pos = strrpos($templateName,".twig");
        if($pos == -1 || $pos === false || $pos != strlen($templateName) - 5){
            $templateName .= ".twig";
        }

        $paths = explode("/", $templateName);
        if(count($paths) == 1) {

            $classes = explode("\\", get_called_class());
            $classes[count($classes) - 1] = str_replace("Controller", "", $classes[count($classes) - 1]);
            if(count($classes) > 2) {
                unset($classes[0]);
                unset($classes[1]);
            }

            $templateName = strtolower(implode("/", $classes)) . "/" . $templateName;

        }

        $assign = array_merge($this->setDefaultAssign(), $this->setAdditionalAssign(), $assign);

        return $this->app->getTemplateEngine()->render($templateName, $assign);
    }

    public function setMessage($message, $as = 'message') {
        $_SESSION[$as] = $message;
    }

    public function getMessage($as = 'message'){
        return isset($_SESSION[$as]) ? $_SESSION[$as] : "";
    }

    public function showMessage($as = 'message') {
        $message = $this->getMessage($as);
        unset($_SESSION[$as]);
        return $message;
    }

    //Overrides Methods
    protected function beforeAction(){
        return "";
    }

    protected function setAdditionalAssign(){
        return array();
    }
}