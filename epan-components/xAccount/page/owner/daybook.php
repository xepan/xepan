<?php
class page_xAccount_page_owner_daybook extends page_xAccount_page_owner_main{
	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': DayBook';

		$form = $this->add('Form');
		$form->addField('DatePicker','date')->validateNotNull();
		$form->addSubmit('Open Day Book');

		$day_transaction_model = $this->add('xAccount/Model_Transaction');
		$transaction_row=$day_transaction_model->leftjoin('xaccount_transaction_row.transaction_id');
		$transaction_row->hasOne('xAccount/Account','account_id');
		$transaction_row->addField('amountDr');
		$transaction_row->addField('amountCr');
		
		
		$daybook_lister_crud = $this->add('CRUD',array('grid_class'=>'xAccount/Grid_DayBook'));

		if($this->api->stickyGET('date_selected')){
			$day_transaction_model->addCondition('created_at','>=',$_GET['date_selected']);
			$day_transaction_model->addCondition('created_at','<',$this->api->nextDate($_GET['date_selected']));
		}else{
			$day_transaction_model->addCondition('created_at','>=',$this->api->today);
			$day_transaction_model->addCondition('created_at','<',$this->api->nextDate($this->api->today));

		}
 
		$daybook_lister_crud->setModel($day_transaction_model,array('voucher_no','transaction_type','Narration','account','amountDr','amountCr'));
		$daybook_lister_crud->grid->removeColumn('Narration');
		$daybook_lister_crud->grid->removeColumn('transaction_type');

		if($form->isSubmitted()){
			$daybook_lister_crud->js()->reload(array('date_selected'=>$form['date']?:0))->execute();
		}

		$daybook_lister_crud->add('xHR/Controller_Acl');
	}
}