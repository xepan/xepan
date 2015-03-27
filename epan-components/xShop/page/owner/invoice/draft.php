<?php
class page_xShop_page_owner_invoice_draft extends page_xShop_page_owner_main{
	
	function init(){
		parent::init();

		$from_saled_order_vp = $this->add('VirtualPage')->set(function($p){
			
			$sales_orders = $p->add('xShop/Model_Order');
			$sales_orders->addCondition('status','<>',array('draft','submitted'));
			$sales_orders->addExpression('has_invoice')->set($sales_orders->refSQL('xShop/SalesInvoice')->count());
			$sales_orders->addCondition('has_invoice',0);

			$form = $p->add('Form_Stacked');
			$form->addField('autocomplete/Basic','sales_order')->setModel($sales_orders);
			$form->addSubmit('Create');

			if($form->isSubmitted()){
				$sale_order = $p->add('xShop/Model_Order')->load($form['sales_orders']);
				$invoice = $p->add('xShop/Model_Invoice');
				$invoice['sales_order_id'] = $sale_order['id'];
				$invoice['status'] = "draft";
				$invoice->save();

				$ois = $sale_order->orderItems();
				foreach ($ois as $oi) {
					$invoice_itm = $p->add('xShop/Model_InvoiceItem');
					$invoice_itm['item_id'] =  $oi['item_id'];
					$invoice_itm['name'] =  $oi['name'];
					$invoice_itm['qty'] =  $oi['qty'];
					$invoice_itm['rate'] =  $oi['rate'];
					$invoice_itm['custom_fields'] =  $oi['custom_fields'];
					$invoice_itm['narration'] =  $oi['narration'];
					$invoice_itm['amount'] =  $oi['amount'];
					$invoice_itm['net_amount'] =  $oi['net_amount'];
					$invoice_itm->save();
				}
				$form->js(null,$form->js()->univ()->closeDialog())->execute();
				// $form->js()->univ()->reload()->execute();
			}

		});

		$invoice_draft = $this->add('xShop/Model_Invoice_Draft');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel($invoice_draft);

		if(!$crud->isEditing()){
			$btn = $crud->addButton('From Sales order');	
			if($btn->isClicked()){
				$crud->js()->univ()->frameURL('Create Invoice From Sales ORder',$from_saled_order_vp->getURL())->execute();
			}
		}

		$crud->add('xHR/Controller_Acl');
	}
}		