<?php

class page_xShop_page_owner_quotation_draft extends page_xShop_page_owner_main{

	function page_index(){

		$draft_quotation_model = $this->add('xShop/Model_Quotation_Draft');

		$draft_quotation_model->getElement('opportunity_id')->system(true);

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Quotation'));
		$crud->setModel($draft_quotation_model);

		$crud->add('xHR/Controller_Acl');

		// $this->add('xShop/View_Quotation',array('quotation'=>$this->add('xShop/Model_Quotation')->load(2)));
		}

	}

