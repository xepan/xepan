<?php
class Model_Alerts extends Model_Table{
	public $table="alerts";
	function init(){
		parent::init();
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addField('name')->caption('Title')->sortable(true);
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('is_read')->type('boolean')->defaultValue(false)->sortable(true);
		$this->addField('type')->enum(array('default','primary','success','info','warning','danger'))->sortable(true);
		$this->addField('sender_signature');
		$this->addField('sender_namespace');

		// //$this->add('dynamic_model/Controller_AutoCreator');
	}

	function createNew($epan_id,$title,$type,$sender_signature,$sender_namespace){

		$this['epan_id']=$epan_id;
		$this['name']=$title;
		$this['type']=$type;
		$this['sender_signature']=$sender_signature;
		$this['sender_namespace']=$sender_namespace;
		$this->save();
	}

}