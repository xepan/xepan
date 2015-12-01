<?php

class page_xMarketingCampaign_page_owner_tele_campaign extends page_xMarketingCampaign_page_owner_main{

	function page_index(){
		// parent::init();

		$model = $this->add('xMarketingCampaign/Model_Tele_Campaign');
		$model->addExpression('total_leads')->set(function($m,$q){
			return 10;
		});

		$model->addExpression('today_leads')->set(function($m,$q){
			return 20;
		});

		$model->addExpression('today_followups')->set(10);

		$model->addExpression('overdue_followups')->set(function($m,$q){
			return 10;
		});

		$crud  = $this->add('CRUD');
		$crud->setModel($model,array('name','created_at'));
		$crud->grid->addFormatter('name','campaign_link');

		if(!$crud->isEditing()){
			$crud->grid->addMethod('format_campaign_link',function($g,$f){
    			$g->current_row_html[$f]= '<a href="'.$this->api->url('xMarketingCampaign/page_owner_tele_playground',['telecampaign_id'=>$g->model['id']]).'">'.$g->model['name'].'</a>'.'<div>'.$g->model['total_leads'].' Total Leads, '.$g->model['today_leads'].' today new leads: '.$g->model['today_followups'].' follow-ups today, '.$g->model['overdue_followups'].' overdue follow-ups</div>';
    		});

    		$crud->grid->addColumn('expander','leads');
		}
		
	}

	function page_leads(){
		$telecampaign_id = $this->api->stickyGET('xmarketingcampaign_tele_campaigns_id');
	
		$this->add('View_Info')->set('Add Lead to Campaign');
		$asso_model = $this->add('xMarketingCampaign/Model_Tele_CampLeadAsso')->addCondition('telecampaign_id',$telecampaign_id);
		$crud = $this->add('CRUD');

		$crud->setModel($asso_model);
		$grid = $crud->grid;
		if($crud->isEditing()){
			$crud->form->getElement('telelead_id')->getModel()->addCondition('telecampaign_id','>',0);
		}

		if(!$crud->isEditing()){
			$grid->addColumn('Button');

		}

		$crud->grid->addPaginator(5);

	}


}