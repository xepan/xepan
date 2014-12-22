<?php

class page_owner_installcomponent extends page_base_owner {

	function page_index(){
		$this->api->stickyGET('component_id');

		$component = $this->add('Model_MarketPlace')->load($_GET['component_id']);
		$this->setModel($component);
		$this->add('H1')->set($component['name']);
		$this->add('View')->set($component['description']);
		
		if( $this->add('Model_InstalledComponents')
			->addCondition('epan_id',$this->api->current_website->id)
			->addCondition('component_id',$component->id)
			->tryLoadAny()
			->loaded())
		{
			// Component is installed
			$this->add('View')->set('Component Already Installed')->addClass('alert')->addClass('alert-success');
		}else{
			// Component is not installed
			$this->add('Button')->set('Install')->js('click')->univ()->frameURL('Install ???',$this->api->url($component['namespace'].'_page_install'));
		}
		
		if(is_file($path = getcwd().'/epan-components/'.$component['namespace'].'/templates/view/'.$component['namespace'].'-about.html')){
			$l=$this->api->locate('addons',$component['namespace'], 'location');
			$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-addons/'.$component['namespace'], array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'css',
		        'js'=>'js',
			    )
			);

			$about_component = $this->add('View',null,null,array('view/'.$component['namespace'].'-about'));
		}


	}

	// function defaultTemplate(){
	// 	return array('owner/installcomponent');
	// }
}