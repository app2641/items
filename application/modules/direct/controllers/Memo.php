<?php

class Memo
{
    // memo load
    public function loadData ()
    {
        $path = ROOT_PATH.'/data/fixtures/memo.txt';

        if (file_exists($path)) {
            $memo = file_get_contents($path);
            return array('success' => true, 'data' => array('memo' => $memo));
        
        } else {
            return array('success' => true, 'data' => array('memo' => ''));
        }
    }


    /**
     * @formHandler
     * memoの更新
     */
    public function updateData ($request)
    {
        $memo = $request['memo'];
        $path = ROOT_PATH.'/data/fixtures/memo.txt';

        if (! file_exists($path)) {
            touch($path);
        }

        $fp = fopen($path, 'w');
        @fwrite($fp, $memo, strlen($memo));
        fclose($fp);

        return array('success' => true);
    }
}
