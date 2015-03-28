<?php
namespace xShop;
class View_Invoice extends  \CompleteLister{
	public $invoice;
	public $sno=1;

	function init(){
		parent::init();
		
		$self = $this;
		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('sales_order_clicked');
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_clicked']);
			$view_order = $p->add('xShop/View_Order');
			$view_order->setModel($o);
		});


		$this->template->setHtml('invoice_no',$this->invoice['name']);
		$this->template->setHtml('billing_address',$this->invoice['billing_address']);
		$this->template->setHtml('customer_name',$this->invoice->ref('customer_id')->get('customer_name'));
		$this->template->setHtml('billing_address',$this->invoice['billing_address']);
		$this->template->setHtml('mobile_no',$this->invoice->ref('customer_id')->get('mobile_number'));
		$this->invoice['type']?$this->template->setHtml('type',"Invoice: <b>".ucwords($this->invoice['type'])."</b>"):"";
		$this->invoice['sales_order']?$this->template->setHtml('sales_order_no',"Sales Order No: <b>".'<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->invoice['sales_order'], $this->api->url($this->vp->getURL(),array('sales_order_clicked'=>$this->invoice['sales_order_id']))).'">'.$this->invoice['sales_order']."</a></b>"):"";

		$this->invoice['po']?$this->template->setHtml('po',"Purchase Order No: <b>".ucwords($this->invoice['po'])."</b>"):"";
		
		$this->setModel($this->invoice->itemrows());
	}

	function formatRow(){
		 $this->current_row['sno']=$this->sno;
		// $this->current_row('item',$this->invoice['name']);
		// $this->current_row('qty',$this->invoice['name']);
		// $this->current_row('unit',$this->invoice['name']);
		// $this->current_row('rate',$this->invoice['name']);
		// $this->current_row('discount',$this->invoice['name']);
		// $this->current_row('net_amount',$this->invoice['name']);
		$this->sno++;
	}
		
	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		
		
		return array('view/invoice');
	}
	
  
}