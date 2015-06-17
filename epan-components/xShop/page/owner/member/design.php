<?php

class page_xShop_page_owner_member_design extends Page {
	public $html_attributes;
	function page_index(){
		
		if(!$_GET['designer_page']){
			$this->add('View_Warning')->set('Specify the designer page');
			return ;
		}

		$designer_page = $this->api->stickyGET('designer_page');

		$member = $this->add('xShop/Model_MemberDetails');
		
		if(!$member->loadLoggedIn()){
			$this->add('View_Error')->set('Not Authorized');
			return;
		}

		$form = $this->add('Form');
		$crud = $this->add('CRUD',array('allow_add'=>false,'allow_edit'=>'false'));
		$template_model = $this->add('xShop/Model_ItemTemplate');
		$form->addField('dropdown','item_template')->setModel($template_model);

		$form->addSubmit('Duplicate');
		if($form->isSubmitted()){
			$new_item = $template_model->load($form['item_template'])->duplicate($create_default_design_also=true);
			// create default design as well for this new template that is just duplicated
			$form->js(null,$crud->js()->reload())->univ()->successMessage('Design Duplicated')->execute();
		}

		$designer = $this->add('xShop/Model_MemberDetails');
		$designer->loadLoggedIn();

		$my_designs_model = $this->add('xShop/Model_ItemMemberDesign');
		$item_j = $my_designs_model->join('xshop_items','item_id');
		$item_j->addField('name');
		$item_j->addField('sku');
		$item_j->addField('is_party_publish')->caption('Sent for Publish')->type('boolean');
		$item_j->addField('short_description')->type('text');
		$item_j->addField('description')->type('text')->display(array('form'=>'RichText'))->group('z~12');
		$my_designs_model->addCondition('member_id',$designer->id);

		$crud->setModel($my_designs_model,array('name','sku','short_description','description','is_party_publish'),array('name','sku','designs','is_ordered','is_party_publish'));

		if(!$crud->isEditing()){
			$g = $crud->grid;
			$g->add_sno();
			//Image
			$g->addMethod('format_designs',function($g,$f)use($my_designs_model){
				$g->current_row_html[$f] = '<img src="index.php?page=xShop_page_designer_thumbnail&item_member_design_id='.$my_designs_model['id'].'" width="50px;"/>';
			});
			$g->addFormatter('designs','designs');
			
			//Edit Template
			$g->addColumn('edit_template');

			$g->addMethod('format_edit_template',function($g,$f)use($designer,$designer_page){
				// echo $this->api->url();
				if($g->model->ref('item_id')->get('designer_id') == $designer->id)
					$g->current_row_html[$f]='<a target="_blank" href='.$g->api->url('index',array('subpage'=>$designer_page,'xsnb_design_item_id'=>$g->model['item_id'],'xsnb_design_template'=>'true')).'>Edit Template</a>';
				else
					$g->current_row_html[$f]='';	
			});

			$g->addFormatter('edit_template','edit_template');
			//Edit Design
			$g->addColumn('design');
			// $subpage = $_GET['designer_page'];//$this->html_attributes['xsnb-desinger-page'];
			$g->addMethod('format_design',function($g,$f)use($designer,$designer_page){
				if(!$g->model['is_dummy'])
					$g->current_row_html[$f]='<a target="_blank" href='.$g->api->url('index',array('subpage'=>$designer_page,'xsnb_design_item_id'=>'not-available','xsnb_design_template'=>'false','item_member_design_id'=>$g->model->id)).'>Design</a>';
				else
					$g->current_row_html[$f] ='';
			});
			$g->addFormatter('design','design');

			
			if($g->hasColumn('is_party_publish'))$g->removeColumn('is_party_publish');

			$g->addMethod('format_edit',function($g,$f){
				if($g->model['is_ordered'])
					$g->current_row_html[$f]="";
				else
					$g->current_row_html[$f]= $g->current_row_html[$f];
			});

			$g->addFormatter('edit','edit');
			
			$g->addMethod('format_delete1',function($g,$f){
				if($g->model['is_ordered'])
					$g->current_row_html[$f]="";
				else
					$g->current_row_html[$f]= $g->current_row_html[$f];
			});		
			$g->addFormatter('delete','delete1');

		}
		

	}
}