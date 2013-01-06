<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Translated_Form
 *
 * @author przemo
 */
class Classes_TranslatedForm extends Zend_Form{
    //put your code here
    
    private $translator;
    
    function __construct($translator, $options=null){
        parent::__construct($options);
        $this->translator = $translator;
    }
    
    function addElement($element, $name=null, $options=null){
        parent::addElement($element, $name, $options);
        $lab = $element->getLabel();
        $element->setLabel($this->translator->_($lab));
    }
}

?>
