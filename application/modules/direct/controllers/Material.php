<?php

use Items\Table\MaterialTable,
    Items\Filesystem;

class Material
{
    // ひとつぶんのデータを取得
    public function getData ($request)
    {
        $data = MaterialTable::fetchById($request->id);
        $data->description = preg_replace("/\n/", '<br />', $data->description);
        return $data;
    }


    /**
     * @formHandler
     *  materialレコードの追加
     */
    public function dataCreate ($request)
    {
        try {
            if (isset($request['is_active'])) {
                $active = true;
            } else {
                $active = false;
            }

            $sql = 'INSERT INTO material
                (name, description, class, price, exp, experience, is_active, created_at)
                VALUES (:name, :des, :cls, :price, :exp, :ex, :active, :create)';

            $conn = \Zend_Registry::get('conn');
            $stmt = $conn->prepare($sql);
            $stmt->execute(
                array(
                    'name' => $request['name'],
                    'des' => $request['description'],
                    'cls' => $request['class'],
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
        $data = MaterialTable::fetchById($id);
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

        $sql = 'UPDATE material
            SET name = :name,
            description = :des,
            class = :class,
            price = :price,
            exp = :exp,
            is_active = :active,
            updated_at = :update
            WHERE material.id = :id';

        $conn = \Zend_Registry::get('conn');
        $stmt = $conn->prepare($sql);
        $stmt->execute(
            array(
                'id' => $request['id'],
                'name' => $request['name'],
                'des' => $request['description'],
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
            $sql = 'DELETE FROM material
                WHERE material.id = ?';

            $conn = \Zend_Registry::get('conn');
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($request->id));
        
        } catch (\Exception $e) {
            return array('success' => false, 'msg' => $e->getMessage());
        }

        return array('success' => true);
    }

    
    // csv書き出し
    public function generateCsv ()
    {
        // tmpフォルダ作成
        Items\Filesystem::makeTmp();

        $data = MaterialTable::fetchAll();
        $csv = '';
        $c = ',';

        foreach ($data as $d) {
            $csv .= $this->_csvEscape($d->id).$c.$this->_csvEscape($d->name).$c.$this->_csvEscape($d->description).$c.
                $this->_csvEscape($d->class).$c.$this->_csvEscape($d->price).$c.$this->_csvEscape($d->exp).$c.
                $this->_csvEscape($d->experience).$c.$this->_csvEscape($d->is_active)."\n";
        }

        $file = '/tmp/items/material.csv';
        if (file_exists($file)) {
            unlink($file);
        }

        touch($file);

        $fp = fopen($file, 'w');
        @fwrite($fp, $csv, strlen($csv));
        fclose($fp);

        return array('success' => true, 'name' => 'material');
    }

    // csv escape
    private function _csvEscape($string)
    {
        return '"'.str_replace('"', '\"', $string).'"';
    }
}
