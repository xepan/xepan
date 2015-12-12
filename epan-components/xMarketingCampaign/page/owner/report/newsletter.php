<?php

class page_xMarketingCampaign_page_owner_report_newsletter extends page_xMarketingCampaign_page_owner_main{
	function page_index(){
		// parent::init();

		$category=$this->add('xEnquiryNSubscription/Model_NewsLetterCategory');
		$newsletter=$this->add('xEnquiryNSubscription/Model_NewsLetter');

		$form=$this->add('Form');
		$form->addField('DropDown','category')->setEmptyText('Please Select')->setModel($category);
		$form->addField('DatePicker','from_date');
        $form->addField('DatePicker','to_date');
        $form->addSubmit('Get Report');

        $grid=$this->add('xEnquiryNSubscription/Grid_NewsLetter');

        $this->app->stickyGET('filter');
        $this->app->stickyGET('category');
        $this->app->stickyGET('from_date');
        $this->app->stickyGET('to_date');

        if($_GET['filter']){
        	if($_GET['category']){
        		$newsletter->addCondition('category_id','=',$_GET['category']);
        	}
        	if($_GET['from_date']){
				$newsletter->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$newsletter->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
        }else{
        	$newsletter->addCondition('id',-1);
        }

        $grid->setModel($newsletter);
		$grid->addPaginator(100);
		$grid->addSno();

		if($form->isSubmitted()){

			$grid->js()->reload(array('category'=>$form['category'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}	

	}
	function page_send(){
		$this->api->stickyGET('xenquirynsubscription_newsletter_id');

		$tabs = $this->add('Tabs');
		$tabs->addTabURL('xMarketingCampaign_page_owner_newsletters_sendtosingle','Send To Single');
		$tabs->addTabURL('xMarketingCampaign_page_owner_newsletters_massemail','Mass Email');
	}
}