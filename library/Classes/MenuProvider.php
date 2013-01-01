<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuProvider
 *
 * @author przemo
 */
class Classes_MenuProvider {
    //put your code here
    
    private $_id;
    private $_model;
    
    public function __construct($id, $m=null){
            $this->_id=$id;
            if($m==null){
                $this->_model= new Application_Model_Menus();
                
            } else {
                $this->_model=$m;
            }
    }
    
    
    public function createMenu($id=null){
        $meta=$this->createMeta($id);
        $ret = '<ul class="'.$this->getMenuClass('class', $meta).'" id="'.$this->getMenuId('html_id', $meta).'">';
        $ret.=$this->prepareMenu($this->getMainMenuItems($meta[0]['id']));
        $ret.='</ul>';
        return $ret;
    }
    
    protected function prepareMenu($menuItems){
        $ret="";
        foreach($menuItems as $item){
            $ret.='<li><a href="'.$item['href'].'">'.$item['title'].'</a>';
            if(Application_Model_MenuItems::hasChildren($item['id'])){
                $ret.='<ul>';
                $ret.=$this->prepareMenu(Application_Model_MenuItems::getChildren($item['id']));
                $ret.='</ul>';
            }
            $ret.='</li>';
        }
        return $ret;
    }
    
   
    protected function getMainMenuItems($menuId){
        $mi = new Application_Model_MenuItems();
        return $mi->fetchAll('menus_id='.$this->_id.' and parent_id is null')->toArray();
    }
    

    public function getId(){
        return $this->_id;
    }
    
    
    
    public function getModel(){
        return $this->_model;
    }
    
    
    protected function createMeta($id=null){
        if($id==null)
            $r = $this->_model->fetchAll('id='.$this->_id);
        else {
            $r = $this->_model->fetchAll('id='.$id);
        }
           $r=$r->toArray();
        return $r;
    }
    /*
     * TODO remove this function or narrow its access modifier. This is only diagnostic.
     */
    public function getDescription(){
        return $this->getClass();
    }
            
    private function getMenuClass($className, $meta){
        return $meta[0][$className];
        
        
    }
    
    private function getMenuId($menu_id, $meta){
        return $meta[0][$menu_id];
    }
}

?>
