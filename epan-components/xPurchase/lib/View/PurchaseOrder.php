<?php
namespace xPurchase;

class View_PurchaseOrder extends \CompleteLister{
	
	public $purchaseorder;
	public $sno=1;
	
	function init(){
		parent::init();

		$this->template->set('name',$this->purchaseorder['name']);
		$this->template->set('request_on',$this->purchaseorder['created_at']);
		$this->template->set('status',ucwords($this->purchaseorder['status']));
		$this->template->set('priority',ucwords($this->purchaseorder['priority']));
		 $this->template->set('total_amount',ucwords($this->purchaseorder['total_amount']));
		// $this->template->set('net_amount',ucwords($this->purchaseorder['net_amount']));
		// $this->template->set('form_dept',$this->purchaseorder['name']);
		$this->template->set('supplier',$this->purchaseorder['supplier']);
		
		$this->setModel($this->purchaseorder->itemrows());
	}

	function formatRow(){
		$this->current_row['sno']=$this->sno;
		$this->current_row_html['custom_field'] =  $this->add('xShop/Model_Item')->genericRedableCustomFieldAndValue($this->model['custom_fields']);
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
		return array('view/purchaseorder');
	}
}