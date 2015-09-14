<?php

namespace xShop;

class Model_ItemSpecificationAssociation extends \Model_Table{
	public $table = "xshop_item_spec_ass";

	function init(){
		parent::init();

		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xShop/Specification','specification_id');

		$this->addField('value');
		$this->addField('highlight_it')->type('boolean');

		$this->addHook('beforeSave',$this);
		//$this->add('dynamic_model/Controller_AutoCreator');
	}	

	function beforeSave(){
		
		$item_categories = $this->ref('item_id')->getCategory(null,$category_name = false);
		
		foreach($item_categories as $category_id) {
			$filter = $this->add('xShop/Model_Filter');
			$filter->addCondition('specification_id',$this['specification_id']);
			$filter->addCondition('category_id',$category_id);
			$filter->tryLoadAny();

			//For First Time/New Value
			$new_value_array = explode(',',$this['value']);
			$unique_values_array = [] ;

			//If Record is Already exists
			if($filter->loaded()){
				//Get Saved Json Data to Array
				$filter_old_unique_value_array = count(json_decode($filter['unique_values'],true))?json_decode($filter['unique_values'],true):[];
				
				if($this->loaded()){//is Editing
					$ass_model = $this->add('xShop/Model_ItemSpecificationAssociation')->load($this->id);
					$old_filter_value = explode(',',$ass_model['value']);
					$old_filter_diff_value = array_diff($old_filter_value, $new_value_array);

					//Check if Editing and remove some Specification Value
					foreach ($old_filter_diff_value as $key => $value) {
						if(in_array($value, $old_filter_value,true)) {
							//Minus the Count by 1
							$filter_old_unique_value_array[$value] = $filter_old_unique_value_array[$value]-1;
							if($filter_old_unique_value_array[$value]==0)//Checking if count is zero then removed
								unset($filter_old_unique_value_array[$value]);
						}
					}						
				}

				//New Entry
				foreach ($new_value_array as $key => $value) {
					if(isset($filter_old_unique_value_array[$value])){
						//Jo dono me he usko karo plus
						//Check for Value is Available in old filter value at editing time then not increse the count
						if( !(isset($old_filter_value) and in_array($value, $old_filter_value,true)))
							$filter_old_unique_value_array[$value] = $filter_old_unique_value_array[$value]+1;
					}else{
						$filter_old_unique_value_array[$value] = 1;
					}
					
				}
				$unique_values_array = $filter_old_unique_value_array;

			}else{
				foreach ($new_value_array as $key => $value) {
					$unique_values_array[$value] = 1;
				}
			}

			$filter['unique_values'] = json_encode($unique_values_array);
			$filter->save();
		}



	}

	function duplicate($item_id){
		$new_asso = $this->add('xShop/Model_ItemSpecificationAssociation');
		foreach ($this as $junk) {
			$new_asso['item_id'] = $item_id;
			$new_asso['specification_id'] = $junk['specification_id'];
			$new_asso['value'] = $junk['value'];
			$new_asso['highlight_it'] = $junk['highlight_it'];
			$new_asso->saveAndUnload();
		}
	}
}