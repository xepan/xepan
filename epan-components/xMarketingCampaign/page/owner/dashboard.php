<?php

class page_xMarketingCampaign_page_owner_dashboard extends page_xMarketingCampaign_page_owner_main {

	function init(){
		parent::init();	
		$this->app->title=$this->api->current_department['name'] .': Dashboard';

		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		$col_3 = $col->addColumn(3);
		$col_4 = $col->addColumn(3);
		

		// Total Grabbed Emails
		$sub_model = $this->add('xEnquiryNSubscription/Model_Subscription');
		$total_grabbed_email_tile = $col_1->add('View_Tile')->addClass('atk-swatch-blue')->setStyle('box-shadow','');
		$total_grabbed_email_tile->setTitle('Total Grabbed Emails');
		$total_grabbed_email_tile->setContent($sub_model->addCondition('from_app','DataGrabberPhrase')->count()->getOne());
		

		//total Emails
		$sub_model = $this->add('xEnquiryNSubscription/Model_Subscription');
		$total_email_tile = $col_2->add('View_Tile')->addClass('atk-swatch-yellow')->setStyle('box-shadow','');
		$total_email_tile->setTitle('Total Grabbed Emails');
		$total_email_tile->setContent($sub_model->addCondition('from_app','xMarketingCampaign')->count()->getOne());
		
		//Total NewsLetter
		$newsletter_model = $this->add('xEnquiryNSubscription/Model_NewsLetter');
		$total_newsletter_tile = $col_3->add('View_Tile')->addClass('atk-swatch-ink')->setStyle('box-shadow','');
		$total_newsletter_tile->setTitle('Total Newsletter');
		$total_newsletter_tile->setContent($newsletter_model->count()->getOne());

		
		//Active Newsletter
		$newsletter_model = $this->add('xEnquiryNSubscription/Model_NewsLetter');
		$total_active_newsletter_tile = $col_4->add('View_Tile')->addClass('atk-swatch-green')->setStyle('box-shadow','');
		$total_active_newsletter_tile->setTitle('Total Active Newsletter');
		$total_active_newsletter_tile->setContent($newsletter_model->addCondition('is_active',true)->count()->getOne());

		//DeActive newsletter
		$col_1->add('View')->setElement('br');
		$newsletter_deactive_model = $this->add('xEnquiryNSubscription/Model_NewsLetter');
		$total_deactive_newsletter_tile = $col_1->add('View_Tile')->addClass('atk-swatch-red')->setStyle('box-shadow','');
		$col_1->add('View')->setElement('br');
		$total_deactive_newsletter_tile->setTitle('Total De-Active Newsletter');
		$total_deactive_newsletter_tile->setContent($newsletter_deactive_model->addCondition('is_active',false)->count()->getOne());

		//Total Email Jobs
		$col_2->add('View')->setElement('br');
		$email_jobs = $this->add('xEnquiryNSubscription/Model_EmailJobs');
		$total_email_jobs_tile = $col_2->add('View_Tile')->addClass('atk-swatch-blue')->setStyle('box-shadow','');
		$total_email_jobs_tile->setTitle('Total Email Jobs');
		$total_email_jobs_tile->setContent($email_jobs->count()->getOne());

		//Total  pending Email Jobs
		$col_3->add('View')->setElement('br');
		$email_jobs = $this->add('xEnquiryNSubscription/Model_EmailJobs');
		$total_pending_email_jobs_tile = $col_3->add('View_Tile')->addClass('atk-swatch-yellow')->setStyle('box-shadow','');
		$total_pending_email_jobs_tile->setTitle('Total  pending Email Jobs');
		$email_jobs->addExpression('pending_emails')->set(function($m,$q){
			return $m->refSQL('xEnquiryNSubscription/EmailQueue')->addCondition('is_sent',false)->count();
		});
		$total_pending_email_jobs_tile->setContent($email_jobs->addCondition('pending_emails','>','0')->count()->getOne());


		//kab konsa newsletter send kara
		$col = $this->add('Columns');
		$col1 = $col->addColumn(3);
		$col2 = $col->addColumn(9);

		$email_queue = $this->add('xEnquiryNSubscription/Model_EmailQueue');
		$queue_job_j = $email_queue->join('xenquirynsubscription_emailjobs','emailjobs_id');
		$queue_job_j->addField('newsletter_id')->system(true);
		$newsletter_j = $queue_job_j->join('xenquirynsubscription_newsletter','newsletter_id');
		$newsletter_j->addField('name')->caption('Newsletter Title');
		$email_queue->addCondition('sent_at','<',date('Y-m-d H:i:s'));
		$email_queue->addCondition('is_sent',true);
		$email_queue->getElement('email')->system(true);
		$email_queue->setOrder('sent_at','desc');	
		$email_queue->tryLoadAny();
		$email_queue->setLimit(5);
		$v = $col1->add('View_Tile')->addClass('atk-swatch-blue');
		$col1->add('View')->setElement('br');
		$v->setTitle('Kab Konsa NewsLetter kisko send kara');
		$col1->add('View')->setElement('br');
		$grid = $col2->add('Grid');
		if($email_queue->loaded()){
			$grid->addMethod('format_sentto',function($g,$f){
				$subscription_model = $g->add('xEnquiryNSubscription/Model_Subscription');
				$subscription_model->addCondition('id',$g->model['subscriber_id']);
				$subscription_model->tryLoadAny();
				$sent_to = $subscription_model['email'];
				if(!$g->model['subscriber_id'])
					$sent_to = $g->model['email'];
				$g->current_row_html[$f]=$sent_to; 
			});	

			$grid->addColumn('sentto','Send To');
		}
		$grid->setModel($email_queue,array('sent_to','name','sent_at'));


		//Recent Social Post
		$col = $this->add('Columns');
		$col1 = $col->addColumn(3);
		$col2 = $col->addColumn(9);
		$csp_model = $this->add('xMarketingCampaign/Model_CampaignSocialPost');
		$csp_model->addCondition('is_posted',true);
		$csp_model->setOrder('post_on','desc');
		$csp_model->setLimit(5);
		$v = $col1->add('View_Tile')->addClass('atk-swatch-yellow');
		$col1->add('View')->setElement('br');
		$v->setTitle('Recent Social Posts');
		$grid = $col2->add('Grid');

		$grid->setModel($csp_model,array('socialpost','post_on_datetime'));
		if($grid->model){
			$grid->model->getElement('Facebook')->system(true);
			$grid->model->getElement('Linkedin')->system(true);
			$grid->model->getElement('GoogleBlogger')->system(true);
			// $grid->model->getElement('Twitter')->system(true);
		}
		$grid->addMethod('format_social',function($g,$f){
			$social_icon="";
			if($g->model['Facebook']){
				$social_icon .='<i class="fa fa-facebook" style="color:blue;"></i> ';
			}
			if($g->model['Linkedin']){
				$social_icon .='<i class="fa fa-linkedin" style="background-color:#00CCFF;color:white;padding:2px;"></i> ';
			}
			if($g->model['Twitter']){
				$social_icon .='<i class="fa fa-twitter" style="color:#55acee;"></i> ';
			}
			if($g->model['GoogleBlogger']){
				$social_icon .='<i class="glyphicon glyphicon-bold" style="background:orange;color:white;padding:2px 0;"></i> ';
			}	
			$g->current_row_html[$f]=$social_icon; 
		});

		


		//Next Scheduled Email Job
		$col = $this->add('Columns');
		$col1 = $col->addColumn(3);
		$col2 = $col->addColumn(9);
		$cnl_model = $this->add('xMarketingCampaign/Model_CampaignNewsLetter');
		$cnl_model->_dsql()->having('posting_date','>',date('Y-m-d H:i:s'));
		$cnl_model->setOrder('posting_date','desc');
		$cnl_model->setLimit(5);
		$v = $col1->add('View_Tile')->addClass('atk-swatch-blue');
		$v->setTitle('Next Scheduled Email Job');
		$col1->add('View')->setElement('br');
		$grid = $col2->add('Grid');
		$grid->setModel($cnl_model,array('posting_date','newsletter'));
		
		//Next Scheduled Social Job
		$col = $this->add('Columns');
		$col1 = $col->addColumn(3);
		$col2 = $col->addColumn(9);
		$csp_model = $this->add('xMarketingCampaign/Model_CampaignSocialPost');	
		$csp_model->_dsql()->having('post_on_datetime','>',date('Y-m-d H:i:s'));
		$csp_model->setOrder('post_on_datetime','desc');
		$csp_model->setLimit(5);
		$v = $col1->add('View_Tile')->addClass('atk-swatch-yellow');
		$col1->add('View')->setElement('br');
		$v->setTitle('Next Scheduled Social Job');
		$grid = $col2->add('Grid');
		$grid->setModel($csp_model,array('socialpost','post_on_datetime'));
		if($grid->model){
			$grid->model->getElement('Facebook')->system(true);
			$grid->model->getElement('Linkedin')->system(true);
			$grid->model->getElement('GoogleBlogger')->system(true);
			// $grid->model->getElement('Twitter')->system(true);
		}			
		$grid->addMethod('format_social',function($g,$f){
			$social_icon="";
			if($g->model['Facebook']){
				$social_icon .='<i class="fa fa-facebook" style="color:blue;"></i> ';
			}
			if($g->model['Linkedin']){
				$social_icon .='<i class="fa fa-linkedin" style="background-color:#00CCFF;color:white;padding:2px;"></i> ';
			}
			if($g->model['Twitter']){
				$social_icon .='<i class="fa fa-twitter" style="color:#55acee;"></i> ';
			}
			if($g->model['GoogleBlogger']){
				$social_icon .='<i class="glyphicon glyphicon-bold" style="background:orange;color:white;padding:2px 0;"></i> ';
			}	
			$g->current_row_html[$f]=$social_icon; 
		});
		$grid->addColumn('social','Post On');
	}
}		