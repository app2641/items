<?php

namespace Items\Cmd;
require_once dirname(__FILE__) . '/Base/CmdAbstract.php';

class dump extends Base\CmdAbstract
{
    public function run (array $params)
    {
        try {
            $config = new \Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini', 'database');

            $user = $config->db->username;
            $pass = $config->db->password;

            $cmd = sprintf("mysqldump5 -u %s --password='%s' items > %s",
                $user,
                $pass,
                ROOT_PATH.'/data/fixtures/items.db');

            system($cmd, $ret);
        
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function help ()
    {
        /* write help message */
        $msg = 'databaseデータをdata/fixtures/items.dbへダンプする';

        return $msg;
    }
}
