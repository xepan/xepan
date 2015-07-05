<?php
class page_xMarketingCampaign_page_owner_xmail extends page_xMarketingCampaign_page_owner_main{
	
	function init(){
		parent::init();
		
		$this->app->title='x-Mail';

		$dept = $this->api->current_department;
		$official_email_array = $dept->getOfficialEmails();
		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-envelope"></i> '.$dept['name'].' Mails <small> '.implode(", ", $official_email_array).'  </small>');

		$col = $this->add('Columns');
		$left_col=$col->addColumn(2);
		$right_col=$col->addColumn(10);

//Emails--------------------------------------------------------------------------------------
		$email_view = $right_col->add('xCRM/View_Email')->addClass('xcrm-memberforemail');

//CUSTOMER SECTION----------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xShop/Model_CustomerForEmail'),'member_type'=>'Customer','panel_open'=>"on",'email_view'=>$email_view));

//SUPPLIER SECTION--------------------------------------------------------------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xPurchase/Model_SupplierForEmail'),'member_type'=>'Supplier','email_view'=>$email_view))->addStyle('margin-top','5%');

//AFFILIATE SECTION-----------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xShop/Model_AffiliateForEmail'),'member_type'=>'Affiliate','email_view'=>$email_view))->addStyle('margin-top','5%');

		
		// $this->js(true)->_selector('*')->xtooltip();
	}


}