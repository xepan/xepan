<?php

class page_developerZone_page_owner_main extends page_componentBase_page_owner_main {

	function init(){
		parent::init();

		$this->h1->setHTML('<i class="fa fa-wrench"></i> '.$this->component_name .'<small> Helper utility to create new applications </small>');

		if(!$this->api->isAjaxOutput()){
			$dh_b= $this->toolbar->addButton( 'Developer Home' );
			$dh_b->setIcon('ui-icon-home');
			$dh_b->js( 'click', $this->js()->univ()->redirect( $this->api->url('developerZone_page_owner_main') ) );
			$ds_b= $this->toolbar->addButton( 'Dashboard' );
			$ds_b->setIcon('ui-icon-home');
			$ds_b->js( 'click', $this->js()->univ()->redirect( $this->api->url('owner_dashboard') ) );
		}
	}

	function page_index(){
		if($_GET['page'] == 'developerZone_page_owner_main' or $_GET['page'] == 'developerZone/page/owner/main'){
			$this->add('H4')->set('Available Components in Local MarketPlace');
			$grid = $this->add('Grid');
			$grid->setModel('MarketPlace',array('namespace','type','name','is_system','has_toolbar_tools','has_owner_modules','has_plugins','has_live_edit_app_page'));

			$btn=$grid->add('Button',null,'top_1')->set('New Component');
			$btn->setIcon('ui-icon-plusthick');
			$btn->js('click',$this->js()->univ()->redirect($this->api->url('developerZone_page_owner_component_new')));

			$grid->setFormatter('namespace','template')->setTemplate('<a href="?page=developerZone_page_owner_component_edit&component=<?$namespace?>"><?$namespace?></a>');

			$grid->addColumn('Template','download')->setTemplate('<a href="epan-components/<?$namespace?>/<?$namespace?>.zip" target="_blank">download</a>');
			$grid->addColumn('Button','create_package');
			// $grid->addColumn('Expander','contribute_to_xepan');

			if($_GET['create_package']){
				$component = $this->add('Model_MarketPlace');
				$component->load($_GET['create_package']);
				$component->createPackage();
				$this->js()->univ()->successMessage('Package Created')->execute();
			}

		}
	}

	function page_contribute_to_xepan(){
		$this->api->stickyGET('epan_components_marketplace_id');
		$component = $this->add('Model_MarketPlace');
		$component->Load($_GET['epan_components_marketplace_id']);

		$this->add('H5')->set('Provide Your xEpan Developer Credentials');

		$tabs = $this->add('Tabs');
		$login_tab = $tabs->addTab('Login & Upload');
		$register_tab = $tabs->addTab('Register');

		$form=$login_tab->add('Form');
		$form->addField('line','username');
		$form->addField('password','password');
		$form->addSubmit('Upload');
		if($form->isSubmitted()){
			// Check credentials SSL ???
			// 
		}
	}

	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}