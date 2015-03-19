<?php
namespace xCRM;

class Model_Activity extends \Model_Document{
	public $status=array();
	public $table="xcrm_document_activities";
	public $root_document_name= 'xCRM\Activity';

	function init(){
		parent::init();

		$from_to = array('Lead','Oppertunity','Customer','Employee','Supplier','OutSource Party');

		$this->addField('from')->enum($from_to);
		$this->addField('from_id');
		$this->addField('to')->enum($from_to);
		$this->addField('to_id');

		$this->addField('subject');
		$this->addField('message')->type('text');
		
		$this->addField('action');//->enum(array('created','submitted','approved','rejected','canceled','forwarded','reply'));

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

}