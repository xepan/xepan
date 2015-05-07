<?php

class page_xMarketingCampaign_page_owner_config extends page_xMarketingCampaign_page_owner_main{

	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Configuration';
		$tab = $this->app->layout->add('Tabs');
		$email_tab = $tab->addTabURL('./emailconfig','<i class="fa fa-envelope"></i> <i class="fa fa-cog"></i> Mass Email Config');
		$api_tab = $tab->addTabURL('./social','<i class="fa fa-share-alt-square"></i> <i class="fa fa-cog"></i> Social Config');
	}	
		//Email Tab
	function page_emailconfig(){
		$config_model = $this->add('xMarketingCampaign/Model_Config');
		$crud = $this->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_ConfigMassMail'));
		$crud->setModel($config_model);

		// $crud->add('Controller_FormBeautifier');
		if(!$crud->isEditing()){
			$crud->add_button->setIcon('ui-icon-plusthick');
		}
	}
			//End of Email Tab

	function page_social(){
		
		$tabs = $this->add('Tabs');

		$objects = scandir($plug_path = getcwd().DS.'epan-components'.DS.'xMarketingCampaign'.DS.'lib'.DS.'Controller'.DS.'SocialPosters');
    	foreach ($objects as $object) {
    		if ($object != "." && $object != "..") {
        		if (filetype($plug_path.DS.$object) != "dir"){
        			$object = str_replace(".php", "", $object);
        			$t=$tabs->addTab($object);
        			// $login_status_view =$t->add('View');
        			$social = $t->add('xMarketingCampaign/Controller_SocialPosters_'.$object);
        			$social->config_page();
        			// $login_status_view->setHTML($object. ' - '. $social->login_status());
        		}
    		}
    	}

	}
}		