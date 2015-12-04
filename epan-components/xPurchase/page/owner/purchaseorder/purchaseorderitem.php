<?php

class page_xPurchase_page_owner_purchaseorder_purchaseorderitem extends page_xPurchase_page_owner_main{
	
	function init(){
		parent::init();

        $po_id = $this->api->stickyGET('xpurchase_purchase_order_id');
		$crud = $this->add('CRUD');
        $po_item=$this->add('xPurchase/Model_PurchaseOrderItem');
        $po_item->addCondition('po_id',$po_id);

        $crud->setModel($po_item,array('item_id','qty','rate','amount','narration','custom_fields'),array('item','qty','unit','rate','amount','status'));
        // $crud->add('xHR/Controller_Acl');

        if($crud->isEditing()){
        	$item_field = $crud->form->getElement('item_id');
        	$item_field->qty_effected_custom_fields_only = true;
        }
        $crud->add('xShop/Controller_getRate');
		$crud->add('xHR/Controller_Acl',array('document'=>'xPurchase\PurchaseOrder_'. ucwords($po_item->order()->get('status')),'show_acl_btn'=>false,'override'=>array('can_view'=>'All','can_see_activities'=>'No')));

	}
	
}