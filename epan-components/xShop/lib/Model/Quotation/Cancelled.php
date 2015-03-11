<?php

namespace xShop;

class Model_Quotation_Cancelled extends Model_Quotation{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Leads this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Leads this post can edit'),
			'allow_del'=>array('caption'=>'Whose Created Leads this post can delete'),
			'can_cancel'=>array('caption'=>'Whose Created Leads this post can cancel'),
		);

	function init(){
		parent::init();

		$this->addCondition('status','cancelled');

	}

	

}