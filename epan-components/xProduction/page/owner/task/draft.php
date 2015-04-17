<?php

class page_xProduction_page_owner_task_draft extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		$draft = $this->add('xProduction/Model_Task_Draft');

		$form= $this->add('Form_Minimal');
		$form->addField('line','to_do');

		$crud=$this->add('CRUD');

		if($form->isSubmitted()){
			$draft['subject'] = $form['to_do'];
			$draft->save();
			$form->js(null,$crud->grid->js()->reload())->reload()->execute();
		}
				
		$crud->setModel($draft,array('employee','team','subject','content','Priority','expected_start_date','expected_end_date'));
		$crud->add('xHR/Controller_Acl',array('override'=>array('allow_add'=>true,'allow_edit'=>'Self Only','allow_del'=>'Self Only')));
		
	}


}