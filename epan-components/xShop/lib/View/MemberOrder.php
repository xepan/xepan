<?php

namespace xShop;

class View_MemberOrder extends \View{
	public $ipp = 10;
	public $gridFields = array('name','created_date','total_amount','gross_amount','tax','net_amount','billing_address','shipping_address');
	function init(){
		parent::init();

		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url("xShop/page_printorder",array('order_id'=>$_GET['print'],'cut_page'=>1,'subpage'=>'xshop-junk')),null,'height=689,width=1246,scrollbar=1')->execute();
		}  
		
		$m = $this->add('xShop/Model_MemberDetails');
		$m->loadLoggedIn();
		$order=$this->add('xShop/Model_Order');
		$order->getAllOrder($m->id);
		
		$grid=$this->add('Grid');
		$order->_dsql()->order('id','desc');
		$grid->setModel($order,$this->gridFields);

		$grid->addColumn('button','print');
		$grid->addPaginator($this->ipp);
		$grid->addQuickSearch(array('name','created_date'));	
	}  
}
