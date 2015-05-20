<?php

class page_owner_updater extends page_base_owner {
	public $git_path = 'https://github.com/xepan/xepan';

	function page_index(){

                $this->add('H3')->setHtml('<i class="glyphicon glyphicon-chevron-up"></i> xEpan Update <small>Update xEpan via git </small>');

		$this->add('View_Error')->set('1 : You are strongly recommended to backup your database and files and folders first.');
		$this->add('View_Error')->set('2 : Provide proper permissions to get files replaced');
		
		$this->add('HR');

                $form = $this->add('Form');
                $form->addField('line','git_exec_path')->set('/usr/bin/git')->validateNotNull();
                $form->addField('DropDown','git_branch')->setEmptyText("Do not Update Code")->setValueList(array('master'=>'master','develop'=>'develop'));
                $update_btn = $form->addSubmit('Update');

                if($form->isSubmitted()){
			         $this->page_updateall(true,$form['git_exec_path'],$form['git_branch']);
			         $this->js(null, $update_btn->js()->text('Updated'))->univ()->successMessage('xEpan CMS Updated')->execute();
                }

	}

    function page_updateall($dynamic_model_update=true,$git_exec_path=null, $git_branch=''){

        $this->page_update($dynamic_model_update,$git_exec_path,$git_branch);
        
        $components = $this->add('Model_MarketPlace')->addCondition('type','<>','element');
        foreach ($components as $comp) {
            $this->add('View')->set('Updating ' . $comp['namespace']);
            $this->add('page_'.$comp['namespace'].'_page_owner_update');
        }

    }

	function page_update($dynamic_model_update=true,$git_exec_path=null, $git_branch=''){
		if($this->git_path==null)
			throw $this->exception('public variable git_path must be defined in page class');
		
		
		$installation_path = getcwd();

                if($git_branch){
                        if($git_exec_path){
                                Git::set_bin($git_exec_path);
                        }

        		if(file_exists($installation_path.DS.'.git'))
        			$repo = Git::open($installation_path);
        		else
        			$repo=Git::create($installation_path);

        		$remote_branches = $repo->list_remote_branches();

        		if(count($remote_branches) == 0)
        			$repo->add_remote_address($this->git_path);

        		$repo->run('fetch --all');
        		$repo->run('reset --hard origin/'.$git_branch);
                }

		if($dynamic_model_update){
                        $current_autocreator_value= $this->api->getConfig('autocreator');
                        $this->api->setConfig('autocreator',true);
                        $model_array=array();
                        $dir = getcwd().DS.'lib'.DS.'Model';
                        
                        if(file_exists($dir)){
                                $lst = scandir($dir);
                        array_shift($lst);
                        array_shift($lst);
                    
                    $by_pass_models=array('Model_Document','Model_Table');

                    foreach ($lst as $item){
                        if (filetype($dir."/".$item) == "dir") continue;
                        $item = str_replace(".php", "", $item);
                        if(!in_array('Model_'.$item, $by_pass_models))
                            $model_array[] = 'Model_'.$item;
                    }

                    foreach ($model_array as $md_name) {
                        $md = $this->add($md_name);
                        if(!$md instanceof SQL_Model) {
                                continue;
                        }
                                        $model = $this->add($md);
                                        if(isset($model->is_view) and $model->is_view) continue;

                                        $this->dropForeignkeys($model->table);
                                        foreach ($model->elements as $elm) {
                                                if(!$elm instanceof AbstractObject) continue;
                                                if($elm instanceof Field_Expression or $elm instanceof SQL_Many)
                                                        $elm->destroy();
                                                if($elm instanceof Field_Reference or $elm instanceof filestore\Field_Image ){
                                                        // $temp=$elm->short_name;
                                                        // $elm->destroy();
                                                        // $model->addField($temp,$temp)->type('int');
                                                }
                                        }
                                        try{
                                                $model->add('dynamic_model/Controller_AutoCreator',array('force_create_foreignkeys'=>true));
                                                $model->tryLoadAny();
                                        }catch(Exception $e){
                                                $this->add('View_Error')->setHTML("in $md_name: ". $e->getHTML());
                                        }
                                }       
                        }
                        $this->api->setConfig('autocreator',$current_autocreator_value);
                }

		// re Process base Element Config
		$base_element_market_place = $this->add('Model_MarketPlace')->loadBy('namespace','baseElements');
		$base_element_market_place->reProcessConfig();

	}

	function query($q){
		$this->api->db->dsql($this->api->db->dsql()->expr($q))->execute();
	}

    function dropForeignkeys($table){
        $q="
            SELECT * FROM 
                information_schema.TABLE_CONSTRAINTS 
                WHERE information_schema.TABLE_CONSTRAINTS.CONSTRAINT_TYPE='FOREIGN KEY' AND information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA='".$this->api->db->dbname."' AND information_schema.TABLE_CONSTRAINTS.TABLE_NAME='".$table."'
        ";

        $keys = $this->api->db->dsql()->expr($q)->get();
        
        foreach ($keys as $key) {
            $drop_q= "alter table $table drop FOREIGN KEY ". $key['CONSTRAINT_NAME'];
            $this->api->db->dsql()->expr($drop_q)->execute();
        }
    }
}