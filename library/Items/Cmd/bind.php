<?php

namespace Items\Cmd;
require_once dirname(__FILE__) . '/Base/CmdAbstract.php';

class bind extends Base\CmdAbstract
{
    public function run (array $params)
    {
        try {
            $path = 'library/bind';

            if (count($params) === 0) {
                $path .= DS . 'Items';
            } else {
                $path .= DS . $params[0];
            }

            if (! is_dir($path)) {
                $this->logError('this param is failed!');
                return false;
            }

            $cmd = 'java -jar ' . $path . '/../compiler.jar ';
            // $cmd = 'java -jar ' . $path . '/../compiler.jar --compilation_level ADVANCED_OPTIMIZATIONS ';

            $yaml = new \Zend_Config_Yaml($path . DS . 'files.yaml');

            foreach ($yaml->src as $s) {
                $cmd .= '--js ' . $yaml->path . $s . ' ';
            }

            $cmd .= '--js_output_file ' . $yaml->dest;

            try {
                exec($cmd, $output, $error);
            
            } catch (RunTimeException $run) {
                throw $run;
            }
        
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function help ()
    {
        /* write help message */
        $msg = '';

        return $msg;
    }
}
