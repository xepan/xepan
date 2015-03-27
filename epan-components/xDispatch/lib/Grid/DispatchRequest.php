<?php
namespace xDispatch;
class Grid_DispatchRequest extends \Grid{
	
	function init(){
		parent::init();

		$this->vp_order = $this->add('VirtualPage')->set(function($p){
			$o = $p->add('xShop/Model_Order')->loadBy('name',$_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});

		$this->addQuickSearch(array('status','order'));
		$this->addPaginator($ipp=50);
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['order_no'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['order_no']))).'">'. $this->current_row[$field] ."</a>";
	}

	function setModel($dispatch_request, $fields=null){
		
		if(!$fields)
			$fields= array('order_no','name','created_at','from_department','forwarded_to');

		$m=parent::setModel($dispatch_request,$fields);

		if(in_array('order_no', $fields))
			$this->addFormatter('order_no','orderview');

		return $m;
	}

}