<?php


namespace Items\CsvGenerator;

abstract class AbstractCsvGenerator
{
    protected
        $columns;


    abstract function execute ();

    
    /**
     * csvを生成する
     *
     * @author app2641
     */
    public function buildCsv ($data)
    {
        $csv = '';
        $c = ',';

        foreach ($data as $d) {
            foreach ($this->columns as $column) {
                $csv .= $this->_escapeDubleQuote($d->{$column}).$c;
            }

            $csv .= PHP_EOL;
        }

        return $csv;
    }



    /**
     * 指定パスに指定データを指定ファイル名で保存する
     *
     * @author app2641
     */
    public function generateFile ($path, $data)
    {
        if (file_exists($path)) {
            unlink($path);
        }

        touch($path);
        chmod($path, 0777);


        $fp = fopen($path, 'w');
        @fwrite($fp, $data, strlen($data));
        fclose($fp);
    }



    /**
     * ダブルクオートでエスケープする
     *
     * @author app2641
     */
    public function _escapeDubleQuote ($string)
    {
        return '"'.str_replace('"', '\"', $string).'"';
    }
}
