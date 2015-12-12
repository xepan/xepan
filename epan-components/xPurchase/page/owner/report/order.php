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

		$grid=$this->add('xPurchase/Grid_PurchaseOrder');

		$this->app->stickyGET('filter');
		$supplier = $this->app->stickyGET('supplier');
		$status = $this->app->stickyGET('status');
		$from_date = $this->app->stickyGET('from_date');
        $to_date = $this->app->stickyGET('to_date');

		if($_GET['filter']){
			if($supplier){
				$purchase->addCondition('supplier_id',$_GET['supplier']);
			}
			
			if($status){
				$purchase->addCondition('status',$_GET['status']);
			}
			if($from_date){
				$purchase->addCondition('created_at','>=',$_GET['from_date']);
			}

			if($to_date){
				$purchase->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
		
		}else{
			$purchase->addCondition('id',-1);
		}



		$grid->setModel($purchase);
		$grid->addPaginator(100);
		$grid->addSno();

		$print_all_btn=$grid->addButton('print')->set('Print All');

		$print_all_btn->OnClick(function($print_all_btn)use($grid,$from_date,$to_date,$supplier,$status){
            return $this->js()->univ()->newWindow($this->api->url('xPurchase_page_owner_printpurchaseorder',array('from_date'=>$from_date,'to_date'=>$to_date,'supplier_id'=>$supplier,'status'=>$status,'printAll'=>1)))->execute();
        });

		if($form->isSubmitted()){
			$grid->js()->reload(array('supplier'=>$form['supplier'],
									  'status'=>$form['status'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}	
		
	}
}
