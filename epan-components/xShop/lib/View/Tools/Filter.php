<?php

namespace xShop;

class View_Tools_Filter extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

		$specifications = $this->add('xShop/Model_Specification');
		$specifications->addCondition('is_filterable',true);
		$specifications->setOrder('order');
		$specifications->tryLoadAny();
		
		foreach ($specifications as $specification) {
			$filter = $this->add('xShop/View_Lister_Filter',array('html_attributes'=>$this->html_attributes,'specification_id'=>$specification->id));
			// $filter->setModel($specification);
		}
		
	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}