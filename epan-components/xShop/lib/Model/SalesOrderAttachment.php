<?php

namespace xShop;

class Model_SalesOrderAttachment extends \Model_Attachment{
	public $root_document_name = "xShop\SalesOrderAttachment";
	function init(){
		parent::init();

		$this->addCondition('related_root_document_name','xShop\Order');
		// //$this->add('dynamic_model/Controller_AutoCreator');
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

