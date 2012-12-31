<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $users = new Application_Model_DbTable_Users();
        if($users->fetchAll()->count()==0){
            $this->view->numofusers='No users!';
            
            $users->insert(array('id'=>'1', 'username'=>'nikt', 'password'=>'password'));
        } else {
            
            $u = $users->fetchAll()->current();
            $this->view->u=$u->id;
        }
    }

    public function indexAction()
    {
        // action body
    }


}

