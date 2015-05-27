<?php
class page_xHR_page_owner_xmail extends page_xHR_page_owner_main{
	
	function init(){
		parent::init();
		
		$this->app->title='x-Mail';
		$dept_id = $this->api->stickyGET('department_id');
		
		$dept = $this->add('xHR/Model_Department')->load($dept_id);
		$official_email_array = $dept->getOfficialEmails();
		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-envelope"></i> '.$dept['name'].' Mails <small> '.implode(", ", $official_email_array).'  </small>');

		$col = $this->add('Columns');
		$left_col=$col->addColumn(2);
		$right_col=$col->addColumn(10);

//CUSTOMER SECTION----------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xShop/Model_CustomerForEmail'),'member_type'=>'Customer'));

//SUPPLIER SECTION--------------------------------------------------------------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xPurchase/Model_SupplierForEmail'),'member_type'=>'Supplier'))->addStyle('margin-top','5%');

//AFFILIATE SECTION-----------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xShop/Model_AffiliateForEmail'),'member_type'=>'Affiliate'))->addStyle('margin-top','5%');

//Emails--------------------------------------------------------------------------------------
		$right_col->add('xCRM/View_Email');
		
		// $this->js(true)->_selector('*')->xtooltip();
	}


}