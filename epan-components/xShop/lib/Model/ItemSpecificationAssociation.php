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

		// throw new \Exception($this->isDirty('value'));
		$item_categories = $this->ref('item_id')->getCategory(null,$category_name = false);
		
		foreach($item_categories as $category_id) {
			$filter = $this->add('xShop/Model_Filter');
			$filter->addCondition('specification_id',$this['specification_id']);
			$filter->addCondition('category_id',$category_id);
			$filter->tryLoadAny();

			//For First Time/New Value
			$new_value_array = explode(',',$this['value']);
			$unique_values_array = [] ;

			//If Recoed is Already exists
			if($filter->loaded()){
				$filter_value_array = [];//Json Values{'value-1'=>count(),'Value-2'=>count()}
				if(count(json_decode($filter['unique_values'],true)))
					$filter_value_array = json_decode($filter['unique_values'],true);
												
				foreach ($filter_value_array as $spec_value => $count) {
					//Jo dono me he usko karo plus
					if(in_array($spec_value, $new_value_array)){
						$filter_value_array[$spec_value] = $count+1;
						//Unset Value From new Array
						unset($new_value_array[$spec_value]);
					}else{
						//Unset the Saved Filter Unique Value
						//Jo Filter Value me he usko karo delete
						unset($filter_value_array[$spec_value]);
					}
				}

				$unique_values_array = $filter_value_array;

			}else{
				foreach ($new_value_array as $junk) {
					$unique_values_array[$junk] = 1;
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