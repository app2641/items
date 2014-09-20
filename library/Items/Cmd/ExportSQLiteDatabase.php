<?php

namespace Items\Cmd;
require_once dirname(__FILE__) . '/Base/CmdAbstract.php';

class ExportSQLiteDatabase extends Base\CmdAbstract
{
    public function run (array $params)
    {
        try {
            // fixtureへのパス
            $fixture_path = ROOT_PATH.'/data/fixtures';

            if (! file_exists($fixture_path.'/mixture_app_empty.sqlite')) {
                throw new \Exception('mixture_app_empty.sqliteが存在しません！');
            }

            if (file_exists($fixture_path.'/mixture_app.sqlite')) {
                unlink($fixture_path.'/mixture_app.sqlite');
            }

            // mixture_app.sqliteをコピー生成
            copy($fixture_path.'/mixture_app_empty.sqlite', $fixture_path.'/mixture_app.sqlite');


            // csvを拾ってインポート処理
            $pdo = new \PDO('sqlite:'.$fixture_path.'/mixture_app.sqlite');
            $conn = \Zend_Registry::get('conn');


            /**
             * important table
             **/
            $sql = 'select * from important';
            $results = $conn->state($sql)->fetchAll();

            foreach ($results as $result) {
                $sql = 'insert into important
                    (_id, name, description, experience)
                    VALUES (:id, :name, :desc, :experience)';

                $bind = array(
                    'id' => $result->id,
                    'name' => $result->name,
                    'desc' => $result->description,
                    'experience' => 0
                );

                $stmt = $pdo->prepare($sql);
                $stmt->execute($bind);
            }



            /**
             * item table
             **/
            $sql = 'select * from item';
            $results = $conn->state($sql)->fetchAll();

            foreach ($results as $result) {
                $sql = 'insert into item
                    (_id, name, description, class, rarity, price, exp,
                        experience, date, last_date, qty)
                    VALUES (:id, :name, :desc, :class, :rare, :price, :exp,
                        :experience, :date, :last, :qty)';

                $bind = array(
                    'id' => $result->id,
                    'name' => $result->name,
                    'desc' => $result->description,
                    'class' => $result->class,
                    'rare' => $result->rarity,
                    'price' => $result->price,
                    'exp' => $result->exp,
                    'experience' => 0,
                    'date' => null,
                    'last' => null,
                    'qty' => 0
                );

                $stmt = $pdo->prepare($sql);
                $stmt->execute($bind);
            }



            /**
             * level_note
             **/
            $sql = 'select * from level_note';
            $results = $conn->state($sql)->fetchAll();

            foreach ($results as $result) {
                $sql = 'insert into level_note
                    (_id, level, note) VALUES (:id, :level, :note)';

                $bind = array(
                    'id' => $result->id,
                    'level' => $result->level,
                    'note' => $result->note
                );

                $stmt = $pdo->prepare($sql);
                $stmt->execute($bind);
            }



            /**
             * material table
             **/
            $sql = 'select * from material';
            $results = $conn->state($sql)->fetchAll();

            foreach ($results as $result) {
                $sql = 'insert into material
                    (_id, name, description, class, rarity, price, experience,
                    date, last_date, qty) VALUES
                    (:id, :name, :desc, :class, :rare, :price, :experience,
                    :date, :last_date, :qty)';

                $bind = array(
                    'id' => $result->id,
                    'name' => $result->name,
                    'desc' => $result->description,
                    'class' => $result->class,
                    'rare' => $result->rarity,
                    'price' => $result->price,
                    'experience' => 0,
                    'date' => null,
                    'last_date' => null,
                    'qty' => 0
                );

                $stmt = $pdo->prepare($sql);
                $stmt->execute($bind);
            }

            

            /**
             * mixin table
             **/
            $sql = 'select * from mixin';
            $results = $conn->state($sql)->fetchAll();

            foreach ($results as $result) {
                $sql = 'insert into mixin
                    (material1_id, material2_id, item_id, experience) VALUES
                    (:m1_id, :m2_id, :item_id, :experience)';

                $bind = array(
                    'm1_id' => $result->material1_id,
                    'm2_id' => $result->material2_id,
                    'item_id' => $result->item_id,
                    'experience' => 0
                );

                $stmt = $pdo->prepare($sql);
                $stmt->execute($bind);
            }


            $this->log('success!');

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function help ()
    {
        /* write help message */
        $msg = 'Databaseからデータを抽出してdata/fixtues/mixture_app.sqliteを生成する';

        return $msg;
    }
}
