<?php
/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 7/15/16
 * Time: 10:31 AM
 */

namespace App;

use FullSilex\Twig\Functions\PublicUrl;

class Application extends \FullSilex\Application
{
    protected $useDatabase          = false;
    protected $useMailer            = true;
    protected $useTranslator        = true;
    protected $useTemplateEngine    = true;

    protected function setControllerProviders(){
        $this->mount("/", new DefaultControllerProvider());
    }
}