<?php

namespace Items\Cmd;
require_once dirname(__FILE__) . '/Base/CmdAbstract.php';

class compass extends Base\CmdAbstract
{
    public function run (array $params)
    {
        try {
            if (! isset($params[0])) {
                throw new \Exception('need sass file parameter!');
            }

            if (! file_exists(ROOT_PATH . '/public_html/resources/sass/' . $params[0] . '.scss')) {
                throw new \Exception(sprintf('%s.scss is not found!', $params[0]));
            }

            $path = 'public_html/resources/sass';
            chdir($path);

            $cmd = 'compass compile ' . $params[0] . '.scss';

            try {
                exec($cmd, $output);

                foreach ($output as $p) {
                    $this->log($p);
                }
                
            } catch (\RunTimeException $run) {
                throw $run;
            }
        
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function help ()
    {
        /* write help message */
        $msg = 'sassファイルをコンパスコンパイル';

        return $msg;
    }
}
