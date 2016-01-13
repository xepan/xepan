<?php

class page_xShop_page_owner_item_attributes extends page_xShop_page_owner_main{
	function page_index(){
		if(!$_GET['item_id'])
			return;
		
		$this->api->stickyGET('item_id');
		
		$tabs = $this->add('Tabs');
		$tabs->addTabURL('./specification','Specification');
		$tabs->addTabURL('./customfields','CustomFields');
		$tabs->addTabURL('./stockcustomfields','StockEffectCustomFieds');
		$tabs->addTabURL('./filter','filter');
	}

	function page_filter(){
		$itemid=$this->api->stickyGET('item_id');
		// throw new \Exception($_GET['item_id'], 1);
		$item = $this->add('xShop/Model_Item')->load($_GET['item_id']);

		$filter = $this->add('xShop/Model_Filter');
		$filter->addCondition('item_id',$_GET['item_id']);
		$crud = $this->add('CRUD');
		$crud->setModel($filter);
	}

	function page_specification(){
		$item_id=$this->api->stickyGET('item_id');
		$item = $this->add('xShop/Model_Item')->load($item_id);

		$crud = $this->add('CRUD');
		$crud->setModel($item->ref('xShop/ItemSpecificationAssociation'));
	}

	function page_customfields(){
		$item_id=$this->api->stickyGET('item_id');
		$application_id = $this->api->recall('xshop_application_id');
		
		$item_model = $this->add('xShop/Model_Item')->load($item_id);
		
		$custom_fields = $this->add('xShop/Model_ItemCustomFieldAssos');
		$custom_fields->addCondition('item_id',$item_id)
					->addCondition('can_effect_stock',false)
					->addCondition('department_phase_id','<>',null);
		$dept_j = $custom_fields->leftJoin('xhr_departments','department_phase_id');
		$dept_j->addField('production_level');
		$custom_fields->setOrder("department_phase_id,production_level");

		$custom_fields->tryLoadAny();



		$crud = $this->add('CRUD');
		$crud->setModel($custom_fields,array('department_phase_id','customfield_id','rate_effect','is_active'),array('department_phase','customfield','rate_effect','is_active'));
		if($crud->form){
			$crud->form->getElement('customfield_id')->getModel()->addCondition('application_id',$application_id);
		}
		if(!$crud->isEditing()){	
			$g = $crud->grid;
			$crud->grid->addColumn('expander','values');
			
			$g->addMethod('format_values',function($g,$f){
				$temp = $g->add('xShop/Model_CustomFieldValue')->addCondition('itemcustomfiledasso_id',$g->model->id)->tryLoadAny();
				$str = "";
				if($temp->count()->getOne())
					$str = '<span class=" atk-label atk-swatch-green">'.$temp->count()->getOne()."</span>";
				
				$g->current_row_html[$f] = $g->current_row_html[$f].$str;
				if($g->model->ref('customfield_id')->get('type') == 'line')
					$g->current_row_html[$f] = " ";
			});

			$g->addFormatter('values','values');
		}
	}

	function page_customfields_values(){
		$item_id=$this->api->stickyGET('item_id');
		$custom_field_asso_id = $this->api->stickyGET('xshop_item_customfields_assos_id');

		$custom_feild_values_model = $this->add('xShop/Model_CustomFieldValue')->addCondition('itemcustomfiledasso_id',$custom_field_asso_id)->tryLoadAny();
		$custom_feild_values_model->setOrder('name');
		$crud = $this->add('CRUD');
		$crud->setModel($custom_feild_values_model,array('name','rate_effect'));

		// $crud->grid->addColumn('expander','images');
		$crud->grid->addColumn('expander','filter');
	}

	function page_customfields_values_images(){
		$item_id=$this->api->stickyGET('item_id');
		$custom_filed_value_id = $this->api->stickyGET('xshop_custom_fields_value_id');

		$image_model = $this->add('xShop/Model_ItemImages')
					->addCondition('customefieldvalue_id',$custom_filed_value_id)
					->addCondition('item_id',$item_id)
					->tryLoadAny();
		
		$crud = $this->add('CRUD');
		$crud->setModel($image_model,array('item_image_id','alt_text','title'),array('item_image','alt_text','title'));
		if(!$crud->isEditing()){
			$g = $crud->grid;
			$g->addMethod('format_image_thumbnail',function($g,$f){
				$g->current_row_html[$f] = '<img style="height:40px;max-height:40px;" src="'.$g->current_row[$f].'"/>';
			});
			$g->addFormatter('item_image','image_thumbnail');
			$g->addQuickSearch(array('category_name'));
			$g->addPaginator($ipp=50);
		}
	}

	function page_customfields_values_filter(){
		$item_id=$this->api->stickyGET('item_id');
		
		$custom_field_asso_id=$this->api->stickyGET('xshop_item_customfields_assos_id');
		$application_id = $this->api->recall('xshop_application_id');

		$custom_filed_value_id = $this->api->stickyGET('xshop_custom_fields_value_id');
		
		$filter_model = $this->add('xShop/Model_CustomFieldValueFilterAssociation');

		$crud = $this->add('CRUD');
		//for Custom Field Id
		$temp = $this->add('xShop/Model_ItemCustomFieldAssos');
		$associated_customfiled = $temp->addCondition('item_id',$item_id)->addCondition('id','<>',$custom_field_asso_id)->_dsql()->del('fields')->field('customfield_id')->getAll();
		$associated_customfiled = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_customfiled)),false);
		// ----------------------
		$filter_model->addCondition('item_id',$item_id);		
		$filter_model->addCondition('customefieldvalue_id',$custom_filed_value_id);
		$crud->setModel($filter_model,array('customfield_id','name'),array('customfield','name'));
		
		if($crud->form){
			$form_model = $crud->form->getElement('customfield_id')->getModel();
			$form_model->addCondition('application_id',$application_id);
			if(count($associated_customfiled) > 0)
				$form_model->addCondition('id','in',$associated_customfiled);
			else
				$form_model->addCondition('id',-1);
		}
	}

	function page_stockcustomfields(){

		$item_id=$this->api->stickyGET('item_id');
		$application_id = $this->api->recall('xshop_application_id');
		
		$item_model = $this->add('xShop/Model_Item')->load($item_id);
		
		$custom_fields = $this->add('xShop/Model_ItemCustomFieldAssos');
		$custom_fields->addCondition('item_id',$item_id)
						->addCondition('can_effect_stock',true)
						->addCondition('department_phase_id',null);
		$custom_fields->tryLoadAny();

		$stock_effetc_crud = $this->add('CRUD');
		$stock_effetc_crud->setModel($custom_fields,array('customfield_id','is_active'),array('customfield','is_active'));
		if($stock_effetc_crud->form){
			$stock_effetc_crud->form->getElement('customfield_id')->getModel()->addCondition('application_id',$application_id);
		}
		$stock_effetc_crud->grid->addColumn('expander','values');
		if(!$stock_effetc_crud->isEditing()){	
			$g = $stock_effetc_crud->grid;
			$g->addMethod('format_values',function($g,$f){
				$temp = $g->add('xShop/Model_CustomFieldValue')->addCondition('itemcustomfiledasso_id',$g->model->id)->tryLoadAny();
				$str = "";
				if($temp->count()->getOne())
					$str = '<span class=" atk-label atk-swatch-green">'.$temp->count()->getOne()."</span>";
							
				$g->current_row_html[$f] = $g->current_row_html[$f].$str;
			});
			$g->addFormatter('values','values');
		}
	}


	function page_stockcustomfields_values(){
		$item_id=$this->api->stickyGET('item_id');
		$custom_field_asso_id = $this->api->stickyGET('xshop_item_customfields_assos_id');

		$custom_feild_values_model = $this->add('xShop/Model_CustomFieldValue')->addCondition('itemcustomfiledasso_id',$custom_field_asso_id)->tryLoadAny();
		$crud = $this->add('CRUD');
		$crud->setModel($custom_feild_values_model,array('name','rate_effect'));

		// $crud->grid->addColumn('expander','images');
		// $crud->grid->addColumn('expander','filter');
	}

}
