<?php
namespace xShop;
class Grid_Affiliate extends \Grid{
	function init(){
		parent::init();
	}

	function setModel($model){
		
		$m=parent::setModel($model,array('company_name','owner_name','logo_url','is_active','pnhone_no','mobile_no','email_id','website_url','office_address','city','state','country','zip_code','description'));


		$this->fooHideAlways('logo_url');
		$this->fooHideAlways('website_url');
		$this->fooHideAlways('office_address');
		$this->fooHideAlways('city');
		$this->fooHideAlways('state');
		$this->fooHideAlways('country');
		$this->fooHideAlways('description');

		$this->addQuickSearch(array('name','company_name','phone_no','mobile_no','email_id','website_url','state','zip_code'));
		$this->addPaginator($ipp=50);
		$this->add_sno();

		return $m;

	}

	function formatRow(){

		parent::formatRow();		
	}

}