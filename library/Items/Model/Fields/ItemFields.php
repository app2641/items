<?php


namespace Items\Model\Fields;

class ItemFields implements FieldsInterface
{
    protected
        $fields = array(
            'id',
            'name',
            'description',
            'class',
            'price',
            'exp',
            'experience',
            'rarity',
            'is_active',
            'created_at',
            'updated_at'
        );


    /**
     * テーブルのフィールド情報を取得する
     *
     * @return array
     * @author app2641
     **/
    public function getFields ()
    {
        return $this->fields;
    }
}
