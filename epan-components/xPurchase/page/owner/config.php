<?php
class page_xPurchase_page_owner_config extends page_xPurchase_page_owner_main{
	function page_index(){
		$crud= $this->add('CRUD',array('allow_add'=>false,'allow_del'=>false));//,array('grid_class'=>'xShop/Grid_Shop'));
		$crud->setModel('xShop/Shop',array('name'));
		$crud->grid->addColumn('expander','configuration',array("descr"=>"Configuration",'icon'=>'cog'));

	}
	function page_configuration(){
		$application_id = $this->api->StickyGET('xshop_application_id');
		
		$config_model=$this->add('xShop/Model_Configuration')->addCondition('application_id',$application_id)->tryLoadAny();
		
		$tab=$this->add('Tabs');
			// $comment_tab=$tab->addTab('Comments');

			// 	$comment_form=$comment_tab->add('Form_Stacked');
			// 	$comment_form->setModel($config_model,array('disqus_code'));
			// 	$comment_form->addSubmit('Update');
			// 	if($comment_form->Submitted()){
			// 		$comment_form->Update();
			// 		$comment_form->js(null,$comment_form->js()->reload())->univ()->successMessage('Update Information')->execute();
			// 	}
			// 	$comment_form->addClass('panel panel-default');
			// 	$comment_form->addStyle('padding','20px');
			
			$mail_tab=$tab->addTab('Email Templates Layouts');
			
				$lay_tab=$mail_tab->add('Tabs');
				// 	$sales_tab=$lay_tab->addTab('Sales Order');
				// 		$sales_form=$sales_tab->add('Form_Stacked');
				// 		$sales_form->setModel($config_model,array('order_detail_email_subject','order_detail_email_body'));
				// 		$sales_form->addSubmit('Update');
				// 		if($sales_form->Submitted()){
				// 			$sales_form->Update();
				// 			$sales_form->js(null,$sales_form->js()->reload())->univ()->successMessage('Update Information')->execute();
				// 		}
				// 		$sales_form->addClass('panel panel-default');
				// 		$sales_form->addStyle('padding','20px');
					$purchase_tab=$lay_tab->addTab('Purchase Order');
						$purchase_form=$purchase_tab->add('Form_Stacked');
						$purchase_form->setModel($config_model,array('purchase_order_detail_email_subject','purchase_order_detail_email_body'));
						$purchase_form->addSubmit('Update');
						if($purchase_form->Submitted()){
							$purchase_form->Update();
							$purchase_form->js(null,$purchase_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						}
						$purchase_form->addClass('panel panel-default');
						$purchase_form->addStyle('padding','20px');
					
					// $quotation_tab=$lay_tab->addTab('Quotation');
					// 	$q_form=$quotation_tab->add('Form_Stacked');
					// 	$q_form->setModel($config_model,array('quotation_email_subject','quotation_email_body'));
					// 	$q_form->addSubmit('Update');
					// 	if($q_form->Submitted()){
					// 		$q_form->Update();
					// 		$q_form->js(null,$q_form->js()->reload())->univ()->successMessage('Update Information')->execute();
					// 	}
					// 	$q_form->addClass('panel panel-default');
					// 	$q_form->addStyle('padding','20px');
					
					// $sales_invoice_tab=$lay_tab->addTab('Sales Invoice');
					// 	$i_form=$sales_invoice_tab->add('Form_Stacked');
					// 	$i_form->setModel($config_model,array('invoice_email_subject','invoice_email_body'));
					// 	$i_form->addSubmit('Update');
					// 	if($i_form->Submitted()){
					// 		$i_form->Update();
					// 		$i_form->js(null,$i_form->js()->reload())->univ()->successMessage('Update Information')->execute();
					// 	}
					// 	$i_form->addClass('panel panel-default');
					// 	$i_form->addStyle('padding','20px');

					$purchase_invoice_tab=$lay_tab->addTab('Purchase Invoice');
						$p_form=$purchase_invoice_tab->add('Form_Stacked');
						$p_form->setModel($config_model,array('purchase_invoice_email_subject','purchase_invoice_email_body'));
						$p_form->addSubmit('Update');
						if($p_form->Submitted()){
							$p_form->Update();
							$p_form->js(null,$p_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						}
						$p_form->addClass('panel panel-default');
						$p_form->addStyle('padding','20px');

						// $outsource_tab=$lay_tab->addTab('OutSource Party');
						// $o_form=$outsource_tab->add('Form_Stacked');
						// $o_form->setModel($config_model,array('outsource_email_subject','outsource_email_body'));
						// $o_form->addSubmit('Update');
						// if($o_form->Submitted()){
						// 	$o_form->Update();
						// 	$o_form->js(null,$o_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						// }
						// $o_form->addClass('panel panel-default');
						// $o_form->addStyle('padding','20px');	

					// $cash_voucher_tab=$lay_tab->addTab('Cash Voucher');
					// 	$cash_form=$cash_voucher_tab->add('Form_Stacked');
					// 	$cash_form->setModel($config_model,array('cash_voucher_email_subject','cash_voucher_email_body'));
					// 	$cash_form->addSubmit('Update');
					// 	if($cash_form->Submitted()){
					// 		$cash_form->Update();
					// 		$cash_form->js(null,$cash_form->js()->reload())->univ()->successMessage('Update Information')->execute();
					// 	}
					// 	$cash_form->addClass('panel panel-default');
					// 	$cash_form->addStyle('padding','20px');	

			$number_tab=$tab->addTab('Starting Number');
			$number_form = $number_tab->add('Form_Stacked');
			$number_form->setModel($config_model,array('purchase_order_starting_number','purchase_invoice_starting_number'));
			$number_form->addSubmit('Update');
			if($number_form->Submitted()){
							$number_form->Update();
							$number_form->js(null,$number_form->js()->reload())->univ()->successMessage('Updated')->execute();
						}
			$number_form->addClass('panel panel-default');
			$number_form->addStyle('padding','20px');


			$misc_tab=$tab->addTab('Misc Setting');
			$misc_form = $misc_tab->add('Form_Stacked');
			$misc_form->setModel($config_model,array('is_round_amount_calculation'));
			$misc_form->addSubmit('Update');
			if($misc_form->Submitted()){
				$misc_form->update();
				$misc_form->js(null,$misc_form->js()->reload())->univ()->successMessage('Updated')->execute();
			}
			$misc_form->addClass('panel panel-default');
			$misc_form->addStyle('padding','20px');		
	}
}