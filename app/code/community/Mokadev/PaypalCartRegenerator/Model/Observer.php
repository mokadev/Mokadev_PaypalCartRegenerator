<?php
/**
 * PaypalCartRegenerator observer
 *
 * @category   Mokadev
 * @package    Mokadev_PaypalCartRegenerator
 * @author     Mohamed Kaïd <mohamed@mokadev.com>
 */

class Mokadev_PaypalCartRegenerator_Model_Observer
{

    /**
     * Get last quote
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {

        $session = Mage::getSingleton('checkout/session');

        if ($session->getQuoteId()){
            $quote = Mage::getModel('sales/quote')->load($session->getQuoteId());
            if ($quote->getId()) return $quote;
        }

        return false;
    }

    /**
     * put the cart back when a paypal order is canceled
     *
     * @param $observer
     * @return Mokadev_PaypalCartRegenerator_Model_Observer
     */
    public function cartRegenerator($observer)
    {
        $quote = $this->_getQuote();
        if ($quote){
            $session = Mage::getSingleton('checkout/session');
            $session->replaceQuote($quote);
            $quote->setIsActive(true)
                ->save();
        }

        return $this;
    }
}