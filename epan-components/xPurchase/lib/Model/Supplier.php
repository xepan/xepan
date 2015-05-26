<?php
namespace xPurchase;

class Model_Supplier extends \Model_Document{
	public $table="xpurchase_supplier";
	public $status = array();
	public $actions = array(
				'allow_del'=>array(),
				'allow_edit'=>array(),
				'allow_add'=>array()
				);
	public $title_field ='supplier_search_phrase';
	public $root_document_name = 'xPurchase\Supplier';


	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('name')->caption('Company name')->mandatory(true)->sortable(true)->group('a~3~Basic Detail');
		$this->addField('owner_name')->sortable(true)->group('a~3');
		$this->addField('accounts_person_name')->sortable(true)->group('a~3');
		$this->addField('contact_person_name')->sortable(true)->group('a~3');
		
		$this->addField('address')->type('text')->mandatory(true)->sortable(true)->group('b~4~Address Detail');
		$this->addField('city')->mandatory(true)->sortable(true)->group('b~2');
		$this->addField('code')->mandatory(true)->sortable(true)->group('b~3');
		$this->addField('state')->mandatory(true)->sortable(true)->group('b~3');
		// $this->addField('pin_code')->type('Number')->sortable(true)->group('b~2');
		
		$this->addField('contact_no')->mandatory(true)->sortable(true)->group('c~4~Contact Detail');
		$this->addField('fax_number')->type('Number')->sortable(true)->group('c~4');
		$this->addField('email')->sortable(true)->group('c~4');

		$this->addField('tin_no')->group('d~4~Company Detail');
		$this->addField('is_active')->type('boolean')->defaultValue(true)->group('d~4');
		// $this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'))->sortable(true);

		$this->hasMany('xPurchase/PurchaseOrder','supplier_id');
		$this->hasMany('xPurchase/PurchaseInvoice','supplier_id');
		$this->hasMany('xAccount/Account','supplier_id');
		$this->addHook('beforeDelete',$this);
		$this->addHook('afterInsert',$this);

		

		$this->addExpression('supplier_search_phrase')->set($this->dsql()->concat(
				$this->getElement('name'),
				' :: ',
				$this->getElement('owner_name'),
				' :: ',
				$this->getElement('email'),
				' :: ',
				$this->getElement('contact_no')
				
			));

		$this->add('Controller_Validator');
		$this->is(array(
							'code|unique'
						)
				);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$po = $this->ref('xPurchase/PurchaseOrder')->count()->getOne();
		$pi = $this->ref('xPurchase/PurchaseInvoice')->count()->getOne();
		$supplier = $this->ref('xAccount/Account')->count()->getOne();
		if($po or $pi or $supplier)
			throw $this->exception('Canot Delete, First Delete PurchaseOrder or PurchaseInvoice or Account');
	}

	function forceDelete(){
		$this->ref('xPurchase/PurchaseOrder')->each(function($po){
			$po->forceDelete();
		});
		
		$this->ref('xPurchase/PurchaseInvoice')->each(function($pi){
			$pi->forceDelete();
		});

		$this->ref('xAccount/Account')->each(function($account){
			$account->forceDelete();
		});

		$this->delete();
	}

	function afterInsert($obj,$new_id){		
		$supplier_model=$this->add('xPurchase/Model_Supplier')->load($new_id);
		$supplier_model_value = array($supplier_model);
		$this->api->event('new_supplier_registered',$supplier_model_value);
	}

	function account(){
		$acc = $this->add('xAccount/Model_Account')
				->addCondition('customer_id',$this->id)
				->addCondition('group_id',$this->add('xAccount/Model_Group')->loadSundryCreditor()->get('id'));
		$acc->tryLoadAny();
		if(!$acc->loaded()){
			$acc['name'] = $this['supplier_search_phrase'];
			$acc->save();
		}

		return $acc;
	}

	function email(){
		if(!$this->loaded())
			return false;
		return $this['personal_email'];
	}

	function mobileno(){
		if(!$this->loaded())
			return false;
		return $this['contact_no'];
	}

	function updateEmail($email){
		if(!$this->loaded()) return false;
		
		$this['email'] = $this['email'].', '.$email;
		$this->save();
	}
}		
