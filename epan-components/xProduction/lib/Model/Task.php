<?php

namespace xProduction;

class Model_Task extends \Model_Document{
	public $table = "xproduction_tasks";
	public $status=array('assigned','processing','processed','complete','cancel');
	public $root_document_name = "Task";

	function init(){
		parent::init();

		$this->addField('root_document_name');
		$this->addField('document_name');
		$this->addField('document_id');

		$this->hasOne('xProduction/Team','team_id');
		$this->hasOne('xHR/Employee','employee_id');

		$this->addField('name')->caption('Subject');
		$this->addField('content')->type('text');
		$this->addField('Priority')->enum(array('low','Medium','High','Urgent'));

		$this->addField('expected_start_date')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('expected_end_date')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));

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
		print_r($my_team->getAssociatedEmployees( $team_leader = true ));
		return $my_team->getAssociatedEmployees( $team_leader = true );
	}

	function relatedDocument(){
		$class=$this['document_name'];
		$class =explode("\\", $class);
		$class[1] = "Model_".$class[1];
		$class = implode("", $class);

		return $this->add($class)->load($this['document_id']);
	}

	function start_processing(){

	}

	function mark_processed(){

	}

}