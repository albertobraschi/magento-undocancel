<?php
class Cammino_Undocancel_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View {

	public function  __construct() {

		parent::__construct();

		$order = $this->getOrder();

		if($order->isCanceled()) {
			$this->_addButton('uncancel', array(
				'label'     => __('Undo Cancel'),
				'onclick'   => 'deleteConfirm(\''. __('Do you really want undo cancel this order?') .'\', \''. $this->getUndocancelUrl() .'\')',
				'class'     => 'go'
			), 0, 100, 'header', 'header');
		}
	}

	private function getUndocancelUrl()
	{
		return $this->getUrl('*/*/undocancel');
	}

}
?>