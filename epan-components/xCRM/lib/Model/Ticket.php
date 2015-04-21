<?php
namespace xCRM;

class Model_Ticket extends \Model_Document{
	
	public $status=array('draft','submitted','solved','canceled','assigned');
	public $table="xcrm_tickets";
	public $root_document_name= 'xCRM\Tickets';

	function init(){
		parent::init();
		
 		$this->hasOne('Epan','epan_id');
 		$this->hasOne('xShop/Model_Customer','customer_id');
 		$this->hasOne('xShop/Model_Order','order_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}
