<?php

namespace xShop;

class View_Tools_MemberAccount extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();
		
		//Checking Authentication
		// throw new \Exception($this->html_attributes['xsnb-login-page'], 1);
		
		if(!$this->api->auth->model->loaded()){
			if($this->html_attributes['xsnb-login-page']){
				$this->api->redirect($this->api->url(null,array('subpage'=>$this->html_attributes['xsnb-login-page'],'user_selected_form'=>'login','redirect'=>$_GET['subpage'])));
			}else{
				$this->add('View_Warning',null,'noAuth')->set('Login First ');
			}
				$this->template->tryDel('auth');
				return;
		}
		//Login User Model and Checking is it FrontEndUses or BackEndUser
		$user=$this->add('Model_Users')->load($this->api->auth->model->id);
		$created_at=$user->get('created_at');
		$last_login=$user->get('last_login_date');
		if($user['type']==50){
				$user['type']='FrontEndUser';
		}elseif ($user['type']==100) {
					$user['type']='SuperUser';
		}else{
			$user['type']='BackEndUser';

		}

		$user_type=$user->get('type');
		$user_email=$user->get('email');

		//Seeting Some Values in Templates
		$this->template->trySet('customer',$this->api->auth->model['name']);
		$this->template->trySet('created_at',date('M-d',strtotime($created_at)));
		$this->template->trySet('last_login_date',date('M-d',strtotime($last_login)));
		$this->template->trySet('user_type',$user_type);
		$this->template->trySet('email',$user_email);


		//Adding Two view Left and Right
		$left = $this->add('View',null,'listmenu');
		$right = $this->add('View');
		
		//Left Menu bar Buttons
		$left->add('View')->setElement('button')->addClass('list-group-item atk-swatch-yellow')->set('My Account')->setAttr('data-type','myaccount')->setStyle('padding','10px !important');
		$left->add('View')->setElement('button')->addClass('list-group-item ')->set('Order History')->setAttr('data-type','order')->setStyle('padding','10px !important');
		$left->add('View')->setElement('button')->addClass('list-group-item ')->set('My Designs')->setAttr('data-type','mydesign')->setStyle('padding','10px !important');
		$left->add('View')->setElement('button')->addClass('list-group-item ')->set('Settings')->setAttr('data-type','setting')->setStyle('padding','10px !important');

		//Default selected Menu
		$selected_menu = 'myaccount';
		//My Account Info
		if($this->api->stickyGET('selectedmenu'))
			$selected_menu = $this->api->stickyGET('selectedmenu');

		$member = $this->add('xShop/Model_MemberDetails');
		$member->addCondition('users_id',$this->api->auth->model->id);
		$member->tryLoadAny();

		if( $selected_menu == "myaccount"){
			$right->add('H2','heading')->set('Account Information')->setStyle(array('border-bottom'=>'2px solid #f2f2f2','padding-bottom'=>'10px'));
			// $this->template->trySet('heading','Account Information');

			$right->add('H2')->set($member['name']);
			$right->add('view')->setElement('p')->set(" ".$member['email'])->addClass('icon-mail');
			$right->add('view')->setElement('p')->set(" ".($member['mobile_number']?:'Not Added') )->addClass('icon-phone');

			$c = $right->add('Columns');
			$col_1 = $c->addColumn(4);
			$col_2 = $c->addColumn(4);
			$col_3 = $c->addColumn(4);

			//Permanent Address
			$col_1->add('H4')->set('Permanent Address')->addClass('atk-swatch-gray atk-padding');
			$col_1->add('View')->setElement('p')->set(($member['address']?:"Not Added"))->addClass('atk-padding');
			
			//Billing Address
			// $col_2->add('H4')->set('Billing Address')->addClass('atk-swatch-gray atk-padding');
			// $col_2->add('View')->setElement('p')->set(($member['billing_address']?:"Not Added"))->addClass('atk-padding');

			// //Shipping Address
			// $col_3->add('H4')->set('Shipping Address')->addClass('atk-swatch-gray atk-padding');
			// $col_3->add('View')->setElement('p')->set(($member['shipping_address']?:"Not Added"))->addClass('atk-padding');
			
			//Recent Order 
			$right->add('H2')->set('Recent Order');
			$right->add('xShop/View_MemberOrder',['ipp'=>5,'gridFields'=>['name','created_date','total_amount','gross_amount','tax','net_amount']]);

		}elseif($selected_menu == "order"){
			// $this->template->trySet('heading','Order History');
			$right->add('H2','heading')->set('Order History')->setStyle(array('border-bottom'=>'2px solid #f2f2f2','padding-bottom'=>'10px'));
			$right->add('xShop/View_MemberOrder',['ipp'=>10,'gridFields'=>['name','created_date','total_amount','gross_amount','tax','net_amount']]);

		}elseif($selected_menu == "mydesign"){
			$right->add('H2','heading')->set('My Designs')->setStyle(array('border-bottom'=>'2px solid #f2f2f2','padding-bottom'=>'10px'));
			$right->add('xShop/View_MemberDesign',array('designer_page'=>$this->html_attributes['xsnb-desinger-page']));

		}elseif($selected_menu == "setting"){
			$right->add('H2','heading')->set('Settings')->setStyle(array('border-bottom'=>'2px solid #f2f2f2','padding-bottom'=>'10px'));
			$right->add('xShop/View_MemberAccountInfo');
		}

		$right->add('View')->set($_GET['type1']);

		$right_url = $this->api->url(null,['cut_object'=>$right->name]);
		

		//Js For Reloading the Right Column and passed the type valued
		$left->on('click','button',
			[
            	$left->js()->find('.atk-swatch-yellow')->removeClass('atk-swatch-yellow'),
				$right->js()->reload(['selectedmenu'=>$this->js()->_selectorThis()->attr('data-type'),'designer_page'=>$this->html_attributes['xsnb-desinger-page']]),
				$this->js()->_selectorThis()->addClass('atk-swatch-yellow'),
			]
			);



			// $tab = $right->add('Tabs',null,null,['view/tabs_vertical'])->addClass('nav-stacked');
			//Account Information
			// $s = $tab->addTabUrl('xShop/page/owner_member_accountinfo','Settings');
			//MEMBER ORDER tab
			// $tab->addTabUrl('xShop/page/owner_member_order','Order');

			// MEMBER DESIGNS
			// $tab->addTabUrl($this->api->url('xShop/page/owner_member_design',array('designer_page'=>$this->html_attributes['xsnb-desinger-page'])),'Designs');

	}
	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}