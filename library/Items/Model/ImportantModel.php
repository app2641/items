<?php


namespace Items\Model;

use Items\Container,
    Items\Factory\ModelFactory;

class ImportantModel extends AbstractModel
{
    protected
        $table,
        $fields;


    public function __construct ()
    {
        $container    = new Container(new ModelFactory);
        $this->table  = $container->get('ImportantTable');
        $this->fields = $container->get('ImportantFields');
    }
}
