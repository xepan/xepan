<?php
namespace xStore;
class Model_MaterialRequestSent_Cancelled extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array(),
				
		);
	function init(){
		parent::init();
		$this->addCondition('status','cancelled');
	}
}	