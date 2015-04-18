<?php

class page_xProduction_page_owner_task_draft extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		$col=$this->add('Columns');
		$left_col=$col->addColumn(6);
		$right_col=$col->addColumn(6);

		$task_vp = $this->add('VirtualPage');
		$task_vp->set(function($p){
			$m=$p->add('xProduction/Model_Task')->tryLoad($_GET['task_id']);
			$p->add('View')->setHTML($m['content'])->addCLass('well');
		});

		$draft = $this->add('xProduction/Model_Task_Draft');
			$form= $left_col->add('Form_Minimal');
			$form->addField('line','to_do');
			$crud=$left_col->add('CRUD');

			if($form->isSubmitted()){
				$draft['subject'] = $form['to_do'];
				$draft->save();
				$form->js(null,$crud->grid->js()->reload())->reload()->execute();
			}
					
			$crud->setModel($draft,array('subject','content','Priority','expected_start_date','expected_end_date'),array('subject','Priority','expected_start_date','expected_end_date'));
			$crud->grid->addMethod('format_subject',function($g,$f)use($task_vp){
					$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$g->js()->univ()->frameURL('Task Content',$g->api->url($task_vp->getURL(),array('task_id'=>$g->model->id))).'">'.$g->current_row[$f].'</a>';
				});
				$crud->grid->addFormatter('subject','subject');

			// $crud->grid->ipp=2;
			$crud->add('xHR/Controller_Acl',array('override'=>array('allow_add'=>true,'allow_edit'=>'Self Only','allow_del'=>'Self Only')));

			$right_col->add('View_Info')->set('Assign To Me');
			$assign_to_me_task = $right_col->add('xProduction/Model_Task_Assigned');
			$assign_to_me_task->addCondition('employee_id',$this->api->current_employee->id);
			$left_crud=$right_col->add('CRUD',array('grid_class'=>'xProduction/Grid_Task'));
			$left_crud->setModel($assign_to_me_task);
			$left_crud->add('xHR/Controller_Acl');

	}


}