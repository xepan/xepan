<?php

class page_xMarketingCampaign_page_owner_leads extends page_xMarketingCampaign_page_owner_main{
	
	function page_index(){
		$this->app->title=$this->api->current_department['name'] .': Leads';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> xMarketingCampaign Leads <small> Manage Your Leads </small>');
		// Add Badges


		$leads=$this->add('xMarketingCampaign/Model_Lead');
		$leads->addExpression('last_updated_on',function($m,$q){
			return $m->refSQL('xEnquiryNSubscription/SubscriptionCategoryAssociation')->setLimit(1)->setOrder('last_updated_on','desc')->fieldQuery('last_updated_on');			
		})->sortable(true);	
		
		$leads->setOrder('last_updated_on','desc');

		$crud=$this->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_Lead'));
		$crud->setModel($leads);

		//Add Upload Data Button
		$upl_btn=$crud->grid->addButton('Upload Data');
		$upl_btn->setIcon('ui-icon-arrowthick-1-n');
		$upl_btn->js('click')->univ()->frameURL('Data Upload',$this->api->url('./upload'));

		$crud->add('xHR/Controller_Acl');
	}

	function page_category(){
		$lead_id = $this->api->stickyGET('xenquirynsubscription_subscription_id');

		$asso = $this->add('xEnquiryNSubscription\Model_SubscriptionCategoryAssociation');
		$asso->addCondition('subscriber_id',$lead_id);

		$crud = $this->add('CRUD');
		$crud->setModel($asso);
	}

	function page_upload(){
		
		$form = $this->add('Form');
		$form->addField('line','fields')->setFieldHint('Enter comma separated Fields');
		$form->addSubmit('Generate Sample File');
		
		if($_GET[$this->name]){
			$output=[];
			foreach (explode(",", $_GET[$this->name]) as $fs) {
				$output[] = trim($fs);
			}

			$output = implode(",", $output);
	    	header("Content-type: text/csv");
	        header("Content-disposition: attachment; filename=\"sample_qty_set_file.csv\"");
	        header("Content-Length: " . strlen($output));
	        header("Content-Transfer-Encoding: binary");
	        print $output;
	        exit;
		}

		if($form->isSubmitted()){
			$form->js()->univ()->location($this->api->url(null,array($this->name=>$form['fields'])))->execute();
		}

		$this->add('View')->setElement('iframe')->setAttr('src',$this->api->url('./execute',array('cut_page'=>1,'item_id'=>$_GET['item_id'])))->setAttr('width','100%');
	}

	function page_upload_execute(){
		
		$form= $this->add('Form');
		$form->template->loadTemplateFromString("<form method='POST' action='".$this->api->url(null,array('cut_page'=>1))."' enctype='multipart/form-data'>
			<input type='file' name='csv_lead_file'/>
			<input type='submit' value='Upload'/>
			</form>"
			);

		if($_FILES['csv_lead_file']){
			if ( $_FILES["csv_lead_file"]["error"] > 0 ) {
				$this->add( 'View_Error' )->set( "Error: " . $_FILES["csv_lead_file"]["error"] );
			}else{
				if($_FILES['csv_lead_file']['type'] != 'text/csv'){
					$this->add('View_Error')->set('Only CSV Files allowed');
					return;
				}

				$importer = new CSVImporter($_FILES['csv_lead_file']['tmp_name'],true,',');
				$data = $importer->get(); 

				foreach ($data as $row) { // field like Cst 1, Cst 2 ... 
					// add lead
					$name = $row['name'];
					$organization = $row['organization']

					if(!$row['name'])
						$name = $organization;
					
					if(!$row['organization'])
						$organization = $name;

					$lead = $this->add('xMarketingCampaign/Model_Lead');
					$lead['email'] = trim($row['email']);
					$lead['phone'] = trim($row['phone']);
					$lead['organization_name'] = $name;
					$lead['name'] = $organization;

					$lead->save();

					if($row['category']){
						//associated with multiple category call it's function
						$lead->associatedWithCategory($row['category']);
					}

					$lead->unLoad();
				}
				
				$this->add('View_Info')->set(count($data).' Recored Imported');
				$this->js(true)->univ()->closeDialog();
			}
		}
	
	}


}