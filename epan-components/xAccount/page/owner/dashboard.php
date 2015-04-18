<?php

class page_xAccount_page_owner_dashboard extends page_xAccount_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';

// 				$x = <<<EOF
// 		Todays Business (Total, Cash, Bank)
// 		Total Accounts Receivables
// 		Total Accounts Payable
		
// 		Cash In Hand
// 		Bank Status
		
// 		Recent Financial Transactions (From Day Book)

// EOF;

// 		$this->add('View')->setHTML(nl2br($x));

		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		$col_3 = $col->addColumn(3);
		$col_4 = $col->addColumn(3);

		$today_business_tile = $col_1->add('View_Tile')->addClass('atk-swatch-green');
		$today_business_tile->setTitle('Today Sales Total');
		$today_business_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_business_tile->setFooter(money_format('%!i',00000),'icon-money');

		
		$today_cash_tile = $col_2->add('View_Tile')->addClass('atk-swatch-green');
		$today_cash_tile->setTitle('Today Sales CASH');
		$today_cash_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_cash_tile->setFooter(money_format('%!i',00000),'icon-money');
		
		$today_bank_tile = $col_3->add('View_Tile')->addClass('atk-swatch-green');
		$today_bank_tile->setTitle('Today Sales BANK');
		$today_bank_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_bank_tile->setFooter(money_format('%!i',00000),'icon-money');

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

		$today_payable_tile = $col_5->add('View_Tile')->addClass('atk-swatch-green');
		$today_payable_tile->setTitle('Today Accounts Payable');
		$today_payable_tile->setContent('ToDO');
		if($is_superuser_login)
			$today_payable_tile->setFooter(money_format('%!i',00000),'icon-money');
		
		$cash_inhand_tile = $col_6->add('View_Tile')->addClass('atk-swatch-green');
		$cash_inhand_tile->setTitle('Cash in Hand');
		$cash_inhand_tile->setContent('ToDO');
		if($is_superuser_login)
			$cash_inhand_tile->setFooter(money_format('%!i',00000),'icon-money');

		$bank_status_tile = $col_7->add('View_Tile')->addClass('atk-swatch-green');
		$bank_status_tile->setTitle('Bank Status');
		$bank_status_tile->setContent('ToDO');
		if($is_superuser_login)
			$bank_status_tile->setFooter(money_format('%!i',00000),'icon-money');

		$recent_transaction_tile = $col_8->add('View_Tile')->addClass('atk-swatch-green');
		$recent_transaction_tile->setTitle('Recent Financial Transactions');
		$recent_transaction_tile->setContent('ToDO');
		if($is_superuser_login)
			$recent_transaction_tile->setFooter(money_format('%!i',00000),'icon-money');


		}
}