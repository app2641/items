<?php


namespace Items\Model;

use Items\Container,
    Items\Factory\ModelFactory;

class MaterialModel extends AbstractModel
{
    protected
        $table,
        $fields,
        $record;


    public function __construct ()
    {
        $container    = new Container(new ModelFactory);
        $this->table  = $container->get('MaterialTable');
        $this->fields = $container->get('MaterialFields');
    }
}
