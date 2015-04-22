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

		
		$this->hasOne('xProduction/Team','team_id');
		$this->hasOne('xHR/Employee','employee_id');

		$this->addField('name');
		$this->addField('subject');
		$this->addField('content')->type('text')->display(array('form'=>'RichText'));
		$this->addField('Priority')->enum(array('low','Medium','High','Urgent'))->defaultValue('Medium');

		$this->addField('is_default_jobcard_task')->type('boolean')->defaultValue(false)->system(true);

		$this->addField('expected_start_date')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('expected_end_date')->type('datetime')->defaultValue(null);

		$this->add('dynamic_model/Controller_AutoCreator');
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

	function can_mark_processed_page($p){
		$form = $p->add('Form');
		$form->addField('line','num1');
		$form->addField('line','num2');
		$form->addSubmit();

		if($form->isSubmitted()){
			$form->displayError('num1','oops');
		}
	}

	function can_mark_processed(){
		if($rd = $this->relatedDocument()){
			$rd->setStatus('processed');
		}

		$this['status']='processed';
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


}