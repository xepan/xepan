<?php
namespace xPurchase;

class Model_Supplier extends \Model_Table{
	public $table="xpurchase_supplier";
	function init(){
		parent::init();

		$this->addField('name')->caption('Company name')->mandatory(true);
		$this->addField('owner_name')->mandatory(true);
		$this->addField('code')->mandatory(true);
		$this->addField('address')->mandatory(true);
		$this->addField('city')->mandatory(true);
		$this->addField('state')->mandatory(true);
		$this->addField('pin_code')->type('Number');
		$this->addField('fax_number')->type('Number');
		$this->addField('contact_no')->mandatory(true);
		$this->addField('email');
		$this->addField('is_active')->type('boolean')->defaultValue(true);
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));

		$this->hasMany('xPurchase/PurchaseOrder','xpurchase_supplier_id');
		$this->addHook('beforeDelete',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this->ref('xPurchase/PurchaseOrder')->count()->getOne())
			throw new \Exception("Supplier cannot be delete");
			
	}

}		
