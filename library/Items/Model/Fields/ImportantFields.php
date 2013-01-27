<?php


namespace Items\Model\Fields;

class ImportantFields implements FieldsInterface
{
    protected
        $fields = array(
            'id',
            'name',
            'description',
            'experience',
            'is_active',
            'created_at',
            'updated_at'
        );


    public final function getFields ()
    {
        return $this->fields;
    }
}
