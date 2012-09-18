<?php

use Items\Table\ItemTable,
    Items\Table\MaterialTable;

class Item 
{
    // contentgrid combo選択で変化
    public function getContents ($request)
    {
        $value = $request->value;

        switch ($value) {
            case 'is':
                $class = 'S';
                $table = 'Item';
                break;

            case 'ia':
                $class = 'A';
                $table = 'Item';
                break;

            case 'ib':
                $class = 'B';
                $table = 'Item';
                break;

            case 'ic':
                $class = 'C';
                $table = 'Item';
                break;

            case 'id':
                $class = 'D';
                $table = 'Item';
                break;

            case 'ms':
                $class = 'S';
                $table = 'Material';
                break;

            case 'ma':
                $class = 'A';
                $table = 'Material';
                break;

            case 'mb':
                $class = 'B';
                $table = 'Material';
                break;
            
            case 'mc':
                $class = 'C';
                $table = 'Material';
                break;

            case 'md':
                $class = 'D';
                $table = 'Material';
                break;

            default:
                return array();
                break;
        }

        switch ($table) {
            case 'Item':
                $data = ItemTable::fetchAllByClass($class);
                break;

            case 'Material':
                $data = MaterialTable::fetchAllByClass($class);
                break;
        }

        return array('success' => true, 'data' => $data);
    }

    // comboboxのリストを取得する
    public function getComboList ($request)
    {
        return array(
            array('id' => 'is', 'value' => 'ItemS'),
            array('id' => 'ia', 'value' => 'ItemA'),
            array('id' => 'ib', 'value' => 'ItemB'),
            array('id' => 'ic', 'value' => 'ItemC'),
            array('id' => 'id', 'value' => 'ItemD'),
            array('id' => 'ms', 'value' => 'MaterialS'),
            array('id' => 'ma', 'value' => 'MaterialA'),
            array('id' => 'mb', 'value' => 'MaterialB'),
            array('id' => 'mc', 'value' => 'MaterialC'),
            array('id' => 'md', 'value' => 'MaterialD')
        );
    }

    // ひとつぶんのデータを取得
    public function getData ($request)
    {
        $data = ItemTable::fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        return $data;
    }


    /**
     * @formHandler
     *  itemレコードの追加
     */
    public function dataCreate ($request)
    {
        try {
            if (isset($request['is_active'])) {
                $active = true;
            } else {
                $active = false;
            }

            $sql = 'INSERT INTO item
                (name, description, class, rarity, price, exp, experience, is_active, created_at)
                VALUES (:name, :des, :cls, :rare, :price, :exp, :ex, :active, :create)';

            $conn = \Zend_Registry::get('conn');
            $stmt = $conn->prepare($sql);
            $stmt->execute(
                array(
                    'name' => $request['name'],
                    'des' => $request['description'],
                    'cls' => $request['class'],
                    'rare' => $request['rarity'],
                    'price' => $request['price'],
                    'exp' => $request['exp'],
                    'ex' => false,
                    'active' => $active,
                    'create' => date('Y-m-d H:i:s', time())
                )
            );
        
        } catch (\Exception $e) {
            return array('success' => false, 'msg' => $e->getMessage());
        }
        return array('success' => true);
    }


    // formデータの取得
    public function dataLoad ($id)
    {
        $data = ItemTable::fetchById($id);
        return array('success' => true, 'data' => $data);
    }

    /**
     * @formHandler
     * formデータupdate
     */
    public function dataUpdate ($request)
    {
        if (isset($request['is_active'])) {
            $active = true;
        } else {
            $active = false;
        }

        $sql = 'UPDATE item
            SET name = :name,
            description = :des,
            class = :class,
            rarity = :rare,
            price = :price,
            exp = :exp,
            is_active = :active,
            updated_at = :update
            WHERE item.id = :id';

        $conn = \Zend_Registry::get('conn');
        $stmt = $conn->prepare($sql);
        $stmt->execute(
            array(
                'id' => $request['id'],
                'name' => $request['name'],
                'des' => $request['description'],
                'rare' => $request['rarity'],
                'class' => $request['class'],
                'price' => $request['price'],
                'exp' => $request['exp'],
                'active' => $active,
                'update' => date('Y-m-d H:i:s', time())
            )
        );

        return array('success' => true);
    }

    // data削除
    public function dataDelete ($request)
    {
        try {
            $sql = 'DELETE FROM item
                WHERE item.id = ?';

            $conn = \Zend_Registry::get('conn');
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($request->id));
        
        } catch (\Exception $e) {
            return array('success' => false, 'msg' => $e->getMessage());
        }

        return array('success' => true);
    }


    public function generateCsv ()
    {
        // tmpフォルダ作成
        Items\Filesystem::makeTmp();

        $data = ItemTable::fetchAll();
        $csv = '';
        $c = ',';

        foreach ($data as $d) {
            $csv .= $this->_csvEscape($d->id).$c.$this->_csvEscape($d->name).$c.$this->_csvEscape($d->description).$c.
                $this->_csvEscape($d->class).$c.$this->_csvEscape($d->price).$c.$this->_csvEscape($d->exp).$c.
                $this->_csvEscape($d->experience).$c.$this->_csvEscape($d->is_active)."\n";
        }

        $file = '/tmp/items/item.csv';
        if (file_exists($file)) {
            unlink($file);
        }

        touch($file);

        $fp = fopen($file, 'w');
        @fwrite($fp, $csv, strlen($csv));
        fclose($fp);

        return array('success' => true, 'name' => 'item');
    }

    // csv escape
    private function _csvEscape($string)
    {
        return '"'.str_replace('"', '\"', $string).'"';
    }
}
