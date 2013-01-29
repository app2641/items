<?php


namespace Items\Factory;

use Items\Model\Fields\ItemFields,
    Items\Model\Fields\ImportantFields,
    Items\Model\Fields\LevelNoteFields,
    Items\Model\Fields\MaterialFields,
    Items\Model\Fields\MixinFields;

use Items\Model\ItemModel,
    Items\Model\ImportantModel,
    Items\Model\LevelNoteModel,
    Items\Model\MaterialModel,
    Items\Model\MixinModel;

use Items\Model\Table\ItemTable,
    Items\Model\Table\ImportantTable,
    Items\Model\Table\LevelNoteTable,
    Items\Model\Table\MaterialTable,
    Items\Model\Table\MixinTable;

class ModelFactory extends AbstractFactory
{
    ////////////////////
    // Fields
    ////////////////////

    public function buildItemFields ()
    {
        return new ItemFields();
    }


    public function buildImportantFields ()
    {
        return new ImportantFields();
    }


    public function buildLevelNoteFields ()
    {
        return new LevelNoteFields();
    }


    public function buildMaterialFields ()
    {
        return new MaterialFields();
    }


    public function buildMixinFields ()
    {
        return new MixinFields();
    }



    ////////////////////
    // Model
    ////////////////////

    public function buildItemModel ()
    {
        return new ItemModel();
    }


    public function buildImportantModel ()
    {
        return new ImportantModel();
    }


    public function buildLevelNoteModel ()
    {
        return new LevelNoteModel();
    }


    public function buildMaterialModel ()
    {
        return new MaterialModel();
    }


    public function buildMixinModel ()
    {
        return new MixinModel();
    }



    ////////////////////
    // Table
    ////////////////////

    public function buildItemTable ()
    {
        return new ItemTable();
    }


    public function buildImportantTable ()
    {
        return new ImportantTable();
    }


    public function buildLevelNoteTable ()
    {
        return new LevelNoteTable();
    }


    public function buildMaterialTable ()
    {
        return new MaterialTable();
    }


    public function buildMixinTable ()
    {
        return new MixinTable();
    }
}
