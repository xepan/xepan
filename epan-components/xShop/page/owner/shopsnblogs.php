<?php

class page_xShop_page_owner_shopsnblogs extends page_xShop_page_owner_main {
	
	function page_index(){
		
		$this->app->title=$this->api->current_department['name'] .': Configuration';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Shops & Blogs Management <small> Manage your shops and blogs here </small>');

		$tabs= $this->add('Tabs');
		$shop_tab = $tabs->addTabURL('./shops','Shops');
		$shop_tab = $tabs->addTabURL('./blogs','Blogs');
	}

	function page_shops(){



		$crud= $this->add('CRUD',array('grid_class'=>'xShop/Grid_Shop'));
		$crud->setModel('xShop/Shop');

		$cf_crud = $crud->addRef('xShop/CustomFields',array('label'=>'Custom Fields'));
		$sp_crud = $crud->addRef('xShop/Specification',array('label'=>'Specifications'));
		$itemoffer_crud=$crud->addRef('xShop/ItemOffer',array('label'=>'Item Offers'));
		if(!$crud->isEditing()){
			$crud->grid->addColumn('expander','configuration',array("descr"=>"Configuration",'icon'=>'cog'));
			$crud->grid->addColumn('expander','tax',array("descr"=>"Taxs",'icon'=>'money'));
			$crud->grid->addColumn('expander','priority',array("descr"=>"Priority",'icon'=>'signal'));
		}

		$crud->grid->addQuickSearch(array('name'));
		$crud->grid->addPaginator($ipp=50);
        $crud->add('xHR/Controller_Acl');
		
	}

	function page_blogs(){
		$crud= $this->add('CRUD',array('grid_class'=>'xShop/Grid_Blog'));
		$crud->setModel('xShop/Blog');

		if(!$crud->isEditing()){
			$crud->grid->addColumn('expander','configuration',array("descr"=>"Configuration",'icon'=>'cog'));
		}

		$crud->grid->addQuickSearch(array('name'));
		$crud->grid->addPaginator($ipp=50);
	}

	function page_shops_configuration(){
		$this->page_blogs_configuration();
	}
	
	function page_shops_tax(){
		$tax = $this->add('xShop/Model_Tax');
		$crud = $this->add('CRUD');
		$crud->setModel($tax,array('name','value'));
	}

	function page_shops_priority(){
		$priority = $this->add('xShop/Model_Priority');
		$crud = $this->add('CRUD');
		$crud->setModel($priority,array('name','value'));
	}

	function page_blogs_configuration(){
		$application_id = $this->api->StickyGET('xshop_application_id');
		$config_model=$this->add('xShop/Model_Configuration')->addCondition('application_id',$application_id)->tryLoadAny();
		$tab=$this->add('Tabs');
			$comment_tab=$tab->addTab('Comments');

				$comment_form=$comment_tab->add('Form');
				$comment_form->setModel($config_model,array('disqus_code'));
				$comment_form->addSubmit('Update');
				if($comment_form->Submitted()){
					$comment_form->Update();
					$comment_form->js(null,$comment_form->js()->reload())->univ()->successMessage('Update Information')->execute();
				}
				$comment_form->addClass('panel panel-default');
				$comment_form->addStyle('padding','20px');
			
			$mail_tab=$tab->addTab('Layouts');
			
				$lay_tab=$mail_tab->add('Tabs');
					$sales_tab=$lay_tab->addTab('Sales Order');
						$sales_form=$sales_tab->add('Form');
						$sales_form->setModel($config_model,array('order_detail_email_subject','order_detail_email_body'));
						$sales_form->addSubmit('Update');
						if($sales_form->Submitted()){
							$sales_form->Update();
							$sales_form->js(null,$sales_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						}
						$sales_form->addClass('panel panel-default');
						$sales_form->addStyle('padding','20px');
					
					$purchase_tab=$lay_tab->addTab('Purchase Order');
						$purchase_form=$purchase_tab->add('Form');
						$purchase_form->setModel($config_model,array('purchase_order_detail_email_subject','purchase_order_detail_email_body'));
						$purchase_form->addSubmit('Update');
						if($purchase_form->Submitted()){
							$purchase_form->Update();
							$purchase_form->js(null,$purchase_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						}
						$purchase_form->addClass('panel panel-default');
						$purchase_form->addStyle('padding','20px');
					
					$quotation_tab=$lay_tab->addTab('Quotation');
						$q_form=$quotation_tab->add('Form');
						$q_form->setModel($config_model,array('quotation_email_subject','quotation_email_body'));
						$q_form->addSubmit('Update');
						if($q_form->Submitted()){
							$q_form->Update();
							$q_form->js(null,$q_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						}
						$q_form->addClass('panel panel-default');
						$q_form->addStyle('padding','20px');
					
					$sales_invoice_tab=$lay_tab->addTab('Sales Invoice');
						$i_form=$sales_invoice_tab->add('Form');
						$i_form->setModel($config_model,array('invoice_email_subject','invoice_email_body'));
						$i_form->addSubmit('Update');
						if($i_form->Submitted()){
							$i_form->Update();
							$i_form->js(null,$i_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						}
						$i_form->addClass('panel panel-default');
						$i_form->addStyle('padding','20px');

					$purchase_invoice_tab=$lay_tab->addTab('Purchase Invoice');
						$p_form=$purchase_invoice_tab->add('Form');
						$p_form->setModel($config_model,array('purchase_invoice_email_subject','purchase_invoice_email_body'));
						$p_form->addSubmit('Update');
						if($p_form->Submitted()){
							$p_form->Update();
							$p_form->js(null,$p_form->js()->reload())->univ()->successMessage('Update Information')->execute();
						}
						$p_form->addClass('panel panel-default');
						$p_form->addStyle('padding','20px');	

	}

}