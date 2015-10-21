<?php

namespace xShop;

class View_Tools_Search extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

	$search_result_subpage=$this->html_attributes['xshop_search_result_subpage'];
	if(!$search_result_subpage){
		$search_result_subpage="home";
	}

	$form_type ="Form";

	if($this->html_attributes['form-type']=="stacked"){
		$form_type = "Form_Stacked";
	}

	$label = "";
	if($this->html_attributes['field-label'] != "")
		$label = $this->html_attributes['field-label'];

	$search_model = $this->add('xShop/Model_Item');
	$form=$this->add('Form_Horizontal');
   	$form_field=$form->addField('line','search',$label)->setAttr('PlaceHolder',$this->html_attributes['input-placeholder']?:"Type Your Search String");
   	$form_field->setModel($search_model);
	
   	if($this->html_attributes['form-btn']){
   		if($form_type == "Form_Stacked")
 	  		$form->addSubmit($this->html_attributes['form-btn-label'] !=""?$this->html_attributes['form-btn-label']:"Search");
   		else{
 			$btn = $form_field->afterField()->add('Button')->addClass('xshop-search-btn')->set(array($this->html_attributes['form-btn-label'],'icon'=>'search'))->js('click',$form->js()->submit());
   		}
   	}
	

   	if($form->isSubmitted()){
   		$form->api->redirect($this->api->url(null,array('subpage'=>$search_result_subpage,'search'=>$form['search'])));
   		$this->js()->reload(array(''))->execute();
   	}

	}
	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}