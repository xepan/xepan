<?php

namespace xStore;

class Model_MaterialRequestSent_Processing extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array(),
			'can_mark_processed'=>array('icon'=>'ok')
		);
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	