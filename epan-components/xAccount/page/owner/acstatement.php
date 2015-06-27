<?php
class page_xAccount_page_owner_acstatement extends page_xAccount_page_owner_main {
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Statement';

		$form=$this->add('Form');
		$account_field = $form->addField('autocomplete/Basic','account')->validateNotNull();
		$account_field->setModel('xAccount/Account');

		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Statement');

		$grid = $this->add('xAccount/Grid_AccountsBase');

		$transactions = $this->add('xAccount/Model_TransactionRow');

		if($_GET['account_id'] or $_GET['AccountNumber']){
			$account_id = $this->api->stickyGET('account_id');
			$this->api->stickyGET('AccountNumber');
			$this->api->stickyGET('from_date');
			$this->api->stickyGET('to_date');
		
			if($_GET['account_id']){
				$transactions->addCondition('account_id',$_GET['account_id']);
			}
			if($_GET['AccountNumber']){
				$transactions->join('accounts','account_id')->addField('AccountNumber');
				$transactions->addCondition('AccountNumber',$_GET['AccountNumber']);
			}

			if($_GET['from_date'])
				$transactions->addCondition('created_at','>=',$_GET['from_date']);
			if($_GET['to_date'])
				$transactions->addCondition('created_at','<',$this->api->nextDate($_GET['to_date']));
			if($_GET['account_id']){
				$opening_balance = $this->add('xAccount/Model_Account')->load($_GET['account_id'])->getOpeningBalance($_GET['from_date']);
			}

			if($_GET['AccountNumber']){
				$opening_balance = $this->add('xAccount/Model_Account')->loadBy('AccountNumber',$_GET['AccountNumber'])->getOpeningBalance($_GET['from_date']);
			}

			if(($opening_balance['DR'] - $opening_balance['CR']) > 0){
				$opening_column = 'amountDr';
				$opening_amount = $opening_balance['DR'] - $opening_balance['CR'];
				$opening_narration = "To Opening balace";
				$opening_side = 'DR';
			}else{
				$opening_column = 'amountCr';
				$opening_amount = $opening_balance['CR'] - $opening_balance['DR'];
				$opening_narration = "By Opening balace";
				$opening_side = 'CR';
			}
			$grid->addOpeningBalance($opening_amount,$opening_column,array('Narration'=>$opening_narration),$opening_side);
			$grid->addCurrentBalanceInEachRow();


			$send_email_btn = $grid->addButton('Send E-mail');

	/*Send Account Statement In mail to Customer*/
			$mail_vp = $this->add('VirtualPage');
			$mail_vp->set(function($p)use($transactions,$account_id){
				
				$account_model=$p->add('xAccount/Model_Account');
				$acc=$account_model->load($account_id);
				$email=$acc->customer()->get('customer_email');
				
				$vp_form=$p->add('Form');
				$vp_form->addField('line','email_to')->set($email);
				$vp_form->addField('line','subject');
				$account_lister_view=$p->add('xAccount/View_Lister_AccountStatement',array('account_id'=>$account_id,'from_date'=>$_GET['from_date']));
				$account_lister_view->setModel($transactions);
								
				$vp_form->addSubmit('send');
				if($vp_form->isSubmitted()){
					$account_model->sendEmail($vp_form['email_to'],$vp_form['subject'],$account_lister_view->getHtml(),$vp_form['message'],$ccs=array(),$bccs=array());
					$vp_form->js(null,$vp_form->js()->univ()->closeDialog())->univ()->successMessage('Mail Send Successfully')->execute();
				}
			});

			if($send_email_btn->isClicked()){
				$this->js()->univ()->frameURL('Send Mail',$mail_vp->getURL(),array('account_id'=>$_GET['account_id']))->execute();
				}

		}else{
			$transactions->addCondition('id',-1);
		}

		$transactions->setOrder('created_at');
		$grid->setModel($transactions,array('voucher_no','transaction_type','created_at','Narration','amountDr','amountCr'));
		// $grid->addPaginator(10);
		$grid->addSno();
		



		if($form->isSubmitted()){
			
			$a=$this->add('xAccount/Model_Account');
			$grid->js()->reload(
					array(
						'account_id'=>$form['account'],
						'from_date'=>($form['from_date'])?:0,
						'to_date'=>($form['to_date'])?:0,
						)
					)->execute();
			$a->tryLoad($form['account']);
			$open = $a->getOpeningBalance();
			$form->displayError('accounts',($open['DR'] - $open['CR']));
		}
	}
}