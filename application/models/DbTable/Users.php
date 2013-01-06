<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    public function getMaxId(){
        return $this->fetchRow($this->select()->where('id=(select max(id) from users)'))->id;
    }
}

