<?php

class page_xShop_page_owner_item_qtyandprice extends page_xShop_page_owner_main{

	function init(){
		parent::init();
		$this->api->stickyGET('item_id');
	}
	
	function page_index(){
		$item = $this->add('xShop/Model_Item')->load($this->api->stickyGET('item_id'));
		// $this->add('View_Info')->set('Display Basic Price For Item Here Again As Form .. updatable');
		
		$form = $this->add('Form_Stacked');
		$form->setModel($item,array('original_price','sale_price','minimum_order_qty','maximum_order_qty','qty_unit','qty_from_set_only'));
		$form->addSubmit()->set('Update');

		if($form->isSubmitted()){
			$form->update();
			$form->js(null,$this->js()->reload())->univ()->successMessage('Item Updtaed')->execute();
		}
		$form->add('Controller_FormBeautifier');

		$crud = $this->add('CRUD');
		$crud->setModel($item->ref('xShop/QuantitySet')->setOrder(array('custom_fields_conditioned desc','qty desc','is_default asc')),array('name','qty','price'),array('name','qty','old_price','price','is_default','custom_fields_conditioned'));
		

		if(!$crud->isEditing()){
			$g = $crud->grid;
		
			$upl_btn=$g->addButton('Upload Data');
			$upl_btn->setIcon('ui-icon-arrowthick-1-n');
			$upl_btn->js('click')->univ()->frameURL('Data Upload',$this->api->url('./upload',array('item_id'=>$_GET['item_id'])));
		
			$g->addColumn('expander','conditions');

			$g->addMethod('format_image_thumbnail',function($g,$f){
				if($g->model['is_default']){
					$g->current_row_html[$f] = "";
				}
			});

			$g->addFormatter('conditions','image_thumbnail');
			$g->addFormatter('edit','image_thumbnail');
			$g->addFormatter('delete','image_thumbnail');
		}
	}

	function page_conditions(){
		$item_id = $this->api->stickyGET('item_id');

		$item_model = $this->add('xShop/Model_Item')->load($_GET['item_id']);
        $application_id = $this->api->recall('xshop_application_id');
		$qs_id = $this->api->stickyGET('xshop_item_quantity_sets_id');
		
		$qty_set_condition_model = $this->add('xShop/Model_QuantitySetCondition')
							->addCondition('quantityset_id',$qs_id);

		$crud = $this->add('CRUD');
		$crud->setModel($qty_set_condition_model,array('quantityset_id','custom_field_value_id','customfield_id'),array('quantityset','custom_field_value','customfield'));//,array('custom_field_value_id'),array('custom_field_value'));

        /*
            Get All item's custom fields and let select its value
            Must have extra value called '*' or Any
           
        */    
        if($crud->isEditing()){
            $custom_values_model = $crud->form->getElement('custom_field_value_id')->getModel();
			$custom_values_model->addCondition('item_id',$item_id)
						->addCondition('is_active',true);
        }
	}

	function page_upload(){
		$item_id = $this->api->stickyGET('item_id');
		$form = $this->add('Form');
		$form->addField('line','custom_fields')->setFieldHint('Enter comma separated custom fields');
		$form->addSubmit('Generate Sample File');
		
		if($_GET[$this->name]){
			$output=array("Qty");
			foreach (explode(",", $_GET[$this->name]) as $cfs) {
				$output[] = trim($cfs);
			}
			$output[] = "Price";

			$output = implode(",", $output);
	    	header("Content-type: text/csv");
	        header("Content-disposition: attachment; filename=\"sample_qty_set_file.csv\"");
	        header("Content-Length: " . strlen($output));
	        header("Content-Transfer-Encoding: binary");
	        print $output;
	        exit;
		}

		if($form->isSubmitted()){
			$form->js()->univ()->location($this->api->url(null,array($this->name=>$form['custom_fields'])))->execute();
		}

		// $form = $this->add('Form',array('js_widget'=>null));
		// $x=$form->addField('upload','csv_qty_set_file')->setMode('plain');
		// $form->addSubmit("Upload");

		// if($form->isSubmitted()){

		// 	throw new \Exception($_FILES[$x->name]['type'], 1);
		// 	echo $this->js(true)->univ()->closeDialog();
		// 	exit;
		// }

		$this->add('View')->setElement('iframe')->setAttr('src',$this->api->url('./execute',array('cut_page'=>1,'item_id'=>$_GET['item_id'])))->setAttr('width','100%');
	}

	function page_upload_execute(){
		$item_id = $this->api->stickyGET('item_id');
		
		$form= $this->add('Form');
		$form->template->loadTemplateFromString("<form method='POST' action='".$this->api->url(null,array('cut_page'=>1,'item_id'=>$_GET['item_id']))."' enctype='multipart/form-data'>
			<input type='file' name='csv_qty_set_file'/>
			<label> Remove old qty sets <input type='checkbox' name='remove_old'/></label>
			<input type='submit' value='Upload'/>
			</form>"
			);

		if($_FILES['csv_qty_set_file']){
			if ( $_FILES["csv_qty_set_file"]["error"] > 0 ) {
				$this->add( 'View_Error' )->set( "Error: " . $_FILES["csv_qty_set_file"]["error"] );
			}else{
				if($_FILES['csv_qty_set_file']['type'] != 'text/csv'){
					$this->add('View_Error')->set('Only CSV Files allowed');
					return;
				}

				$importer = new CSVImporter($_FILES['csv_qty_set_file']['tmp_name'],true,',');
				$data = $importer->get(); 
				$item = $this->add('xShop/Model_Item')->load($_GET['item_id']);

				if($_POST['remove_old']){
					// Remove all Quantity sets if said so
					// TODO
					$qs = $this->add('xShop/Model_QuantitySet');
					$qs->addCondition('item_id',$item->id);

					foreach ($qs as $junk) {
						$qs->forceDelete();
					}
				}

				foreach ($data as $row) { // field like Qty ... Cst 1, Cst 2 ... Price
					// take qty and price and enter a condition set row 
					// $nqs = (unset qty, price and continue) xShop/QuantitySet
					$qs = $this->add('xShop/Model_QuantitySet');
					$qs['item_id'] = $item->id;
					$qs['qty'] = $row['Qty'];
					$qs['price'] = $row['Price'];
					$qs->save();
					unset($row['Qty']);
					unset($row['Price']);

					// Take rest of fields for making conditions in this set 
					foreach ($row as $field => $value) {
						// $ncf = Create/Load new Custom field If not exists $field xShop/Model_CustomFields
						$cf = $this->add('xShop/Model_CustomFields')
							->addCondition('name',$field)
							->addCondition('application_id',$this->api->xshop_application_id())
							->tryLoadAny();
						if(!$cf->loaded()) $cf->save();

						$icassos = $this->add('xShop/Model_ItemCustomFieldAssos')
										->addCondition('customfield_id',$cf->id)
										->addCondition('item_id',$item->id)
										->addCondition('can_effect_stock',true)
										->tryLoadAny();

						if(!$icassos->loaded()) $icassos->save();
						
						if(!$value) continue;

						// $ncfv = check if its $value is added for current item, if not add xShop/Model_CustomFieldValue
						$iassoscfval = $this->add('xShop/Model_CustomFieldValue')
										->addCondition('itemcustomfiledasso_id',$icassos->id)
										->addCondition('customfield_id',$cf->id)
										->addCondition('item_id',$item->id)
										->addCondition('name',trim($value))
										->tryLoadAny();

						if(!$iassoscfval->loaded()) $iassoscfval->save();
						// add condition if not exists xShop/Model_QuantitySetCondition


						$qscond = $this->add('xShop/Model_QuantitySetCondition')
										->addCondition('quantityset_id',$qs->id)
										->addCondition('custom_field_value_id',$iassoscfval->id)
										->addCondition('customfield_id',$cf->id)
										->addCondition('item_id',$item->id)
										->tryLoadAny();

						if(!$qscond->loaded())
							$qscond->save();
					}
				}
				
				$this->add('View_Info')->set(count($data).' Recored Imported');
				$this->js(true)->univ()->closeDialog();
			}
		}
	
	}

}