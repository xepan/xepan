<?php

class page_owner_message extends page_base_owner{
	function page_index(){
				$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-bullhorn"></i> Messages <small>Application Messages</small>');
		$bv = $this->add('View_BackEndView',array('cols_widths'=>array(12)));
		$bv->addToTopBar('H3')->set('Messages');
		
		$op = $bv->addOptionButton();
		$crud = $bv->addToColumn(0,'View');

		$col=$this->app->layout->add('Columns');
		$app_col=$col->addColumn(4);
		$msg_col=$col->addColumn(8);

		$msg=$this->add('Model_Messages');
		// $msg->addCondition('is_read',false);
		foreach ($msg as  $junk) {
			// throw new \Exception("Error Processing Request", 1);
			$msg['is_read']=true;
			$msg->saveAndUnload();
		}

		$installed_components = $this->add('Model_InstalledComponents');
		$app_crud=$app_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false));
		$app_crud->setModel($installed_components,array('namespace'));
		
		if(!$app_crud->isEditing()){
			$g=$app_crud->grid;
			$g->addMethod('format_sendersign',function($g,$f)use($msg_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $msg_col->js()->reload(array('installed_app_id'=>$g->model['namespace'])) .'">'.$g->current_row[$f].'</a>';
			});
			$g->addFormatter('namespace','sendersign');
			$g->addMethod('format_total', function($g,$f){
				$g->current_row[$f]=$g->add('Model_Messages')->addCondition('sender_namespace',$g->model['namespace'])->count()->getOne();
			});
			$g->addColumn('total','Total');
			$g->addColumn('total','Total');

			$g->addMethod('format_unread', function($g,$f){
			$msg_model = $g->add('Model_Messages');
			$unread_message= $msg_model
									->addCondition('is_read',0)
									->addCondition('watch',1)
	            					->addCondition('sender_namespace',$g->model['namespace'])
	   				 				->count()->getOne();

			$g->current_row[$f]=$unread_message;
			});

			$g->addColumn('unread','unread');
		}
		if($_GET['installed_app_id']){
			// throw new \Exception($_GET['installed_app_id']);
			$this->api->stickyGET('installed_app_id');
			$filter_box = $msg_col->add('View_Box')->setHTML(' Messages Application for  <b>'. $_GET['installed_app_id'].'</b>' );
			
			$filter_box->add('Icon',null,'Button')
        	    ->addComponents(array('size'=>'mega'))
            	->set('cancel-1')
            	->addStyle(array('cursor'=>'pointer'))
            	->on('click',function($js) use($filter_box,$msg_col) {
                $filter_box->api->stickyForget('installed_app_id');
                return $filter_box->js(null,$msg_col->js()->reload())->hide()->execute();
            });
			$msg->addCondition('sender_namespace',$_GET['installed_app_id']);
		}

		$crud=$msg_col->add('CRUD');//,array('allow_add'=>false,'allow_edit'=>false));
		$crud->setModel($msg);

		if($crud->grid){
			$crud->grid->addQuickSearch(array('name','message','created_at'));
			$watch = $crud->grid->addColumn('Button','watching');
			$message_title = $crud->grid->setFormatter('name','template')
			->setTemplate('<a href="#" onclick="javascript:$(this).univ().frameURL(\'Message\',\'index.php?page=owner_messagedetails&message_id=<?$id?>\')"><?$name?></a>');
		}
		
		if($_GET['watching']){			
			$msg_model=$this->add('Model_Messages')->load($_GET['watching']);
			if($msg_model['watch']==false)
				$msg_model['watch']=true;
			else
				$msg_model['watch']=false;
			$msg_model->save();
			$crud->grid->js(null,$this->js()->univ()->successMessage('Watch Changes'))->reload()->execute();
		}
	}	
}