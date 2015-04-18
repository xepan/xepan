<?php
namespace xHR;

class Model_DocumentAcl extends \Model_Table{
	public $table="xhr_departments_acl";
	
	function init(){
		parent::init();

		$acl =array('No'=>'No','Self Only'=>'Created By Employee','Include Subordinats'=>'Created By Subordinates','Include Colleagues'=>'Created By Colleagues','Include Subordinats & Colleagues'=>'Created By Subordinats or Colleagues','Assigned To Me'=>'Assigned To Me','Assigned To My Team'=>'Assigned To Me & My Team','If Team Leader'=>'If Team Leader','All'=>'All');

		$this->addExpression('department')->set(function($m,$q){
			return $m->refSQL('document_id')->fieldQuery('department');
		})->sortable(true);


		$this->hasOne('xHR/Document','document_id')->display(array('form'=>'Readonly'))->mandatory(true)->sortable(true);
	
		$this->hasOne('xHR/Post','post_id')->mandatory(true);
		
		$this->addField('can_view')->setValueList($acl)->defaultValue('Self Only');
	
		$this->addField('allow_add')->type('boolean')->defaultValue(false);
		$this->addField('allow_edit')->setValueList($acl)->defaultValue('No');
		$this->addField('allow_del')->setValueList($acl)->defaultValue('No');
	
		$this->addField('can_submit')->setValueList($acl)->defaultValue('No');
		$this->addField('can_select_outsource')->setValueList($acl)->defaultValue('No');
		$this->addField('can_approve')->setValueList($acl)->defaultValue('No');
		$this->addField('can_reject')->setValueList($acl)->defaultValue('No');
		$this->addField('can_redesign')->setValueList($acl)->defaultValue('No');
		$this->addField('can_accept')->setValueList($acl)->defaultValue('No');
		$this->addField('can_cancel')->setValueList($acl)->defaultValue('No');

		$this->addField('can_assign')->setValueList($acl)->defaultValue('No');
		$this->addField('can_assign_to')->enum(array('No','Dept. Teams','Dept. Employee','Self Team Members'))->defaultValue('No');

		$this->addField('can_forward')->setValueList($acl)->defaultValue('No');
		$this->addField('can_receive')->type('boolean')->defaultValue(false);
		
		$this->addField('can_start_processing')->setValueList($acl)->defaultValue('No');
		$this->addField('can_mark_processed')->setValueList($acl)->defaultValue('No');

		$this->addField('can_manage_attachments')->setValueList($acl)->defaultValue('No');
		$this->addField('can_manage_tasks')->setValueList($acl)->defaultValue('No');
		$this->addField('task_types')->setValueList(array("job_card_tasks"=>"Root Docuement","job_card_current_status_tasks"=>"Specific Document","job_card_all_status_tasks"=>'Root Document With Status'));

		$this->addField('can_send_via_email')->setValueList($acl)->defaultValue('No');
		$this->addField('can_forcedelete')->setValueList($acl)->defaultValue('No');
		
		$this->addField('can_see_activities')->setValueList(array('No'=>'No','All'=>'All','Deep'=>'Deep'))->defaultValue('No');
		
		$this->addHook('beforeSave',$this);

		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforeSave(){
		// if document_id wala document ! instance of Task
			// must not be anything in terms of "assigned" or "if team leader" kind of
	}

	function document(){
		return $this->ref('document_id');
	}


}