<?php

namespace xCRM;

class Model_SMS extends \Model_Document {
	public $table = 'xcrm_smses';
	public $status = array();
	public $root_document_name='xCRM\SMS';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addField('name')->caption('Mobile Numbers')->type('text');
		$this->addField('message');

		$this->addField('return')->type('text');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function send(){
		$nos = explode(",", $this['name']);
		$return="";
		foreach($nos as $no){
			if($no=$this->senitizeNos($no)){
				$return .= $this->add('Controller_Sms')->sendMessage($no,$this['message']);
			}
		}
		if($return != "")
			$this->save();
	}

	function senitizeNos($no){
		return trim($no);
	}
}