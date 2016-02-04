<?php

namespace xShop;

class View_Tools_MemberAccount extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

		if(!$this->api->auth->model->loaded()){
			$this->add('View_Warning',null,'noAuth')->set('Login First');
			$this->template->tryDel('auth');
			return;
		}
		
		$this->template->trySet('customer',$this->api->auth->model['name']);
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
		$this->template->trySet('created_at',date('M-d',strtotime($created_at)));
		$this->template->trySet('last_login_date',date('M-d',strtotime($last_login)));
		$this->template->trySet('user_type',$user_type);
		$this->template->trySet('email',$user_email);

		$col = $this->add('Columns');
		// $left = $col->addColumn(3);
		// $right = $col->addColumn(9);
		$left = $this->add('View',null,'listmenu');
		$right = $this->add('View');
		// $this->add('H1')->set($this->api->auth->model['name'])->addClass('xsnb-member-name');
		$left->add('View')->setElement('button')->addClass('list-group-item atk-swatch-yellow')->set('My Account')->setAttr('data-type','myaccount')->setStyle('padding','10px !important');
		$left->add('View')->setElement('button')->addClass('list-group-item ')->set('Order History')->setAttr('data-type','order')->setStyle('padding','10px !important');
		$left->add('View')->setElement('button')->addClass('list-group-item ')->set('My Designs')->setAttr('data-type','mydesign')->setStyle('padding','10px !important');
		$left->add('View')->setElement('button')->addClass('list-group-item ')->set('Settings')->setAttr('data-type','setting')->setStyle('padding','10px !important');

		//My Account Info
		$type = 'myaccount';
		if($this->api->stickyGET('type'))
			$type = $this->api->stickyGET('type');


		if( $type == "myaccount"){
			$this->template->trySet('heading','Account Information');
			$right->add('View_Info')->set('myAccount');

		}elseif($type == "order"){
			$right->add('View_Info')->set('Order');

		}elseif($type == "mydesign"){
			$right->add('View_Info')->set('My Designs');

		}elseif($type == "setting"){
			$right->add('View_Info')->set('Settings');
		}

		$right->add('View')->set($_GET['type1']);

		$right_url = $this->api->url(null,['cut_object'=>$right->name]);
		

		//Js For Reloading the Right Column and passed the type valued
		$left->on('click','button',
			[
            	$left->js()->find('.atk-swatch-yellow')->removeClass('atk-swatch-yellow'),
				$right->js()->reload(['type'=>$this->js()->_selectorThis()->attr('data-type')]),
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