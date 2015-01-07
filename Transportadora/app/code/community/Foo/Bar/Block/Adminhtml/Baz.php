<?php
class Foo_Bar_Block_Adminhtml_Baz extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        // The blockGroup must match the first half of how we call the block, and controller matches the second half
        // ie. foo_bar/adminhtml_baz
        $this->_blockGroup = 'foo_bar';
        $this->_controller = 'adminhtml_baz';
        $this->_headerText = $this->__('Transportadoras');
         
        parent::__construct();
    }
}