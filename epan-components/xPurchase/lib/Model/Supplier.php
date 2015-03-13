<?php
namespace xPurchase;

class Model_Supplier extends \Model_Table{
	public $table="xpurchase_supplier";
	function init(){
		parent::init();

		$this->addField('name')->caption('Company name');
		$this->addField('owner_name');
		$this->addField('code');
		$this->addField('address');
		$this->addField('city');
		$this->addField('state');
		$this->addField('pin_code')->type('Number');
		$this->addField('fax_number')->type('Number');
		$this->addField('contact_no');
		$this->addField('email');
		$this->addField('is_active')->type('boolean');
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));

		$this->hasMany('xPurchase/PurchaseOrder','xpurchase_supplier_id');
			//$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
