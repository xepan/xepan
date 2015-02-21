<?php
namespace xHR;

class Model_DocumentAcl extends \Model_Table{
	public $table="xhr_departments_acl";
	function init(){
		parent::init();

		$acl =array('No','Self Only','Include Subordinats','Include Colleagues','Include Subordinats & Colleagues','All');

		$this->hasOne('xHR/Document','document_id')->display(array('form'=>'Readonly'));
	
		$this->hasOne('xHR/Post','post_id');
		
		$this->addField('can_view')->enum($acl)->defaultValue('No');
	
		$this->addField('allow_add')->type('boolean')->defaultValue(false);
		$this->addField('allow_edit')->enum($acl)->defaultValue('No');
		$this->addField('allow_del')->enum($acl)->defaultValue('No');
	
		$this->addField('can_submit')->enum($acl)->defaultValue('No');
		$this->addField('can_select_outsource')->enum($acl)->defaultValue('No');
		$this->addField('can_approve')->enum($acl)->defaultValue('No');
		$this->addField('can_reject')->enum($acl)->defaultValue('No');

		$this->addField('can_assign')->enum(array('No','Dept. Teams','Dept. Employee','Self Team Members'))->defaultValue('No');

		$this->addField('can_forward')->enum($acl)->defaultValue('No');
		$this->addField('can_receive')->type('boolean')->defaultValue(false);
		$this->addField('can_send_via_email')->enum($acl)->defaultValue('No');
		
		$this->addField('can_see_communication')->enum($acl)->defaultValue('No');
		$this->addField('can_see_deep_communication')->enum($acl)->defaultValue('No');
		

		$this->add('dynamic_model/Controller_AutoCreator');

	}
}



