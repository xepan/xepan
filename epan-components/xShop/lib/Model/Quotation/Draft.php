<?php

namespace xShop;

class Model_Quotation_Draft extends Model_Quotation{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Quotation(draft) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Quotation this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Quotation'),
			'allow_del'=>array('caption'=>'Whose Created Quotation this post can delete'),
			'can_submit'=>array('caption'=>'Whose Created Quotation this post can submit'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','draft');
	}

	function submit(){
		$this['status'] = 'submitted';
		$this->saveAndUnload();
		return "Sended For Approval";
	}
}