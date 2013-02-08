<?php
class Cammino_Undocancel_Adminhtml_Sales_OrderController extends Mage_Adminhtml_Controller_Action
{

	public function undocancelAction()
	{
		$id = $this->getRequest()->getParam('order_id');
		$order = Mage::getModel('sales/order')->load($id);

		try {
			foreach($order->getItemsCollection() as $item) {
				if ($item->getQtyCanceled() > 0) $item->setQtyCanceled(0)->save();
			}
		
			$order->setBaseDiscountCanceled(0)
				->setBaseShippingCanceled(0)
				->setBaseSubtotalCanceled(0)
				->setBaseTaxCanceled(0)
				->setBaseTotalCanceled(0)
				->setDiscountCanceled(0)
				->setShippingCanceled(0)
				->setSubtotalCanceled(0)
				->setTaxCanceled(0)
				->setTotalCanceled(0);

			$state = 'new';
			$status = 'pending';

			$order->setStatus($status)
				->setState($state)
				->save();

			$this->_getSession()->addSuccess($this->__('Order was successfully uncancelled.'));
		}
		catch (Mage_Core_Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
		catch (Exception $e) {
			$this->_getSession()->addError($this->__('Order was not uncancelled.'));
		}

		$this->_redirect('*/sales_order/view', array('order_id' => $order->getId()));
	}

}
?>