<?php
/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 7/20/16
 * Time: 4:46 PM
 */

namespace App\Models\Repositories;


class BaseRepository
{
    /** @var  \FullSilex\Application  $app */
    protected $app;

    public function __construct($app){
        $this->app = $app;
    }
}