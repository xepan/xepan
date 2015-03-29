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
		$this->hasOne('xShop/Customer','customer_id');
		$this->hasOne('xHR/Model_Employee','employee_id');
		$this->hasOne('xAccount/Group','group_id')->mandatory(true);
		
		$this->addField('name')->mandatory(true);
		$this->addField('account_type');
		$this->addField('AccountDisplayName')->caption('Account Displ. Name');
		$this->addField('is_active')->type('boolean')->defaultValue(true);

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

		$transaction_row=$this->add('xAccount/Model_TransactionRow');
		$transaction_row['amountDr']=$amount;
		$transaction_row['side']='DR';
		$transaction_row['transaction_id']=$transaction_id;
		$transaction_row['account_id']=$this->id;
		// $transaction_row['accounts_in_side']=$no_of_accounts_in_side;
		$transaction_row->save();

		$this->debitOnly($amount);
	}

	function creditWithTransaction($amount,$transaction_id,$only_transaction=null,$no_of_accounts_in_side=null){

		$transaction_row=$this->add('xAccount/Model_TransactionRow');
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

	function getOpeningBalance($on_date=null,$side='both',$forPandL=false) {
		if(!$on_date) $on_date = '1970-01-02';
		if(!$this->loaded()) throw $this->exception('Model Must be loaded to get opening Balance','Logic');
		

		$transaction_row=$this->add('xAccount/Model_TransactionRow');
		$transaction_join=$transaction_row->join('xaccount_transaction.id','transaction_id');
		$transaction_join->addField('transaction_date','created_at');
		$transaction_row->addCondition('transaction_date','<',$on_date);
		$transaction_row->addCondition('account_id',$this->id);

		if($forPandL){
			$financial_start_date = $this->api->getFinancialYear($on_date,'start');
			$transaction_row->addCondition('created_at','>=',$financial_start_date);
		}

		$transaction_row->_dsql()->del('fields')->field('SUM(amountDr) sdr')->field('SUM(amountCr) scr');
		$result = $transaction_row->_dsql()->getHash();

		if($this['OpeningBalanceCr'] ==null){
			$temp_account = $this->add('xAccount/Model_Account')->load($this->id);
			$this['OpeningBalanceCr'] = $temp_account['OpeningBalanceCr'];
			$this['OpeningBalanceDr'] = $temp_account['OpeningBalanceDr'];
		}

		$cr = $result['scr'];
		if(!$forPandL) $cr = $cr + $this['OpeningBalanceCr'];
		if(strtolower($side) =='cr') return $cr;

		$dr = $result['sdr'];		
		if(!$forPandL) $dr = $dr + $this['OpeningBalanceDr'];
		if(strtolower($side) =='dr') return $dr;

		return array('CR'=>$cr,'DR'=>$dr,'cr'=>$cr,'dr'=>$dr,'Cr'=>$cr,'Dr'=>$dr);
	}

	function loadDefaultSalesAccount(){
		$this->addCondition('name','Sales Account');
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadDirectIncome()->fieldQuery('id'));
		$this->tryLoadAny();

		if(!$this->loaded()){
			$this->save();
		}

		return $this;
	}

	function loadDefaultTaxAccount(){
		$this->addCondition('name','Tax Account');
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadDutiesAndTaxes()->fieldQuery('id'));
		$this->tryLoadAny();

		if(!$this->loaded()){
			$this->save();
		}

		return $this;
	}


	function loadDefaultDiscountAccount(){
		$this->addCondition('name','Discount Given');
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadDirectExpenses()->fieldQuery('id'));
		$this->tryLoadAny();

		if(!$this->loaded()){
			$this->save();
		}

		return $this;
	}

	function loadCashAccounts(){
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadCashAccount()->fieldQuery('id'));
		return $this;
	}

	function loadDefaultCashAccount(){
		$this->addCondition('name','Cash Account');
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadCashAccount()->fieldQuery('id'));
		$this->tryLoadAny();

		if(!$this->loaded()){
			$this->save();
		}

		return $this;
	}

	function loadBankAccounts(){
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadBankAccounts()->fieldQuery('id'));
		return $this;
	}

	function loadDefaultBankAccount(){
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadBankAccounts()->fieldQuery('id'));
		$this->tryLoadAny();

		if(!$this->loaded()){
			$this['name']='Your Default Bank Account';
			$this->save();
		}

		return $this;
	}

	function loadDefaultBankChargesAccount(){
		$this->addCondition('name','Bank Charges');
		$this->addCondition('group_id',$this->add('xAccount/Model_Group')->loadIndirectExpenses()->fieldQuery('id'));
		$this->tryLoadAny();

		if(!$this->loaded()){
			$this->save();
		}

		return $this;
	}
}
