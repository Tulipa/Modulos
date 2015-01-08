<?php

class Inchoo_Shipping_Model_Carrier
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * Carrier's code, as defined in parent class
     *
     * @var string
     */
    protected $_code = 'inchoo_shipping';

    /**
     * Returns available shipping rates for Inchoo Shipping carrier
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
		  if ($this->_inicialCheck($request) === false) {
            return false;
        }

        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');

        /** @var Inchoo_Shipping_Helper_Data $expressMaxProducts */
        $expressMaxWeight = Mage::helper('inchoo_shipping')->getExpressMaxWeight();

        $expressAvailable = true;
        foreach ($request->getAllItems() as $item) {
            if ($item->getWeight() > $expressMaxWeight) {
                $expressAvailable = false;
            }
        }

        if ($expressAvailable) {
            $result->append($this->_getExpressRate($request));
        }
        $result->append($this->_getStandardRate($request));

        return $result;
    }
	
	    protected function _inicialCheck(Mage_Shipping_Model_Rate_Request $request)
    {


 
        $destCountry = $request->getDestCountryId();
        if ( $destCountry != 'BR') {
            // Out of delivery area
            Mage::log('Out of delivery area');
            return false;
        }

// Mage::getSingleton('core/session')->addNotice($request->getDestPostcode());
 
        $this->_toZip   = $request->getDestPostcode();
if ( $this->_toZip == '') {
	return false;
}

        // Fix ZIP code
     
        $this->_toZip   = str_replace(array('-', '.'), '', trim($this->_toZip));

        if (!preg_match('/^([0-9]{8})$/', $this->_toZip)) {
            Mage::log(' From ZIP Code Error');
            return false;
        }



    }

    /**
     * Returns Allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array(
            'standard'    =>  'Standard delivery',
            'express'     =>  'Express delivery',
        );
    }

    /**
     * Get Standard rate object
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getStandardRate(Mage_Shipping_Model_Rate_Request $request)
    {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');
		$this->_toZip   = $request->getDestPostcode();
		/*recuperar inf dos produtos*/
		
		$items = Mage::getModel('checkout/cart')->getQuote()->getAllVisibleItems();

        foreach ($items as $item) {
            $_product = $item->getProduct();

            if ($_product->getData('volume_altura') == '' || (int) $_product->getData('volume_altura') == 0) {
                $itemAltura = 0;
            } else {
                $itemAltura = $_product->getData('volume_altura');
            }

            if ($_product->getData('volume_largura') == '' || (int) $_product->getData('volume_largura') == 0) {
                $itemLargura = 0;
            } else {
                $itemLargura = $_product->getData('volume_largura');
            }

            if ($_product->getData('volume_comprimento') == '' || (int) $_product->getData('volume_comprimento') == 0) {
                $itemComprimento = 0;
            } else {
                $itemComprimento = $_product->getData('volume_comprimento');
            }
	
		 $pesoCubicoTotal += (($itemAltura * $itemLargura * $itemComprimento) * $item->getQty()) ;
	
        }
		
		
	    $prefix = Mage::getConfig()->getTablePrefix();
		$resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
		$query = 'SELECT  preco *('. ($pesoCubicoTotal/1000000).'/fator) FROM '.$prefix.'foo_bar_baz where cepini <= '.$this->_toZip.' and cepfim >= '.$this->_toZip.'  limit 1';
		//Mage::getSingleton('core/session')->addNotice($query);
		$valorfrete = $readConnection->fetchOne($query);
		$query = 'SELECT  prazo FROM '.$prefix.'foo_bar_baz where cepini <= '.$this->_toZip.' and cepfim >= '.$this->_toZip.'  limit 1';
		$prazo = $readConnection->fetchOne($query);
		
		//Mage::getSingleton('core/session')->addNotice($this->_volumeWeight);
		

        //$this->_volumeWeight = number_format($pesoCubicoTotal, 2, '.', '');
		

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('Transportadora');
        $rate->setMethodTitle("Em média $prazo dias");
        $rate->setPrice($valorfrete);
        $rate->setCost(0);

        return $rate;
    }




    /**
     * Get Express rate object
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getExpressRate()
    {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate 
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('express');
        $rate->setMethodTitle('Express delivery');
        $rate->setPrice(12.3);
        $rate->setCost(0);

        return $rate;*/
    }
}