<?php

class page_xShop_page_owner_order extends page_xShop_page_owner_main{

	function page_index(){
		
		$this->app->title=$this->api->current_department['name'] .': Orders';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Sale Orders Management <small> Manage your sale Orders </small>');

		$this->add('xShop/View_Badges_OrderPage');

		$tab = $this->add('Tabs');
			$tab->addTabURL('xShop/page/owner/order_draft','Draft '.$this->add('xShop/Model_Order_Draft')->myUnRead());
			$tab->addTabURL('xShop/page/owner/order_submitted','Submitted '.$this->add('xShop/Model_Order_Submitted')->myUnRead());
			$tab->addTabURL('xShop/page/owner/order_approved','Approved '.$this->add('xShop/Model_Order_Approved')->myUnRead());
			$tab->addTabURL('xShop/page/owner/order_processing','Processing '.$this->add('xShop/Model_Order_Processing')->myUnRead());
			$tab->addTabURL('xShop/page/owner/order_processed','Processed '.$this->add('xShop/Model_Order_Processed')->myUnRead());
			$tab->addTabURL('xShop/page/owner/order_shipping','Shipping '.$this->add('xShop/Model_Order_Shipping')->myUnRead());
			$tab->addTabURL('xShop/page/owner/order_completed','Complete '.$this->add('xShop/Model_Order_Completed')->myUnRead());
			$tab->addTabURL('xShop/page/owner/order_cancelled','Cancel / Return '.$this->add('xShop/Model_Order_Cancelled')->myUnRead());

		// $application_id=$this->api->recall('xshop_application_id');
		// //$order_model->addCondition('application_id',$application_id);	
		
		//Badges 
		
		// $order_model = $this->add('xShop/Model_Order');
		// $order_model->setOrder('id','desc');
						
		// $crud=$this->app->layout->add('CRUD');
		// $crud->setModel($order_model);
		// if($_GET['print']){			
		// 	$this->js()->univ()->newWindow($this->api->url("xShop/page_printorder",array('order_id'=>$_GET['print'],'cut_page'=>1,'subpage'=>'xshop-junk')),null,'height=689,width=1246,scrollbar=1')->execute();
		// } 
		// if(!$crud->isEditing()){
		// 	$crud->grid->addQuickSearch(array('member','order_id','amount','billing_address','shipping_address','order_date'));
		// 	$crud->grid->addPaginator($ipp=50);
  //        	 $crud->grid->addColumn('expander','detail');
  //        	 $crud->grid->addColumn('button','print');
		// }

    }

 //    function page_detail(){
 //    	$crud = $this->add('CRUD');
 //        $order_id = $this->api->stickyGET('xshop_orders_id');
 //        $order_detail=$this->add('xShop/Model_OrderDetails');
 //        $order_detail->addCondition('order_id',$order_id);
 //        $crud->setModel($order_detail);
	// } 

}