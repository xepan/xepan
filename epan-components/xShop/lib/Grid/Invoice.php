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

		$this->addPaginator($ipp=50);
	}
	
	function format_view($field){
		$this->setTDParam('name','style','width:180px;');
		if($this->model['invoiceitem_count']==0){
			$this->setTDParam($field, 'class', ' atk-swatch-yellow ');
		}else{
			$this->setTDParam($field, 'class', '');
		}

		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Invoice', $this->api->url($this->vp->getURL(),array('invoice_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>".'<br><small title="'.$this->model['customer'].'" style="color:gray;width:100px;">'.$this->model['customer'].'</small>';
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['sales_order'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['sales_order_id']))).'">'. $this->current_row[$field] ."</a>";
	}
	
	function setModel($invoice_model,$field=array()){
		$invoice_model->getField('total_amount')->caption('Amount');
		if(!$field)
			$field = array('name','sales_order','customer','total_amount','discount','tax','net_amount','customer_id','created_at','invoiceitem_count','gross_amount','shipping_charge');
		$m=parent::setModel($invoice_model,$field);
		
		$this->addFormatter('name','view');
		$this->addFormatter('name','Wrap');
		$this->addFormatter('sales_order','orderview');
		$this->addFormatter('sales_order','Wrap');
		// if($invoice_model['status'] == 'draft' or $invoice_model['status'] == 'redesign')
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_invoice_items','descr'=>'Items'));
		
		if($this->hasColumn('customer_id')){
			$this->removeColumn('customer_id');
			$this->removeColumn('customer');
		}

		if($this->hasColumn('invoiceitem_count'))$this->removeColumn('invoiceitem_count');
		
		if($this->hasColumn('tax'))$this->removeColumn('tax');
		if($this->hasColumn('gross_amount'))$this->removeColumn('gross_amount');
		if($this->hasColumn('discount'))$this->removeColumn('discount');
		if($this->hasColumn('shipping_charge'))$this->removeColumn('shipping_charge');
		if($this->hasColumn('net_amount'))$this->removeColumn('net_amount');

		$this->addQuickSearch($invoice_model->getActualFields());

		return $m;
	}
	
	function formatRow(){
		// $this->setTDParam('net_amount','style','min-width:100px;');
		$hr = '<hr style="margin:0px;"/>';
		$amount = '<div class="atk-row atk-size-micro">';
		$amount .= '<div class="atk-col-4">';
		$amount.= 'Total Amount<br/>';
		if($this->model['tax']>0)	
			$amount.= 'Tax'.$hr;
		$amount.= 'Gross Amount<br/>';
		if($this->model['discount']>0)
			$amount.= 'Discount Amount'.'<br/>';
		if($this->model['shipping_charge'])	
			$amount.= 'Shipping Charge'.'<br/>';

		$amount .= $hr;
		$amount .= 'Net Amount';
		$amount .= '</div>';
			
		$amount .= '<div class="atk-col-8 pull-right">';
		$amount .= $this->model['total_amount'].'<br/>';
		if($this->model['tax']>0)
			$amount .= $this->model['tax'].$hr;
		$amount .= $this->model['gross_amount'].'<br/>';
		
		if($this->model['discount']>0)
			$amount .= $this->model['discount'].'<br/>';
		if($this->model['shipping_charge'])
			$amount .= $this->model['shipping_charge'].'<br/>';
		// $amount .= $hr;
		$amount .= $hr;
		$amount .= '<b>'.$this->model['net_amount'].'</b>';
		$amount .= '</div>';
		$amount .= '</div>';

		$this->current_row_html['total_amount'] = $amount;
		
		parent::formatRow();
	}

	}	