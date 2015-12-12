<?php

class page_xPurchase_page_owner_report_order extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$supplier=$this->add('xPurchase/Model_Supplier');
		$purchase=$this->add('xPurchase/Model_PurchaseOrder');

		$form=$this->add('Form');
		$form->addField('autocomplete/Basic','supplier')->setModel($supplier);
		$form->addField('Dropdown','status')->setValueList(array('Approved'=>'Approved','Redesign'=>'Redesign','Completed'=>'Completed','Rejected'=>'Rejected'))->setEmptyText('Please Select');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get report');

		$grid=$this->add('Grid');

		$this->app->stickyGET('filter');
		$this->app->stickyGET('supplier');
		$this->app->stickyGET('status');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');

				if($_GET['filter']){

			if($_GET['supplier']){
				$purchase->addCondition('supplier_id',$_GET['supplier']);
			}
			
			if($_GET['status']){
				$purchase->addCondition('status',$_GET['status']);
			}
			if($_GET['from_date']){
				$purchase->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$purchase->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
		
		}else{
			$purchase->addCondition('id',-1);
		}


			$grid->setModel($purchase);

		$grid->addPaginator(100);
		$grid->addSno();

		if($form->isSubmitted()){
			$grid->js()->reload(array('supplier'=>$form['supplier'],
									  'status'=>$form['status'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}	
		
	}
}
