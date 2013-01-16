<?php


namespace Items\Factory;

use Items\Model\Fields\ItemFields,
    Items\Model\Fields\MaterialFields;

use Items\Model\ItemModel,
    Items\Model\MaterialModel;

use Items\Model\Table\ItemTable,
    Items\Model\Table\MaterialTable;

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
}
