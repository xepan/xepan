<?php

namespace xShop;

class View_SalesInvoiceDetail extends \CompleteLister{
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
			
			$this->template->set('gross_amount',$invoice['gross_amount']);
			//$this->template->set('delivery_date',$model['delivery_date']);
			// $this->template->set('discount_voucher',$model['discount_voucher']);
			$this->template->set('discount_voucher_amount',$invoice['discount_voucher_amount']?:'0.00');
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
		return array('view/xShop-salesinvoiceDetail');
	}

}