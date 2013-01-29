<?php


use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class Item 
{
    protected
        $container;

    public function __construct ()
    {
        $this->container = new Container(new ModelFactory);
    }


    // contentgrid combo選択で変化
    public function getContents ($request)
    {
        $value = $request->value;

        switch ($value) {
            case 'im':
                $table = 'Important';
                break;

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
                $table = $this->container->get('ItemTable');
                $data = $table->fetchAllByClass($class);
                break;

            case 'Material':
                $table = $this->container->get('MaterialTable');
                $data = $table->fetchAllByClass($class);
                break;

            case 'Important':
                $table = $this->container->get('ImportantTable');
                $impotants = $table->fetchAll();
                $data = array();

                foreach ($impotants as $i) {
                    $data[] = array(
                        'id' => $i->id,
                        'name' => $i->name,
                        'rarity' => null,
                        'price' => null,
                        'exp' => null,
                        'is_active' => $i->is_active
                    );
                }
                break;
        }

        return array('success' => true, 'data' => $data);
    }



    // comboboxのリストを取得する
    public function getComboList ($request)
    {
        return array(
            array('id' => 'im', 'value' => 'Impotant'),
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
        $table = $this->container->get('ItemTable');

        $data = $table->fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        $data->cls = $data->class;

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

            $model = $this->container->get('ItemModel');
            $table = $this->container->get('ItemTable');


            $params = new \stdClass;
            $params->name = $request['name'];
            $params->description = $request['description'];
            $params->class = $request['class'];
            $params->price = $request['price'];
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
        $table = $this->container->get('ItemTable');

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

        $table = $this->container->get('ItemTable');
        $model = $this->container->get('ItemModel');

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
            $table = $this->container->get('ItemTable');
            $model = $this->container->get('ItemModel');

            $data = $table->fetchById($request->id);

            $model->setRecord($data);
            $model->delete();
        
        } catch (\Exception $e) {
            return array('success' => false, 'msg' => $e->getMessage());
        }

        return array('success' => true);
    }


    
    /**
     * csvの生成
     *
     * @author app2641
     **/
    public function generateCsv ()
    {
        $container = new Container(new UtilityFactory);
        $generator = $container->get('ItemCsvGenerator');
        $generator->execute();

        return array('success' => true, 'name' => 'item');
    }


    /**
     * ItemSelectorに表示するリストデータを取得する
     *
     * @author app2641
     **/
    public function getItemSelectorData ($request)
    {
        $class = strtoupper(substr($request->cls, 1, 1));

        $table = $container->get('ItemTable');

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
