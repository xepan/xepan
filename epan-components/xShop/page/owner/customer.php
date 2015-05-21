<?php

class page_xShop_page_owner_customer extends page_xShop_page_owner_main{

	function page_index(){

		$this->app->title=$this->api->current_department['name'] .': Customers';		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Customers Management <small> Manage your customers </small>');


		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Customer'));
	
		$members=$this->add('xShop/Model_Customer');

		if(!$crud->isEditing()){

			$btn = $crud->grid->addButton('System User to Customer Create');
			if($btn->isClicked()){
				foreach ($um=$this->add('Model_Users') as $junk) {
					$nm = $this->add('xShop/Model_MemberDetails');
					$nm->addCondition('users_id',$um->id);
					$nm->tryLoadAny();
					$nm->save();
				}
			$crud->grid->js()->reload()->execute();
			}
		}
		
		$members->setOrder('id');
		$crud->setModel($members,array(
										'username','password',
										'customer_name','customer_email',
										'type','email','other_emails','mobile_number',
										'landmark','city','state','pan_no','tin_no',
										'country','address',
										'pincode','billing_address',
										'shipping_address','user_account_activation','is_active'
										),
								array('customer_name','customer_email',
										'mobile_number','address','city','state',
										'country','pincode','user_account_activation','is_active')
								);

        $crud->add('xHR/Controller_Acl');
		
	}
}	