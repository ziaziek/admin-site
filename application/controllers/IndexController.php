<?php

class IndexController extends Zend_Controller_Action
{

    private $translate = null;

    private $polish = array(
        'Password' => 'Hasło',
        'Username' => 'Użytkownik'
        );

    public function init()
    {
        /* Initialize action controller here */
        Zend_Loader::loadClass('Classes_TranslatedForm');
        try {
            $this->translate = new Zend_Translate(
        array(
            'adapter' => 'csv',
            'content' => APPLICATION_PATH. '/languages/pl.csv',
            'delimiter'=>',',
            'locale'  => 'pl',
        )
    );
    } catch(Exception $ex){
        $this->view->err=$ex->getMessage();
    }
            
        $users = new Application_Model_DbTable_Users();
        $r = $users->createRow(array('id'=>$users->getMaxId()+1, 'username'=>'pedal', 'password'=>'haslo'));
        $r->save();
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
        $f = new Classes_TranslatedForm($this->translate);
        $captcha = new Zend_Captcha_Image(array(
                'name' => 'foo_captcha',
                'wordLen' => 6,
                'timeout' => 300,
            ));
        $id = $captcha->generate();
        $f->setName('form1');
        $f->addElements(array(
            new Zend_Form_Element_Text('username', array('label'=>'Username')),
            new Zend_Form_Element_Password('password', array('label'=>'Password')),
            new Zend_Form_Element_Button('Clickme', array('label'=>'Click me')),
            new Zend_Form_Element_Submit('submit', array('label'=>'Submit button')),
            new Zend_Form_Element_MultiCheckbox('foo', array(
    'multiOptions' => array(
        'foo' => 'Foo Option',
        'bar' => 'Bar Option',
        'baz' => 'Baz Option',
        'bat' => 'Bat Option',
    )
)),
            $captcha,
            new Zend_Form_Element_Text('cap', array('label'=>'Enter the word'))
        ));
        $this->view->word=$captcha->getWord();
        $this->view->fc = $captcha->render();
        $f->getElement('foo')->setValue(array('bar', 'baz'));
        $f->setOptions(array('class'=>'loginform_class'));
        $this->view->form1=$f;
        
        //currency
        $curr = new Zend_Currency('PL');
        $curr->setValue(150);
        $this->view->amount=$curr;
        
        $date = '01.03.2000';
if (Zend_Date::isDate($date)) {
    print "String $date is a date";
} else {
    print "String $date is NO date";
}
    }

    public function errorAction()
    {
        // action body
        //$this->_forward('error', 'Error');
    }


}




