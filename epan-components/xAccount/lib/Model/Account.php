<?php
namespace xAccount;

class Model_Account extends \Model_Table{
	public $table="xaccount_account";
	function init(){
		parent::init();

		$this->hasOne('xPurchase/Supplier','supplier_id');
		$this->hasOne('xProduction/OutSourceParty','out_source_party_id');
		$this->hasOne('xShop/MemberDetails','member_id');
		$this->hasOne('xAccount/Group','group_id');
		$this->addField('name')->mandatory(true);
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));
		$this->addField('account_type');
		$this->addField('AccountNumber')->display(array('form'=>'Readonly'));
		$this->addField('AccountDisplayName')->caption('Account Displ. Name');
		$this->addField('Status')->enum(array('Active','Dead'));
		$this->addField('LoanInsurranceDate')->type('datetime');
		$this->addField('OpeningBalanceDr')->type('money')->defaultValue(0);
		$this->addField('OpeningBalanceCr')->type('money')->defaultValue(0);
		$this->addField('ClosingBalance')->type('money')->defaultValue(0);
		$this->addField('CurrentBalanceDr')->type('money')->defaultValue(0);
		$this->addField('CurrentInterest')->type('money')->defaultValue(0);
		$this->addField('Amount')->type('money')->defaultValue(0);
		$this->addField('LockingStatus')->type('boolean')->defaultValue(false);
		$this->addField('affectsBalanceSheet')->type('boolean')->defaultValue(false);
		$this->addField('MaturedStatus')->type('boolean')->defaultValue(false);
		$this->addField('extra_info')->type('text')->system(true);

		$this->addHook('beforeSave',$this);
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function createNewAccount($member_id,$group_id, $AccountNumber,$otherValues=null,$form=null,$created_at=null){

		$this['member_id'] = $member_id;
		$this['group_id'] = $group_id;
		$this['AccountNumber'] = $AccountNumber;
		$this['created_at'] = $created_at;
		$this['LastCurrentInterestUpdatedAt']=isset($otherValues['LastCurrentInterestUpdatedAt'])? :$created_at;
		
		foreach ($otherValues as $field => $value) {
			if(!is_array($value))
				$this[$field] = $value;
		}

		$this->save();
		return $this->id;
	}

	function beforeSave(){
		$i = 0;
		if($this['supplier_id'])
			$i++;
		if($this['group_id'])
			$i++;
	}
}
