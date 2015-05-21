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

		if($crud->isEditing()){
			$cats = $crud->form->addField('DropDownNormal','add_to_category')
				->setEmptyText('Do not add to any subscription category');
			$cats->setModel('xMarketingCampaign/LeadCategory');
			$crud->form->addHook('update',function($form)use($members){
				$members->addHook('afterSave',function($m)use($form){
					
					$subs = $m->add('xEnquiryNSubscription\Model_Subscription');
					$subs->addCondition('email',$m['customer_email']);
					$subs->tryLoadAny();
					$subs['name'] = $m['customer_name'];
					$subs['mobile_no'] = $m['mobile_number'];
					$subs['from_app'] = 'Customer';
					$subs['organization_name'] = $m['organization_name'];
					$subs['website'] = $m['website'];
					$subs['from_id'] = $m->id;
					$subs->save();
					// throw new \Exception($m['customer_email'], 1);
					$subs_cat = $this->add('xEnquiryNSubscription\Model_SubscriptionCategories');
					$subs_cat->load($form['add_to_category']);
					$subs_cat->addSubscriber($subs);
					// throw new \Exception($m['customer_name']. ' '.  $form->get('add_to_category'), 1);
				});
			});
		}

		$crud->setModel($members,array(
										'username','password',
										'customer_name','customer_email','organization_name',
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

		if($crud->isEditing('edit')){
			$subs = $this->add('xEnquiryNSubscription\Model_Subscription');
			$subs->addCondition('email',$crud->form->model['customer_email']);
			$subs->tryLoadAny();
			$crud->form->getElement('add_to_category')->set($subs->ref('xEnquiryNSubscription/SubscriptionCategoryAssociation')->tryLoadAny()->get('id'));
		}

        $crud->add('xHR/Controller_Acl');
		
	}
}	