<?php

class page_xMarketingCampaign_page_owner_tele_playground extends page_xMarketingCampaign_page_owner_main{

	function init(){
		parent::init();

		$campaign_id = $this->api->stickyGET('telecampaign_id');
		$selected_lead = $this->api->stickyGET('telelead_id');

		$campaign = $this->add('xMarketingCampaign/Model_Tele_Campaign');
		$campaign->tryLoad($campaign_id);

		$this->add('H2')->set(" ".$campaign['name'])->addClass('atk-box-small icon-ok');

		$row = $this->add('Columns');
		$col1 = $row->addColumn(4);
		$col8 = $row->addColumn(8);
		$v8 = $col8->add('View');
		$cols = $v8->add('Columns');
		$col2 = $cols->addColumn(6);
		$col3 = $cols->addColumn(6);

		// $col3 = $row->addColumn(4);
		$col1->add('View_Info')->set('Add Lead and show all leads');
		$col2->add('View_Info')->set('Activities');
		$col3->add('View_Info')->set('Show all Follow-ups');


		$grid = $col1->add('Grid');
		$grid->setModel($campaign->leads(),['name','email','mobile_no']);
		$grid->addQuickSearch(array('name','email','mobile_no'));
		$grid->addFormatter('name','name');
		$grid->addMethod('format_name',function($g,$f)use($v8){
    		$g->current_row_html[$f]= '<a href="#na" onclick="javascript:'.$v8->js()->reload(['telelead_id'=>$g->model->id]).'">'.$g->model['name'].'</a>';
    	});
		
		// $form = $col1->add('Form_Stacked');
		// $dropdown = $form->addField('autocomplete/Plus','Lead')->setModel();
		// $form->addSubmit('Associates');

//===============================Activities===================================
		if($selected_lead){
			$activity_crud = $col2->add('CRUD',['allow_del'=>false]);
			$activity_lead_model = $col2->add('xMarketingCampaign/Model_Tele_Lead')->load($selected_lead);
			$activity_model = $activity_lead_model->activities();
			$activity_model->addCondition('from','Employee');
			$activity_model->addCondition('to','Lead');
			$activity_model->addCondition('action','call');
			$activity_crud->setModel($activity_model,array('from','to','subject','message','action'));
		}
		
//===============================Follow-ups===================================

		$follow_ups_model = $col3->add('xMarketingCampaign/Model_Tele_Followups');
		$follow_ups_model->addCondition('telecampaign_id',$campaign_id);
		
		$show_all_follow_ups = $this->api->stickyGET('show_all_follow_ups')?:0;
		$label = "Show Today Follow-ups";
		if(!$show_all_follow_ups){
			$follow_ups_model->addCondition('next_followup_date','<=',$this->api->today);
			$label = "Show All Follow-ups";
		}
		if($selected_lead)
			$follow_ups_model->addCondition('telelead_id',$selected_lead);

		$lead_model = $follow_ups_model->ref('telelead_id');
		$lead_model->join('xmarketingcampaign_tele_campaign_lead_asso.telelead_id');
		$follow_ups_model->setOrder('next_followup_date','desc');

		$followups_crud = $col3->add('CRUD');
		$followups_crud->setModel($follow_ups_model,array('telecampaign_id','telelead_id','next_followup_date','name','is_active'),array('telelead','name','next_followup_date','is_active'));
		
		$show_all_follow_ups_btn = $followups_crud->grid->addButton($label);

		$show_all_follow_ups_btn->onClick(function($show_all_follow_ups_btn)use($col3,$show_all_follow_ups){
			// return $col3->js()->univ()->alert($show_all_follow_ups);
			return $col3->js()->reload(['show_all_follow_ups'=>$show_all_follow_ups?0:1]);
		});



	}
}