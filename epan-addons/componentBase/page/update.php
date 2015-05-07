<?php

class page_componentBase_page_update extends page_base_owner{

	public $git_path=null;

	function update($dynamic_model_update=true,$update_git=true){
		
		$class = get_class( $this );
		preg_match( '/page_(.*)_page_(.*)/', $class, $match );

		$this->component_namespace = $match[1];
		$mp=$this->add('Model_MarketPlace')->loadBy('namespace',$this->component_namespace);
		$this->component_name = $mp['name'];

		$component_path = getcwd().DS.'epan-components'.DS.$this->component_namespace;

		$git_pass_strings=array('git-pass','git_pass','gitpass','pass_git','pass-git','passgit');
		foreach ($git_pass_strings as $t) {
			if(isset($_GET[$t]))
				$update_git=false;
		}

		if($update_git){
			if($this->git_path==null)
				throw $this->exception('public variable git_path must be defined in page class');
			

			if($_GET['git_exec_path']){
				Git::set_bin($_GET['git_exec_path']);
			}

			try{
				if(file_exists($component_path.DS.'.git'))
					$repo = Git::open($component_path);
				else
					$repo=Git::create($component_path);
			}catch(Exception $e){
				// No Git Found ... So just return
				return;
			}


			$remote_branches = $repo->list_remote_branches();

			if(count($remote_branches) == 0)
				$repo->add_remote_address($this->git_path);

			$branch ='master';
			if($_GET['git_branch']){
				$branch=$_GET['git_branch'];
			}

			$repo->run('fetch --all');
			$repo->run('reset --hard origin/'.$branch);
		}

		if($dynamic_model_update){
			$current_autocreator_value= $this->api->getConfig('autocreator');
			$this->api->setConfig('autocreator',true);
			$model_array=array();
			$dir = $component_path.DS.'lib'.DS.'Model';
			
			if(file_exists($dir)){
				$lst = scandir($dir);
	                array_shift($lst);
	                array_shift($lst);
	            
	            foreach ($lst as $item){
	            	if (filetype($dir."/".$item) == "dir") continue;
	            	$item = str_replace(".php", "", $item);
	            	$model_array[] = $this->component_namespace .'/'.'Model_'.$item;
	            }
	            foreach ($model_array as $md_name) {
            		$md = $this->add($md_name);
	            	if(!$md instanceof SQL_Model) {
	            		continue;
	            	}
					$model = $this->add($md);
					
					foreach ($model->elements as $elm) {
						if(!$elm instanceof AbstractObject) continue;
						if($elm instanceof Field_Expression or $elm instanceof SQL_Many)
							$elm->destroy();
						if($elm instanceof Field_Reference or $elm instanceof filestore\Field_Image ){
							$temp=$elm->short_name;
							$elm->destroy();
							$model->addField($temp,$temp)->type('int');
						}
					}
					try{
						$model->add('dynamic_model/Controller_AutoCreator');
						$model->tryLoadAny();
					}catch(Exception $e){
						$this->add('View_Error')->set("in $md_name: ". $e->getMessage());
					}
				}	
			}
			$this->api->setConfig('autocreator',$current_autocreator_value);
		}

		// Re process Config file

		$this->add('Model_MarketPlace')
			->loadBy('namespace',$this->component_namespace)
			->reProcessConfig();


		// Get new code from git
		// Get all models in lib/Model
		// add dynamic line on object
		// tryLoanAny

	}

}
