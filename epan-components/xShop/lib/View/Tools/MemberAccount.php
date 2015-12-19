<?php

namespace xShop;

class View_Tools_MemberAccount extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

		if(!$this->api->auth->model->loaded()){
			$this->add('View_Warning')->set('Login First');
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

		// $this->add('H1')->set($this->api->auth->model['name'])->addClass('xsnb-member-name');
			
			$tab = $this->add('Tabs')->addClass('nav-stacked');
			//Account Information
			$tab->addTabUrl('xShop/page/owner_member_accountinfo','Settings');

			//MEMBER ORDER tab
			$tab->addTabUrl('xShop/page/owner_member_order','Order');

			// MEMBER DESIGNS
			$tab->addTabUrl($this->api->url('xShop/page/owner_member_design',array('designer_page'=>$this->html_attributes['xsnb-desinger-page'])),'Designs');

	}
	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}