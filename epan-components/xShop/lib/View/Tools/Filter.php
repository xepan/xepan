<?php

namespace xShop;

class View_Tools_Filter extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	public $filter_design=array();//Make Filter List with Category item ['specification_name'=>['value1'=>['options']]]
	public $selected_filter_value = null;//Selected Value of Filter
	public $min_price = null;
	public $max_price = null;

	function init(){
		parent::init();

		$this->min_price = $this->html_attributes['xshop-filter-start-price'];
		$this->max_price = $this->html_attributes['xshop-filter-end-price'];

		if($_GET['filter_data']){
			$selected_data = explode("|", $_GET['filter_data']);
			$this->selected_filter_value = $_GET['filter_data'];
		}

		if(isset($_GET['xmip']) and $_GET['xmip'])
			$this->min_price = $_GET['xmip'];

		if(isset($_GET['xmap']) and $_GET['xmap'])
			$this->max_price = $_GET['xmap'];

		$this->addClass('xshop-filter-tool');

		$this->api->stickyGET('xsnb_category_id');
		$this->api->stickyGET('filter_data');

		$specifications = $this->add('xShop/Model_Specification');
		$specifications->addCondition('is_filterable',true);
		$specifications->setOrder('order');
		$specifications->tryLoadAny();

		/*
			['specification_id'] = [
									unique_values => [
														'name'=>''
													]
									'specification_id'=>,
									'specification_name'=>'',
									]
		*/
		$new_values=[];
		foreach ($specifications as $specification) {
			$filter = $this->add('xShop/Model_Filter');
			$filter->addCondition('specification_id',$specification->id);
			$filter->addCondition('category_id',$_GET['xsnb_category_id']);
			$filter->tryLoadAny();

			if(!count(json_decode($filter['unique_values'],true))){
				continue;
			}

			$v = json_decode($filter['unique_values'],true);

			$unique_values_array = [];
			foreach ($v as $key=>$value) {
				$is_selected = "unchecked";
				if(isset($selected_data) and in_array($specification['id'].":".$key,$selected_data)){
					$is_selected = "checked";
				}
				$unique_values_array[$key] = $is_selected;
			}

			$new_values[$specification->id] = [
												'unique_values'=>$unique_values_array,
												'category_id'=>$filter['category_id'],
												'specification_id'=>$filter['specification_id'],
												'specification_name'=>$specification['name'],
												'is_selected'=>$is_selected
											];
		}	
		
		$this->filter_design = $new_values;
		$this->api->stickyForget('filter_data');
		$this->api->stickyForget('xmip');
		$this->api->stickyForget('xmap');

	}

	function render(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>array('templates/css','templates/js'),
		        'img'=>array('templates/css','templates/js'),
		        'js'=>'templates/js',

		    )
		);

		$this->api->jquery->addStylesheet('filter');
		$this->api->template->appendHTML('js_include','<script src="epan-components/xShop/templates/js/filter.js"></script>'."\n");

		$this->js(true)->xepan_xshopfilter(
											array(
													'filter_design'=>$this->filter_design,
													'html_attributes'=>$this->html_attributes,
													'url'=>$this->api->url(),
													'selected_filter_value'=>$this->selected_filter_value,
													'min_price'=>$this->min_price,
													'max_price'=>$this->max_price
												)
											);
		parent::render();
	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}