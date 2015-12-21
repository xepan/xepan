<?php
class page_xPurchase_page_owner_config extends page_xPurchase_page_owner_main{
	function page_index(){
		$this->app->title=$this->api->current_department['name'] .': Configuration';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Purchase Department Management <small> Manage your shops here</small>');
		$crud= $this->add('CRUD',array('allow_add'=>false,'allow_del'=>false));//,array('grid_class'=>'xShop/Grid_Shop'));
		$crud->setModel('xShop/Shop',array('name'));
		$crud->grid->addColumn('expander','configuration',array("descr"=>"Configuration",'icon'=>'cog'));

	}
	function page_configuration(){

		$application_id = $this->api->StickyGET('xshop_application_id');
		$config_model=$this->add('xShop/Model_Configuration')->addCondition('application_id',$application_id)->tryLoadAny();

		$tab=$this->add('Tabs');
			
			$mail_tab=$tab->addTab('Email Templates Layouts');
			
				$lay_tab=$mail_tab->add('Tabs');
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