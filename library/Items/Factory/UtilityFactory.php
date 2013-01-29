<?php


namespace Items\Factory;

use Items\FileSystem;

use Items\CsvGenerator\Important,
    Items\CsvGenerator\Material,
    Items\CsvGenerator\Item,
    Items\CsvGenerator\Mixin,
    Items\CsvGenerator\LevelNote;

class UtilityFactory extends AbstractFactory
{
    public function buildFileSystem ()
    {
        return new FileSystem();
    }


    public function buildImportantCsvGenerator ()
    {
        return new Important();
    }


    public function buildMaterialCsvGenerator ()
    {
        return new Material();
    }


    public function buildItemCsvGenerator ()
    {
        return new Item();
    }


    public function buildMixinCsvGenerator ()
    {
        return new Mixin();
    }


    public function buildLevelNoteCsvGenerator ()
    {
        return new LevelNote();
    }
}
