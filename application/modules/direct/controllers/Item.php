<?php


use Items\Container,
    Items\Factory\ModelFactory;

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


        $container = new Container(new ModelFactory);

        switch ($table) {
            case 'Item':
                $table = $container->get('ItemTable');
                $data = $table->fetchAllByClass($class);
                break;

            case 'Material':
                $table = $container->get('MaterialTable');
                $data = $table->fetchAllByClass($class);
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
        $container = new Container(new ModelFactory);
        $table = $container->get('ItemTable');

        $data = $table->fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        return $data;
    }


    /**
     * @formHandler
     *  itemレコードの追加
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
            $model = $container->get('ItemModel');
            $table = $container->get('ItemTable');


            $params = new \stdClass;
            $params->name = $request['name'];
            $params->description = $request['description'];
            $params->class = $request['class'];
            $params->rarity = $request['rarity'];
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
        $table = $container->get('ItemTable');

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
        $table = $container->get('ItemTable');
        $model = $container->get('ItemModel');

        $data = $table->fetchById($request['id']);

        $data->name = $request['name'];
        $data->description = $request['description'];
        $data->rarity = $request['rarity'];
        $data->class = $request['class'];
        $data->price = $request['price'];
        $data->exp = $request['exp'];
        $data->is_active = $active;
        $data->updated_at = date('Y-m-d H:i:s');

        $model->setRecord($data);
        $model->update();

        return array('success' => true);
    }



    // data削除
    public function dataDelete ($request)
    {
        try {
            $container = new Container(new ModelFactory);
            $table = $container->get('ItemTable');
            $model = $container->get('ItemModel');

            $data = $table->fetchById($request->id);

            $model->setRecord($data);
            $model->delete();
        
        } catch (\Exception $e) {
            return array('success' => false, 'msg' => $e->getMessage());
        }

        return array('success' => true);
    }


    public function generateCsv ()
    {
        // tmpフォルダ作成
        Items\Filesystem::makeTmp();

        $data = ItemTable::fetchAll();
        $csv = '';
        $c = ',';

        foreach ($data as $d) {
            $csv .= $this->_csvEscape($d->id).$c.$this->_csvEscape($d->name).$c.$this->_csvEscape($d->description).$c.
                $this->_csvEscape($d->class).$c.$this->_csvEscape($d->price).$c.$this->_csvEscape($d->exp).$c.
                $this->_csvEscape($d->experience).$c.$this->_csvEscape($d->is_active)."\n";
        }

        $file = '/tmp/items/item.csv';
        if (file_exists($file)) {
            unlink($file);
        }

        touch($file);

        $fp = fopen($file, 'w');
        @fwrite($fp, $csv, strlen($csv));
        fclose($fp);

        return array('success' => true, 'name' => 'item');
    }


    // csv escape
    private function _csvEscape($string)
    {
        return '"'.str_replace('"', '\"', $string).'"';
    }
}
