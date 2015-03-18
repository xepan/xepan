<?php

namespace xShop;

class Grid_Order extends \Grid {

	function init(){
		parent::init();
		$self = $this;

		$this->add('VirtualPage')->addColumn('col_name','title','btn_text',$this)->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->load($p->id);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
		});
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
		$this->addQuickSearch(array('order_id'));
		return $m;
	}	

}