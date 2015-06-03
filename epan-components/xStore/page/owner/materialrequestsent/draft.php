<?php

class page_xStore_page_owner_materialrequestsent_draft extends page_xStore_page_owner_main{
	function page_index(){
		// parent::init();
		$di = $this->api->stickyGET('department_id');
		// $this->add('PageHelp',array('page'=>'materialrequestsent_draft'));

		$model = $this->add('xStore/Model_MaterialRequestSent_Draft');
		$model->addCondition('from_department_id',$di);

		$crud=$this->add('CRUD',array('grid_class'=>'xStore/Grid_MaterialRequest'));
		$crud->setModel($model,array('to_department_id'),array('to_department'));
		
		// $ic = $crud->addRef('xStore/MaterialRequestItem',array('label'=>'Items'));
		$editing_mode = $crud->isEditing();
		if($editing_mode === 'add' OR $editing_mode ==='edit'){
			$crud->form->getElement('to_department_id')->getModel()->addCondition('id','<>',$this->api->current_department->id);
		}else{
			$crud->grid->addColumn('expander','items');
		}

		$crud->add('xHR/Controller_Acl');
		// $this->add('xStore/View_StockMovement',array('stockmovement'=>$this->add('xStore/Model_StockMovement')->load(1)));
	}
	

	function page_items(){
        $mr_id = $this->api->stickyGET('xstore_material_request_id');
		$dummy_item = $this->add('xShop/Model_Item');

		$crud = $this->add('CRUD');
        $mr_item=$this->add('xStore/Model_MaterialRequestItem');
        $mr_item->addCondition('material_request_jobcard_id',$mr_id);

        $crud->setModel($mr_item);
        // $crud->add('xHR/Controller_Acl');

        if($crud->isEditing()){
        	$item_field = $crud->form->getElement('item_id');
        	$item_field->custom_field_element= 'custom_fields';
        	$item_field->qty_effected_custom_fields_only = true;
        }

        
        if(!$crud->isEditing()){
        	$crud->grid->addMethod('format_readable',function($g,$f)use($dummy_item){
        		$g->current_row_html[$f]  = $dummy_item->genericRedableCustomFieldAndValue($g->model['custom_fields']);
        	});
        	$crud->grid->addFormatter('custom_fields','readable');
        }
        $crud->grid->removeColumn('created_by');
        $crud->grid->removeColumn('material_request_jobcard');
        $crud->grid->removeColumn('item');

        $crud->grid->addOrder()->move('unit','before','narration')->now();
	}


}