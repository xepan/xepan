<?php
class page_xAccount_page_owner_amtpaid extends page_xAccount_page_owner_main {
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Payment';

		$tabs= $this->add('Tabs');
		$cash_tab = $tabs->addTab('Cash Payment');
		$bank_tab = $tabs->addTab('Bank Payment');

		// ==== CASH PAYMENT ===========
		$paid_to_model=$this->add('xAccount/Model_Account');

		$cash_accounts = $this->add('xAccount/Model_Account')->loadCashAccounts();

		$form = $cash_tab->add('Form_Stacked');


		$cash_field = $form->addField('autocomplete/Basic','cash_account')->validateNotNull(true);
		$cash_field->setModel($cash_accounts);

		$cash_field->set($this->add('xAccount/Model_Account')->loadDefaultCashAccount()->get('id'));

		$paid_to_field = $form->addField('autocomplete/Basic','paid_to')->validateNotNull(true);
		$paid_to_field->setModel($paid_to_model);

		$form->addField('Money','amount')->validateNotNull(true);
		$form->addField('Text','narration');
		$form->addSubmit('Pay Now');

		if($form->isSubmitted()){

			$transaction = $this->add('xAccount/Model_Transaction');
			$transaction->createNewTransaction('CASH PAYMENT', null, $this->api->now, $form['narration']);

			$transaction->addCreditAccount($this->add('xAccount/Model_Account')->load($form['cash_account']),$form['amount']);
			
			$transaction->addDebitAccount($this->add('xAccount/Model_Account')->load($form['paid_to']),$form['amount']);

			$transaction->execute();
			
			$form->js(null,$form->js()->reload())->univ()->successMessage('Done')->execute();
		}



		// ==== BANK PAYMENT ===========
		$paid_to_model=$this->add('xAccount/Model_Account');

		$bank_accounts = $this->add('xAccount/Model_Account')->loadBankAccounts();

		$form = $bank_tab->add('Form_Stacked');


		$bank_field = $form->addField('autocomplete/Basic','bank_account')->validateNotNull(true);
		$bank_field->setModel($bank_accounts);

		$bank_field->set($this->add('xAccount/Model_Account')->loadDefaultBankAccount()->get('id'));

		$paid_to_field = $form->addField('autocomplete/Basic','paid_to')->validateNotNull(true);
		$paid_to_field->setModel($paid_to_model);

		$form->addField('Money','amount')->validateNotNull(true);
		$form->addField('Text','narration');
		$form->addSubmit('Pay Now');

		if($form->isSubmitted()){

			$transaction = $this->add('xAccount/Model_Transaction');
			$transaction->createNewTransaction('BANK PAYMENT', null, $this->api->now, $form['narration']);

			$transaction->addCreditAccount($this->add('xAccount/Model_Account')->load($form['bank_account']),$form['amount']);
			
			$transaction->addDebitAccount($this->add('xAccount/Model_Account')->load($form['paid_to']),$form['amount']);

			$transaction->execute();
			
			$form->js(null,$form->js()->reload())->univ()->successMessage('Done')->execute();
		}

	}
}