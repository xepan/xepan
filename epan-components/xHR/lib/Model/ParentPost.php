<?php

namespace xHR;

class Model_ParentPost extends Model_Post {
	var $table_alias= "pPost";
	var $title_field ='post_with_department';
	
	function init(){
		parent::init();

		$this->addExpression('post_with_department')->set($this->dsql()->concat(
			$this->getElement('name'),
			' :: ',
			$this->add('xHR/Model_Department')->addCondition('id',$this->getElement('department_id'))->fieldQuery('name')
			));

	}
}