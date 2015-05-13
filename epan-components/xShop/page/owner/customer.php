<?php

class page_xShop_page_owner_customer extends page_xShop_page_owner_main{

	function page_index(){

		$this->app->title=$this->api->current_department['name'] .': Customers';		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Customers Management <small> Manage your customers </small>');

			$this->vp = $this->add('VirtualPage')->set(function($p){
			$this->api->StickyGET('customer_id');
			// $p->add('View')->set('hghjg'.$_GET['customer_id']);

			$grid = $p->add('xShop/Grid_Order');
			$so = $p->add('xShop/Model_Order')->addCondition('member_id',$_GET['customer_id']);
			$grid->setModel($so);
		});


		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Customer'));
		

		$members=$this->add('xShop/Model_Customer');
		

		if(!$crud->isEditing()){
		// $users_join = $members->leftJoin('users','users_id');
		// $users_join->addField('username','username');
		// $users_join->addField('email','email');
		// $users_join->addField('is_user_active','is_active')->type('boolean');
		// $users_join->addField('joining_date','created_at')->type('date');

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

			// $crud->grid->add('misc/Export');
			$crud->grid->addQuickSearch(array('users','email','address','city','mobile_number'));
			$crud->grid->addPaginator($ipp=50);
		}
		
		$members->setOrder('id');
		$crud->setModel($members,array(
										'username','password',
										'customer_name','customer_email',
										'type','email','other_emails','mobile_number',
										'landmark','city','state','pan_no','tin_no',
										'country','address',
										'pincode','billing_address',
										'shipping_address'
										),
								array('customer_name','customer_email',
										'mobile_number','address','city','state',
										'country','pincode')
								);

        $crud->add('xHR/Controller_Acl');
        
        	if(!$crud->isEditing()){
	        	$self = $this;
				$g=$crud->grid;	
				$g->addColumn('total_sales_order');
				$g->addMethod('format_total_sales_order',function($g,$f)use($self){
					$g->current_row_html[$f] = '<a href="#na" onclick="javascript:'.$g->js()->univ()->frameURL('Sales Order List ', $self->api->url($self->vp->getURL(),array('customer_id'=>$g->model['id']))).'">'. $g->model->ref('xShop/Order')->count()->getOne()."</a>";
				});
				$g->addFormatter('total_sales_order','total_sales_order');
		}
		
	}
}	