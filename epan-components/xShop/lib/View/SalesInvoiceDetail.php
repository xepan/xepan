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
		$this->current_row_html['sub_total']=$this->model['qty']*$this->model['rate'];
		$this->current_row_html['unit']= $this->model['unit'];
		$this->current_row_html['tax_amount'] = round($this->model['tax_amount'],3);
		$this->current_row_html['texted_amount'] = round($this->model['texted_amount'],3);
		$this->current_row_html['tax_type']= $this->model->tax()->get('name');		
		if($this->model['narration'])
			$this->current_row_html['item_narration'] = "<br/>Narration: ".$this->model['narration'];
		$this->sno++;
		
	}

	function setModel($model){

		parent::setModel($model);

		$invoice= $model->ref('invoice_id');

		$this->template->setHtml('currency',$invoice->currency());
		// $invoice= $model->ref('priority_id');
		// $this->template->set('gross_amount',$invoice['amount']);
		
		$this->template->set('gross_amount',$invoice['gross_amount']);
		//$this->template->set('delivery_date',$model['delivery_date']);
		if($invoice['discount'] == 0){
			$this->template->set('discount_voucher_amount_section',"");
		}else
			$this->template->set('discount_voucher_amount',$invoice['discount']?:'0.00');

		if($invoice['shipping_charge']== 0){
			$this->template->del('shipping_charge_section');
		}else
			$this->template->set('shipping_charge',$invoice['shipping_charge']);

		$this->template->set('net_amount',$invoice['net_amount']);
		//Amount in word
		$this->template->set('net_amount_in_words',$invoice->convertNumberToWords($invoice['net_amount']));
		
		$this->template->set('round_amount',abs(round($invoice['net_amount'] - ($invoice['gross_amount']),2)));
		
		// throw new \Exception($model->item()->genericRedableCustomFieldAndValue($model['custom_fields']));
		
		// $this->template->set('invoice_item_custom_field',$model['id']);
		$this->template->setHtml('detail_height_start','<table width="100%">');
		$this->template->setHtml('detail_height_end','</table>');
							
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