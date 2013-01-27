<?php


use Items\Container,
    Items\Factory\ModelFactory;

class Important
{
    protected
        $container;

    public function __construct ()
    {
        $this->container = new Container(new ModelFactory);
    }


    
    public function getData ($request)
    {
        $table = $this->container->get('ImportantTable');

        $data = $table->fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        $data->class = null;
        $data->cls = null;
        $data->rarity = null;
        $data->price = null;
        $data->exp = null;

        return $data;
    }




    /**
     * データの更新
     *
     * @formHandler
     * @author app2641
     **/
    public function dataUpdate ($request)
    {
        if (isset($request['is_active'])) {
            $active = true;
        } else {
            $active = false;
        }

        $table = $this->container->get('ImportantTable');
        $model = $this->container->get('ImportantModel');

        $data = $table->fetchById($request['id']);

        $data->name = $request['name'];
        $data->description = $request['description'];
        $data->is_active = $active;
        $data->updated_at = date('Y-m-d H:i:s');

        $model->setRecord($data);
        $model->update();

        return array('success' => true);
    }



    /**
     * データを読み込む
     *
     * @author app2641
     **/
    public function dataLoad ($id)
    {
        $table = $this->container->get('ImportantTable');
        $data = $table->fetchById($id);

        $data->class = null;
        $data->price = null;
        $data->rarity = null;

        return array('success' => true, 'data' => $data);
    }


    
    /**
     * csvを生成する
     *
     * @author app2641
     */
    public function generateCsv ()
    {
        // tmpフォルダ作成
        Items\Filesystem::makeTmp();

        $table = $this->container->get('ImportantTable');
        $data = $table->fetchAll();
        $csv = '';
        $c = ',';

        foreach ($data as $d) {
            $csv .= $this->_csvEscape($d->id).$c.$this->_csvEscape($d->name).$c.$this->_csvEscape($d->description).$c.
                $this->_csvEscape($d->experience).$c.$this->_csvEscape($d->is_active).PHP_EOL;
        }

        $file = '/tmp/items/important.csv';
        if (file_exists($file)) {
            unlink($file);
        }

        touch($file);

        $fp = fopen($file, 'w');
        @fwrite($fp, $csv, strlen($csv));
        fclose($fp);

        return array('success' => true, 'name' => 'important');
    }


    // csv escape
    private function _csvEscape($string)
    {
        return '"'.str_replace('"', '\"', $string).'"';
    }
}
