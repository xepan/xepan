<?php

namespace xShop;

class Model_Quotation_Submit extends Model_Quotation{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Quotation(submitted) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Quotation(submitted) this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Quotation(submitted)'),
			'allow_del'=>array('caption'=>'Whose Created Quotation(submitted) this post can delete'),
			'can_approve'=>array('caption'=>'Whose Created Quotation(submitted) this post can approve'),
			'can_reject'=>array('caption'=>'Whose Created Quotation(submitted) this post can reject'),
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','submitted');
	}

	function approve(){
		$this['status'] = 'approved';
		$this->saveAndUnload();
		return "Quotation Approved";
	}

	function redesign(){
		$this['status'] = 'redesign';
		$this->saveAndUnload();
		return "Quotation Approved";
	}
}