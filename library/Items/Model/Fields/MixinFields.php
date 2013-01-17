<?php


namespace Items\Model\Fields;

class MixinFields implements FieldsInterface
{
    protected
        $fields = array(
            'material1_id',
            'material2_id',
            'item_id'
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
