<?php
class Foo_Bar_Adminhtml_BazController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {  
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }  
     
    public function newAction()
    {  
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }  
     
    public function deleteAction()
    {
		        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('foo_bar/baz');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Esta Transporadora não está cadastrada.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
		try {
			$model->delete();
			Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Transporadora Excluida!'));
			$this->_redirect('*/*/');     
 
            return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
			catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Oops! Isto não era para acontecer...'));
            }
		  
	}
    public function editAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('foo_bar/baz');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Esta Transporadora não está cadastrada.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
     
        $this->_title($model->getId() ? $model->getName() : $this->__('Nova Transportadora'));
     
        $data = Mage::getSingleton('adminhtml/session')->getBazData(true);
	
       if (!empty($data)) {
            $model->setData($data);
        }  
     
        Mage::register('foo_bar', $model);
     
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Baz') : $this->__('New Baz'), $id ? $this->__('Edit Baz') : $this->__('New Baz'))
            ->_addContent($this->getLayout()->createBlock('foo_bar/adminhtml_baz_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
	 /*		*/
    }
     
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('foo_bar/baz');
			//print_r( $model);
			//print_r($postData);
            $model->setData($postData);
			//print_r( $model);
            
 
         try {
                $model->save();
 
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Transporadora Salva!'));
				
             $this->_redirect('*/*/');     
 
                return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Oops! Isto não era para acontecer...'));
            }
 
           Mage::getSingleton('adminhtml/session')->setBazData($postData);
           $this->_redirectReferer();
		/*	*/
        }
	
    }
     
    public function messageAction()
    {
        $data = Mage::getModel('foo_bar/baz')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
     
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('sales/foo_bar_baz')
            ->_title($this->__('Transportadora'))
            ->_addBreadcrumb($this->__('Transportadora'), $this->__('Transportadora'));
         
        return $this;
    }
     
    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/foo_bar_baz');
    }
}