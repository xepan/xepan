<?php
namespace xAccount;

class Model_BalanceSheet extends \Model_Document{
	public $table="xaccount_balance_sheet";
	public $status=array();
	public $root_document_name = 'xAccount\Balance_Sheet';
	function init(){
		parent::init();

		$this->addField('name')->mandatory(true);
		$this->addField('positive_side')->enum(array('LT','RT'))->mandatory(true);
		$this->addField('is_pandl')->type('boolean')->mandatory(true);
		$this->addField('show_sub')->enum(array('SchemeGroup','SchemeName','Accounts'))->mandatory(true);
		$this->addField('subtract_from')->enum(array('Cr','Dr'))->mandatory(true);
		$this->addField('order');


		$this->add('dynamic_model/Controller_AutoCreator');
	}


	function loadDepositeLibilities(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('name','Deposits - Liabilities')
			->loadAny();
		return $this;
	}

	function isDepositeLibilities(){
		return $this['name'] =='Deposits - Liabilities';
	}

	function loadCurrentAssets(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('name','Current Assets')
			->loadAny();
		return $this;	
	}

	function isCurrentAssets(){
		return $this['name'] == "Current Assets";
	}

	function loadCapitalAccount(){
		if($this->loaded())
			$this->unload();
		$this->addCondition('name','Capital Account')
			->loadAny();
			return $this;
	}
	
	function isCapitalAccount(){
		return $this['name'] == 'Capital Account';
	}

	function loadExpenses(){
			if($this->loaded())
				$this->unload();
			$this->addCondition('name','Expenses')
				->loadAny();
				return $this;
		}

	function isExpenses(){
		return $this['name'] == 'Expenses';
	}

	function loadIncome(){
			if($this->loaded())
				$this->unload();
			$this->addCondition('name','Income')
				->loadAny();
				return $this;
		}

	function isIncome(){
		return $this['name'] == 'Income';
	}

	function loadDutiesAndTaxes(){
			if($this->loaded())
				$this->unload();
			$this->addCondition('name','Duties & Taxes')
				->loadAny();
				return $this;
		}

	function isDutiesAndTaxes(){
		return $this['name'] == 'Duties & Taxes';
	}

	function loadSuspenceAccount(){
			if($this->loaded())
				$this->unload();
			$this->addCondition('name','Suspence Account')
				->loadAny();
				return $this;
		}

	function isSuspenceAccount(){
		return $this['name'] == 'Suspence Account';
	}

	function loadFixedAssets(){
			if($this->loaded())
				$this->unload();
			$this->addCondition('name','Fixed Assets')
				->loadAny();
				return $this;
		}

	function isFixedAssets(){
		return $this['name'] == 'Fixed Assets';
	}

	function loadBranchDivisions(){
			if($this->loaded())
				$this->unload();
			$this->addCondition('name','Branch/Divisions')
				->loadAny();
				return $this;
		}

	function isBranchDivisions(){
		return $this['name'] == 'Branch/Divisions';
	}

	function loadCurrentLiabilities(){
			if($this->loaded())
				$this->unload();
			$this->addCondition('name','Current Liabilities')
				->loadAny();
				return $this;
		}

	function isCurrentLiabilities(){
		return $this['name'] == 'Current Liabilities';
	}

}
