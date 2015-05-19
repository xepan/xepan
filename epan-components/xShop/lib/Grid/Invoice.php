<?php

namespace xShop;

class Grid_Invoice extends \Grid{
	function init(){
		parent::init();

		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('invoice_clicked');
			$p->add('xShop/View_SalesInvoice',array('invoice'=>$p->add('xShop/Model_SalesInvoice')->load($_GET['invoice_clicked'])));
		});
		
		$this->vp_order = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('sales_order_no_clicked');
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
		});

		$sale_invoice_print = $this->addColumn('Button','print');
		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url('xShop_page_owner_printsaleinvoice',array('saleinvoice_id'=>$_GET['print'],'cut_page'=>0)))->execute();
		}

		$this->addPaginator($ipp=100);
	}
	
	function format_view($field){
		if($this->model['invoiceitem_count']==0){
			$this->setTDParam($field, 'class', ' atk-swatch-yellow ');
		}else{
			$this->setTDParam($field, 'class', '');
		}

		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Invoice', $this->api->url($this->vp->getURL(),array('invoice_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>".'<br><small style="color:gray;">'.$this->model['customer'].'</small>';
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['sales_order'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['sales_order_id']))).'">'. $this->current_row[$field] ."</a>";
	}
	
	function setModel($invoice_model,$field=array()){
		if(!$field)
			$field = array('name','invoice_no','sales_order','customer','total_amount','discount','tax','net_amount','customer_id');

		$m=parent::setModel($invoice_model,$field);
		$this->addFormatter('name','view');
		$this->addFormatter('sales_order','orderview');
		// if($invoice_model['status'] == 'draft' or $invoice_model['status'] == 'redesign')
			$this->addColumn('expander','items',array('page'=>'xShop_page_owner_invoice_items','descr'=>'Items'));
		
		$this->removeColumn('customer');
		$this->removeColumn('invoiceitem_count');
		return $m;
	}
	

	}	