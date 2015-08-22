<?php
namespace xShop;
class Grid_Affiliate extends \Grid{
	function init(){
		parent::init();

	}


	function setModel($model,$fields=null){
		
		$model->getElement('logo_url_id')->caption('Company');

		$m=parent::setModel($model,$fields);

		if($this->hasColumn('application')) $this->removeColumn('application');
		if($this->hasColumn('affiliatetype')) $this->removeColumn('affiliatetype');
		if($this->hasColumn('name')) $this->removeColumn('name');
		if($this->hasColumn('city')) $this->removeColumn('city');
		if($this->hasColumn('state')) $this->removeColumn('state');
		if($this->hasColumn('country')) $this->removeColumn('country');
		if($this->hasColumn('zip_code')) $this->removeColumn('zip_code');
		if($this->hasColumn('office_address')) $this->removeColumn('office_address');
		if($this->hasColumn('is_active')) $this->removeColumn('is_active');
		if($this->hasColumn('phone_no')) $this->removeColumn('phone_no');
		if($this->hasColumn('mobile_no')) $this->removeColumn('mobile_no');
		if($this->hasColumn('email_id')) $this->removeColumn('email_id');
		if($this->hasColumn('website_url')) $this->removeColumn('website_url');
		if($this->hasColumn('item_name')) $this->removeColumn('item_name');
		if($this->hasColumn('created_by')) $this->removeColumn('created_by');
		if($this->hasColumn('related_document')) $this->removeColumn('related_document');
		if($this->hasColumn('created_date')) $this->removeColumn('created_date');
		if($this->hasColumn('updated_date')) $this->removeColumn('updated_date');
		
		// $this->fooHideAlways('description');
		// $this->fooHideAlways('website_url');
		// $this->fooHideAlways('office_address');
		// $this->fooHideAlways('city');
		// $this->fooHideAlways('state');
		// $this->fooHideAlways('country');

		if(!$fields)
			$fields = $this->model->getActualFields();
		$this->addQuickSearch($fields,null,'xShop/Filter_Affiliate');
		$this->addPaginator($ipp=50);
		$this->add_sno();

		return $m;

	}

	function recursiveRender(){

		$type_btn = $this->addButton('Affiliate Type Management');
		if($type_btn->isClicked()){
			$this->js()->univ()->frameURL('Affiliate Type',$this->api->url('xShop_page_owner_affiliatetype'))->execute();
		}

		parent::recursiveRender();
	}

	function formatRow(){

		if($this->model['is_active'])
			$this->setTDParam('company_name','class','');
		else
			$this->setTDParam('company_name','class','');
		//Logo
		$this->current_row_html['logo_url'] = '<img src="'.$this->model->ref('logo_url_id')->ref('thumb_file_id')->get('url').'"/>';

		$contact ="";
		if($this->model['phone_no'])
			$contact .= '<i class="icon-phone">'.$this->model['phone_no'].'</i>';
		if($this->model['mobile_no'])
			$contact .= '&nbsp;<i class="icon-mobile">'.$this->model['mobile_no'].'</i>';

		$email = "";
		if($this->model['email_id'])
			$email .= '<br/><i class="icon-mail"> '.$this->model['email_id'].'</i>';
		
		$website = "";
		if($this->model['website_url']){
			// $array = parse_url($this->model['website_url']);
			$url=$this->model['website_url'];
			$website = '<br/><a class="glyphicon glyphicon-globe" target="_blank" href="'.$url.'">'.$url.'</a>';
		}

		$this->current_row_html['company_name']='<div class="atk-size-kilo">'.$this->model['company_name'].'</div>'.$this->model['name'].'<br/>'.$this->model['office_address'].'<br/>'.$this->model['city'].', '.$this->model['state'].', '.$this->model['country'].', '.$this->model['zip_code'].'<br/>'.$contact.$email.$website;
	
		$img_url ="";
		if(!$this->model['logo_url']){
		 	$img_url= "epan-components/xShop/templates/images/item_no_image.png";
		}else{
			$img_url=$this->model['logo_url'];
		}
		$this->current_row_html['logo_url']='<img style="max-width:70px;"  src="'.$img_url.'"></img>';

		$this->current_row_html['description']= $this->model['description'];
		parent::formatRow();		
	}

}