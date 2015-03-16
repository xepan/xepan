<?php

class page_xStore_page_owner_materialrequestsent_draft extends page_xStore_page_owner_main{
	function page_index(){
		// parent::init();
		$di = $this->api->stickyGET('department_id');
		$this->add('PageHelp',array('page'=>'materialrequestsent_draft'));

		$model = $this->add('xStore/Model_MaterialRequestSent_Draft');
		$model->addCondition('from_department_id',$di);

		$crud=$this->add('CRUD');
		$crud->setModel($model,array('to_department_id'),array('to_department'));
		
		// $ic = $crud->addRef('xStore/MaterialRequestItem',array('label'=>'Items'));
		$editing_mode = $crud->isEditing();
		if($editing_mode === 'add' OR $editing_mode ==='edit'){
			$crud->form->getElement('to_department_id')->getModel()->addCondition('id','<>',$this->api->current_department->id);
		}else{
			$crud->grid->addColumn('expander','items');
		}

		// $p=$crud->addFrame('Details', array('icon'=>'plus'));
		// if($p){
		// 	$p->add('xProduction/View_Jobcard',array('jobcard'=>$this->add('xProduction/Model_JobCard')->load($crud->id)));
		// }
		
		$crud->add('xHR/Controller_Acl');
	}
	

	function page_items(){
        $mr_id = $this->api->stickyGET('xstore_material_request_id');
		
		$crud = $this->add('CRUD');
        $mr_item=$this->add('xStore/Model_MaterialRequestItem');
        $mr_item->addCondition('material_request_jobcard_id',$mr_id);

        $crud->setModel($mr_item);
        // $crud->add('xHR/Controller_Acl');

        if($crud->isEditing()){
        	$item_field = $crud->form->getElement('item_id');
            $f = $item_field->other_field;
            $custom_fields_field = $crud->form->getElement('custom_fields');
            // $custom_fields_field->js(true)->hide();
            
            $btn = $item_field->other_field->belowField()->add('Button')->set('CustomFields');
            $btn->js('click',$this->js()->univ()->frameURL('Custome Field Values',array($this->api->url('xStore_page_owner_materialrequestsent_customfields',array('orderitem_id'=>$crud->id,'custom_field_name'=>$crud->form->getElement('custom_fields')->name)),"selected_item_id"=>$item_field->js()->val(),'current_json'=>$custom_fields_field->js()->val())));
        }

	}


}