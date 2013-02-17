<?php


namespace Items\Model\Table;

use Items\Model\AbstractModel;

use Items\Container,
    Items\Factory\ModelFactory;

class ImportantTable implements TableInterface
{
    protected
        $conn,
        $fields;


    public function __construct ()
    {
        $this->conn = \Zend_Registry::get('conn');

        $container = new Container(new ModelFactory);
        $this->fields = $container->get('ImportantFields');
    }



    public final function insert (\stdClass $params)
    {
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

            $sql = 'UPDATE important
                SET name = :name, description = :description,
                is_active = :is_active, price = :price, experience = :experience,
                created_at = :created_at, updated_at = :updated_at
                WHERE id = :id';

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
        try {
            $sql = 'SELECT * FROM important
                WHERE id = ?';

            $result = $this->conn
                ->state($sql, $id)->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }



    /**
     * レコードを全取得する
     *
     * @author app2641
     **/
    public function fetchAll ()
    {
        try {
            $sql = 'SELECT * FROM important';

            $results = $this->conn
                ->state($sql)->fetchAll();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $results;
    }
}
