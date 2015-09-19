<?php

class page_developerZone_page_owner_dashboard extends page_developerZone_page_owner_main {

	function page_index(){
			$this->app->title="Developer Zone" .': Dashboard';
			$this->app->layout->add('H4')->set('Available Components in Local MarketPlace');
			$grid = $this->app->layout->add('Grid');
			$grid->setModel('MarketPlace',array('namespace','type','name','is_system','has_toolbar_tools','has_owner_modules','has_plugins','has_live_edit_app_page'));

			$btn=$grid->add('Button',null,'grid_buttons')->set('New Component');
			$btn->setIcon('ui-icon-plusthick');
			$btn->js('click',$this->js()->univ()->frameURL("New Component",$this->api->url('developerZone_page_owner_component_new')));

			$btn_installer = $grid->add('Button',null,'grid_buttons')->set('Create Installer');
			$btn_installer->setIcon('icon-cog');
			$btn_installer->js('click',$this->js()->univ()->frameURL("Create Installer",$this->api->url('./create_installer')));

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

	function page_create_installer(){
		$this->template->loadTemplate('page/owner/create_installer');
		$this->template->set('_name',$this->name);
		$components_in_database =[];
		$components_in_physical =[];
		$components_not_physically_present=[];
		$components_not_in_database=[];

		// Check all components are in Database
		$this->add('Model_MarketPlace')->each(function($m)use(&$components_in_database){
			$components_in_database[]=$m['namespace'];
		});
		
		$components_in_physical = array_filter(glob('epan-components/*'), 'is_dir');
		array_walk($components_in_physical, function(&$v){$v= str_replace("epan-components/", "", $v);});

		$components_not_physically_present = array_diff($components_in_database, $components_in_physical);
		$components_not_in_database = array_diff($components_in_physical, $components_in_database);

		$this->add('CompleteLister',null,'missmatch_components',['page/owner/create_installer','missmatch_components'])
			->setSource($components_not_physically_present)
			->template->set(['block_title'=>'Components Not Physical','block_swatch'=>'red']);

		$to_db = $this->add('CompleteLister',null,'missmatch_components',['page/owner/create_installer','missmatch_components'])
			->setSource($components_not_in_database);
		$to_db
			->template->set(['block_title'=>'Components Not in Database','block_swatch'=>'yellow']);

		$this->add('Button',null,'lite_button',['page/owner/create_installer','lite_button'])
				->js('click',$this->js()->reload(['installer'=>'lite']));


		// $to_db->addHook('formatRow',function($l){
		// 	$this->add('Model_MarketPlace')
		// 			->reProcessConfig('epan-components'.DS.$l->current_row['name'].DS.'config.xml' ,true);
		// });


		// create sql
		// create structure sql
		// pic selected database that are required by default and add to SQL as insert statement
		// create a zip file and add all files
		// - epans/web file
		// + epans/web/index.html file
		// - upload files
		// - .git folder
	}

	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}