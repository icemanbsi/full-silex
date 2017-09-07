<?php

/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com)
 * Date: 7/21/16
 * Time: 10:55 AM
 */
namespace FullSilex\Models\Traits;

use FullSilex\Helpers\UtilitiesHelper;

trait Authorizable
{
    // BEFORE SAVE : auth_beforeSave

    protected $password;
    protected $password_confirmation;
    protected $minPasswordLength = 6;

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->flag_dirty("password_hash");
        $this->flag_dirty("salt");
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password_confirmation
     */
    public function setPasswordConfirmation($password_confirmation)
    {
        $this->password_confirmation = $password_confirmation;
    }

    /**
     * @return mixed
     */
    public function getPasswordConfirmation()
    {
        return $this->password_confirmation;
    }

    /**
     * @param mixed $length
     */
    public function setMinPasswordLength($length)
    {
        $this->minPasswordLength = $length;
    }

    /**
     * @return mixed
     */
    public function getMinPasswordLength()
    {
        return $this->minPasswordLength;
    }


    public function validate(){
        if ( $this->is_new_record() ){
            //save
            if (empty($this->password)) {
                $this->errors->add('password', $this->app->trans('errorPasswordEmpty'));
            }
        }
        else if ( ! $this->is_new_record() && $this->dirty_attributes()) {
            //update
        }

        if ($this->password != $this->password_confirmation) {
            $this->errors->add('passwordConfirmation', $this->app->trans('errorPasswordConfirmationWrong'));
        }
    }

    public function auth_beforeSave(){
        if (!empty($this->password)) {
            $this->salt = time();
            $this->password_hash = UtilitiesHelper::toHash($this->password, $this->salt, $this->app->config('globalSalt'));
        }
    }

    function generateActivationKey() {
        $this->activation_key = sha1(mt_rand(10000,99999).time());
    }

    function resetPassword() {
        $new_password = "";
        for($i=0; $i<floor($this->getMinPasswordLength() / 5); $i++) {
            $new_password .= base_convert(mt_rand(0x19A100, 0x39AA3FF), 10, 36);
        }
        $mod = $this->getMinPasswordLength() % 5;
        if($mod > 0)
            $new_password .= base_convert(mt_rand( pow(36, $mod-1), (pow(36, $mod) - 1) ), 10, 36);

        $this->salt = time();
//        $this->setPassword(UtilitiesHelper::toHash($new_password, $this->get('salt'), $this->app->config('globalSalt')));
        $this->setPassword($new_password);
        $this->setPasswordConfirmation($new_password);
        return $new_password;
    }
}