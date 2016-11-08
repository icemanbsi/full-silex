<?php
/**
 * Created by Bobby Stenly Irawan (http://bobbystenly.com).
 * Date: 11/8/16
 * Time: 2:06 PM
 */

namespace FullSilex\Helpers;


class FileHelper
{
    public static function removeFolder($dir) {
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $file) {
            if ($file == '.' || $file == '..') continue;
            if (!self::removeFolder($dir . DIRECTORY_SEPARATOR . $file)) {
                chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
                if (!self::removeFolder($dir . DIRECTORY_SEPARATOR . $file)) return false;
            };
        }
        return rmdir($dir);
    }
}