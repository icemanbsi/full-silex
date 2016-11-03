<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com)
 * Date: 7/21/16
 * Time: 11:37 AM
 */

namespace FullSilex\Models\Traits;


trait HasTimestamp
{
    public function time_beforeCreate()
    {
        $this->created_at = date("Y-m-d H:i:s");
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public function time_beforeSave()
    {
        $this->updated_at = date("Y-m-d H:i:s");
    }
}