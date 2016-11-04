<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com)
 * Date: 7/20/16
 * Time: 4:46 PM
 */

namespace FullSilex\Models\Repositories;


class BaseRepository
{
    /** @var  \FullSilex\Application  $app */
    protected $app;

    public function __construct($app){
        $this->app = $app;
    }
}