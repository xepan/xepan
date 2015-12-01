<?php

class page_xMarketingCampaign_page_owner_tele_campaign extends page_xMarketingCampaign_page_owner_main{

	function page_index(){
		// parent::init();

		$model = $this->add('xMarketingCampaign/Model_Tele_Campaign');
		$model->addExpression('total_leads')->set(function($m,$q){
			
		});

		$model->addExpression('today_leads')->set(function($m,$q){
			$l = $m->add('xMarketingCampaign/Model_Tele_Lead');
			$l->addCondition('telecampaign_id',$m->id)->addCondition('created_at',$this->api->today);
			return $l->count()->getOne()?:0;
		});

		$model->addExpression('today_followups')->set('10');

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

		$col = $this->add('Columns');
		$col1 = $col->addColumn('6');
		$col2 = $col->addColumn('6');

		$col1->add('View_Info')->set('Create New Telecalling Lead');
		$lead_model = $col1->add('xMarketingCampaign/Model_Tele_Lead')->addCondition('telecampaign_id',$telecampaign_id);
		$lead_model->setOrder('id','desc');
		$crud = $col1->add('CRUD');
		$crud->setModel($lead_model,array('name','phone','mobile_no','email'));
		$crud->grid->addPaginator(5);

	
		// $col2->add('View_Info')->set('Add Lead to Campaign');
		// $asso_model = $col2->add('xMarketingCampaign/Model_Tele_CampLeadAsso')->addCondition('telecampaign_id',$telecampaign_id);
		// $crud = $col2->add('CRUD');
		// if($crud->isEditing()){
		// 	$crud->grid->model()->ref('telecampaign_id')->addCondition('telecampaign_id','>',0);
		// }

		// $crud->setModel($asso_model);
		// $crud->grid->addPaginator(5);

	}


}