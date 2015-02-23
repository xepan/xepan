<?php

class page_xShop_page_owner_order_customfields extends page_xShop_page_owner_main {

	public $orderitem;
	public $existing_values;
	public $item;
	public $form;


	function init(){
		parent::init();

		$this->api->stickyGET('custom_field_name');
		$this->api->stickyGET('current_json');

		$orderitem_id = $this->api->stickyGET('orderitem_id');
		$this->orderitem = $orderitem = $this->add('xShop/Model_OrderDetails')->addCondition('id',$orderitem_id)->tryLoadAny();

		$this->existing_values = json_decode($_GET['current_json'],true);

		$item_id = $this->api->stickyGET('selected_item_id');
		$this->item = $item = $this->add('xShop/Model_Item')->tryLoad($item_id);

		if(!$item->loaded()) {
			$this->add('View_Error')->set('item not selcetd');
			return;
		}

		$this->form = $form = $this->add('Form_Stacked');

		$phases = $this->add('xProduction/Model_Phase');
		foreach ($phases as $phase) {
		// add all phases
			$phase_field = $form->addField('Checkbox','phase_'.$phase->id,$phase['name']);
			// if item has custome fields for phase & set if editing
			if(isset($this->existing_values[$phase->id])) 
				$phase_field->set(true);

			$custom_fields = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);
			$custome_fields_array=array();
			foreach ($custom_fields as $cfassos) {
				$field = $this->addCustomField($cf = $cfassos->ref('customfield_id'));
				if(isset($this->existing_values[$phase->id][$cf->id])){
					$field->set($this->existing_values[$phase->id][$cf->id]);
				}

				$custome_fields_array[] = 'custom_field_'.$cf->id;
			}

			if(count($custome_fields_array)){
				$phase_field->js(true)->univ()->bindConditionalShow(array(
					''=>array(),
					'*'=>$custome_fields_array
				),'div.atk-form-row');	
			}
				// add custome fields here
					// if orderitem is loaded fill exising values
		}

		$form->addSubmit('Update');

		$custom_fields_values=array();
		
		if($form->isSubmitted()){
			foreach ($phases as $phase) {
				if( $form['phase_'.$phase->id] ){
					$custom_fields_values [$phase->id]=array();
					$custom_fields = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);
					foreach ($custom_fields as $cfassos) {
						$cf = $cfassos->ref('customfield_id');
						$custom_fields_values [$phase->id][$cf->id] =  $form['custom_field_'.$cf->id];
					}
				}
			}
			$json = json_encode($custom_fields_values);
			$form->js(null,$form->js()->univ()->closeDialog())->_selector('#'.$_GET['custom_field_name'])->val($json)->execute();
		}

	}

	function addCustomField(&$cf){
		switch($cf['type']){
			case "line":
				$field = $this->form->addField('line','custom_field_'.$cf->id , $cf['name']);
			break;
			case "DropDown":
				$field = $drp = $this->form->addField('DropDown','custom_field_'.$cf->id , $cf['name']);
				$values = $this->add('xShop/Model_CustomFieldValue');
				$values->addCondition('item_id',$this->item->id);
				$values->addCondition('customfield_id',$cf->id);
				$values_array=array();
				foreach ($values as $value) {
					$values_array[$value['name']]=$value['name'];
				}
				$drp->setValueList($values_array);
				$drp->setEmptyText('Please Select Value');
			break;
			case "Color":
			break;
		}

		return $field;
	}
}