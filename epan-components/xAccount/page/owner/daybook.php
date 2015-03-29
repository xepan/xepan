<?php
class page_xAccount_page_owner_daybook extends page_xAccount_page_owner_main{
	function init(){
		parent::init();
		
		$form = $this->add('Form');
		$form->addField('DatePicker','date')->validateNotNull();
		$form->addSubmit('Open Day Book');

		$day_transaction_model = $this->add('xAccount/Model_Transaction');
		$transaction_row=$day_transaction_model->join('xaccount_transaction_row.transaction_id');
		$transaction_row->hasOne('xAccount/Account','account_id');
		$transaction_row->addField('amountDr');
		$transaction_row->addField('amountCr');
		
		$daybook_lister_grid = $this->add('xAccount/Grid_DayBook');

		if($_GET['date_selected']){
			$day_transaction_model->addCondition('created_at','>=',$_GET['date_selected']);
			$day_transaction_model->addCondition('created_at','<',$this->api->nextDate($_GET['date_selected']));
		}else{
			$day_transaction_model->addCondition('created_at',$this->api->today);

		}
 
		$daybook_lister_grid->setModel($day_transaction_model,array('voucher_no','Narration','account','amountDr','amountCr'));
		$daybook_lister_grid->removeColumn('Narration');

		if($form->isSubmitted()){
			$daybook_lister_grid->js()->reload(array('date_selected'=>$form['date']?:0))->execute();
		}


	}
}