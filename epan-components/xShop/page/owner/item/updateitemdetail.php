<?php

class page_xShop_page_owner_item_updateitemdetail extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		
		if(!$_GET['item_id'])
			return;
		
		$this->api->stickyGET('inherit_parent');

		$this->api->stickyGET('item_id');
		
		$selected_item_model = $this->add('xShop/Model_Item')->load($_GET['item_id']);	
		if($_GET['inherit_parent'])
			$selected_item_model = $this->add('xShop/Model_Item')->load($selected_item_model['duplicate_from_item_id']);


		if(!$selected_item_model->loaded())
			return;
		
		$form = $this->add('Form_Stacked');
		$update_detail=$form->addField('DropDown','update_detail')
										->setValueList(array(
														'Specification'=>'Specification','CustomField'=>'Custom Field',
														'qtyandprice'=>'Qty & Price','categoryitem'=>'Categories',
														'itemimages'=>'Item Images','item_tex'=>'Item Taxes',
														'item_dept'=>'Item Department','All'=>'All'))->setEmptyText('Please Select');
		// $form->setModel($selected_item_model,array('designer_id','name','sku','is_publish','is_party_publish','short_description','rank_weight','created_at','expiry_date','is_saleable','allow_uploadedable','is_purchasable','is_productionable','is_servicable','website_display','is_downloadable','is_designable','mantain_inventory','allow_negative_stock','is_enquiry_allow','is_template','is_fixed_assest','warrenty_days','show_detail','show_price','new','feature','latest','mostviewed','is_visible_sold','offer_id','offer_position','allow_comments','comment_api','add_custom_button','custom_button_label','custom_button_url','reference','theme_code','description','terms_condition'));
		$form->addSubmit()->set('Update');		

		if($form->isSubmitted()){

			if($_GET['inherit_parent']){
				$childs = $this->add('xShop/Model_Item')->addCondition('id',$_GET['item_id']);
			}else
				$childs = $this->add('xShop/Model_Item')->addCondition('duplicate_from_item_id',$selected_item_model->id);

			foreach ($childs as $item) {

				if($form['update_detail']=='Specification' Or $form['update_detail']=='All') {
					//Delete All Previous Specification Association
					$item->deleteSpecificationAsso();
					// throw new \Exception($item->id, 1);
					$old_specification = $this->add('xShop/Model_ItemSpecificationAssociation')->addCondition('item_id',$selected_item_model->id);
					$old_specification->duplicate($item['id']);
				}

				if($form['update_detail']=='CustomField' Or $form['update_detail']=='All') {
					$item->deleteCustomField();

					$old_customfield = $this->add('xShop/Model_ItemCustomFieldAssos')->addCondition('item_id',$selected_item_model->id);
					foreach ($old_customfield as $junk){
						$new_customfield = $old_customfield->duplicate($item['id']);
						//New Custom Field Association with old Vlaues
						$old_custom_value = $this->add('xShop/Model_CustomFieldValue')->addCondition('itemcustomfiledasso_id',$old_customfield['id']);
						foreach ($old_custom_value as $junk){
							$new_custom_value = $old_custom_value->duplicate($new_customfield['id'],$item['id']);
							$new_custom_value->unload();
						}
							$new_customfield->unload();
					}
				}

				if($form['update_detail']=='qtyandprice' Or $form['update_detail']=='All') {					
					$item->deleteqtyandpriceAsso();
					$old_qtyandprice = $this->add('xShop/Model_QuantitySet')->addCondition('item_id',$selected_item_model->id)->addCondition('is_default',false);
					
					foreach ($old_qtyandprice as $model){
						$new_qtyandprice = $model->duplicate($item['id']);
					}
					
					$item->updateDefaultQuantitySet();

				}

				if($form['update_detail']=='categoryitem' Or $form['update_detail']=='All') {
					//Delete All Previous Specification Association
					$item->deleteCategoryItemasso();
					// throw new \Exception($item->id, 1);
					$cat_item_asso = $this->add('xShop/Model_CategoryItem')->addCondition('item_id',$selected_item_model->id);
					$cat_item_asso->duplicate($item['id']);
				}

				if($form['update_detail']=='itemimages' Or $form['update_detail']=='All') {
					//Delete All Previous Specification Association
					$item->deleteItemImageasso();
					// throw new \Exception($item->id, 1);
					$image = $this->add('xShop/Model_ItemImages')->addCondition('customefieldvalue_id',Null)->addCondition('item_id',$selected_item_model->id);
					$image->duplicate($item['id']);
				}

				if($form['update_detail']=='item_tex' Or $form['update_detail']=='All') {
					//Delete All Previous Specification Association
					$item->deleteItemTaxasso();
					// throw new \Exception($item->id, 1);
					$old_tax_asso = $this->add('xShop/Model_ItemTaxAssociation')->addCondition('item_id',$selected_item_model->id);
					foreach ($old_tax_asso as $junk) {
						$old_tax_asso->duplicate($item['id']);
					}
		
				}

				if($form['update_detail']=='item_dept' Or $form['update_detail']=='All') {
					//Delete All Previous Specification Association
					$item->deleteItemDepartmentAsso();
					// throw new \Exception($item->id, 1);
					$department_ass_model = $this->add('xShop/Model_ItemDepartmentAssociation')->addCondition('item_id',$selected_item_model->id);
					$department_ass_model->duplicate($item['id']);
		
				}
			}

			$form->js()->univ()->successMessage('Item Update Successfully')->execute();
		}


	}
}