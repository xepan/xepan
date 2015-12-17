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
		// $this->template->trySet('user_name',$this->api->auth->model['user_name']);

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