<?php
namespace xShop;

class Model_Order_Processed extends Model_Order{
	public $actions=array(
			'can_view'=>array(),
			'can_send_via_email'=>array(),
			'can_forcedelete'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_add'=>array(),
			'can_mark_processed'=>array(),
			'can_see_activities'=>array(),
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','processed');
	}

	function can_mark_processed_page($p){
		$form = $p->add('Form');
		$form->addSubmit('Complete This Order');

		if($form->isSubmitted()){
			$this->can_mark_processed();
			return true;
		}
	}

	function can_mark_processed(){
		$this->setStatus('completed');
	}
}