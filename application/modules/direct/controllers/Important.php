<?php


use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

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
        try {
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
            $data->price = $request['price'];
            $data->is_active = $active;
            $data->updated_at = date('Y-m-d H:i:s');

            $model->setRecord($data);
            $model->update();

        } catch (\Exception $e) {
            return array('success' => false, 'msg' => $e->getMessage());
        }

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
        $container = new Container(new UtilityFactory);

        // CsvGeneraterを用意
        $generator = $container->get('ImportantCsvGenerator');
        $generator->execute();

        return array('success' => true, 'name' => 'important');
    }
}
