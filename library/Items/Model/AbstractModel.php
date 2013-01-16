<?php


namespace Items\Model;

abstract class AbstractModel
{
    protected
        $table,
        $record,
        $fields;


    /**
     * レコードを新規作成する
     *
     * @author app2641
     **/
    public function insert (\stdClass $params)
    {
        return $this->table->insert($params);
    }

    

    /**
     * 指定レコードを更新する
     *
     * @author app2641
     **/
    public function update ()
    {
        return $this->table->update($this);
    }



    /**
     * 指定レコードを削除する
     *
     * @author app2641
     **/
    public function delete ()
    {
        $this->table->delete($this);
    }



    /**
     * 内包レコードをセットする
     *
     * @return boolean
     * @author app2641
     **/
    public final function setRecord (\stdClass $params)
    {
        foreach ($params as $key => $param) {
            if (! in_array($key, $this->fields->getFields())) {
                unset($params->{$key});
            }
        }

        $this->record = $params;

        return true;
    }



    /**
     * 内包レコードを取得する
     *
     * @return stdClass
     * @author app2641
     **/
    public final function getRecord ()
    {
        if (is_null($this->record)) {
            throw new \Exception('did not set record!');
        }

        return $this->record;
    }



    /**
     * 指定フィールドの値を内包レコードから取得する
     *
     * @author app2641
     **/
    public final function get ($key)
    {
        if (in_array($key, $this->fields->getFields())) {
            return $this->record->{$key};
        }

        return false;
    }



    /**
     * 内包レコードの指定フィールドに値をセットする
     *
     * @author app2641
     **/
    public final function set ($key, $val)
    {
        if (in_array($key, $this->fields->getFields())) {
            $this->record->{$key} = $val;
            return true;
        }

        return false;
    }
}
