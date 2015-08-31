<?php
namespace xShop;
class View_SalesInvoice extends  \CompleteLister{
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
		$this->invoice['billing_address']?$this->template->setHtml('billing_address',"Billing Address: ".$this->invoice['billing_address']):"";
		$this->template->setHtml('mobile_no',$this->invoice->ref('customer_id')->get('mobile_number'));
		$this->invoice['status']?$this->template->setHtml('status',"Invoice: <b>".ucwords($this->invoice['status'])."</b>"):"";
		$this->invoice['sales_order']?$this->template->setHtml('sales_order_no',"Sales Order No: <b>".'<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->invoice['sales_order'], $this->api->url($this->vp->getURL(),array('sales_order_clicked'=>$this->invoice['sales_order_id']))).'">'.$this->invoice['sales_order']."</a></b>"):"";

		$this->invoice['po']?$this->template->setHtml('po',"Purchase Order No: <b>".ucwords($this->invoice['po'])."</b>"):"";
		$this->template->trySetHtml('gross_amount',$this->invoice['gross_amount']?:'0.00');
		$this->template->trySetHtml('discount_voucher_amount',$this->invoice['discount_voucher_amount']?:'0.00');
		$this->template->trySetHtml('net_amount',$this->invoice['net_amount']);
		$this->template->trySetHtml('shipping_charge',$this->invoice['shipping_charge']?:'0.00');
		$this->template->trySetHtml('narration',$this->invoice['narration']);

		if(!$this->invoice['termsandcondition_id'])
			$this->template->del('tandc_section');
		else
			$this->template->trySetHTML('termsandcondition_matter',$this->invoice->ref('termsandcondition_id')->get('terms_and_condition'));

		$this->template->trySetHtml('currency',$this->invoice->currency());
		$this->setModel($this->invoice->itemrows());
	}

	function formatRow(){
		$this->current_row['sno']=$this->sno;
		$this->current_row['redable_custom_fields']=$this->model->item()->genericRedableCustomFieldAndValue($this->model['custom_fields']);
		$this->current_row['unit']=$this->model['unit'];

		$this->current_row['sub_total']=$this->model['qty']*$this->model['rate'];
		
		$shop_config = $this->add('xShop/Model_Configuration')->tryLoadAny();
		if($shop_config['is_round_amount_calculation']){
			$this->current_row['tax_amount']=round($this->model['tax_amount'],2);
		}
		$this->current_row_html['item_narration']= "<br/>Narration: ".$this->model['narration'];
		
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