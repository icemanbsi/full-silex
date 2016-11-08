<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com).
 * Date: 11/8/16
 * Time: 1:45 PM
 */

namespace FullSilex\Models\Traits;


trait HasPosition
{
    // BEFORE CREATE : pos_beforeCreate

    public function pos_beforeCreate()
    {
        if (is_null($this->position)) {
            $last = self::first(array(
                "order" => "position DESC"
            ));
            if($last){
                $this->position = $last->position + 1;
            }
            else{
                $this->position = 1;
            }
        }
    }
}