<?php
namespace xPurchase;

class View_PurchaseOrder extends \CompleteLister{
	
	public $purchaseorder;
	public $sno=1;
	
	function init(){
		parent::init();
		
		$supplier  = $this->add('xPurchase/Model_Supplier')->tryLoad($this->purchaseorder['supplier_id']);
		// throw new \Exception("Error Processing Request");
		$this->template->set('name',$this->purchaseorder['name']);
		$this->template->set('request_on',$this->purchaseorder['created_at']);
		$this->template->set('status',ucwords($this->purchaseorder['status']));
		$this->template->set('priority',ucwords($this->purchaseorder['priority']));
		$this->template->set('total_amount',ucwords($this->purchaseorder['total_amount']));
		$this->template->set('order_summary',$this->purchaseorder['order_summary']);
		$this->template->set('delivery_to',$this->purchaseorder['delivery_to']);
		
		$supplier_info = $this->purchaseorder['supplier']."<br>".$supplier['address']."<br>".$supplier['city'].",".$supplier['state'];
		$this->template->trySetHtml('supplier_info',$supplier_info);
		$this->template->trySet('created_by_x',$this->purchaseorder->ref('created_by_id')->get('name_with_designation') . ' on ' .$this->purchaseorder['created_at']);
		
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