<?php
class Foo_Bar_Block_Adminhtml_Baz_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('foo_bar_baz_form');
        $this->setTitle($this->__('Dados da Transportadora'));
    }  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  
        $model = Mage::registry('foo_bar');
     
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Dados da Transportadora'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }  
     
        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('checkout')->__('Name'),
            'title'     => Mage::helper('checkout')->__('Name'),
            'required'  => true,
        ));
		
		$fieldset->addField('regiao', 'text', array(
            'name'      => 'regiao',
            'label'     => Mage::helper('checkout')->__('Região'),
            'title'     => Mage::helper('checkout')->__('Região'),
            'required'  => true,
        ));
		
		$fieldset->addField('cepini', 'text', array(
            'name'      => 'cepini',
            'label'     => Mage::helper('checkout')->__('Cep Inicial'),
            'title'     => Mage::helper('checkout')->__('Cep Inicial'),
            'required'  => true,
        ));
		
		$fieldset->addField('cepfim', 'text', array(
            'name'      => 'cepfim',
            'label'     => Mage::helper('checkout')->__('Cep Final'),
            'title'     => Mage::helper('checkout')->__('Cep Final'),
            'required'  => true,
        ));
		
		$fieldset->addField('prazo', 'text', array(
            'name'      => 'prazo',
            'label'     => Mage::helper('checkout')->__('Prazo'),
            'title'     => Mage::helper('checkout')->__('Prazo'),
            'required'  => true,
        ));
		
		$fieldset->addField('preco', 'text', array(
            'name'      => 'preco',
            'label'     => Mage::helper('checkout')->__('Preço'),
            'title'     => Mage::helper('checkout')->__('Preço'),
            'required'  => true,
        ));
	
     	$fieldset->addField('fator', 'text', array(
            'name'      => 'fator',
            'label'     => Mage::helper('checkout')->__('Fator'),
            'title'     => Mage::helper('checkout')->__('Fator'),
            'required'  => true,
        ));
	 
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }  
}