<?php

namespace xShop;

class Grid_Order extends \Grid {

	function init(){
		parent::init();
		$self = $this;

		$vp = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_clicked']);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
		});
		
		$this->js(true)->find('tr')->css('cursor','pointer');
		$this->on('click','tbody td:not(:has(button))',$this->js()->univ()->frameURL('Sales Order',array($this->api->url($vp->getURL()),'sales_order_clicked'=>$this->js()->_selectorThis()->closest('tr')->data('id'))));
	}


	function setModel($model,$fields=null){

		if($fields==null){
			$fields = array(
						'name','order_from','on_date','member',
						'net_amount','last_action'
						);
		}

		$m = parent::setModel($model,$fields);

		$this->addColumn('expander','details',array('page'=>'xShop_page_owner_order_detail','descr'=>'Details'));
		$this->addColumn('expander','attachment',array('page'=>'xShop_page_owner_attachment','descr'=>'Attachments'));
		$this->addColumn('Button','print');

		if($_GET['print']){			
			$this->js()->univ()->newWindow($this->api->url("xShop/page_printorder",array('order_id'=>$_GET['print'],'cut_page'=>1,'subpage'=>'xshop-junk')),null,'height=689,width=1246,scrollbar=1')->execute();
		} 



		$this->addPaginator(100);
		$this->addQuickSearch(array('order_id','order_from','on_date','discount_voucher'));
		return $m;
	}	

}