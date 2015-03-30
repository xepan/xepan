<?php

class page_xShop_page_owner_order extends page_xShop_page_owner_main{

	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Orders';

		$this->vp = $this->add('VirtualPage')->set(function($p){
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_searched']);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
		});


		$order_model = $this->add('xShop/Model_Order');
		$order_model->title_field = 'search_phrase';

		$cols = $this->app->layout->add('Columns',null,'page_title');
		$lc= $cols->addColumn(8);
		$rc= $cols->addColumn(4);
		$lc->add('View')->setHTML('<i class="fa fa-users"></i> Sale Orders Management <small> Manage your sale Orders </small>');
		$form = $rc->add('Form_Empty');
		$form->addField('autocomplete/Basic','order')->setModel($order_model);

		if($form->isSubmitted()){
			$order_model->load($form['order']);

			$form->js(null, $form->js()->reload())->univ()->frameURL('Order '. $order_model['name'],$this->api->url($this->vp->getURL(),array('sales_order_searched'=>$form['order'])))->execute();
		}

		$this->add('xShop/View_Badges_OrderPage');

		$tab = $this->add('Tabs');
		$tab->addTabURL('xShop/page/owner/order_draft','Draft '.$this->add('xShop/Model_Order_Draft')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_submitted','Submitted '.$this->add('xShop/Model_Order_Submitted')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_approved','Approved '.$this->add('xShop/Model_Order_Approved')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_processing','Processing '.$this->add('xShop/Model_Order_Processing')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_processed','Processed '.$this->add('xShop/Model_Order_Processed')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_shipping','Shipping '.$this->add('xShop/Model_Order_Shipping')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_completed','Complete '.$this->add('xShop/Model_Order_Completed')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_cancelled','Cancel / Return '.$this->add('xShop/Model_Order_Cancelled')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/order_redesign','Redesign '.$this->add('xShop/Model_Order_Redesign')->myCounts(true,false));
    }

}