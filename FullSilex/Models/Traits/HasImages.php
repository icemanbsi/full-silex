<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com).
 * Date: 11/8/16
 * Time: 1:58 PM
 */

namespace FullSilex\Models\Traits;


use FullSilex\Helpers\FileHelper;

trait HasImages
{
    // AFTER DESTROY : img_afterDestroy

    protected function classname()
    {
        $classname = get_called_class();
        $classname_r = explode('\\', $classname);
        $classname = $classname_r[count($classname_r)-1];
        return $classname;
    }
    /**
     * @return string
     * Override this method to change path name
     */
    public function imageBaseUrl()
    {
        $classname = $this->classname();
        /** @var \FullSilex\Models\BaseModel $this */
        return 'images/'.$classname.'/' . $this->id . '/';
    }

    public function imageBasePath()
    {
        $classname = $this->classname();
        /** @var \FullSilex\Models\BaseModel $this */
        return $this->app->getRootDir() . '/' . $this->app->getPublicDirectory() . '/' . 'images/'.$classname.'/' . $this->id . '/';
    }

    /**
     * @param $fieldName
     * @return array|mixed
     * It is imperative to use bean here
     */
    protected function _getImageField($fieldName)
    {
        try {
            /** @var \FullSilex\Models\BaseModel $this */
            return \GuzzleHttp\json_decode($this->$fieldName, true);
        }
        catch (\Exception $e) {
            return array();
        }
    }

    /**
     * @param $fieldName
     * @param array $values
     * It is imperative to use bean here
     */
    protected function _setImageField($fieldName, $values = array())
    {
        if (is_string($values)) {
            $this->$fieldName = $values;
        }
        else {
            /** @var \FullSilex\Models\BaseModel $this */
            $this->$fieldName = json_encode($values);
        }
    }

    public function getImages()
    {
        return $this->_getImageField('images');

    }


    public function setImages($values = array())
    {
        $this->_setImageField('images', $values);
    }

    public function img_afterDestroy()
    {
        $oldId = $this->id;
        $classname = $this->classname();
        /** @var \FullSilex\Models\BaseModel $this */
        $imagePath = $this->app->getRootDir() . '/' . $this->app->getPublicDirectory() . '/' . 'images/'.$classname.'/' . $oldId . '/';
        FileHelper::removeFolder($imagePath);
    }
}