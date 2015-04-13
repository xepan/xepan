<?php

namespace xPurchase;

class View_PurchaseInvoiceDetail extends \CompleteLister{
	public $sno=1;
	public $show_price = false;
	function init(){
		parent::init();

	}

	function formatRow(){

		$this->current_row_html['sno']=$this->sno;
		$this->sno++;
	}

	function setModel($model){
		parent::setModel($model);

			$invoice= $model->ref('invoice_id');
			// $invoice= $model->ref('priority_id');
			// $this->template->set('gross_amount',$invoice['amount']);
			$this->template->set('total_amount',$invoice['total_amount']);
			//$this->template->set('delivery_date',$invoice['delivery_date']);
			// $this->template->set('discount_voucher',$invoice['discount_voucher']);
			$this->template->set('texted_amount',$invoice['tax']?:'0.00');
			$this->template->set('net_amount',$invoice['net_amount']);
			// $this->template->set('departments',"1");
			// $this->template->set('invoice_item_custom_field',$model['id']);
		
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
		return array('view/purchaseinvoiceDetail');
	}

}