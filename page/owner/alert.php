<?php

class page_owner_alert extends page_base_owner{
	function page_index(){
		
		$default_alert = $this->api->current_website->ref('Alerts')->addCondition('type','default')->count()->getOne();		
		$dv = $this->add('View_BackEndView',array('cols_widths'=>array(12)));
		$dv->addToTopBar('View')->setHTML('Default -'.$default_alert)->addClass('label label-default');

		$primary_alert = $this->api->current_website->ref('Alerts')->addCondition('type','primary')->count()->getOne();		
		$dv->addToTopBar('View')->setHTML('Primary -'.$primary_alert)->addClass('label label-primary');

		$success_alert = $this->api->current_website->ref('Alerts')->addCondition('type','success')->count()->getOne();		
		$dv->addToTopBar('View')->setHTML('Success -'.$success_alert)->addClass('label label-success');

		$info_alert = $this->api->current_website->ref('Alerts')->addCondition('type','info')->count()->getOne();		
		$dv->addToTopBar('View')->setHTML('Info -'.$info_alert)->addClass('label label-info');


		$warning_alert = $this->api->current_website->ref('Alerts')->addCondition('type','warning')->count()->getOne();		
		$dv->addToTopBar('View')->setHTML('Warning -'.$warning_alert)->addClass('label label-warning');


		$danger_alert = $this->api->current_website->ref('Alerts')->addCondition('type','danger')->count()->getOne();		
		$dv->addToTopBar('View')->setHTML('Danger -'.$danger_alert)->addClass('label label-danger');

		$dv_op = $dv->addOptionButton();
		$crud = $dv->addToColumn(0,'View');

		$col=$this->app->layout->add('Columns');
		$app_col=$col->addColumn(4);
		$alert_col=$col->addColumn(8);
		
		$alrt=$this->add('Model_Alerts');
		// $alrt->addCondition('is_read',true);
		foreach ($alrt as  $junk) {
			// throw new \Exception("Error Processing Request", 1);
			$alrt['is_read']=true;
			$alrt->saveAndUnload();
		}

		$installed_components = $this->add('Model_InstalledComponents');
		$app_crud=$app_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false));
		$app_crud->setModel($installed_components,array('namespace'));
		if(!$app_crud->isEditing()){
			$g=$app_crud->grid;
			$g->addMethod('format_sendersign',function($g,$f)use($alert_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $alert_col->js()->reload(array('installed_app_id'=>$g->model['namespace'])) .'">'.$g->current_row[$f].'</a>';
			});
			$g->addFormatter('namespace','sendersign');
		}
		if($_GET['installed_app_id']){
			// throw new \Exception($_GET['installed_app_id']);
			$this->api->stickyGET('installed_app_id');
			$filter_box = $alert_col->add('View_Box')->setHTML(' Alerts Application for <b>'. $_GET['installed_app_id'].'</b>' );
			
			$filter_box->add('Icon',null,'Button')
        	    ->addComponents(array('size'=>'mega'))
            	->set('cancel-1')
            	->addStyle(array('cursor'=>'pointer'))
            	->on('click',function($js) use($filter_box,$alert_col) {
                $filter_box->api->stickyForget('installed_app_id');
                return $filter_box->js(null,$alert_col->js()->reload())->hide()->execute();
            });
			$alrt->addCondition('sender_signature',$_GET['installed_app_id']);
		}


		$crud=$alert_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false));
		$crud->setModel($alrt);
		if($crud->grid){
			$crud->grid->addQuickSearch(array('name','created_at','type','sender_signature'));
		}

	}	
}