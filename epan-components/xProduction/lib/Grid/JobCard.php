<?php
namespace xProduction;

class Grid_JobCard extends \Grid{

	function init(){
		parent::init();
		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xProduction/View_Jobcard',array('jobcard'=>$p->add('xProduction/Model_JobCard')->load($p->api->stickyGET('jobcard_clicked'))));
		});

		$this->vp_order = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->loadBy('name',$_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});

	}
	
	function format_view($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Job Card '. $this->model['name'], $this->api->url($this->vp->getURL(),array('jobcard_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['order_no'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['order_no']))).'">'. $this->current_row[$field] ."</a>";
	}


	function setModel($job_card_model){
		$m=parent::setModel($job_card_model,array('order_no','name','created_at','orderitem','from_department','forwarded_to'));
		// $this->addFormatter('order_no','orderview');
		$this->addFormatter('name','view');

		return $m;
	}
}