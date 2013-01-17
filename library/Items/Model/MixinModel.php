<?php


namespace Items\Model;

use Items\Container,
    Items\Factory\ModelFactory;

class MixinModel extends AbstractModel
{
    protected
        $fields,
        $table;


    public function __construct ()
    {
        $container    = new Container(new ModelFactory);
        $this->table  = $container->get('MixinTable');
        $this->fields = $container->get('MixinFields');
    }
}

