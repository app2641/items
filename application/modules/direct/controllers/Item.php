<?php

use Items\Table\ItemTable,
    Items\Table\MaterialTable;

class Item 
{
    // contentgrid combo選択で変化
    public function getContents ($request)
    {
        $value = $request->value;

        switch ($value) {
            case 'is':
                $class = 'S';
                $table = 'Item';
                break;

            case 'ia':
                $class = 'A';
                $table = 'Item';
                break;

            case 'ib':
                $class = 'B';
                $table = 'Item';
                break;

            case 'ic':
                $class = 'C';
                $table = 'Item';
                break;

            case 'id':
                $class = 'D';
                $table = 'Item';
                break;

            case 'ms':
                $class = 'S';
                $table = 'Material';
                break;

            case 'ma':
                $class = 'A';
                $table = 'Material';
                break;

            case 'mb':
                $class = 'B';
                $table = 'Material';
                break;
            
            case 'mc':
                $class = 'C';
                $table = 'Material';
                break;

            case 'md':
                $class = 'D';
                $table = 'Material';
                break;

            default:
                return array();
                break;
        }

        switch ($table) {
            case 'Item':
                $data = ItemTable::fetchAllByClass($class);
                break;

            case 'Material':
                $data = MaterialTable::fetchAllByClass($class);
                break;
        }

        return array('success' => true, 'data' => $data);
    }

    // comboboxのリストを取得する
    public function getComboList ($request)
    {
        return array(
            array('id' => 'is', 'value' => 'ItemS'),
            array('id' => 'ia', 'value' => 'ItemA'),
            array('id' => 'ib', 'value' => 'ItemB'),
            array('id' => 'ic', 'value' => 'ItemC'),
            array('id' => 'id', 'value' => 'ItemD'),
            array('id' => 'ms', 'value' => 'MaterialS'),
            array('id' => 'ma', 'value' => 'MaterialA'),
            array('id' => 'mb', 'value' => 'MaterialB'),
            array('id' => 'mc', 'value' => 'MaterialC'),
            array('id' => 'md', 'value' => 'MaterialD')
        );
    }

    // ひとつぶんのデータを取得
    public function getData ($request)
    {
        $data = ItemTable::fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        return $data;
    }

    // formデータの取得
    public function dataLoad ($request)
    {
        var_dump($request);
        exit();
    }
}
