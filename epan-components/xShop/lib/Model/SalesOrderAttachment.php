<?php

namespace xShop;

class Model_SalesOrderAttachment extends \Model_Attachment{
	public $root_document_name = "xShop\SalesOrderAttachment";

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(draft) you can see'),
			'allow_add'=>array('caption'=>'Whose created Order(draft) you can add'),
			'allow_edit'=>array('caption'=>'Whose created Order(draft) you can edit'),
			'allow_del'=>array('caption'=>'Whose created Order(draft) you can delete'),
		);

	function init(){
		parent::init();

		$this->addCondition('related_root_document_name','xShop\Order');
	}

	function duplicate($item_id){
		$new = $this->add('xShop/Model_Attachments');
		foreach ($this as $junk) {
			$new['name'] = $junk['name'];
			$new['item_id'] = $item_id;
			$new['attachment_url'] = $junk['attachment_url'];
			$new->saveAndUnload();
		}
	}
}

