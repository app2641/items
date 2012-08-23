<?php

namespace Items\Cmd;
require_once dirname(__FILE__) . '/Base/CmdAbstract.php';

class generate extends Base\CmdAbstract
{
    public function run (array $params)
    {
        try {
            if (! isset($params[0])) {
                throw new \Exception ('fail parameter 0');
            }

            $class_name = $params[0];

            $path = dirname(__FILE__) . '/' . $class_name . '.php';
            $s_path = dirname(__FILE__) . '/Base/Skeleton/CmdSkeleton.php'; 

            if (! file_exists($s_path)) {
                throw new \Exception('skeleton file is not exists!');
            }

            $skeleton = file_get_contents($s_path);
            $skeleton = str_replace('{$class}', $class_name, $skeleton);

            touch($path);
            chmod($path, 0766);

            $fp = fopen($path, 'w');
            @fwrite($fp, $skeleton, strlen($skeleton));
            fclose($fp);

            $this->log('ganerate ' . $class_name . ' command!', 'success!');

        } catch (\Exception $e) {
            $this->logError($e->getMessage());
        }
    }

    public function help ()
    {
        /* write help message. */
        $msg = '新たなコマンドファイルを作成します。';

        return $msg;
    }
}
