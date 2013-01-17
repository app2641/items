<?php

use Items\Filesystem;

use Items\Container,
    Items\Factory\ModelFactory;

class Material
{

    // ひとつぶんのデータを取得
    public function getData ($request)
    {
        $container = new Container(new ModelFactory);
        $table = $container->get('MaterialTable');

        $data = $table->fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        $data->cls = $data->class;

        return $data;
    }


    /**
     * @formHandler
     *  materialレコードの追加
     */
    public function dataCreate ($request)
    {
        try {
            if (isset($request['is_active'])) {
                $active = true;
            } else {
                $active = false;
            }

            $container = new Container(new ModelFactory);
            $model = $container->get('MaterialModel');

            $params = new \stdClass;
            $params->name = $request['name'];
            $params->description = $request['description'];
            $params->class = $request['class'];
            $params->rarity = $request['rarity'];
            $params->price = $request['price'];
            $params->exp = $request['exp'];
            $params->experience = false;
            $params->is_active = $active;
            $params->created_at = date('Y-m-d H:i:s');
            $model->insert($params);

        } catch (\Exception $e) {
            return array('success' => false, 'msg' => $e->getMessage());
        }
        return array('success' => true);
    }



    // formデータの取得
    public function dataLoad ($id)
    {
        $container = new Container(new ModelFactory);
        $table = $container->get('MaterialTable');

        $data = $table->fetchById($id);
        return array('success' => true, 'data' => $data);
    }



    /**
     * @formHandler
     * formデータupdate
     */
    public function dataUpdate ($request)
    {
        if (isset($request['is_active'])) {
            $active = true;
        } else {
            $active = false;
        }

        $container = new Container(new ModelFactory);
        $model = $container->get('MaterialModel');
        $table = $container->get('MaterialTable');

        $data = $table->fetchById($request['id']);
        $model->setRecord($data);

        $model->set('name', $request['name']);
        $model->set('description', $request['description']);
        $model->set('class', $request['class']);
        $model->set('rarity', $request['rarity']);
        $model->set('price', $request['price']);
        $model->set('exp', $request['exp']);
        $model->set('is_active', $active);
        $model->set('updated_at', date('Y-m-d H:i:s'));
        $model->update();

        return array('success' => true);
    }



    // data削除
    public function dataDelete ($request)
    {
        $container = new Container(new ModelFactory);
        $table = $container->get('MaterialTable');
        $model = $container->get('MaterialModel');

        $data = $table->fetchById($request->id);
        $model->setRecord($data);
        $model->delete();

        return array('success' => true);
    }


    
    // csv書き出し
    public function generateCsv ()
    {
        // tmpフォルダ作成
        Items\Filesystem::makeTmp();

        $data = MaterialTable::fetchAll();
        $csv = '';
        $c = ',';

        foreach ($data as $d) {
            $csv .= $this->_csvEscape($d->id).$c.$this->_csvEscape($d->name).$c.$this->_csvEscape($d->description).$c.
                $this->_csvEscape($d->class).$c.$this->_csvEscape($d->price).$c.$this->_csvEscape($d->exp).$c.
                $this->_csvEscape($d->experience).$c.$this->_csvEscape($d->is_active)."\n";
        }

        $file = '/tmp/items/material.csv';
        if (file_exists($file)) {
            unlink($file);
        }

        touch($file);

        $fp = fopen($file, 'w');
        @fwrite($fp, $csv, strlen($csv));
        fclose($fp);

        return array('success' => true, 'name' => 'material');
    }


    // csv escape
    private function _csvEscape($string)
    {
        return '"'.str_replace('"', '\"', $string).'"';
    }



    /**
     * 素材ItemSelectorに表示するリストデータを取得する
     *
     * @author app2641
     **/
    public function getItemSelectorData ($request)
    {
        $class = strtoupper(substr($request->cls, 1, 1));

        $container = new Container(new ModelFactory);
        $table = $container->get('MaterialTable');

        $data = $table->fetchAllByClass($class);
        $results = array();

        // 余計なデータを削除する
        foreach ($data as $d) {
            $results[] = array(
                'id' => $d->id,
                'name' => $d->name
            );
        }

        return $results;
    }
}
