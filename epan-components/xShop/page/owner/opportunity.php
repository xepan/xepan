<?php
class page_xShop_page_owner_opportunity extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Oppertunities';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Oppertunities Management <small> Manage your sales Oppertunities </small>');
		
		$oppertunity_model = $this->add('xShop/Model_Opportunity');

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Opportunity'));
		$crud->setModel($oppertunity_model,array('name','opportunity','lead','customer','status','created_date','created_by','updated_at'));


		if(!$crud->isEditing()){
			$grid =  $crud->grid;
			// $grid->addColumn('text','last_contacted');
			// $grid->removeColumn('lead');
			// $grid->removeColumn('customer');
		}
		// $crud->grid->addQuickSearch(array('name','created_by','status'));
		// $crud->grid->addPaginator($ipp=50);

		$crud->add('xHR/Controller_Acl');
		$p=$crud->addFrame('quotation',array('icon'=>'plus'));
		
		if($p){
			
			$model_quotation=$p->add('xShop/Model_Quotation');
			$model_quotation->addCondition('opportunity_id',$crud->id);

			$c = $p->add('CRUD',array('grid_class'=>'xShop/Grid_Quotation'));

			if($c->isEditing()){
				
				$oppertunity_model->load($crud->id);			
				if($oppertunity_model['lead_id']){
					$model_quotation->addCondition('lead_id',$oppertunity_model['lead_id']);
					$model_quotation->getElement('customer_id')->system(true);
				}

				if($oppertunity_model['customer_id']){
					$model_quotation->addCondition('customer_id',$oppertunity_model['customer_id']);
					$model_quotation->getElement('lead_id')->system(true);
				}
			}
			
			$c->setModel($model_quotation);
	
		}
	}
}	

