<?php

class page_xShop_page_owner_item_account extends page_xShop_page_owner_main{
	function page_index(){
		// parent::init();

		if(!$_GET['item_id'])
			return;
		$item_id = $this->api->stickyGET('item_id');

		$tab = $this->add('Tabs');
		$tab->addTabURL('./taxs','Tax');
	}


	function page_taxs(){
		$this->api->stickyGET('item_id');
		$crud =	$this->add('CRUD');
		$itm_tax_asso = $this->add('xShop/Model_ItemTaxAssociation')->addCondition('item_id',$_GET['item_id']);
		$crud->setModel($itm_tax_asso,array('tax_id','name'),array('tax','name'));

		//JS Change Event Not Working
		// if($crud->isEditing()){
		// 	// $tax = $this->add('xShop/Model_Tax');
		// 	// $tax_field = $crud->form->getElement('tax_id');
		// 	// $name_field = $crud->form->getElement('name');
		// 	// if($_GET['tax_id']){
		// 	// 	$tax = $this->add('xShop/Model_Tax')->load($_GET['tax_id']);
		// 	// 	echo $name_field->js(true)->val($tax['value']);//->execute();
		// 	// 	exit;
		// 	// }

		// 	// //TODO Change Event Value Filled
		// 	// $tax_field->other_field->js('change',
		// 	// 	$name_field->js()->reload(array(
		// 	// 		'tax_id'=>$tax_field->js()->val()
		// 	// 		))
		// 	// 	);
		// }

	}


}		