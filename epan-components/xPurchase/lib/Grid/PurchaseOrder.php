<?php

namespace xPurchase;

class Grid_PurchaseOrder extends \Grid {

	function init(){
		parent::init();
	// 	$self = $this;

	// 	$this->add('VirtualPage')->addColumn('col_name','title','btn_text',$this)->set(function($p)use($self){
	// 		$o = $p->add('xShop/Model_Order')->load($p->id);
	// 		$order = $p->add('xShop/View_Order');
	// 		$order->setModel($o);
	// 	});
	// }
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