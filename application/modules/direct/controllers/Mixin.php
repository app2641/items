<?php

use Items\Container,
    Items\Factory\ModelFactory,
    Items\Factory\UtilityFactory;

class Mixin
{

    /**
     * 新規レコードの作成
     *
     * @formHandler
     */
    public function insert ($request)
    {
        try {
            $conn = \Zend_Registry::get('conn');
            $conn->beginTransaction();

            $first_value = $request['first_value'];
            $second_value = $request['second_value'];
            $item_value = $request['item_value'];

            $container = new Container(new ModelFactory);
            $model = $container->get('MixinModel');
            $table = $container->get('MixinTable');


            // 素材組み合わせが既にあるかどうか
            // ある場合は更新処理にする
            $data = $table->fetchByMaterialIds($first_value, $second_value);

            if ($data) {
                $data->item_id = $item_value;

                $model->setRecord($data);
                $model->update();


                // 逆組み合わせの更新処理
                $data->material1_id = $second_value;
                $data->material2_id = $first_value;

                $model->setRecord($data);
                $model->update();

            } else {
                $params = new \stdClass;
                $params->material1_id = $first_value;
                $params->material2_id = $second_value;
                $params->item_id = $item_value;

                $model->insert($params);


                // 逆組み合わせの新規作成
                $params->material1_id = $second_value;
                $params->material2_id = $first_value;

                $model->insert($params);
            }

            $conn->commit();
        
        } catch (\Exception $e) {
            $conn->rollBack();
            return array('success' => false, 'msg' => $e->getMessage());
        }

        return array('success' => true);
    }



    /**
     * Materialの組み合わせからアイテムデータを取得する
     *
     * @author app2641
     **/
    public function fetchItemData ($request)
    {
        $container = new Container(new ModelFactory);
        $table = $container->get('MixinTable');

        $data = $table->fetchByMaterialIds(
            $request->first_value,
            $request->second_value
        );

        return array('success' => true, 'data' => $data);
    }



    /**
     * csvを生成する
     *
     * @author app2641
     **/
    public function generateCsv ()
    {
        $container = new Container(new UtilityFactory);
        $generator = $container->get('MixinCsvGenerator');
        $generator->execute();

        return array('success' => true, 'name' => 'mixin');
    }
    
}
