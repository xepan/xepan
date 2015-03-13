<?php

class page_xPurchase_page_owner_purchaseorder_draft extends page_xPurchase_page_owner_main{
	
	function page_index(){
		// parent::init();

		$model = $this->add('xPurchase/Model_PurchaseOrder_Draft');

		$crud=$this->add('CRUD');
		$crud->setModel($model);
		// $crud->addRef('xPurchase/PurchaseOrderItem');
		$crud->add('xHR/Controller_Acl');
		if(!$crud->isEditing()){
			$crud->grid->addColumn('expander','purchase_order_item');
		}

	}

	function page_purchase_order_item(){
        $po_id = $this->api->stickyGET('xpurchase_purchase_order_id');
		$crud = $this->add('CRUD');
        $po_item=$this->add('xPurchase/Model_PurchaseOrderItem');
        $po_item->addCondition('po_id',$po_id);

        $crud->setModel($po_item);
        // $crud->add('xHR/Controller_Acl');

        if($crud->isEditing()){
        	$item_field = $crud->form->getElement('item_id');
            $f = $item_field->other_field;
            $custom_fields_field = $crud->form->getElement('custom_fields');
            // $custom_fields_field->js(true)->hide();
            
            $btn = $item_field->other_field->belowField()->add('Button')->set('CustomFields');
            $btn->js('click',$this->js()->univ()->frameURL('Custome Field Values',array($this->api->url('xPurchase_page_owner_purchaseorder_customfields',array('orderitem_id'=>$crud->id,'custom_field_name'=>$crud->form->getElement('custom_fields')->name)),"selected_item_id"=>$item_field->js()->val(),'current_json'=>$custom_fields_field->js()->val())));
        }

	}
	
}