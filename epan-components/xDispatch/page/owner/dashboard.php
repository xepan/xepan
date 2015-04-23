<?php

class page_xDispatch_page_owner_dashboard extends page_xDispatch_page_owner_main {
	
	function initMainPage(){

		$this->app->title=$this->api->current_department['name'] .': Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-gauge"></i> Dispatch Department Dashboard');

		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		$col_3 = $col->addColumn(3);
		$col_4 = $col->addColumn(3);
		 

		 //Today  Dispatch Request
		$dispatch_req = $this->add('xDispatch/Model_DispatchRequest')->addCondition('updated_date',$this->api->today);
		$dispatch_req_tile = $col_1->add('View_Tile')->addClass('atk-swatch-ink');
		$dispatch_req_tile->setTitle('Today Dispatch Request');
		$dispatch_req_tile->setContent($dispatch_req->count()->getOne());


		//Today partial Complete order
		$partial_order = $this->add('xDispatch/Model_DispatchRequest_PartialComplete')->addCondition('updated_date',$this->api->today);
		$partial_order_tile = $col_3->add('View_Tile')->addClass('atk-swatch-green');
		$partial_order_tile->setTitle('Today Partial Complete Order');
		$partial_order_tile->setContent($partial_order->count()->getOne());

		

		
		
		//Today complete Order
		$complete_order = $this->add('xDispatch/Model_DispatchRequest');
		$complete_order->addExpression('complete_on')->set(function($m,$q){
			$act = $m->add('xCRM/Model_Activity')
				->addCondition('action','completed')
				->addCondition('related_root_document_name',$m->root_document_name)
				->addCondition('related_document_id',$q->getField('id'))
				->setOrder('updated_at','desc')
				->setLimit(1);
			return $act->fieldQuery('created_at');
		});

		$complete_order->addCondition('complete_on','>',$this->api->today);
		$complete_order->addCondition('complete_on','<=',$this->api->nextDate($this->api->today));
		
		$complete_tile = $col_2->add('View_Tile')->addClass('atk-swatch-yellow');
		$complete_tile->setTitle('Today Delivered/Completed Orders');
		$complete_tile->setContent($complete_order->count()->getOne());
		
	
		 //Rejected Orders
		$cancel_order = $this->add('xDispatch/Model_DispatchRequest_Cancelled')->addCondition('updated_date',$this->api->today);
		$cancel_tile = $col_4->add('View_Tile')->addClass('atk-swatch-red');
		$cancel_tile->setTitle('Today Cancelled Dispatch Request');
		$cancel_tile->setContent($cancel_order->count()->getOne());
		
		
	//Today Submiited Delivery Note
		$col_1->add('View')->setElement('br');
		$submitted_delivery_note = $this->add('xDispatch/Model_DeliveryNote_Submitted')->addCondition('updated_date',$this->api->today);
		$submitted_delivery_note_tile = $col_1->add('View_Tile')->addClass('atk-swatch-blue');
		$submitted_delivery_note_tile->setTitle('Today Submitted Delivery Note');
		$submitted_delivery_note_tile->setContent($submitted_delivery_note->count()->getOne());
		




		//today Completed Delivery note
		$col_2->add('View')->setElement('br');
		$complete_delivery_note = $this->add('xDispatch/Model_DeliveryNote_Completed')->addCondition('updated_date',$this->api->today);
		$complete_delivery_note_tile = $col_2->add('View_Tile')->addClass('atk-swatch-green');
		$complete_delivery_note_tile->setTitle('Today Completed Delivery Note');
		$complete_delivery_note_tile->setContent($complete_delivery_note->count()->getOne());
		
		
	
		
		

	}	

}