<?php


namespace Items\Model\Table;

use Items\Model\AbstractModel;

use Items\Container,
    Items\Factory\ModelFactory;

class MixinTable implements TableInterface
{
    protected
        $conn,
        $fields;


    public function __construct ()
    {
        $this->conn = \Zend_Registry::get('conn');

        $container = new Container(new ModelFactory);
        $this->fields = $container->get('MixinFields');
    }


    public final function insert (\stdClass $params)
    {
        try {
            foreach ($params as $key => $val) {
                if (! in_array($key, $this->fields->getFields())) {
                    throw new \Exception('invalid field!');
                }
            }

            $sql = 'INSERT INTO mixin
                (material1_id, material2_id, item_id) VALUES
                (:material1_id, :material2_id, :item_id)';

            $this->conn->state($sql, $params);

            $data = $this->fetchByMaterialIds(
                $params->material1_id,
                $params->material2_id
            );
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $data;
    }


    public final function update (AbstractModel $model)
    {
        try {
            $record = $model->getRecord();

            foreach ($record as $key => $val) {
                if (! in_array($key, $this->fields->getFields())) {
                    throw new \Exception('invalid field!');
                }
            }

            $sql = 'UPDATE mixin
                SET item_id = :item_id
                WHERE material1_id = :material1_id
                AND material2_id = :material2_id';

            $this->conn->state($sql, $record);
        
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public final function delete (AbstractModel $model)
    {
    }


    public final function fetchById ($id)
    {
        return false;
    }



    /**
     * Mixinの素材組み合わせidでレコードを取得する
     *
     * @author app2641
     **/
    public function fetchByMaterialIds ($first, $second)
    {
        try {
            $sql = 'SELECT * FROM mixin
                WHERE mixin.material1_id = ?
                AND mixin.material2_id = ?';

            $data = $this->conn
                ->state($sql, array($first, $second))->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $data;
    }
}
