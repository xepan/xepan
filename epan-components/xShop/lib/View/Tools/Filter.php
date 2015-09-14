<?php

namespace xShop;

class View_Tools_Filter extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

		$this->api->stickyGET('xsnb_category_id');

		$specifications = $this->add('xShop/Model_Specification');
		$specifications->addCondition('is_filterable',true);
		$specifications->setOrder('order');
		$specifications->tryLoadAny();
		
		foreach ($specifications as $specification) {
			$filter = $this->add('xShop/Model_Filter');
			$filter->addCondition('specification_id',$specification->id);
			$filter->addCondition('category_id',$_GET['xsnb_category_id']);
			$filter->tryLoadAny();

			if(!count(json_decode($filter['unique_values'],true))){
				continue;
			}

			$v = json_decode($filter['unique_values'],true);
			$new_values=[];

			foreach ($v as $key=> $value) {
				$new_values[] = array(
									'url'=>$this->api->url("home"),
									'unique_value'=>$key,
									'category_id'=>$filter['category_id'],
									'specification_id'=>$filter['specification_id'],
									'specification_name'=>$specification['name']
								);
			}
			$lister = $this->add('xShop/View_Lister_Filter')->setSource($new_values);
			$lister->template->trySet('spec_name',$specification['name']);
		}

		$this->on('click','.xshop-item-filter-checkbox')->univ()->location($this->api->url('',array('filter'=>$this->js()->_selectorThis()->data('unique-value'))));
		
	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}