<?php
namespace xDispatch;
class Model_DeliveryNote_Redesign extends Model_DeliveryNote{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(received) this post can see'),
		);
	function init(){
		parent::init();
		$this->addCondition('status','redesign');
	}
}	