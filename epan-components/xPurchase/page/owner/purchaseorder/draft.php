<?php

class page_xPurchase_page_owner_purchaseorder_draft extends page_xPurchase_page_owner_main{
	
	function page_index(){
		// parent::init();

		$draft_purchase_order_model = $this->add('xPurchase/Model_PurchaseOrder_Draft');


		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_PurchaseOrder','add_form_beautifier'=>false));
		// $crud->addHook('crud_form_submit',function($crud,$form){
		// 	$purchase_order = $crud->model;
		// 	//CHECK FOR GENERATE INVOICE
		// 	if($form['payment']){
		// 		switch ($form['payment']) {
		// 			case 'cheque':
		// 				if(trim($form['amount']) == "" or $form['amount'] == 0)
		// 					$form->displayError('amount','Amount Cannot be Null');

		// 				if(trim($form['bank_account_detail']) == "")
		// 					$form->displayError('bank_account_detail','Account Number Cannot  be Null');

		// 				if(trim($form['cheque_no']) =="")
		// 					$form->displayError('cheque_no','Cheque Number not valid.');
						
		// 				if(!$form['cheque_date'])
		// 					$form->displayError('cheque_date','Date Canot be Empty.');

		// 			break;

		// 			case 'cash':
		// 				if(trim($form['amount']) == "" or $form['amount'] == 0)
		// 					$form->displayError('amount','Amount Cannot be Null');
		// 			break;
		// 		}
				
		// 			$form->model->addHook('afterSave',function($m)use($form){
		// 				if($form['payment'] == "cash")
		// 					$m->cashAdvance($form['amount']);
		// 				if($form['payment'] == "cheque")
		// 					$m->bankAdvance($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
		// 			});
				
		// 	}
			
		// 	return true;
		// });		

		// if($crud->isEditing('add') OR $crud->isEditing('edit')){
		// 	$v=$crud->form->add('View')->set('Payment Advanced ');
		// 	$form = $crud->form;
		// 	$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
		// 	$form->addField('Money','amount');
		// 	$form->addField('line','bank_account_detail');
		// 	$form->addField('line','cheque_no');
		// 	$form->addField('DatePicker','cheque_date');
		// 	$form->addField('Checkbox','send_receipt_via_email');
		// 	$form->addField('line','email_to');

		// }

		$crud->setModel($draft_purchase_order_model,array('supplier_id','priority','order_date','order_summary','orderitem_count'),array('name','supplier','order_date','orderitem_count'));
		
		// if($crud->isEditing('add') OR $crud->isEditing('edit')){
		// 	$o = $form->add('Order');
		// 	$o->move('payment','last');
		// 	$o->move('amount','last');
		// 	$o->move('bank_account_detail','last');
		// 	$o->move('cheque_no','last');
		// 	$o->move('cheque_date','last');
		// 	$o->move('send_receipt_via_email','last');
		// 	$o->move('email_to','last');
		// 	$o->now();
		// }

		
		// if(!$crud->isEditing()){
		// 	$crud->grid->addColumn('expander','purchase_order_item');
		// }

		$crud->add('Controller_FormBeautifier');
		$crud->add('xHR/Controller_Acl');
		//$this->add('xPurchase/View_PurchaseOrder',array('purchaseorder'=>$this->add('xPurchase/Model_PurchaseOrder')->load(1)));
	}

	function page_purchase_order_item(){
        $po_id = $this->api->stickyGET('xpurchase_purchase_order_id');
		$crud = $this->add('CRUD');
        $po_item=$this->add('xPurchase/Model_PurchaseOrderItem');
        $po_item->addCondition('po_id',$po_id);

        $crud->setModel($po_item,array('item_id','qty','unit','rate','amount','narration','custom_fields'),array('item','item_name','qty','rate','amount','status'));
        // $crud->add('xHR/Controller_Acl');

        if($crud->isEditing()){
        	$item_field = $crud->form->getElement('item_id');
        	$item_field->qty_effected_custom_fields_only = true;
        }


	}
	
}