<?php


namespace Items\Model\Fields;

class LevelNoteFields implements FieldsInterface
{
    protected
        $fields = array(
            'id',
            'level',
            'note'
        );


    public final function getFields ()
    {
        return $this->fields;
    }
}
