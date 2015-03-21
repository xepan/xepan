<?php

namespace xShop;

class Model_SalesOrderDetailAttachment extends \Model_Attachment{
	public $root_document_name = "xShop\SalesOrderDetailAttachment";

		public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(draft) you can see'),
			'allow_add'=>array('caption'=>'Whose created Order(draft) you can add'),
			'allow_edit'=>array('caption'=>'Whose created Order(draft) you can edit'),
			'allow_del'=>array('caption'=>'Whose created Order(draft) you can delete'),
		);


	function init(){
		parent::init();

		$this->addCondition('related_root_document_name','xShop\OrderDetail');
		// $this->hasOne('Epan','epan_id');
		// $this->addCondition('epan_id',$this->api->current_website->id);	
		// $this->hasOne('xShop/Item','item_id');
		
		// $this->addField('name')->mandatory(true)->group('a~6~Item Attachments');
		// $this->add('filestore/Field_Image','attachment_url_id')->mandatory(true);
		// // $this->addField('attachment_url')->display(array('form'=>'ElImage'))->mandatory(true)->mandatory(true)->group('a~6');

		// //$this->add('dynamic_model/Controller_AutoCreator');
	}

	// function duplicate($item_id){
		// $new = $this->add('xShop/Model_Attachments');
		// foreach ($this as $junk) {
			// $new['name'] = $junk['name'];
			// $new['item_id'] = $item_id;
			// $new['attachment_url'] = $junk['attachment_url'];
			// $new->saveAndUnload();
		// }
	// }
}

