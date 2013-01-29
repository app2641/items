<?php

use Items\Filesystem;

use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class Material
{
    protected
        $container;

    public function __construct ()
    {
        $this->container = new Container(new ModelFactory);
    }


    // ひとつぶんのデータを取得
    public function getData ($request)
    {
        $table = $this->container->get('MaterialTable');

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

            $model = $this->container->get('MaterialModel');

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
        $table = $this->container->get('MaterialTable');

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

        $model = $this->container->get('MaterialModel');
        $table = $this->container->get('MaterialTable');

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
        $table = $this->container->get('MaterialTable');
        $model = $this->container->get('MaterialModel');

        $data = $table->fetchById($request->id);
        $model->setRecord($data);
        $model->delete();

        return array('success' => true);
    }


    
    /**
     * csvを生成する
     *
     * @author app2641
     **/
    public function generateCsv ()
    {
        $container = new Container(new UtilityFactory);
        $generator = $container->get('MaterialCsvGenerator');
        $generator->execute();

        return array('success' => true, 'name' => 'material');
    }



    /**
     * 素材ItemSelectorに表示するリストデータを取得する
     *
     * @author app2641
     **/
    public function getItemSelectorData ($request)
    {
        $class = strtoupper(substr($request->cls, 1, 1));

        $table = $this->container->get('MaterialTable');

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
