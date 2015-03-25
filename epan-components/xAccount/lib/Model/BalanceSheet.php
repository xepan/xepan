<?php
namespace xAccount;

class Model_BalanceSheet extends \Model_Table{
	public $table="xaccount_balance_sheet";
	function init(){
		parent::init();

		$this->addField('name')->mandatory(true);
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));
		$this->addField('positive_side')->enum(array('LT','RT'))->mandatory(true);
		$this->addField('is_pandl')->type('boolean')->mandatory(true);
		$this->addField('show_sub')->enum(array('SchemeGroup','SchemeName','Accounts'))->mandatory(true);
		$this->addField('subtract_from')->enum(array('Cr','Dr'))->mandatory(true);
		$this->addField('order');


		$this->add('dynamic_model/Controller_AutoCreator');
	}
}