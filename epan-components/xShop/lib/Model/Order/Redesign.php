<?php
namespace xShop;

class Model_Order_Redesign extends Model_Order{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(approved) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Quotation this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Quotation'),
			'allow_del'=>array('caption'=>'Whose Created Quotation this post can delete'),
			'can_submit'=>array('caption'=>'Can this post Re-Submit Order(redigning)')
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','redesign');
	}
}