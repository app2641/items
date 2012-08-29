<?php

/**
 * @role guest
 */
class ApiController extends Zend_Controller_Action
{
    const DESCRIPTOR = 'Items.REMOTING_API';
    const TYPE = 'remoting';
    const URL = '/direct.php';
    const TIMEOUT = 300000;

    private $currentUser;



    public function indexAction()
    {
        $this->currentUser = Bootstrap::$currentUser;

        // API取得
        $ret = sprintf(
            'eval(%s = %s);',
            self::DESCRIPTOR,
            json_encode($this->getApi())
        );

        // ヘッダー送信
        header('Content-Type: text/javascript');

        // 結果出力
        print $ret;
        exit();
    }



    private function getApi()
    {
        $ret = array(
            'url' => self::URL,
            'type' => self::TYPE,
            'timeout' => self::TIMEOUT,
            'actions' => $this->getRpcActions()
        );

        return $ret;
    }



    private function getRpcActions()
    {
        $config  = new Zend_Config_Ini(APPLICATION_PATH . '/configs/direct.ini', 'production');
        $config  = $config->toArray();
        $modules = $config['modules'];

        // メソッド一覧取得
        $actions = array();

        foreach ($modules as $module) {

            $Class = new $module;
            $class = get_class($Class);
            $methods = get_class_methods($class);

            $actions[$class] = array();

            foreach ($methods as $method) {

                $ref = new ReflectionMethod($class, $method);

                $count = count($ref->getParameters());
                $methods = array('name' => $method, 'len' => $count);

                if ($ref->isPublic() &&
                    strlen($ref->getDocComment()) > 0) {

                    $doc = $ref->getDocComment();

                    if (!!preg_match('/@formHandler/', $doc)) {
                        $methods['formHandler'] = true;
                    }

                    if(preg_match('/@role/', $doc)) {
                        preg_match('/@role.*/', $doc, $matches);
                        $role = trim(str_replace('@role', '', $matches[0]));
                        $actions[$class][] = $methods;

                    } else {
                        $actions[$class][] = $methods;
                    }

                } else {
                    $actions[$class][] = $methods;
                }
            }
        }

        return $actions;
    }


}
