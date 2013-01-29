<?php

namespace Items;

class FileSystem
{
    // tmpに専用フォルダを作る
    public function makeTmp ()
    {
        $tmp = '/tmp/Items';

        if (! is_dir($tmp)) {
            mkdir($tmp);
            chmod($tmp, 0777);
        }
    }
}
