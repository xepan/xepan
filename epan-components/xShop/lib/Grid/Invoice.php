<?php

namespace xShop;

class Grid_Invoice extends \Grid{
	function init(){
		parent::init();

		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xShop/View_Invoice',array('invoice'=>$p->add('xshop/Model_Invoice')->load($p->api->stickyGET('invoice_clicked'))));
		});
		
		$this->vp_order = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('sales_order_no_clicked');
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
		});
	}
	
	function format_view($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Invoice', $this->api->url($this->vp->getURL(),array('invoice_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['sales_order'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['sales_order_id']))).'">'. $this->current_row[$field] ."</a>";
	}
	
	function setModel($invoice_model){
		$m=parent::setModel($invoice_model,array('name','customer','amount','created_at','sales_order'));
		$this->addFormatter('name','view');
		$this->addFormatter('sales_order','orderview');
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_invoice_items','descr'=>'Items'));

		return $m;
	}
	

	}	