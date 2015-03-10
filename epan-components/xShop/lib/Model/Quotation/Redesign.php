<?php

namespace xShop;

class Model_Quotation_Redesign extends Model_Quotation{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Redesign this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Redesign this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create Redesign'),
			'allow_del'=>array('caption'=>'Whose Created Redesign this post can delete'),
			'can_submit'=>array('caption'=>'Whose Created Redesign this post can submit'),
			'can_cancel'=>array('caption'=>'Whose Created Redesign this post can cancel'),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','redesign');

	}
}