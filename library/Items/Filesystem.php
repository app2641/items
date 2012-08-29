<?php

namespace Items;

class Filesystem
{
    // tmpに専用フォルダを作る
    public static function makeTmp ()
    {
        $tmp = '/tmp/Items';

        if (! is_dir($tmp)) {
            mkdir($tmp);
            chmod($tmp, 0777);
        }
    }
}
