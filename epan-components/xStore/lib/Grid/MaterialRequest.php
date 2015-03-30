<?php
namespace xStore;

class Grid_MaterialRequest extends \Grid{
		function init(){
		parent::init();
		$self= $this;
		$this->addSno();

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xStore/View_MaterialRequest',array('materialrequest'=>$p->add('xStore/Model_MaterialRequest')->load($p->api->stickyGET('material_request_clicked'))));
		});

		$this->vp_order = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->loadBy('name',$_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});
	}
	
	function format_view($field){		
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Material Request', $this->api->url($this->vp->getURL(),array('material_request_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['order_no'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['order_no']))).'">'. $this->current_row[$field] ."</a>";
	}


	function setModel($model){
		$m=parent::setModel($model,array('order_no','name','created_by','from_department','to_department','forwarded_to'));
		$this->addFormatter('name','view');
		$this->addFormatter('order_no','orderview');
		return $m;
	}
}
