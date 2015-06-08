<?php
namespace xShop;
class View_Quotation extends \CompleteLister{
	
	public $quotation;
	public $sno=1;
	
	function init(){
		parent::init();
		
		$this->template->setHtml('name',"Quotation No: <b>".$this->quotation['name']."</b>");
		$this->template->setHtml('created_at',"Created At: <b>".$this->quotation['created_at']."</b>");
		$this->template->setHtml('status',"Status: <b>".ucwords($this->quotation['status'])."</b>");
		$this->quotation['customer']?$this->template->setHtml('customer',"Customer: <b>".ucwords($this->quotation['customer'])."</b>"):"";
		$this->quotation['lead']?$this->template->setHtml('lead',"Lead: <b>".ucwords($this->quotation['lead'])."<b>"):"";

		$this->template->trySetHtml('gross_amount',$this->quotation['gross_amount']?:'0.00');
		$this->template->trySetHtml('discount_voucher_amount',$this->quotation['discount_voucher_amount']?:'0.00');
		$this->template->trySetHtml('net_amount',$this->quotation['net_amount']?:'.00');
		
		if(!$this->quotation['termsandcondition_id'])
			$this->template->del('tandc_section');
		else
			$this->template->trySetHTML('termsandcondition_matter',$this->quotation->ref('termsandcondition_id')->get('terms_and_condition'));
		
		if($this->quotation['narration'])
			$this->template->trySetHTML('narration',$this->quotation['narration']);

		$this->setModel($this->quotation->itemrows());
	}

	function formatRow(){
		// throw new \Exception($this->model['narration']);
		
		$this->current_row['sno']=$this->sno;
		$this->current_row['redable_custom_fields']=$this->model->item()->genericRedableCustomFieldAndValue($this->model['custom_fields']);
		$this->current_row['unit']=$this->model['unit'];		
		$this->current_row['item_narration']="Narration: ".$this->model['narration'];
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
		return array('view/quotation');
	}
}