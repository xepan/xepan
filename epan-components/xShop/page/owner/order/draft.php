<?php
class page_xShop_page_owner_order_draft extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel('xShop/Model_Order_Draft',array('member_id','order_summary','delivery_date','termsandcondition_id','priority_id'),array('name','created_at','member','net_amount','last_action','created_by','orderitem_count'));
		$crud->add('xHR/Controller_Acl');
		
		if(!$crud->isEditing()){
			$crud->grid->removeColumn('order_from');
		}

		if($crud->isEditing('add') OR $crud->isEditing('edit')){
			$crud->form->add('View_Info')->set('Payment Advanced ');
			$form = $crud->form;
			$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
			$form->addField('Money','amount');
			$form->addField('line','bank_account_detail');
			$form->addField('line','cheque_no');
			$form->addField('DatePicker','cheque_date');
			$form->addField('Checkbox','send_invoice_via_email');
			$form->addField('line','email_to');
			// $form->addSubmit('PayNow');
			if($form->isSubmitted()){
				$order = $crud->model;				
				//CHECK FOR GENERATE INVOICE
				if($form['payment']){
					switch ($form['payment']) {
						case 'cheque':
							if(trim($form['cheque_no']) =="")
								$form->displayError('cheque_no','Cheque Number not valid.');

							if(!$form['cheque_date'])
								$form->displayError('cheque_date','Date Canot be Empty.');

							if(trim($form['bank_account_detail']) == "")
								$form->displayError('bank_account_detail','Account Number Cannot  be Null');
						break;

						default:
							if(trim($form['amount']) == "")
								$form->displayError('amount','Amount Cannot be Null');
						break;
					}
					
					if($form['payment'] == "cash")
						$order->cashAdvance($form['amount']);
					
					if($form['payment'] == "cheque")
						$order->bankAdvance($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
				}
			
			}
		}



	}
}		