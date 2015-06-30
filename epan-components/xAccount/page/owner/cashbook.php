<?php
class page_xAccount_page_owner_cashbook extends page_xAccount_page_owner_main{
	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': CashBook';

		$form = $this->add('Form');
		$form->addField('DatePicker','from_date')->validateNotNull();
		$form->addField('DatePicker','to_date')->validateNotNull();
		$form->addSubmit('Open Cash Book');

		$grid = $this->add('xAccount/Grid_AccountsBase');

		$cash_transaction_model = $this->add('xAccount/Model_Transaction');
		$transaction_row=$cash_transaction_model->join('xaccount_transaction_row.transaction_id');
		$transaction_row->hasOne('xAccount/Account','account_id');
		$transaction_row->addField('amountDr')->caption('Debit');
		$transaction_row->addField('amountCr')->caption('Credit');
		$account_join = $transaction_row->join('xaccount_account','account_id');
		$group_join = $account_join->join('xaccount_group','group_id');
		$group_join->addField('group_name','name');

		$cash_transaction_model->addCondition('group_name','Cash Account');

		if($_GET['from_date']){
			$this->api->stickyGET('from_date');
			$this->api->stickyGET('to_date');
			$cash_transaction_model->addCondition('created_at','>=',$_GET['from_date']);
			$cash_transaction_model->addCondition('created_at','<',$this->api->nextDate($_GET['to_date']));
			$cash_account = $this->add('xAccount/Model_Account')->loadDefaultCashAccount();
			$opening_balance = $cash_account->getOpeningBalance($_GET['from_date']);
		}else{
			$cash_transaction_model->addCondition('created_at','>=',$this->api->today);
			$cash_transaction_model->addCondition('created_at','<',$this->api->nextDate($this->api->today));
			$cash_account = $this->add('xAccount/Model_Account')->loadDefaultCashAccount();
			$opening_balance = $cash_account->getOpeningBalance($this->api->today);
		}
			

		if(($opening_balance['DR'] - $opening_balance['CR']) > 0){
			$opening_column = 'amountDr';
			$opening_amount = $opening_balance['DR'] - $opening_balance['CR'];
			$opening_narration = "To Opening balance";
			$opening_side = 'DR';
		}else{
			$opening_column = 'amountCr';
			$opening_amount = $opening_balance['CR'] - $opening_balance['DR'];
			$opening_narration = "By Opening balance";
			$opening_side = 'CR';
		}
		$grid->addOpeningBalance($opening_amount,$opening_column,array('Narration'=>$opening_narration),$opening_side);
		$grid->addCurrentBalanceInEachRow();

		$grid->setModel($cash_transaction_model,array('voucher_no','transaction_type','created_at','Narration','account','amountDr','amountCr'));
		$grid->addSno();
		$grid->removeColumn('account');

		$grid->addMethod('format_transaction_type',function($g,$f){
			$g->current_row_html[$f]=$g->model['transaction_type']."::".$g->model->customer()->get('organization_name');
		});
		$grid->addFormatter('transaction_type','transaction_type');

		$js=array(
			$this->js()->_selector('.atk-cells-gutter-large')->parent()->parent()->toggle(),
			$this->js()->_selector('.atk-box')->toggle(),
			$this->js()->_selector('.navbar1')->toggle(),
			// $this->js()->_selector('.atk-text-nowrap')->toggle(),
			$this->js()->_selector('.atk-form')->toggle(),
			);

		$grid->js('click',$js);

		// $grid->addTotals(array('amountCr','amountDr'));
		if($form->isSubmitted()){
			$grid->js()->reload(array('from_date'=>$form['from_date']?:0,'to_date'=>$form['to_date']?:0))->execute();
		}


	}
}