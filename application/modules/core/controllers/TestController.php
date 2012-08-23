<?php

class TestController extends Zend_Controller_Action
{
    public function init ()
    {
        $this->view->layout()->disableLayout();
    }

    public function indexAction ()
    {
        
    }

    public function authAction ()
    {
        $auth = \Zend_Registry::get('auth');
        $token = sha1(md5(uniqid(rand())));

        $_SESSION['auth_token'] = $token;
        $this->view->token = $token;

        if ($auth->isAuth()) {
            $auth->clearStorage();
        }
    }

    public function backendAction ()
    {
        $auth = \Zend_Registry::get('auth');

        if (! $auth->isAuth()) {
            $this->_redirect('/test/auth');
        }
    }

    public function editAction ()
    {
        $id = $this->getRequest()->getParam('id');
        $this->view->id = $id;
    }

    public function createAction ()
    {
        
    }
}
