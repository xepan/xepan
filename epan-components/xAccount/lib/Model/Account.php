<?php
namespace xAccount;

class Model_Account extends \Model_Document{
	public $table="xaccount_account";
	public $status=array();
	public $root_document_name = 'xAccount\Account';
	function init(){
		parent::init();

		$this->hasOne('xPurchase/Supplier','supplier_id');
		$this->hasOne('xProduction/OutSourceParty','out_source_party_id');
		$this->hasOne('xShop/MemberDetails','member_id');
		$this->hasOne('xHR/Model_Employee','employee_id');
		$this->hasOne('xAccount/Group','group_id')->mandatory(true);
		$this->addField('name')->mandatory(true);
		$this->addField('account_type');
		$this->addField('AccountDisplayName')->caption('Account Displ. Name');
		$this->addField('Status')->enum(array('Active','Dead'));
		$this->addField('OpeningBalanceDr')->type('money')->defaultValue(0);
		$this->addField('OpeningBalanceCr')->type('money')->defaultValue(0);
		$this->addField('CurrentBalanceDr')->type('money')->defaultValue(0);
		$this->addField('CurrentBalanceCr')->type('money')->defaultValue(0);

		$this->addField('affectsBalanceSheet')->type('boolean')->defaultValue(true);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function createNewAccount($account_for,$group,$name){

		if($account_for instanceof \xShop\Model_MemberDetails){
			$this['member_id'] = $account_for->id;
		}

		if($account_for instanceof \xPurchase\Model_Supplier){
			$this['supplier_id'] = $account_for->id;
		}

		if($account_for instanceof \xHR\Model_Employee){
			$this['employee_id'] = $account_for->id;
		}

		if($account_for instanceof \xProduction\Model_OutSourceParty){
			$this['employee_id'] = $account_for->id;
		}

		$this['group_id'] = $group->id;
		$this['name'] = $name;
	
		$this->save();
		return $this;
	}

	function debitWithTransaction($amount,$transaction_id,$no_of_accounts_in_side=null){

		$transaction_row=$this->add('Model_TransactionRow');
		$transaction_row['amountDr']=$amount;
		$transaction_row['side']='DR';
		$transaction_row['transaction_id']=$transaction_id;
		$transaction_row['account_id']=$this->id;
		// $transaction_row['accounts_in_side']=$no_of_accounts_in_side;
		$transaction_row->save();

		$this->debitOnly($amount);
	}

	function creditWithTransaction($amount,$transaction_id,$only_transaction=null,$no_of_accounts_in_side=null){

		$transaction_row=$this->add('Model_TransactionRow');
		$transaction_row['amountCr']=$amount;
		$transaction_row['side']='CR';
		$transaction_row['transaction_id']=$transaction_id;
		$transaction_row['account_id']=$this->id;
		// $transaction_row['accounts_in_side']=$no_of_accounts_in_side;
		$transaction_row->save();

		if($only_transaction) return;
		
		$this->creditOnly($amount);
	}

	function debitOnly($amount){ 
		$this->hook('beforeAccountDebited',array($amount));
		$this['CurrentBalanceDr']=$this['CurrentBalanceDr']+$amount;
		$this->save();
		$this->hook('afterAccountDebited',array($amount));
	}

	function creditOnly($amount){
		$this->hook('beforeAccountCredited',array($amount));
		$this['CurrentBalanceCr']=$this['CurrentBalanceCr']+$amount;
		$this->save();
		$this->hook('afterAccountCredited',array($amount));
	}

	function loadDefaultSalesAccount(){
		
	}
	
}
