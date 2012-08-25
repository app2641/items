<?php

class IndexController extends \Zend_Controller_Action
{
    public function indexAction()
    {
    }

    public function downloadcsvAction ()
    {
        $name = $this->getRequest()->getParam('name');
        $csv = '/tmp/items/'.$name.'.csv';

        if (! file_exists($csv)) {
            throw new \Exception(sprintf('%s is not found!'), $csv);
        }

        header('Content-Disposition: attachment; filename="' . $name . '.csv"');
        header('Content-Type: text/csv;');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($csv));
        readfile($csv);

        exit();
    }
}
