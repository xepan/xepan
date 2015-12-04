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
		$self=$this;
		
		$telecampaign_id = $this->api->stickyGET('xmarketingcampaign_tele_campaigns_id');
		

		$form = $this->add('Form_Stacked');
		$form->setModel('xMarketingCampaign/Model_Tele_Lead');
		$form->addSubmit('Add Lead');

		$grid = $this->add('Grid');

		if($form->isSubmitted()){
			$form->save();
			$form->model->association($telecampaign_id);
			// $this->add('xMarketingCampaign/Model_Tele_Lead')->load($form->model->id)->association($telecampaign_id);

			$form->js(null,$grid->js()->reload())->univ()->successMessage('lead associated successfully')->execute();
		}

		$lead_model = $this->add('xMarketingCampaign/Model_Tele_Lead');
		$lead_asso_j = $lead_model->join('xmarketingcampaign_tele_campaign_lead_asso.telelead_id');
		$lead_asso_j->addField('telecampaign_id');
		$lead_model->addCondition('telecampaign_id',$telecampaign_id);

		$grid->setModel($lead_model,array('name','email','phone','mobile_no','created_at'));
		$grid->add('xHR/Controller_Acl');

		// $followupvp = $this->add('VirtualPage')->set(function($p)use($self){
		// $asso_id = $p->api->stickyGET('tele_camp_lead_asso');
		// 	$lead_id = $p->api->stickyGET('lead_id');
		// 	$camp_id = $p->api->stickyGET('campaign_id');
		// 	$asso_model = $p->add('xMarketingCampaign/Model_Tele_Followups')->addCondition('telecampleadasso_id',$asso_id);
		// 	$asso_model->addCondition('telecampaign_id',$camp_id);
		// 	$asso_model->addCondition('telelead_id',$lead_id);

		// 	$p->add('CRUD')->setModel($asso_model);
		// });

	
		// $this->add('View_Info')->set('Add Lead to Campaign');
		// $asso_model = $this->add('xMarketingCampaign/Model_Tele_CampLeadAsso')->addCondition('telecampaign_id',$telecampaign_id);
		
		// $crud = $this->add('CRUD');
		// $grid = $crud->grid;

		// $crud->setModel($asso_model);
		// $grid->addColumn('Button','followup');
		// $grid->addFormatter('followup','followup');
		
		// if($crud->isEditing()){
		// 	$crud->form->getElement('telelead_id')->getModel()->addCondition('telecampaign_id','>',0);
		// }

		// if(!$crud->isEditing()){
		// 	$grid->addMethod('format_followup',function($g,$f)use($followupvp){
  //   			$g->current_row_html[$f]= '<a href="#na" onclick="javascript:'.$g->js()->univ()->frameURL('Follow ups',$this->api->url($followupvp->getURL(),['tele_camp_lead_asso'=>$g->model['id'],'lead_id'=>$g->model['telelead_id'],'campaign_id'=>$g->model['telecampaign_id']])).'">Follow-ups</a>';
  //   		});
		
		// }

		// $crud->add('xHR/Controller_Acl');
		// $crud->grid->addPaginator(5);

	}


}