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
		$item_j->addField('duplicate_from_item_id')->type('text');
		$my_designs_model->addCondition('member_id',$designer->id);

		$crud->setModel($my_designs_model,array('name','sku','short_description','description','is_party_publish','duplicate_from_item_id'),array('name','sku','designs','is_ordered','is_party_publish'));

		if(!$crud->isEditing()){
			$g = $crud->grid;
			$g->add_sno();

			//Image
			// $g->addMethod('format_designs',function($g,$f)use($my_designs_model){
			// 	$g->current_row_html[$f] = '<img style="box-shadow:0 3px 5px rgba(0, 0, 0, 0.2);" src="index.php?page=xShop_page_designer_thumbnail&item_member_design_id='.$my_designs_model['id'].'" width="100px;"/>';
			// });
			// 	$g->addFormatter('designs','designs');
			

			//Edit Template

			$g->addColumn('edit_template');
			$g->addMethod('format_edit_template',function($g,$f)use($designer,$designer_page){
				// echo $this->api->url();
				if($g->model->ref('item_id')->get('designer_id') == $designer->id){
					$img = '<img style="box-shadow:0 3px 5px rgba(0, 0, 0, 0.2);" class="atk-align-center" src="index.php?page=xShop_page_designer_thumbnail&xsnb_design_item_id='.$g->model['item_id'].'" width="100px;"/>';
					$g->current_row_html[$f]=$img.'</br>'.'<a class="icon-pencil atk-margin-small" target="_blank" href='.$g->api->url('index',array('subpage'=>$designer_page,'xsnb_design_item_id'=>$g->model['item_id'],'xsnb_design_template'=>'true')).'>Edit Template</a>';
				}
				else
					$g->current_row_html[$f]='';	
			});

			$g->addFormatter('edit_template','edit_template');

			//Edit Design
			$g->addColumn('design');
			// $subpage = $_GET['designer_page'];//$this->html_attributes['xsnb-desinger-page'];
			$g->addMethod('format_design',function($g,$f)use($designer,$designer_page,$my_designs_model){
				if(!$g->model['is_dummy']){
					$img = '<img style="box-shadow:0 3px 5px rgba(0, 0, 0, 0.2);" src="index.php?page=xShop_page_designer_thumbnail&item_member_design_id='.$my_designs_model['id'].'" width="100px;"/>';
					$g->current_row_html[$f]=$img.'<br/>'.'<a target="_blank" class="icon-pencil atk-margin-small" href='.$g->api->url('index',array('subpage'=>$designer_page,'xsnb_design_item_id'=>'not-available','xsnb_design_template'=>'false','item_member_design_id'=>$g->model->id)).'>Design</a>';
				}
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
			// $g->addColumn('Expander','Images');

			$g->add('VirtualPage')->addColumn('Images','Images',array('icon'=>'icon-users','descr'=>'image'),$g)->set(function($p)use($g){
				$image_design_id = $p->id;
				$item_member_design = $p->add('xShop/Model_ItemMemberDesign')->load($image_design_id);
				$item_model = $item_member_design->ref('item_id');

				// $p->add('View_Info')->set("Images".$_GET['xshop_item_member_designs_id']);
				$item_id = $item_model->id;
				if(!$item_id){
					$this->add('View_Warning')->set('Item Model Not Loaded');
					return;
				}

				$item_images_model = $p->add('xShop/Model_ItemImages')->addCondition('item_id',$item_id)->addCondition('customefieldvalue_id',null);
				$item_images_model->setOrder('id','desc');
				$crud = $p->add('CRUD');
				$crud->setModel($item_images_model,array('item_image_id','alt_text','title'),array('item_image','alt_text','title'));
				if(!$crud->isEditing()){
					$g = $crud->grid;
					$g->addMethod('format_image_thumbnail',function($g,$f){
						$g->current_row_html[$f] = '<img style="height:40px;max-height:40px;" src="'.$g->current_row[$f].'"/>';
					});
					$g->addFormatter('item_image','image_thumbnail');
					$g->addPaginator($ipp=50);
				}

			});

			$g->removeColumn('designs');
		}
		

	}

	// function page_Images(){
	// 	$image_design_id = $this->api->stickyGET('xshop_item_member_designs_id');
		
	// 	$item_member_design = $this->add('xShop/Model_ItemMemberDesign')->load($image_design_id);
	// 	$item_model = $item_member_design->ref('item_id');

	// 	$this->add('View_Info')->set("Images".$_GET['xshop_item_member_designs_id']);

	// 	$item_id = $item_model->id;
	// 	if(!$item_id){
	// 		$this->add('View_Warning')->set('Item Model Not Loaded');
	// 		return;
	// 	}

	// 	$item_images_model = $this->add('xShop/Model_ItemImages')->addCondition('item_id',$item_id)->addCondition('customefieldvalue_id',null);
	// 	$item_images_model->setOrder('id','desc');
	// 	$crud = $this->add('CRUD');
	// 	$crud->setModel($item_images_model,array('item_image_id','alt_text','title'),array('item_image','alt_text','title'));
	// 	if(!$crud->isEditing()){
	// 		$g = $crud->grid;
	// 		$g->addMethod('format_image_thumbnail',function($g,$f){
	// 			$g->current_row_html[$f] = '<img style="height:40px;max-height:40px;" src="'.$g->current_row[$f].'"/>';
	// 		});
	// 		$g->addFormatter('item_image','image_thumbnail');
	// 		$g->addPaginator($ipp=50);
	// 	}
	// }
}