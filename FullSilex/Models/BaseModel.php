<?php
/**
 * Created by PhpStorm.
 * User: Trio-1602
 * Date: 7/19/16
 * Time: 10:25 AM
 */

namespace FullSilex\Models;

use ActiveRecord\Model;
use FullSilex\Application;

class BaseModel extends Model
{
    public static $hiddenFields   = array();
    public static $jsonFields     = array();
    public static $imageFields    = array();

    /** @var  \FullSilex\Application $app */
    protected $app;

    public function __construct(array $attributes=array(), $guard_attributes=true, $instantiating_via_find=false, $new_record=true) {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);

        $this->setApp(Application::getInstance());
    }

    public function setApp($app){
        $this->app = $app;
    }

    /**
     * For more informations about validations,
     * please visit http://www.phpactiverecord.org/projects/main/wiki/Validations
    */
    static $validates_presence_of = array(
        //array('columnName'),
        //array('title', 'message' => 'cannot be blank on a book!', 'on' => 'create')
    );

    static $validates_size_of = array(
        //array('title', 'within' => array(1,5), 'too_short' => 'too short!'),
        //array('cover_blurb', 'is' => 20),
        //array('description', 'maximum' => 10, 'too_long' => 'should be short and sweet')
    );

    static $validates_length_of = array(
        //array('title', 'within' => array(1,5), 'too_short' => 'too short!'),
        //array('cover_blurb', 'is' => 20),
        //array('description', 'maximum' => 10, 'too_long' => 'should be short and sweet')
    );

    static $validates_inclusion_of = array(
        //array('fuel_type', 'in' => array('petroleum', 'hydrogen', 'electric'))
    );

    static $validates_exclusion_of = array(
        //array('fuel_type', 'in' => array('petroleum', 'hydrogen', 'electric'))
    );

    static $validates_format_of = array(
        //array('email', 'with' => '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/'),
        //array('password', 'with' => '/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message' => 'is too weak')
    );

    static $validates_numericality_of = array(
        //array('price', 'greater_than' => 0.01),
        //array('quantity', 'only_integer' => true),
        //array('shipping', 'greater_than_or_equal_to' => 0),
        //array('discount', 'less_than_or_equal_to' => 5, 'greater_than_or_equal_to' => 0)
    );

    static $validates_uniqueness_of = array(
        //array('name'),
        //array(array('blah','bleh'), 'message' => 'blah and bleh!')
    );

    public function validate()
    {
        //if ($this->first_name == $this->last_name)
        //{
        //    $this->errors->add('first_name', "can't be the same as Last Name");
        //    $this->errors->add('last_name', "can't be the same as First Name");
        //}
    }

    public function errorMessages($glue = '\n'){
        return implode($glue, $this->errors->full_messages());
    }
}