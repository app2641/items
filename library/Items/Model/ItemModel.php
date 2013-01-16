<?php


namespace Items\Model;

use Items\Container,
    Items\Factory\ModelFactory;

class ItemModel extends AbstractModel
{
    protected
        $table,
        $fields,
        $record;


    public function __construct ()
    {
        $container    = new Container(new ModelFactory);
        $this->table  = $container->get('ItemTable');
        $this->fields = $container->get('ItemFields');
    }
}
