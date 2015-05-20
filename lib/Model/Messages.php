<?php
class Model_Messages extends Model_Table{
	public $table="messages";
	function init(){
		parent::init();
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addField('name')->caption('Title');
		$this->addField('message')->type('text');
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('is_read')->type('boolean')->defaultValue(false);
		$this->addField('sender_signature');
		$this->addField('sender_namespace');
		$this->addField('watch')->type('boolean')->defaultValue(false);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function createNew($title,$message,$sender_signature,$sender_namespace){

		$this['epan_id']=$this->api->current_website->id;
		$this['name']=$title;
		$this['message']=$message;
		$this['sender_signature']=$sender_signature;
		$this['sender_namespace']=$sender_namespace;
		$this->save();
	}
}
