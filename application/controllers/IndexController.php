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
            
            $u = $users->fetchAll($users->select());
            $umeta=$users->info();
            $ret='';
            foreach($u as $uu){
                foreach($umeta['cols'] as $col){
                    $ret.=$col.': '.$uu->$col.' ';
                }
                $ret.='<br/>';
            }
            
            $this->view->u=$ret;
        }
    }

    public function indexAction()
    {
        // action body
    }


}

