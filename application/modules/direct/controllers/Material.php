<?php

use Items\Table\MaterialTable;

class Material
{
    // ひとつぶんのデータを取得
    public function getData ($request)
    {
        $data = MaterialTable::fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        return $data;
    }

    // formデータの取得
    public function dataLoad ($id)
    {
        $data = MaterialTable::fetchById($id);
        return array('success' => true, 'data' => $data);
    }
}
