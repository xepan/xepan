<?php

namespace xProduction;

class Model_Task extends \Model_Document{

	public $table = "xproduction_tasks";
	public $status=array('assigned','processing','processed','completed','cancelled','rejected');
	public $root_document_name = "xProduction\Task";
	public $actions=array(
			'can_assign'=>array()
		);
	
	public $notification_rules = array(
			// 'activity NOT STATUS' => array (....)
			'assigned' => array('xProduction/Task_Assigned/can_start_processing'=>'New Task {task_name} is assigned to you by {employee_name}'),
			'processing' => array('xProduction/Task_Processing/creator'=>'Your Task {task_name} is under process by {employee_name}'),
			'processed' =>array('xProduction/Task_Processed/creator'=>'New Task {task_name} for approval, assigned to {employee_name}'),
			'rejected' => array('xProduction/Task_Rejected/creator'=>'Your Task Rejected by {employee_name}')
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xProduction/Team','team_id');
		$this->hasOne('xHR/Employee','employee_id');

		$this->addField('name');
		$this->addField('subject');
		$this->addField('content')->type('text')->display(array('form'=>'RichText'));
		$this->addField('priority')->enum(array('Low','Medium','High','Urgent'))->defaultValue('Medium');

		$this->addField('is_default_jobcard_task')->type('boolean')->defaultValue(false)->system(true);

		$this->addField('expected_start_date')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('expected_end_date')->type('datetime')->defaultValue(null);

		$this->hasMany('xProduction/TaskAttachment','related_document_id',null,'Attachments');
		$this->hasMany('xCRM/Email','task_id');
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function getTeamMembers(){
		if(!$this['team_id']) return array(0);
		$my_team = $this->ref('team_id');

		return $my_team->getAssociatedEmployees();
	}

	function getTeamLeaders(){
		if(!$this['team_id']) return array(0);
		$my_team = $this->ref('team_id');
		return $my_team->getAssociatedEmployees( $team_leader = true );
	}

	function start_processing(){
		if($rd = $this->relatedDocument()){
			if($rd->hasMethod('start_processing'))
				$rd->start_processing();
		}

		$this->setStatus('processing',$remark);
	}

	function mark_processed_page($p){
		$form = $p->add('Form_Stacked');
		$form->addField('line','remark');
		$form->addSubmit('Processed');

		if($form->isSubmitted()){
			$this->mark_processed($form['remark']);
			return true;
		}
	}


	function mark_processed($remark){
		if($rd = $this->relatedDocument()){
			if($rd->hasMethod('mark_processed'))
				$rd->mark_processed($remark);
		}

		$this->setStatus('processed',$remark);
	}

	function approve_page($p){
		$form = $p->add('Form_Stacked');
		$form->addField('line','remark');
		$form->addSubmit('Approved');

		if($form->isSubmitted()){
			$this->approve($form['remark']);
			return true;
		}
	}

	function approve($remark){
		if($rd = $this->relatedDocument()){
			if($rd->hasMethod('approve'))
				$rd->approve($remark);
		}
		$this->setStatus('completed',$remark);

	}

	function assign_page($page){
		$cols=$page->add('Columns');
		$col=$cols->addColumn(6);
		$form = $col->add('Form_Stacked');
		$form->addField('dropdown','assign_to_employee')->setEmptyText("Select Employee")->setModel('xHR/Model_Employee');
		// $form->addField('dropdown','assign_to_team')->setEmptyText("Select Team")->setModel('xProduction/Model_Team');
		$form->addSubmit('Assign');
			
		if($form->isSubmitted()){

			if($form['assign_to_employee'] AND $form['assign_to_team']){
				$form->displayError('assign_to_team','Select either team or employee, not both');
			}

			if(!$form['assign_to_employee'] AND !$form['assign_to_team']){
				$form->displayError('assign_to_employee','Select either team or employee (not both)');
			}			

			if($form['assign_to_employee']){
				return $this->assign($form['assign_to_employee']);
			}

			// if($form['assign_to_team']){
			// 	$this['team_id']=$form['assign_to_team'];
			// 	$this->setStatus('assigned',null,'Task :'.$this['subject'],null,null,'Team',$this['team_id']);
			// 	return true;
			// }
		}
	}
			// $form->js(null,$form->js()->univ()->closeDialog())->univ()->successMessage('Assigned Successfully')->reload()->execute();
	function assign($employee_id){

		if(!$employee_id and $employee_id==NULL)
			return false;

		$this['employee_id']=$employee_id;
		$this->setStatus('assigned',null,'Task :'.$this['subject'],null,null,'Employee',$this['employee_id']);
		return true;
	}

	function reject_page($page){
		$form= $page->add('Form_Stacked');
		$form->addField('text','reason');
		$form->addSubmit('Reject & Send to Re Design');
		if($form->isSubmitted()){
			$this->setStatus('rejected',$form['reason']);
			return true;
		}
	}

	function cancel(){
		$this->setStatus('cancelled');
	}

}