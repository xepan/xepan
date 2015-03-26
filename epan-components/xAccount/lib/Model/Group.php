<?php
namespace xAccount;

class Model_Group extends \Model_Table{
	public $table="xaccount_group";
	function init(){
		parent::init();

		$this->hasOne('xAccount/BalanceSheet','balance_sheet_id');
		
		$this->addField('name')->caption('Group Name')->mandatory(true);
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));


		$this->hasMany('Account','group_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function depositeLibilities(){
		$this->addCondition('name','Deposits - Liabilities');
	}

	function loadSunderyCreditor(){
		if($this->loaded())
			throw $this->exception('Already loaded');

		$this->addCondition('name','Sundery Creditor');
		$this->addCondition('balance_sheet_id',$this->add('xAccount/BalanceSheet')->loadDepositeLibilities()->get('id'));
		$this->tryLoadAny();
		if(!$this->loaded()) {
			$this->save();
		}

		return $this;
	}		

	function createNewGroup($name,$balance_sheet_id,$other_values=array(),$form=null,$on_date=null){
		
		$this['name'] = $name;
		$this['balance_sheet_id'] = $balance_sheet_id;
		

		foreach ($other_values as $field => $value) {
			$this[$field] = $value;
		}

		$this->save();
	}

	function loadCashAccount(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Cash Account')
			->loadAny();
		return $this;	
	}

	function isCashAccount(){
		return $this['name'] == "Cash Account";
	}

	function loadBankAccounts(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Bank Accounts')
			->loadAny();
		return $this;	
	}

	function isBankAccounts(){
		return $this['name'] == "Bank Accounts";
	}
	function loadBankOD(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Bank OD')
			->loadAny();
		return $this;	
	}

	function isBankOD(){
		return $this['name'] == "Bank OD";
	}
	function loadFDAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','F.D. Assets')
			->loadAny();
		return $this;	
	}

	function isFDAssets(){
		return $this['name'] == "F.D. Assets";
	}
	function loadShareCapital(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Share Capital')
			->loadAny();
		return $this;	
	}

	function isShareCapital(){
		return $this['name'] == "Share Capital";
	}
	function loadCurrentLiabilities(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Current Liabilities')
			->loadAny();
		return $this;	
	}

	function isCurrentLiabilities(){
		return $this['name'] == "Current Liabilities";
	}
	function loadDepositAssest(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Deposit(Assest)')
			->loadAny();
		return $this;	
	}

	function isDepositAssest(){
		return $this['name'] == "Deposit(Assest)";
	}
	function loadDirectExpenses(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Direct Expenses')
			->loadAny();
		return $this;	
	}

	function isDirectExpenses(){
		return $this['name'] == "Direct Expenses";
	}
	function loadDirectIncome(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Direct Income')
			->loadAny();
		return $this;	
	}

	function isDirectIncome(){
		return $this['name'] == "Direct Income";
	}
	function loadDutiesTaxes(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Duties Taxes')
			->loadAny();
		return $this;	
	}

	function isDutiesTaxes(){
		return $this['name'] == "Duties Taxes";
	}
	function loadFixedAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Fixed Assets')
			->loadAny();
		return $this;	
	}

	function isFixedAssets(){
		return $this['name'] == "Fixed Assets";
	}
	function loadIndirectExpenses(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Indirect Expenses')
			->loadAny();
		return $this;	
	}

	function isIndirectExpenses(){
		return $this['name'] == "Indirect Expenses";
	}
	function loadIndirectIncome(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Indirect Income')
			->loadAny();
		return $this;	
	}

	function isIndirectIncome(){
		return $this['name'] == "Indirect Income";
	}
	function loadInvestment(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Investment')
			->loadAny();
		return $this;	
	}

	function isInvestment(){
		return $this['name'] == "Investment";
	}
	function loadLoanAdvanceAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Loan Advance(Assets)')
			->loadAny();
		return $this;	
	}

	function isLoanAdvanceAssets(){
		return $this['name'] == "Loan Advance(Assets)";
	}
	function loadLoanLiabilities(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Loan(Liabilities)')
			->loadAny();
		return $this;	
	}

	function isLoanLiabilities(){
		return $this['name'] == "Loan(Liabilities)";
	}	
	function loadMiscExpensesAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Misc Expenses(Assets)')
			->loadAny();
		return $this;	
	}

	function isMiscExpensesAssets(){
		return $this['name'] == "Misc Expenses(Assets)";
	}
	function loadProvision(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Provision')
			->loadAny();
		return $this;	
	}

	function isProvision(){
		return $this['name'] == "Provision";
	}
	function loadReserveSurpuls(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Reserve Surpuls')
			->loadAny();
		return $this;	
	}

	function isReserveSurpuls(){
		return $this['name'] == "Reserve Surpuls";
	}
	function loadRetainedEarnings(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Retained Earnings')
			->loadAny();
		return $this;	
	}

	function isRetainedEarnings(){
		return $this['name'] == "Retained Earnings";
	}
	function loadSecuredLoan(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Secured(Loan)')
			->loadAny();
		return $this;	
	}

	function isSecuredLoan(){
		return $this['name'] == "Secured(Loan)";
	}
	function loadSundryCreditor(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Sundry Creditor')
			->loadAny();
		return $this;	
	}

	function isSundryCreditor(){
		return $this['name'] == "Sundry Creditor";
	}
	function loadSundryDebtor(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Sundry Debtor')
			->loadAny();
		return $this;	
	}

	function isSundryDebtor(){
		return $this['name'] == "Sundry Debtor";
	}
	function loadSuspenceAccount(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->get('id'));
		$this->addCondition('name','Suspence Account')
			->loadAny();
		return $this;	
	}

	function isSuspenceAccount(){
		return $this['name'] == "Suspence Account";
	}
}
