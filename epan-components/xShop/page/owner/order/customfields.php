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

		$item_id = $this->api->stickyGET('selected_item_id');
		$this->item = $item = $this->add('xShop/Model_Item')->tryLoad($item_id);
		
		if(!$item->loaded()) {
			$this->add('View_Error')->set('Item not selceted');
			return;
		}
		
		//Make PredefinedPhase Array
		$this->preDefinedPhase = array();
		foreach ($item->getAssociatedDepartment() as $key => $value) {
			$this->preDefinedPhase[$value] = $value;
		}

		$this->existing_values = $_GET['current_json']?json_decode($_GET['current_json'],true):$this->preDefinedPhase;
		// $this->existing_values = $item->getAssociatedDepartment();
		// print_r($this->existing_values);
		if(!$item->loaded()) {
			$this->add('View_Error')->set('item not selcetd');
			return;
		}

		$this->form = $form = $this->add('Form_Stacked');
		$phases = $this->add('xProduction/Model_Phase');
		foreach ($phases as $phase) {
		// add all phases
			$group = $phase['production_level']."~12~Level".$phase['production_level'];
			$phase_field = $form->addField('Checkbox','phase_'.$phase->id,$phase['name'])->setterGetter('group',$group);
			// if item has custome fields for phase & set if editing
			if(isset($this->existing_values[$phase->id])) {
				$phase_field->set(true);
			}
			
			$custom_fields_asso = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);
			$custom_fields_array=array();
			foreach ($custom_fields_asso as $cfassos) {
				$field = $this->addCustomField($cf = $cfassos->ref('customfield_id'),$custom_fields_asso,$group);
				if(isset($this->existing_values[$phase->id][$cf->id])){
					$field->set($this->existing_values[$phase->id][$cf->id]);
				}

				$custom_fields_array[] = 'custom_field_'.$cf->id;
			}

			// if(count($custom_fields_array)){
			// 	$phase_field->js(true)->univ()->bindConditionalShow(array(
			// 		''=>array(),
			// 		'*'=>$custom_fields_array
			// 	),'div.atk-form-row');	
			// }
				// add custome fields here
					// if orderitem is loaded fill exising values
		}

		$form->addSubmit('Update');

		$custom_fields_asso_values=array();
		
		if($form->isSubmitted()){
			//TODOOOOOO

			
			//Check For the Custom Field Value Not Proper
			foreach ($phases as $phase) {
				if( $form['phase_'.$phase->id] ){
					$custom_fields_asso_values [$phase->id]=array();
					$custom_fields_asso = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);
					foreach ($custom_fields_asso as $cfassos) {
						$cf = $cfassos->ref('customfield_id');
						$custom_fields_asso_values [$phase->id][$cf->id] =  $form['custom_field_'.$custom_fields_asso->id];
						if(!$form['custom_field_'.$custom_fields_asso->id])
							$form->displayError('custom_field_'.$custom_fields_asso->id,'Please define custom fields for selected phase');
					}
				}
			}

			$selected_phases = array_keys($custom_fields_asso_values);
			
			$purchase_level = $this->add('xHR/Model_Department')->loadPurchase();
			$purchase_level_id = $purchase_level->id;
			$store_level = $this->add('xHR/Model_Department')->loadStore();
			$store_level_id = $store_level->id;
			$dispatch_level = $this->add('xHR/Model_Department')->loadDispatch();
			$dispatch_level_id = $dispatch_level->id;

			//If Department Is Purchase then next One Department is Select Compulsary 
			if(in_array($purchase_level_id,$selected_phases) and count($selected_phases)===1){
				$form->displayError('phase_'.$purchase_level_id, ' Purchase cannot be alone seleccted, select any other phase/department');
			}

			//If Department Is Store then next One Department is Select Compulsary
			if(in_array($store_level_id,$selected_phases) and !$this->arrayHasBiggerDepartment($selected_phases,$store_level_id)){
				$form->displayError('phase_'.$store_level_id,' Store cannot be alone seleccted, select any other phase/department');
			}

			//If Department Is Dispatch or Dilivey then Previous One Department is Select Compulsary 
			if(in_array($dispatch_level_id,$selected_phases) and !$this->arrayHasSmallerDepartment($selected_phases,$dispatch_level_id)){
				$form->displayError('phase_'.$dispatch_level_id,' Dispatch cannot be alone seleccted, select any other phase/department');
			}

			//Check For the One Department at One Leve
			$level_touched=array();
			foreach ($selected_phases as $ph) {
				if(in_array(($prd_level=$this->add('xHR/Model_Department')->load($ph)->get('production_level')),$level_touched)){
					$form->displayError('phase_'.$ph,' Cannot Select More phases/Departments at a level');
				}
				$level_touched[] = $prd_level;
			}

			$json = json_encode($custom_fields_asso_values);
			$form->js(null,$form->js()->univ()->closeDialog())->_selector('#'.$_GET['custom_field_name'])->val($json)->execute();
		}
		$this->form->add('Controller_FormBeautifier');

	}

	function addCustomField(&$cf, $custom_fields_asso_assos,$group){
		$field=null;
		
		switch($cf['type']){
			case "line":
				$field = $this->form->addField('line','custom_field_'.$cf->id , $cf['name'])->setterGetter('group',$group);
			break;
			case "DropDown":
				$field = $drp = $this->form->addField('DropDown','custom_field_'.$custom_fields_asso_assos->id , $cf['name'])->setterGetter('group',$group);
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

	function arrayHasBiggerDepartment($selected_departments_id_array,$department_id){
		$depts = $this->add('xHR/Model_Department')->load($department_id);
		$big_depts = $this->add('xHR/Model_Department')->addCondition('production_level','>',$depts['production_level']);
		foreach ($big_depts as $d) {
			if(in_array($d->id, $selected_departments_id_array)) return true;
		}

		return false;
	}

	function arrayHasSmallerDepartment($selected_departments_id_array,$department_id){
		$depts = $this->add('xHR/Model_Department')->load($department_id);
		$big_depts = $this->add('xHR/Model_Department')->addCondition('production_level','<',$depts['production_level']);
		foreach ($big_depts as $d) {
			if(in_array($d->id, $selected_departments_id_array)) return true;
		}

		return false;
	}
}