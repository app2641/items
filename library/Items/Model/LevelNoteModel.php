<?php


namespace Items\Model;

use Items\Container,
    Items\Factory\ModelFactory;

class LevelNoteModel extends AbstractModel
{
    protected
        $table,
        $fields;


    public function __construct ()
    {
        $container    = new Container(new ModelFactory);
        $this->table  = $container->get('LevelNoteTable');
        $this->fields = $container->get('LevelNoteFields');
    }
}
