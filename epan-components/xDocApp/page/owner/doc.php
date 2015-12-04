<?php

class page_xDocApp_page_owner_doc extends page_xDocApp_page_owner_main{

	function page_index(){

		$this->api->stickyGET('topic');
		$folder_path = getcwd().'/xepan-doc/';

		$column = $this->add('Columns');
		$directory_col = $column->addColumn(3);
		$editor_col = $column->addColumn(9);

		$view = $directory_col->add('View')->setHTML($this->dirToUl($folder_path));

		$view->addClass('maketree entities');
		// $view->js(true)->univ()->makeTree();
		//Checking for file
		$pre_content ="";
		if($_GET['topic']){
			if($_GET['parent_dir'] and $_GET['parent_dir'] != ""){
				$this->current_file_path = $folder_path.$_GET['parent_dir'].DS.$_GET['topic'];
			}else
				$this->current_file_path = $folder_path.DS.$_GET['topic'];

			if(file_exists($this->current_file_path)){
				$pre_content = file_get_contents($this->current_file_path);
			}else{
				$editor_col->add('View_Error')->set('File Not Exists. '.$this->current_file_path);
				return;
			}
		}

		//Form
		$form = $editor_col->add('Form');
		$content_field = $form->addField('xDocApp/Markdown','content');
		$form->addSubmit('Save');
		$content_field->set($pre_content);
		if($form->isSubmitted()){
			if(isset($this->current_file_path)){
				file_put_contents($this->current_file_path, $form['content']);
				$form->js()->univ()->successMessage('Saved Successfully')->execute();
			}
			$form->js()->univ()->errorMessage('No File Defined')->execute();
		}
		
	}

	function dirToUl($parent_dir) {
		$dir_array = $this->scanAll($parent_dir);
		$str = "";
		foreach ($dir_array as $name => $dir) {
			$str.='<ul class="maketree tools">'.$name;
			foreach ($dir as $key => $value) {
				$parent_dir = $name;
				if(strpos($name, 'xepan-doc') !== false){
					$parent_dir = "";
				}
				$str.='<li><a href="'.$this->api->url(null,array('topic'=>$value,'parent_dir'=>$parent_dir)).'">'.$value.'</a></li>';
			}
			$str.="</ul>";
		}
	    return $str;
	}

	//Return Array that key is directory name and value id file name
	function scanAll($parent_dir){
		$dirTree = [];
		$str ="";
	    $di = new RecursiveDirectoryIterator($parent_dir,RecursiveDirectoryIterator::SKIP_DOTS);
	    foreach (new RecursiveIteratorIterator($di) as $filename) {
	                $dir = str_replace($parent_dir, '', dirname($filename));
	                // $dir = str_replace('/', '>', substr($dir,0));
	              	if(strpos($filename, '.git'))
	              		continue;
	              	$dirTree[trim($dir)][] = basename($filename);
	    
	  }
	  return $dirTree;
	}

}
