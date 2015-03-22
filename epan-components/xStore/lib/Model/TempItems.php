<?php

namespace xStore;

class Model_TempItems extends \Model {
	
	function init(){
		parent::init();
		
		$this->setSource('Session');

		if($this->owner instanceof \CRUD){
			$this->owner->grid->addMethod('format_item',function($g,$f){
				$item = $g->add('xShop/Model_Item')->tryLoad($g->model['item_id']);
				$item_str = $item->get('name') .  '<br/>';
				$item_str .= $item->genericRedableCustomFieldAndValue($g->model['custom_fields']);
				$g->current_row_html[$f] = $item_str;
			});
		}

		$this->addField('item_id')->display(array('form'=>'xShop/Item','grid'=>'item'))->setModel('xShop/Item');
		$this->addField('qty')->mandatory(true);
		$this->addField('custom_fields');
	}
}