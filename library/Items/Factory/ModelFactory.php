<?php


namespace Items\Factory;

use Items\Model\Fields\ItemFields,
    Items\Model\Fields\MaterialFields,
    Items\Model\Fields\MixinFields;

use Items\Model\ItemModel,
    Items\Model\MaterialModel,
    Items\Model\MixinModel;

use Items\Model\Table\ItemTable,
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


    public function buildMaterialTable ()
    {
        return new MaterialTable();
    }


    public function buildMixinTable ()
    {
        return new MixinTable();
    }
}
