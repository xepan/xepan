<?php

namespace xProduction;

class Model_Task extends \Model_Document{

	public $table = "xproduction_tasks";
	public $status=array('assigned','processing','processed','completed','cancelled','rejected');
	public $root_document_name = "xProduction\Task";
	public $actions=array(
			'can_assign'=>array()
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
		$this->addField('Priority')->enum(array('Low','Medium','High','Urgent'))->defaultValue('Medium');

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
		$this->relatedDocument()->set('status','processing')->save();
		$this['status']='processing';
		$this->saveAndUnload();
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

	function approve(){
		$this['status']='completed';
		$this->saveAndUnload();
	}

	function assign_page($page){
		$cols=$page->add('Columns');
		$col=$cols->addColumn(6);
		$form = $col->add('Form_Stacked');
		$form->addField('dropdown','assign_to_employee')->setEmptyText("Select Employee")->setModel('xHR/Model_Employee');
		$form->addField('dropdown','assign_to_team')->setEmptyText("Select Team")->setModel('xProduction/Model_Team');
		$form->addSubmit('Assign');
			
		if($form->isSubmitted()){

			if($form['assign_to_employee'] AND $form['assign_to_team']){
				$form->displayError('assign_to_team','Select either team or employee, not both');
			}

			if(!$form['assign_to_employee'] AND !$form['assign_to_team']){
				$form->displayError('assign_to_employee','Select either team or employee (not both)');
			}			

			if($form['assign_to_employee']){
				$this['employee_id']=$form['assign_to_employee'];
				$this->setStatus('assigned',null,'Task :'.$this['subject'],null,null,'Employee',$this['employee_id']);
				return true;
			}

			if($form['assign_to_team']){
				$this['team_id']=$form['assign_to_team'];
				$this->setStatus('assigned',null,'Task :'.$this['subject'],null,null,'Team',$this['team_id']);
				return true;
			}
		}
	}
			// $form->js(null,$form->js()->univ()->closeDialog())->univ()->successMessage('Assigned Successfully')->reload()->execute();

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