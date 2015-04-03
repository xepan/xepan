<?php
class page_xPurchase_page_owner_invoice_draft extends page_xPurchase_page_owner_main{
	
	function init(){
		parent::init();

		$invoice_draft = $this->add('xPurchase/Model_Invoice_Draft');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_Invoice'));
		$crud->setModel($invoice_draft);

		$from_purchased_order_vp = $this->add('VirtualPage')->set(function($p)use($crud){
			$purchased_orders = $p->add('xPurchase/Model_PurchaseOrder');
			$purchased_orders->addCondition('status','<>',array('draft','submitted'));
			
			$purchased_orders->addExpression('has_invoice')->set($purchased_orders->refSQL('xPurchase/PurchaseInvoice')->count());
			$purchased_orders->addCondition('has_invoice',0);

			$form = $p->add('Form_Stacked');
			$form->addField('autocomplete/Basic','purchase_orders')->setModel($purchased_orders);
			$form->addSubmit('Create');

			if($form->isSubmitted()){
				$purchase_order = $p->add('xPurchase/Model_PurchaseOrder')->load($form['purchase_orders']);
				$purchase_order->createInvoice('draft');
				// echo "hi";
				$crud->grid->js(null,$form->js()->univ()->closeDialog())->_selector('.inv-grid')->trigger('reload')->execute();
			}

		});


		if(!$crud->isEditing()){
			$btn = $crud->addButton('From Purchase order');	
			if($btn->isClicked()){
				$crud->js()->univ()->frameURL('Create Invoice From Purchase Order',$from_purchased_order_vp->getURL())->execute();
			}
			$crud->grid->addClass('inv-grid')->js('reload')->reload();
		}

		$crud->add('xHR/Controller_Acl');
		// $this->add('xPurchase/View_Invoice',array('invoice'=>$this->add('xShop/Model_Invoice')->load(22)));
		
	}
}		