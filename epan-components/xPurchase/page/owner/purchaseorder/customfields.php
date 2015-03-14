<?php

class page_xPurchase_page_owner_purchaseorder_customfields extends page_xPurchase_page_owner_main {

	public $orderitem;
	public $existing_values;
	public $item;
	public $form;


	function init(){
		parent::init();

		$this->api->stickyGET('custom_field_name');
		$this->api->stickyGET('current_json');

		$orderitem_id = $this->api->stickyGET('orderitem_id');
		$this->orderitem = $orderitem = $this->add('xPurchase/Model_PurchaseOrderItem')->addCondition('id',$orderitem_id)->tryLoadAny();

		$this->existing_values = json_decode($_GET['current_json'],true);

		$item_id = $this->api->stickyGET('selected_item_id');
		$this->item = $item = $this->add('xShop/Model_Item')->tryLoad($item_id);

		if(!$item->loaded()) {
			$this->add('View_Error')->set('item not selcetd');
			return;
		}

		$this->form = $form = $this->add('Form_Stacked');

		//get loaded item purchase department custom field only
		$department = $this->add('xHR/Model_Department');
		$department->addCondition('name','Purchase');
		$phase = $department->tryLoadAny();

		$custom_fields_asso = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);
		$custome_fields_array = array();
		foreach ($custom_fields_asso as $cfassos) {
			$field = $this->addCustomField($cf = $cfassos->ref('customfield_id'),$custom_fields_asso);
			if(isset($this->existing_values[$phase->id][$cf->id])){
				$field->set($this->existing_values[$phase->id][$cf->id]);
			}

			$custome_fields_array[] = 'custom_field_'.$cf->id;
		}

		$form->addSubmit('Update');

		$custom_fields_asso_values=array();
		
		if($form->isSubmitted()){
			$custom_fields_asso_values[$phase->id]=array();
			$custom_fields_asso = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);
			foreach ($custom_fields_asso as $cfassos) {
				$cf = $cfassos->ref('customfield_id');
				$custom_fields_asso_values [$phase->id][$cf->id] =  $form['custom_field_'.$custom_fields_asso->id];
			}
				
			$json = json_encode($custom_fields_asso_values);
			$form->js(null,$form->js()->univ()->closeDialog())->_selector('#'.$_GET['custom_field_name'])->val($json)->execute();
		}

	}

	function addCustomField(&$cf, $custom_fields_asso_assos){
		$field=null;
		
		switch($cf['type']){
			case "line":
				$field = $this->form->addField('line','custom_field_'.$cf->id , $cf['name']);
			break;
			case "DropDown":
				$field = $drp = $this->form->addField('DropDown','custom_field_'.$custom_fields_asso_assos->id , $cf['name']);
				$values = $this->add('xShop/Model_CustomFieldValue');
				$values->addCondition('item_id',$this->item->id);
				$values->addCondition('customfield_id',$cf->id);
				$values->addCondition('itemcustomfiledasso_id',$custom_fields_asso_assos->id);
				$values_array=array();
				foreach ($values as $value) {
					$values_array[$value['id']]=$value['name'];
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