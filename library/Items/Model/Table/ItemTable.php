<?php


namespace Items\Model\Table;

use Items\Model\AbstractModel;

use Items\Container,
    Items\Factory\ModelFactory;

class ItemTable implements TableInterface
{
    protected
        $conn,
        $fields;

    public function __construct ()
    {
        $this->conn = \Zend_Registry::get('conn');

        $container = new Container(new ModelFactory);
        $this->fields = $container->get('ItemFields');
    }



    public final function insert (\stdClass $params)
    {
        try {
            foreach ($params as $key => $val) {
                if (! in_array($key, $this->fields->getFields())) {
                    throw new \Exception('invalid field!');
                }
            }

            $sql = 'INSERT INTO item
                (name, description, class, price, exp, experience,
                    rarity, is_active, created_at) VALUES
                (:name, :description, :class, :price, :exp, :experience,
                    :rarity, :is_active, :created_at)';

            $this->conn->state($sql, $params);

            $data = $this->fetchById($this->conn->lastInsertId());
        
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

            $sql = 'UPDATE item
                SET name = :name,
                    description = :description,
                    class = :class,
                    price = :price,
                    exp = :exp,
                    experience = :experience,
                    rarity = :rarity,
                    is_active = :is_active,
                    created_at = :created_at,
                    updated_at = :updated_at
                WHERE item.id = :id';

            $this->conn->state($sql, $record);

            $data = $this->fetchById($model->get('id'));
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $data;
    }



    public final function delete (AbstractModel $model)
    {
        try {
            $sql = 'DELETE FROM item
                WHERE item.id = ?';

            $this->conn->state($sql, $model->get('id'));
        
        } catch (\Exception $e) {
            throw $e;
        }
    }



    public function fetchById ($id)
    {
        try {
            $sql = 'SELECT * FROM item
                WHERE item.id = ?';

            $result = $this->conn
                ->state($sql, $id)->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }



    public function fetchAll()
    {
        try {
            $sql = 'SELECT * FROM item';

            $results = $this->conn->state($sql)->fetchAll();

        } catch (\Exception $e) {
            throw $e;
        }

        return $results;
    }



    public function fetchAllByClass ($cls)
    {
        try {
            $sql = 'SELECT * FROM item
                WHERE item.class = ?';

            $results = $this->conn->state($sql, $cls)->fetchAll();
        
        } catch (\Exception $e) {
            throw $e;
        }
        return $results;
    }
}
