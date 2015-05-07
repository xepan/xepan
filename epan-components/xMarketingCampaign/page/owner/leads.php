<?php

class page_xMarketingCampaign_page_owner_leads extends page_xMarketingCampaign_page_owner_main{
	
	function page_index(){
			$this->app->title=$this->api->current_department['name'] .': Leads';
			$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> xMarketingCampaign Leads <small> Manage Your Leads </small>');
		// Add Badges

		// filter line if filter is there
		$col=$this->add('Columns');
		$cat_col=$col->addColumn(3);	
		$lead_col=$col->addColumn(9);


		$lead_cat_model=$this->add('xMarketingCampaign/Model_LeadCategory');

		$lead_cat_crud=$cat_col->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_LeadCategory'));
		$lead_cat_crud->setModel($lead_cat_model);
		$lead_cat_crud->add('xHR/Controller_Acl');


		if(!$lead_cat_crud->isEditing()){
			$g=$lead_cat_crud->grid;
			$g->addMethod('format_filterleads',function($g,$f)use($lead_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $lead_col->js()->reload(array('leadcategory_id'=>$g->model->id)) .'">'.$g->current_row[$f].'</a>';
			});
			$g->addFormatter('name','filterleads');
			$g->add_sno();
		}
		
		if($_GET['leadcategory_id']){
			$this->api->stickyGET('leadcategory_id');
			
			$selected_cat = $this->add('xMarketingCampaign/Model_LeadCategory')->load($_GET['leadcategory_id']);

			$filter_box = $lead_col->add('View_Box')->setHTML('Lead Category :: '.$this->add('xMarketingCampaign/Model_LeadCategory')->load($_GET['leadcategory_id'])->get('name'));
			$filter_box->add('Icon',null,'Button')
            ->addComponents(array('size'=>'mega'))
            ->set('cancel-1')
            ->addStyle(array('cursor'=>'pointer'))
            ->on('click',function($js) use($filter_box,$lead_col) {
                $filter_box->api->stickyForget('leadcategory_id');
                return $filter_box->js(null,$lead_col->js()->reload())->hide()->execute();
            });

        }    

		$lead_cat_crud->grid->addQuickSearch(array('name'));
		$lead_cat_crud->grid->addPaginator($ipp=50);
		
		$lead_cat_id= $this->api->stickyGET('leadcategory_id');
		// $cat_id=$this->add('xMarketingCampaign/Model_LeadCategory')->load($lead_cat_id);

		$leads=$lead_col->add('xMarketingCampaign/Model_Lead');
		if($_GET['leadcategory_id'])
			$leads->addCondition('leadcategory_id',$_GET['leadcategory_id']);
		// $leads->addCondition('source','DataFeed');
		// $leads->addCondition('source_id','0');




		$crud=$lead_col->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_Lead'));
		$crud->setModel($leads,array(),array());
		$crud->add('xHR/Controller_Acl');

		

	}
}