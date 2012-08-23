<?php

namespace Items\Table;

class ItemTable
{
    public static function fetchAllByClass($class)
    {
        try {
            $conn = \Zend_Registry::get('conn');

            $sql = 'SELECT * FROM item
                WHERE item.class = ?';

            $stmt = $conn->prepare($sql);
            $stmt->execute(array($class));
            $results = $stmt->fetchAll();
        
        } catch (\Exception $e) {
            throw $e;
        }
        return $results;
    }


    public static function fetchById($id)
    {
        try {
            $conn = \Zend_Registry::get('conn');

            $sql = 'SELECT * FROM item
                WHERE item.id = ?';

            $stmt = $conn->prepare($sql);
            $stmt->execute(array($id));
            $result = $stmt->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }
}
