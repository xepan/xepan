<?php
namespace xCRM;

class Model_Communication extends \Model_Table{
	public $table="xcrm_communications";
	function init(){
		parent::init();

		$from_to =array('Lead','Oppertunity','Customer','Employee');

		$this->addField('from')->enum($from_to);
		$this->addField('from_id');
		$this->addField('to')->enum($from_to);
		$this->addField('to_id');
		$this->addField('related')->enum(array('Quotation','SalesOrder','JobCard'));
		$this->addField('related_id');

		$this->addField('subject');
		$this->addField('message')->type('text');
		
		$this->addField('action')->enum(array('Created'));
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('updated_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));

		$this->addField('Deleted');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function create($params=array(),$action){
		
		foreach ($params as $key => $value) {
			$this[$key] = $value;
		}

		$this['action'] = $action;

		$this->save();

	}

}