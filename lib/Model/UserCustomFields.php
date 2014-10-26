<?php

class Model_UserCustomFields extends \Model_Table{
	public $table='user_custom_fields';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);		
		
		$this->addField('name')->caption('Field Name');
		$type=$this->addField('type')->setValueList(array(
													'Number'=>'INTEGER',
													'line'=>'LINE',
													'text'=>'TEXT',
													'password'=>'PASSWORD',
													'radio'=>'radio', 
													'checkbox'=>'checkbox',
													'dropdown'=>'DROPDOWN',
													'DatePicker'=>'DATE',
													'Upload'=>'UPLOAD',
													'captcha'=>'Captcha'));
		$this->addField('is_expandable')->type('boolean')->defaultValue(false);
		$this->addField('set_value')->hint('Comma Separated Values i.e. Male, Female, Other');
		$this->addField('mandatory')->type('boolean')->Caption('Requird Field');
		$this->addField('change')->type('text')->hint('{"Value":["field name"],"Value 2":[""],"Value 3":["Field 1","Field 2","Field 3"]}');
		$this->addField('is_editable')->type('boolean');

		$this->hasMany('CustomFieldValue','usercustomefield_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function getCount($epan_id){
		$this->addCondition('epan_id', $epan_id);
		$this->tryLoadAny();
		return $this->count()->getOne()?:0 ;

	}

}

