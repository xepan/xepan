<?php
namespace xDispatch;
class Grid_DispatchRequestItem extends \Grid{
	
	function init(){
		parent::init();

		$this->vp_order = $this->add('VirtualPage')->set(function($p){
			$p->api->stickyGET('sales_order_no_clicked');
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});

		$this->vp_dispatchrequest = $this->add('VirtualPage')->set(function($p){
			$p->api->stickyGET('dispatch_request_clicked');
			$p->add('xDispatch/View_DispatchRequest',
				array(
					'dispatchrequest'=>$this->add('xDispatch/Model_DispatchRequest')->load($_GET['dispatch_request_clicked'])
					)
				);
		});

		$this->addColumn('order');
		// $this->addQuickSearch(array('status','order'));
		$this->addPaginator($ipp=50);
	}

	function format_order($field){	
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model->orderItem()->order()->get('name'), $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model->orderItem()->order()->id))).'">'. $this->model->orderItem()->order()->get('name') ."</a>";
	}

	function format_dispatchrequest($field){

		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Dispatch Request '. $this->model['dispatch_request'], $this->api->url($this->vp_dispatchrequest->getURL(),array('dispatch_request_clicked'=>$this->model['dispatch_request_id']))).'">'. $this->current_row[$field] ."</a>";
	}

	function setModel($dispatch_request, $fields=null){
		
		if(!$fields)
			$fields= array('dispatch_request','orderitem_id','item_name','item','item_with_qty_fields','qty','unit');

		$m=parent::setModel($dispatch_request,$fields);

		$this->addFormatter('dispatch_request','dispatchrequest');
		$this->addFormatter('order','order');
		
		$this->removeColumn('item_with_qty_fields');
		$this->removeColumn('item');
		$this->removeColumn('orderitem_id');
		return $m;
	}

}