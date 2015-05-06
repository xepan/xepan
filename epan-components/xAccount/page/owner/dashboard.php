<?php

class page_xAccount_page_owner_dashboard extends page_xAccount_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';


		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		$col_3 = $col->addColumn(3);
		$col_4 = $col->addColumn(3);

		

		//Today total sale
		$approved_order = $this->add('xShop/Model_Order');
		$approved_order->addExpression('approved_on')->set(function($m,$q){
			$act = $m->add('xCRM/Model_Activity')
				->addCondition('action','approved')
				->addCondition('related_root_document_name',$m->root_document_name)
				->addCondition('related_document_id',$q->getField('id'))
				->setOrder('updated_at','desc')
				->setLimit(1);
			return $act->fieldQuery('created_at');
		});

		$approved_order->addCondition('approved_on','>',$this->api->today);
		$approved_order->addCondition('approved_on','<=',$this->api->nextDate($this->api->today));

		$approve_tile = $col_1->add('View_Tile')->addClass('atk-swatch-green');
		$approve_tile->setTitle('Today Total Sales');
		$approve_tile->setContent($approved_order->count()->getOne());
		if($is_superuser_login)
			$approve_tile->setFooter(money_format('%!i', $approved_order->sum('net_amount')->getOne()),'icon-money');
		
		//Today Cash Sale
		$today_cash_tile = $col_2->add('View_Tile')->addClass('atk-swatch-green');
		$today_cash_tile->setTitle('Today Sales CASH');
		$today_cash_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_cash_tile->setFooter(money_format('%!i',00000),'icon-money');
		
		//Today Sales BANK
		$today_bank_tile = $col_3->add('View_Tile')->addClass('atk-swatch-green');
		$today_bank_tile->setTitle('Today Sales BANK');
		$today_bank_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_bank_tile->setFooter(money_format('%!i',00000),'icon-money');

		//Today Accounts Receivables
		$today_receivable_tile = $col_4->add('View_Tile')->addClass('atk-swatch-green');
		$today_receivable_tile->setTitle('Today Accounts Receivables');
		$today_receivable_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_receivable_tile->setFooter(money_format('%!i',00000),'icon-money');

		$this->add('View')->setElement('br');
		$col1 = $this->add('Columns');
		$col_5 = $col1->addColumn(3);
		$col_6 = $col1->addColumn(3);
		$col_7 = $col1->addColumn(3);
		$col_8 = $col1->addColumn(3);

		//Today Accounts Payable
		$today_payable_tile = $col_5->add('View_Tile')->addClass('atk-swatch-green');
		$today_payable_tile->setTitle('Today Accounts Payable');
		$today_payable_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_payable_tile->setFooter(money_format('%!i',00000),'icon-money');
		
		//Cash in Hand
		$cash_inhand_tile = $col_6->add('View_Tile')->addClass('atk-swatch-green');
		$cash_inhand_tile->setTitle('Cash in Hand');
		$cash_inhand_tile->setContent('ToDO');
		if($is_superuser_login)
			$cash_inhand_tile->setFooter(money_format('%!i',00000),'icon-money');

		//Bank Status
		$bank_status_tile = $col_7->add('View_Tile')->addClass('atk-swatch-green');
		$bank_status_tile->setTitle('Bank Status');
		$bank_status_tile->setContent('ToDO');
		if($is_superuser_login)
			$bank_status_tile->setFooter(money_format('%!i',00000),'icon-money');

		//Recent Financial Transactions
		$recent_transaction_tile = $col_8->add('View_Tile')->addClass('atk-swatch-green');
		$recent_transaction_tile->setTitle('Recent Financial Transactions');
		$recent_transaction_tile->setContent('ToDO');
		if($is_superuser_login)
			$recent_transaction_tile->setFooter(money_format('%!i',00000),'icon-money');


		}
}