<?php

class page_xPurchase_page_owner_purchaseorder_draft extends page_xPurchase_page_owner_main{
	
	function page_index(){
		// parent::init();

		$draft_purchase_order_model = $this->add('xPurchase/Model_PurchaseOrder_Draft');


		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_PurchaseOrder','add_form_beautifier'=>false));

		$crud->setModel($draft_purchase_order_model,array('supplier_id','priority','order_date','order_summary','orderitem_count','delivery_to'),array('name','supplier','order_date','orderitem_count'));
		
		if(!$crud->isEditing()){
			$crud->grid->addColumn('expander','purchase_order_item');
		}

		$crud->add('Controller_FormBeautifier');
		$crud->add('xHR/Controller_Acl');
		//$this->add('xPurchase/View_PurchaseOrder',array('purchaseorder'=>$this->add('xPurchase/Model_PurchaseOrder')->load(1)));
	}

	function page_purchase_order_item(){
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