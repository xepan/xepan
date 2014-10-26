<?php

class page_owner_updater extends page_base_owner {
	public $git_path = 'https://github.com/xepan/xepan';

	function page_index(){
		$this->add('View_Error')->set('1 : You are strongly recommended to backup your database and files and folders first.');
		$this->add('View_Error')->set('2 : Provide proper permissions to get files replaced');
		
		$this->add('HR');

		$update_btn = $this->add('Button')->set('Update');
		
		$update_btn->js('click',$update_btn->js()->text(' Updating ... '));

		if($update_btn->isClicked()){
			$this->update();
			$this->js(null, $update_btn->js()->text('Updated'))->univ()->successMessage('xEpan CMS Updated')->execute();
		}
	}

	function update($dynamic_model_update=true){
		if($this->git_path==null)
			throw $this->exception('public variable git_path must be defined in page class');
		
		
		$installation_path = getcwd();

		if(file_exists($installation_path.DS.'.git'))
			$repo = Git::open($installation_path);
		else
			$repo=Git::create($installation_path);

		$remote_branches = $repo->list_remote_branches();

		if(count($remote_branches) == 0)
			$repo->add_remote_address($this->git_path);

		$repo->run('fetch --all');
		$repo->run('reset --hard origin/master');

		if($dynamic_model_update){

			$model = $this->add('Model_Branch');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_Staff');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_EpanCategory');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_Epan');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_EpanTemplates');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_EpanPage');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_EpanPageSnapshots');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_MarketPlace');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_InstalledComponents');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();
        	
        	$model = $this->add('Model_Tools');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_Plugins');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_Alerts');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_Aliases');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_Messages');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();

        	$model = $this->add('Model_Users');
        	$model->add('dynamic_model/Controller_AutoCreator');
        	$model->tryLoadAny();


		}

		// fire queries to convert superuser to 100 etc
		$this->query('UPDATE users SET type=IF(type="SuperUser",100,IF(type="BackEndUser",80,IF(type=100,100,50)))');
		// change users type to int
		$this->query('ALTER TABLE `users` CHANGE `type` `type` INT NULL DEFAULT NULL');

		// re Process base Element Config
		$base_element_market_place = $this->add('Model_MarketPlace')->loadBy('namespace','baseElements');
		$base_element_market_place->reProcessConfig();

	}

	function query($q){
		$this->api->db->dsql($this->api->db->dsql()->expr($q))->execute();
	}
}