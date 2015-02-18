<?php
namespace xHR;

class Model_Document extends \Model_Table{
	public $table="xhr_document";
	function init(){
		parent::init();

		$this->hasOne('xHR/Department','department_id');

		$this->addField('name');
		$this->hasMany('xHR/DepartmentAcl','document_id');
		
		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);
		$this->add('dynamic_model/Controller_AutoCreator');

	}
}



