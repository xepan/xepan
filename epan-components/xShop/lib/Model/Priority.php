<?php

namespace xShop;

class Model_Priority extends \Model_Document{
	var $table="xshop_priorities";
	public $status=array();
	public $root_document_name="Priority";
	public $actions=array(
			'allow_edit'=>array('caption'=>'Whose created Quotation this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Quotation'),
			'allow_del'=>array('caption'=>'Whose Created Quotation this post can delete'),
		);
	function init(){
		parent::init();
		$this->addField('name');


		//$this->add('dynamic_model/Controller_AutoCreator');
		}	
}