<?php

namespace xShop;

class View_SalesInvoiceDetail extends \CompleteLister{
	public $sno=1;
	public $show_price = false;
	public $show_customfield = false;
	function init(){
		parent::init();

	}

	function formatRow(){

		$this->current_row_html['departments']= $this->model->item()->genericRedableCustomFieldAndValue($this->model['custom_fields']);
		$this->current_row_html['sno']=$this->sno;
		$this->current_row_html['unit']= $this->model['unit'];
		$this->current_row_html['tax_amount'] = round($this->model['tax_amount']);
		$this->sno++;
	}

	function setModel($model){

		parent::setModel($model);

		$invoice= $model->ref('invoice_id');
		// $invoice= $model->ref('priority_id');
		// $this->template->set('gross_amount',$invoice['amount']);
		
		$this->template->set('gross_amount',$invoice['gross_amount']);
		//$this->template->set('delivery_date',$model['delivery_date']);
		if(!$invoice['discount']){
			$this->template->set('discount_voucher_amount_section',"");
		}else
			$this->template->set('discount_voucher_amount',$invoice['discount']?:'0.00');
		
		if(!$invoice['shipping_charge']){
			$this->template->set('shipping_charge_section',"");
		}else
			$this->template->set('shipping_charge',$invoice['shipping_charge']?:'0.00');

		$this->template->set('net_amount',$invoice['net_amount']);

		// throw new \Exception($model->item()->genericRedableCustomFieldAndValue($model['custom_fields']));
		
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