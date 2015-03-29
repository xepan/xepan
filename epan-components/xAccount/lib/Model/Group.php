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

		$this->add('Controller_Validator');
		$this->is(array(
							'name!|to_trim|unique'
						)
				);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}


	function createNewGroup($name,$balance_sheet_id,$other_values=array()){
		
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
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Cash Account')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isCashAccount(){
		return $this['name'] == "Cash Account";
	}

	function loadBankAccounts(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Bank Accounts')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isBankAccounts(){
		return $this['name'] == "Bank Accounts";
	}

	function loadBankOD(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Bank OD')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;
	}

	function isBankOD(){
		return $this['name'] == "Bank OD";
	}

	function loadFDAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','F.D. Assets')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isFDAssets(){
		return $this['name'] == "F.D. Assets";
	}

	function loadShareCapital(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Share Capital')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isShareCapital(){
		return $this['name'] == "Share Capital";
	}

	function loadDirectExpenses(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadExpenses()->fieldquery('id'));
		$this->addCondition('name','Direct Expenses')
			->tryLoadAny();
		return $this;
	}

	function isDirectExpenses(){
		return $this['name'] == "Direct Expenses";
	}

	function loadDirectIncome(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadIncome()->fieldquery('id'));
		$this->addCondition('name','Direct Income')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isDirectIncome(){
		return $this['name'] == "Direct Income";
	}

	function loadDutiesAndTaxes(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadDutiesAndTaxes()->fieldquery('id'));
		$this->addCondition('name','Duties & Taxes')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isDutiesAndTaxes(){
		return $this['name'] == "Duties & Taxes";
	}

	function loadFixedAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadFixedAssets()->fieldquery('id'));
		$this->addCondition('name','Fixed Assets')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isFixedAssets(){
		return $this['name'] == "Fixed Assets";
	}

	function loadIndirectExpenses(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadExpenses()->fieldquery('id'));
		$this->addCondition('name','Indirect Expenses')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isIndirectExpenses(){
		return $this['name'] == "Indirect Expenses";
	}

	function loadIndirectIncome(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadIncome()->fieldquery('id'));
		$this->addCondition('name','Indirect Income')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isIndirectIncome(){
		return $this['name'] == "Indirect Income";
	}

	function loadLoanAdvanceAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Loan Advances (Assets)')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isLoanAdvanceAssets(){
		return $this['name'] == "Loan Advances (Assets)";
	}

	function loadLoanLiabilities(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentLiabilities()->fieldquery('id'));
		$this->addCondition('name','Loan (Liabilities)')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isLoanLiabilities(){
		return $this['name'] == "Loan (Liabilities)";
	}

	function loadMiscExpensesAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Misc Expenses (Assets)')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isMiscExpensesAssets(){
		return $this['name'] == "Misc Expenses (Assets)";
	}

	// function loadProvision(){
	// 	if($this->loaded())
	// 		$this->unload();
	// 	$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
	// 	$this->addCondition('name','Provision')
	// 		->tryLoadAny();
	// 	return $this;	
	// }

	// function isProvision(){
	// 	return $this['name'] == "Provision";
	// }

	function loadReserveSurpuls(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Reserve Surpuls')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isReserveSurpuls(){
		return $this['name'] == "Reserve Surpuls";
	}

	function loadRetainedEarnings(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Retained Earnings')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isRetainedEarnings(){
		return $this['name'] == "Retained Earnings";
	}

	function loadSecuredLoan(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Secured (Loan)')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isSecuredLoan(){
		return $this['name'] == "Secured (Loan)";
	}

	function loadSundryCreditor(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentLiabilities()->fieldquery('id'));
		$this->addCondition('name','Sundry Creditor')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isSundryCreditor(){
		return $this['name'] == "Sundry Creditor";
	}

	function loadSundryDebtor(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Sundry Debtor')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();

		return $this;	
	}

	function isSundryDebtor(){
		return $this['name'] == "Sundry Debtor";
	}

	function loadSuspenceAccount(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('balance_sheet_id',$this->add('xAccount/Model_BalanceSheet')->loadCurrentAssets()->fieldquery('id'));
		$this->addCondition('name','Suspense Account')
			->tryLoadAny();
		
		if(!$this->loaded()) $this->save();
		
		return $this;	
	}

	function isSuspenceAccount(){
		return $this['name'] == "Suspense Account";
	}
}
