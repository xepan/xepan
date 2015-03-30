<?php

namespace xShop;

class Form_Field_Item extends \autocomplete\Form_Field_Basic {

	public $custom_field_page ;
	
	public $show_custom_fields=true;
	public $qty_effected_custom_fields_only=false;
	
	public $custom_field_element = 'custom_fields';
	public $selected_item_id;
	public $existing_json;

	function init(){
		parent::init();
		if($this->show_custom_fields){
			$this->custom_field_page();
		}

		$self = $this;

		$this->validateField(function($field)use($self){

			if(!$field->get()) $field->displayFieldError('Please specify Item');
			
			$item = $field->add('xShop/Model_Item')->load($field->get());
			$cf_filled = $field->owner->get('custom_fields');

			if($cf_filled == ''){
				if($self->recall('qty_cf_only')){
					$phases_ids = array($field->add('xHR/Model_Department')->loadStore()->get('id'));
				}else{
					$phases_ids = $item->getAssociatedDepartment();
				}

				$cust_field_array = array();
			}else{
				$cust_field_array = json_decode($cf_filled,true);
				$phases_ids = array_keys($cust_field_array);
			}

			foreach ($phases_ids as $phase_id) {
				$custom_fields_assos_ids = $item->getAssociatedCustomFields($phase_id);
				foreach ($custom_fields_assos_ids as $cf_id) {
					if(!isset($cust_field_array[$phase_id][$cf_id]) or $cust_field_array[$phase_id][$cf_id] == ''){
						$field->displayFieldError('This Item requires custom fields to be filled');
					}
				}
			}

			//Stock Effect CustomFields
			$secf = $item ->stockEffectCustomFields();
			foreach ($secf as $cf) {
				$cf = $cf->ref('customfield_id');
				if(!isset($cust_field_array['stockeffectcustomfield'][$cf['id']]) or $cust_field_array['stockeffectcustomfield'][$cf['id']] == ''){
					$field->displayFieldError('This Item requires custom fields to be filled');
				}
			}

		});
	}

	function recursiveRender(){
		if($this->show_custom_fields){
			$this->owner->getElement($this->custom_field_element)->js(true)->closest('.atk-form-row')->hide();
			$this->manageCustomFields();
		}

		if($this->qty_effected_custom_fields_only){
			$this->memorize('qty_cf_only',true);
		}else{
			$this->forget('qty_cf_only');
		}

		parent::recursiveRender();
	}

	function manageCustomFields(){
		$btn = $this->other_field->belowField()->add('ButtonSet')->addButton()->set('Custome Fields')->addClass('atk-swatch-red');
		$btn->js('click',$this->js()->univ()->frameURL
			(
				'Custom Field Values',
				array(
					$this->api->url(
						$this->custom_field_page->getURL(),
						array(
							'custom_field_name'=>$this->owner->getElement($this->custom_field_element)->name,
							'qty_effected_custom_fields_only'=> $this->qty_effected_custom_fields_only?'1':'0'
							)
						),
					"selected_item_id"=>$this->js()->val(),
					'current_json'=>$this->owner->getElement($this->custom_field_element)->js()->val()
					)
				)
			);
	}

	function custom_field_page(){
		$self = $this;
		
		$this->custom_field_page = $this->add('VirtualPage');
			
		$this->custom_field_page->set(function($p)use($self){

			$p->api->stickyGET('custom_field_name');
			$p->api->stickyGET('current_json');
			$qty_cf_only  = $p->api->stickyGET('qty_effected_custom_fields_only');

			$item_id = $p->api->stickyGET('selected_item_id');
			$p->item = $item = $p->add('xShop/Model_Item')->tryLoad($item_id);
			
			if(!$item->loaded()) {
				$p->add('View_Error')->set('Item not selceted');
				return;
			}
			
			//Make PredefinedPhase Array
			$p->preDefinedPhase = array();
			foreach ($item->getAssociatedDepartment() as $key => $value) {
				$p->preDefinedPhase[$value] = array();
			}
			$p->existing_values = $_GET['current_json']?json_decode($_GET['current_json'],true):$p->preDefinedPhase;
			// echo print_r($p->existing_values,true);
			// $this->existing_values = $item->getAssociatedDepartment();
			// print_r($this->existing_values);

			if(!$item->loaded()) {
				$p->add('View_Error')->set('item not selcetd');
				return;
			}

			$p->form = $form = $p->add('Form_Stacked');
			$phases = $p->add('xProduction/Model_Phase');
			
			if($qty_cf_only)
				$phases->addCondition('id',$p->add('xHr/Model_Department')->loadStore()->get('id'));

			//Stock Effect Custom Fields
			$secf = $item->stockEffectCustomFields();
			foreach ($secf as $cfassos) {
				$cf = $cfassos->ref('customfield_id');
				$field = $self->addCustomField($cf,$cfassos,"asas~12~Stock Effected Custom Fields", $p,true);
				if(isset($p->existing_values['stockeffectcustomfield'][$cf->id])){
						$field->set($p->existing_values['stockeffectcustomfield'][$cf->id]);
					}				
			}

			//Department Associated CustomFields
			foreach ($phases as $phase) {
			// add all phases
				$group = $phase['production_level']."~12~Level".$phase['production_level'];
				$field_type = 'Checkbox';
				if($qty_cf_only){
					$field_type = 'Readonly';
				}
				$phase_field = $form->addField($field_type,'phase_'.$phase->id,$phase['name'])->setterGetter('group',$group);
				// if item has custome fields for phase & set if editing
				if(isset($p->existing_values[$phase->id]) or $qty_cf_only) {
					$phase_field->set(true);
				}


				$custom_fields_asso = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);
				
				if($qty_cf_only)
					$custom_fields_asso->addCondition('can_effect_stock',true);

				$custom_fields_array=array();
				foreach ($custom_fields_asso as $cfassos) {
					$field = $self->addCustomField($cf = $cfassos->ref('customfield_id'),$custom_fields_asso,$group, $p);
					if(isset($p->existing_values[$phase->id][$cf->id])){
						$field->set($p->existing_values[$phase->id][$cf->id]);
					}

					$custom_fields_array[] = 'custom_field_'.$custom_fields_asso->id;
				}
			}

			$form->addSubmit('Update');

			$custom_fields_asso_values=array();
			
			if($form->isSubmitted()){
				//Check For the Custom Field Value Not Proper
				foreach ($phases as $phase) {
					// echo "phase ".$phase['name'] .'<br>';
					if( $form['phase_'.$phase->id] ){

						$custom_fields_asso = $item->ref('xShop/ItemCustomFieldAssos')->addCondition('department_phase_id',$phase->id);		
						if($qty_cf_only)
							$custom_fields_asso->addCondition('can_effect_stock',true);

						$custom_fields_asso_values [$phase->id]=array();
						foreach ($custom_fields_asso as $cfassos) {
							$cf = $cfassos->ref('customfield_id');
							// echo '$custom_fields_asso = ' . $custom_fields_asso->id . ', ';
							$custom_fields_asso_values [$phase->id][$cf->id] =  $form['custom_field_'.$custom_fields_asso->id];
							if(!$form['custom_field_'.$custom_fields_asso->id])
								$form->displayError('custom_field_'.$custom_fields_asso->id,'Please define custom fields for selected phase');
						}
					}
				}
				

				$selected_phases = array_keys($custom_fields_asso_values);
				
				$purchase_level = $p->add('xHR/Model_Department')->loadPurchase();
				$purchase_level_id = $purchase_level->id;
				$store_level = $p->add('xHR/Model_Department')->loadStore();
				$store_level_id = $store_level->id;
				$dispatch_level = $p->add('xHR/Model_Department')->loadDispatch();
				$dispatch_level_id = $dispatch_level->id;

				// only either purchase or store should be selecetd
				if(in_array($purchase_level_id,$selected_phases) and in_array($store_level_id, $selected_phases)){
					$form->displayError('phase_'.$store_level_id,' Please select either Purchase or Store');
				}

				//If Department Is Purchase then next One Department is Select Compulsary 
				if(in_array($purchase_level_id,$selected_phases) and count($selected_phases)===1){
					$form->displayError('phase_'.$purchase_level_id, ' Purchase cannot be alone seleccted, select any other phase/department');
				}

				//If Department Is Store then next One Department is Select Compulsary
				if(!$qty_cf_only and (in_array($store_level_id,$selected_phases) and !$self->arrayHasBiggerDepartment($selected_phases,$store_level_id))){
					$form->displayError('phase_'.$store_level_id,' Store cannot be alone seleccted, select any other phase/department');
				}

				//If Department Is Dispatch or Dilivey then Previous One Department is Select Compulsary 
				if(in_array($dispatch_level_id,$selected_phases) and !$self->arrayHasSmallerDepartment($selected_phases,$dispatch_level_id)){
					$form->displayError('phase_'.$dispatch_level_id,' Dispatch cannot be alone seleccted, select any other phase/department');
				}

				//Check For the One Department at One Leve
				$level_touched=array();
				foreach ($selected_phases as $ph) {
					if(in_array(($prd_level=$p->add('xHR/Model_Department')->load($ph)->get('production_level')),$level_touched)){
						$form->displayError('phase_'.$ph,' Cannot Select More phases/Departments at a level');
					}
					$level_touched[] = $prd_level;
				}

				//Stock_effect_Custom_fields added into
				$secf = $item->stockEffectCustomFields();
				$custom_fields_asso_values['stockeffectcustomfield']=array();
				foreach ($secf as $cfassos) {
					$cf = $cfassos->ref('customfield_id');
					$custom_fields_asso_values['stockeffectcustomfield'][$cf->id] =  $form['custom_field_'.$cfassos->id];
					// if(!$form['custom_field_'.$cfassos->id])
					// $form->displayError('custom_field_'.$cfassos->id,'Please define custom fields for selected phase');
				}

				$json = json_encode($custom_fields_asso_values);
				$form->js(null,$form->js()->univ()->closeDialog())->_selector('#'.$_GET['custom_field_name'])->val($json)->execute();
			}
			$p->form->add('Controller_FormBeautifier');
		});

	}


	function addCustomField(&$cf, $custom_fields_asso_assos,$group, $page,$mandatory=false){
		$field=null;
		
		switch($cf['type']){
			case "line":
				$field = $page->form->addField('line','custom_field_'.$custom_fields_asso_assos->id , $cf['name'])->setterGetter('group',$group);
			break;
			case "DropDown":
				$field = $drp = $page->form->addField('DropDown','custom_field_'.$custom_fields_asso_assos->id , $cf['name'])->setterGetter('group',$group);
				$values = $page->add('xShop/Model_CustomFieldValue');
				$values->addCondition('item_id',$page->item->id);
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

		if($mandatory)
			$field->validateNotNull(true);

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