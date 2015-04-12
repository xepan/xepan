<?php

namespace xPurchase;

class Model_PurchaseOrderAttachment extends \Model_Attachment{
	public $root_document_name = "xPurchase\PurchaseOrderAttachment";

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(draft) you can see'),
			'allow_add'=>array('caption'=>'Whose created Order(draft) you can add'),
			'allow_edit'=>array('caption'=>'Whose created Order(draft) you can edit'),
			'allow_del'=>array('caption'=>'Whose created Order(draft) you can delete'),
		);

	function init(){
		parent::init();

		$this->addCondition('related_root_document_name','xPurchase\PurchaseOrder');
		// //$this->add('dynamic_model/Controller_AutoCreator');
	}

}

