<?php
namespace xHR;

class Model_DocumentAcl extends \Model_Table{
	public $table="xhr_departments_acl";
	
	function init(){
		parent::init();

		$acl =array('No'=>'No','Self Only'=>'Created By Employee','Include Subordinats'=>'Created By Subordinates','Include Colleagues'=>'Created By Colleagues','Include Subordinats & Colleagues'=>'Created By Subordinats or Colleagues','Assigned To Me'=>'Assigned To Me','Assigned To My Team'=>'Assigned To My Team','If Team Leader'=>'If Team Leader','All'=>'All');

		$this->hasOne('xHR/Document','document_id')->display(array('form'=>'Readonly'));
	
		$this->hasOne('xHR/Post','post_id');
		
		$this->addField('can_view')->setValueList($acl)->defaultValue('No');
	
		$this->addField('allow_add')->type('boolean')->defaultValue(false);
		$this->addField('allow_edit')->setValueList($acl)->defaultValue('No');
		$this->addField('allow_del')->setValueList($acl)->defaultValue('No');
	
		$this->addField('can_submit')->setValueList($acl)->defaultValue('No');
		$this->addField('can_select_outsource')->setValueList($acl)->defaultValue('No');
		$this->addField('can_approve')->setValueList($acl)->defaultValue('No');
		$this->addField('can_reject')->setValueList($acl)->defaultValue('No');

		$this->addField('can_assign')->enum(array('No','Dept. Teams','Dept. Employee','Self Team Members'))->defaultValue('No');

		$this->addField('can_forward')->setValueList($acl)->defaultValue('No');
		$this->addField('can_receive')->type('boolean')->defaultValue(false);
		
		$this->addField('can_manage_tasks')->setValueList($acl)->defaultValue('No');
		$this->addField('task_types')->setValueList(array("job_card_tasks"=>"Root Docuement","job_card_current_status_tasks"=>"Specific Document","job_card_all_status_tasks"=>'Root Document With Status'));

		$this->addField('can_send_via_email')->setValueList($acl)->defaultValue('No');
		
		$this->addField('can_see_communication')->setValueList($acl)->defaultValue('No');
		$this->addField('can_see_deep_communication')->setValueList($acl)->defaultValue('No');
		

		$this->add('dynamic_model/Controller_AutoCreator');

	}
}



