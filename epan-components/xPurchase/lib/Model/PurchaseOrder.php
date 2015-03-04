<?php
namespace xPurchase;

class Model_PurchaseOrder extends \Model_Document{
	public $table="xpurchase_purchase_order";
	public $status=array('draft','approved','processing','submitted','completed');
	public $root_document_name='xStore\PurchaseOrder';
	function init(){
		parent::init();


		$this->hasOne('xPurchase/Supplier','supplier_id');

		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		

		$this->hasMany('xPurchase/PurchaseOrderItem','po_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function submit(){
		$this['status']='submitted';
		$this->saveAndUnload();
		//return $this;
	}
	function approve(){
		
		$this['status']='approved';
		$this->saveAndUnload();
		
	}

	function start_processing_page($page){
		$page->add('View_Error')->set('supplier ka nam btao phle');
		$form = $page->add('Form');
		$form->addSubmit('Sendmail');

		// if($form->isSubmitted()){
		// 	$this->approve();
		// 	return true;
		// }
		$this['status']='processing';
		$this->saveAndUnload();
	}
	

}		

