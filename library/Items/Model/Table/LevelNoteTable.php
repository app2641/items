<?php


namespace Items\Model\Table;

use Items\Model\AbstractModel;

use Items\Container,
    Items\Factory\ModelFactory;

class LevelNoteTable implements TableInterface
{
    protected
        $conn,
        $fields;


    public function __construct ()
    {
        $this->conn = \Zend_Registry::get('conn');

        $container = new Container(new ModelFactory);
        $this->fields = $container->get('LevelNoteFields');
    }


    public final function insert (\stdClass $params)
    {
        
    }


    public final function update (AbstractModel $model)
    {
        
    }


    public final function delete (AbstractModel $model)
    {
        
    }


    public final function fetchById ($id)
    {
        
    }



    /**
     * 全データを取得する 
     *
     * @author app2641
     **/
    public function fetchAll ()
    {
        try {
            $sql = 'SELECT * FROM level_note';

            $results = $this->conn
                ->state($sql)->fetchAll();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $results;
    }
}
