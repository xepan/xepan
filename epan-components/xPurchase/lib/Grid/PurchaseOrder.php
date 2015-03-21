<?php

namespace xPurchase;

class Grid_PurchaseOrder extends \Grid {

	function init(){
		parent::init();
		}
	function setModel($m){
		parent::setModel($m);

		$self= $this;

		$vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xPurchase/View_PurchaseOrder',array('purchaseorder'=>$self->add('xPurchase/Model_PurchaseOrder')->load($_GET['purchase_order_clicked'])));
		});
		
		$this->js(true)->find('tr')->css('cursor','pointer');
		$this->on('click','tbody td:not(:has(button))',$this->js()->univ()->frameURL('Purchase Order',array($this->api->url($vp->getURL()),'purchase_order_clicked'=>$this->js()->_selectorThis()->closest('tr')->data('id'))));

		$this->addColumn('expander','purchase_order_item',array('page'=>'xPurchase_page_purchase_order_item'));


	function setModel($model,$fields=null){

		if($fields==null){
			$fields = array( 'created_at','name'
						// 'name','order_from','on_date','member',
						// 'net_amount','last_action'
						);
		}

		$m = parent::setModel($model,$fields);

		$this->addPaginator(100);
		$this->addQuickSearch(array('order_id'));
		return $m;
	}	

}
}