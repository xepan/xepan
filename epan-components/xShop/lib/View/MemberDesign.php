<?php
namespace xShop;
class View_MemberDesign extends \View {
	public $html_attributes;
	function init(){
		parent::init();
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

		$crud = $this->add('CRUD',array('allow_add'=>false,'allow_edit'=>false));

		$designer = $this->add('xShop/Model_MemberDetails');
		$designer->loadLoggedIn();

		$my_designs_model = $this->add('xShop/Model_ItemMemberDesign');
		$item_j = $my_designs_model->leftJoin('xshop_items','item_id');
		$item_j->addField('name');
		$item_j->addField('sku');
		$item_j->addField('is_party_publish')->caption('Sent for Publish')->type('boolean');
		$item_j->addField('short_description')->type('text');
		$item_j->addField('description')->type('text')->display(array('form'=>'RichText'))->group('z~12');
		$item_j->addField('duplicate_from_item_id')->type('text');
		$my_designs_model->addCondition('member_id',$designer->id);

		$my_designs_model->setOrder('id','desc');
		$crud->setModel($my_designs_model,array('name','sku','short_description','description','is_party_publish','duplicate_from_item_id'),array('name','sku','designs','is_ordered','is_party_publish'));

		
		if(!$crud->isEditing()){
			$g = $crud->grid;
			$g->add_sno();
			$g->addPaginator(10);
			$g->addQuickSearch(array('name'));
			//Image
			// $g->addMethod('format_designs',function($g,$f)use($my_designs_model){
			// 	$g->current_row_html[$f] = '<img style="box-shadow:0 3px 5px rgba(0, 0, 0, 0.2);" src="index.php?page=xShop_page_designer_thumbnail&item_member_design_id='.$my_designs_model['id'].'" width="100px;"/>';
			// });
			// 	$g->addFormatter('designs','designs');
			
			$g->addMethod('format_name',function($g,$f){
				$is_ordered = "<small style='color:red'>No</small>";
				if($g->model['is_ordered']) $is_ordered = "<small style='color:green'>Yes</small>";
				$g->current_row_html[$f]=$g->model['name']."<br> <small style='color:gray'> SKU - ".$g->model['sku']."</small><br><small style='color:gray'> Is Ordered - ".$is_ordered.'</small>';
			});
			$g->addFormatter('name','name');
			$g->removeColumn('sku');
			$g->removeColumn('is_ordered');

			//Edit Template
			// if(!$member['is_organization'] ){				
			// 	$g->addColumn('edit_template');
			// 	$g->addMethod('format_edit_template',function($g,$f)use($designer,$designer_page){
			// 		// echo $this->api->url();
			// 		if($g->model->ref('item_id')->get('designer_id') == $designer->id){
			// 			$img = '<img style="box-shadow:0 3px 5px rgba(0, 0, 0, 0.2);" class="atk-align-center" src="index.php?page=xShop_page_designer_thumbnail&xsnb_design_item_id='.$g->model['item_id'].'" width="100px;"/>';
			// 			$g->current_row_html[$f]=$img.'</br>'.'<a class="icon-pencil atk-margin-small" target="_blank" href='.$g->api->url('index',array('subpage'=>$designer_page,'xsnb_design_item_id'=>$g->model['item_id'],'xsnb_design_template'=>'true')).'>Edit Template</a>';
			// 		}
			// 		else
			// 			$g->current_row_html[$f]='';	
			// 	});

			// 	$g->addFormatter('edit_template','edit_template');
			// }


			//Edit Design
			$g->addColumn('design');
			// $subpage = $_GET['designer_page'];//$this->html_attributes['xsnb-desinger-page'];
			$g->addMethod('format_design',function($g,$f)use($designer,$designer_page,$my_designs_model){
				if(!$g->model['is_dummy']){
					$img = '<img style="box-shadow:0 3px 5px rgba(0, 0, 0, 0.2);" src="index.php?page=xShop_page_designer_thumbnail&item_member_design_id='.$my_designs_model['id'].'" width="100px;"/>';
					$g->current_row_html[$f]=$img.'<br/>'.'<a target="_blank" class="icon-pencil atk-margin-small" href='.$g->api->url('index',array('subpage'=>$designer_page,'xsnb_design_item_id'=>'not-available','xsnb_design_template'=>'false','item_member_design_id'=>$g->model->id)).'>Edit Design/ Reorder</a>';
				}
				else
					$g->current_row_html[$f] ='';
			});
			$g->addFormatter('design','design');

			
			if($g->hasColumn('is_party_publish'))$g->removeColumn('is_party_publish');

			// $g->addMethod('format_edit',function($g,$f){
			// 	if($g->model['is_ordered'])
			// 		$g->current_row_html[$f]="";
			// 	else
			// 		$g->current_row_html[$f]= $g->current_row_html[$f];
			// });

			// $g->addFormatter('edit','edit');
			
			$g->addMethod('format_delete1',function($g,$f){
				if($g->model['is_ordered'])
					$g->current_row_html[$f]="";
				else
					$g->current_row_html[$f]= $g->current_row_html[$f];
			});		
			$g->addFormatter('delete','delete1');
			// $g->addColumn('Expander','Images');
			$g->removeColumn('designs');
		}
		

	}
}