<?php
class page_xShop_page_owner_order_draft extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order','add_form_beautifier'=>false));
		
		$crud->addHook('crud_form_submit',function($crud,$form){
			$order = $crud->model;
			//CHECK FOR GENERATE INVOICE
			if($form['payment']){
				switch ($form['payment']) {
					case 'cheque':
						if(trim($form['amount']) == "")
							$form->displayError('amount','Amount Cannot be Null');

						if(trim($form['bank_account_detail']) == "")
							$form->displayError('bank_account_detail','Account Number Cannot  be Null');
						
						if(trim($form['cheque_no']) =="")
							$form->displayError('cheque_no','Cheque Number not valid.');

						if(!$form['cheque_date'])
							$form->displayError('cheque_date','Date Canot be Empty.');

					break;

					case 'cash':
						if(trim($form['amount']) == "" or $form['amount'] == 0)
							$form->displayError('amount','Amount Cannot be Null');						
					break;
				}
				
				if($form['payment'] == "cash"){
					$form->model->addHook('afterSave',function($m)use($form){
						$m->cashAdvance($form['amount']);
					});
				}
				
				if($form['payment'] == "cheque")
					$order->bankAdvance($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
			}
			
			return true;
		});

		
		if(!$crud->isEditing()){
			$crud->grid->removeColumn('order_from');
		}

		if($crud->isEditing('add') OR $crud->isEditing('edit')){
			$v=$crud->form->add('View')->set('Payment Advanced ');
			$form = $crud->form;
			$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
			$form->addField('Money','amount');
			$form->addField('line','bank_account_detail');
			$form->addField('line','cheque_no');
			$form->addField('DatePicker','cheque_date');
			$form->addField('Checkbox','send_invoice_via_email');
			$form->addField('line','email_to');

		}

		$crud->setModel('xShop/Model_Order_Draft',array('member_id','order_summary','delivery_date','termsandcondition_id','priority_id'),array('name','created_at','member','net_amount','last_action','created_by','orderitem_count'));
		
		if($crud->isEditing('add') OR $crud->isEditing('edit')){
			$o = $form->add('Order');
			$o->move('payment','last');
			$o->move('amount','last');
			$o->move('bank_account_detail','last');
			$o->move('cheque_no','last');
			$o->move('cheque_date','last');
			$o->move('send_invoice_via_email','last');
			$o->move('email_to','last');
			$o->now();
		}
		$crud->add('Controller_FormBeautifier');
		$crud->add('xHR/Controller_Acl');
	}
}		