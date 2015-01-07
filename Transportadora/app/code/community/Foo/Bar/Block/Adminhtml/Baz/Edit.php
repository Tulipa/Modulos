<?php
class Foo_Bar_Block_Adminhtml_Baz_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'foo_bar';
        $this->_controller = 'adminhtml_baz';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Salvar Transportadora'));
        $this->_updateButton('delete', 'label', $this->__('Apagar Transportadora'));
    }  
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
        if (Mage::registry('foo_bar')->getId()) {
            return $this->__('Editar Transportadora');
        }  
        else {
            return $this->__('Nova Transportadora');
        }  
    }  
}