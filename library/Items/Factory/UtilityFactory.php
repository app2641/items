<?php


namespace Items\Factory;

use Items\FileSystem;

class UtilityFactory extends AbstractFactory
{
    public function buildFileSystem ()
    {
        return new FileSystem();
    }
}
