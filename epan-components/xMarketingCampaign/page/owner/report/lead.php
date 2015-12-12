<?php

class page_xMarketingCampaign_page_owner_report_lead extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();
		$subscription=$this->add('xMarketingCampaign/Model_LeadCategory');
		$lead=$this->add('xMarketingCampaign/Model_Lead');

		$form=$this->add('Form');
		$form->addField('DropDown','category')->setEmptyText('Please Select')->setModel($subscription);
		$form->addField('DatePicker','from_date');
        $form->addField('DatePicker','to_date');
        $form->addSubmit('Get Report');

        // $grid=$this->add('xMarketingCampaign/Grid_Lead');
        $grid=$this->add('Grid');

        $this->app->stickyGET('filter');
        $this->app->stickyGET('category');
        $this->app->stickyGET('from_date');
        $this->app->stickyGET('to_date');

        if($_GET['filter']){
        	if($_GET['category']){
        		$lead_cat_asso=$lead->join('xenquirynsubscription_subscatass.subscriber_id');
        		$lead_cat_asso->addField('category_id');
        		$lead->addCondition('category_id',$_GET['category']);
        	}
        	if($_GET['from_date']){
				$lead->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$lead->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
        }else{
        	$lead->addCondition('id',-1);
        }

        $grid->setModel($lead);
		$grid->addPaginator(100);
		$grid->addSno();

		if($form->isSubmitted()){

			$grid->js()->reload(array('category'=>$form['category'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}	
	}
}