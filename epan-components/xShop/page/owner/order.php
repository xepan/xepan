<?php

class page_xShop_page_owner_order extends page_xShop_page_owner_main{

	function page_index(){
		
		$this->app->title=$this->api->current_department['name'] .': Orders';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Sale Orders Management <small> Manage your sale Orders </small>');

		$counts = $this->add('xShop/Model_Order');
		$counts->_dsql()->del('fields')->field('count(*) cnt')->field('status')->group('status');

		$counts = $counts->_dsql()->get();
		$counts_array=array();
		foreach ($counts as $cnt) {
			$counts_array[$cnt['status']] = $cnt['cnt'];
		}

		$this->add('xShop/View_Badges_OrderPage');
		$tab = $this->add('Tabs');
			$tab->addTabURL('xShop/page/owner/order_draft','Draft '. ($counts_array['draft']? '('.$counts_array['draft'].')':''));
			$tab->addTabURL('xShop/page/owner/order_submitted','Submitted '.($counts_array['submitted']? '('.$counts_array['submitted'].')':''));
			$tab->addTabURL('xShop/page/owner/order_approved','Approved '.($counts_array['approved']? '('.$counts_array['approved'].')':''));
			$tab->addTabURL('xShop/page/owner/order_processing','Processing '.($counts_array['processing']? '('.$counts_array['processing'].')':''));
			$tab->addTabURL('xShop/page/owner/order_processed','Processed '.($counts_array['processed']? '('.$counts_array['processed'].')':''));
			$tab->addTabURL('xShop/page/owner/order_shipping','Shipping '.($counts_array['shipping']? '('.$counts_array['shipping'].')':''));
			$tab->addTabURL('xShop/page/owner/order_complete','Complete '.($counts_array['complete']? '('.$counts_array['complete'].')':''));
			$tab->addTabURL('xShop/page/owner/order_cancel','Cancel / Return '.($counts_array['cancel']? '('.$counts_array['cancel'].')':''));

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