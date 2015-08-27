<?php

class page_xProduction_page_owner_task_draft extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		$col=$this->add('Columns');
		$left_col=$col->addColumn(7);
		$right_col=$col->addColumn(5);

		$task_vp = $this->add('VirtualPage');
		$task_vp->set(function($p){
			$m=$p->add('xProduction/Model_Task')->tryLoad($_GET['task_id']);
			
			$start_date = "";
			if($m['expected_start_date'])
				$start_date = $m['expected_start_date'];

			$end_date = "";
			if($m['expected_end_date'])
				$end_date = $m['expected_end_date'];

			$html = '<div class="atk-row atk-padding page-header">
						<span class="atk-col-4 icon-calendar"> Expected Start Date: '.$start_date.'</span>
						<span class="atk-col-4"><i class="icon-pencil atk-swatch-blue"></i> Created By: '.$m['created_by'].'</span>
						<span class="atk-col-4"> <i class="icon-calendar atk-swatch-red"></i> Dead Line: '.$end_date.'</span>
					</div>'.
					'<div class="atk-padding">'.$m['content'].'</div>'
					;
			$p->add('View')->setHTML($html);
		});

		$draft = $this->add('xProduction/Model_Task_Draft');
		$draft->addCondition('created_by_id',$this->api->current_employee->id);
		$form= $left_col->add('Form_Minimal');
		$form->addField('line','to_do');
		$crud=$left_col->add('CRUD');
		if($form->isSubmitted()){
			$draft['subject'] = $form['to_do'];
			$draft->save();
			$form->js(null,$crud->grid->js()->reload())->reload()->execute();
		}
				
		$crud->setModel($draft,array('subject','content','priority','expected_start_date','expected_end_date'),array('subject','Priority','expected_start_date','expected_end_date'));
		$crud->manageAction('see_activities');
		$crud->grid->addMethod('format_subject',function($g,$f)use($task_vp){
			$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$g->js()->univ()->frameURL($g->model['subject'],$g->api->url($task_vp->getURL(),array('task_id'=>$g->model->id))).'">'.substr(strip_tags($g->model['subject']),0,25).'</a>';
		});
		$crud->grid->addFormatter('subject','subject');
		$crud->manageAction('assign');
		$crud->manageAction('approve','target','Complete');
		if(!$crud->isEditing()){
			$crud->grid->addPaginator($ipp=100);
		}
		// $crud->grid->ipp=2;
		// $crud->add('xHR/Controller_Acl',array('override'=>array('allow_add'=>true,'allow_edit'=>'Self Only','allow_del'=>'Self Only')));

		$right_col->add('View_Info')->set('Assign To Me');
		$assign_to_me_task = $right_col->add('xProduction/Model_Task_Assigned');
		$assign_to_me_task->addCondition('employee_id',$this->api->current_employee->id);
		$left_crud=$right_col->add('CRUD',array('grid_class'=>'xProduction/Grid_Task','allow_add'=>false,'allow_edit'=>false,'allow_del'=>false));
		$left_crud->setModel($assign_to_me_task);
		$left_crud->manageAction('start_processing','play');
		$left_crud->manageAction('reject','cancel-circled atk-swatch-red');
		$left_crud->manageAction('activities','comment atk-swatch-blue');
		// $left_crud->add('xHR/Controller_Acl');

	}


}