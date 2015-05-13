<?php


class page_xShop_page_owner_afflilate extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Affiliate';		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Affiliate Management <small> Manage item Affiliates like brands/publishers/authors etc. </small>');

		$application_id=$this->api->recall('xshop_application_id');

		$cols = $this->app->layout->add('Columns');
		$type_col = $cols->addColumn(3);
		$aff_col = $cols->addColumn(9);
		$afflilate_type_model = $this->add('xShop/Model_AffiliateType');
		$afflilate_type_model->addCondition('application_id',$application_id);
		$type_crud=$type_col->add('CRUD',array('grid_class'=>'xShop/Grid_AffiliateType'));

		$type_crud->setModel($afflilate_type_model);//,array('name'));
		$afflilate_model = $this->add('xShop/Model_Affiliate');
		$afflilate_model->addCondition('application_id',$application_id);

		if(!$type_crud->isEditing()){
			$g=$type_crud->grid;
			$g->addMethod('format_filterafflilate',function($g,$f)use($aff_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $aff_col->js()->reload(array('afflilatetype_id'=>$g->model->id)) .'">'.$g->current_row[$f].'</a>';
			});
			$g->addFormatter('name','filterafflilate');
		}

		

		if($_GET['afflilatetype_id']){
			$this->api->stickyGET('afflilatetype_id');
			$filter_box = $aff_col->add('View_Box')->setHTML(' Affiliate for <b>'. $afflilate_type_model->load($_GET['afflilatetype_id'])->get('name').'</b>' );
			
			$filter_box->add('Icon',null,'Button')
            ->addComponents(array('size'=>'mega'))
            ->set('cancel-1')
            ->addStyle(array('cursor'=>'pointer'))
            ->on('click',function($js) use($filter_box,$aff_col) {
                $filter_box->api->stickyForget('afflilatetype_id');
                return $filter_box->js(null,$aff_col->js()->reload())->hide()->execute();
            });
            
			$afflilate_model->addCondition('affiliatetype_id',$_GET['afflilatetype_id']);
		}

		$aff_crud=$aff_col->add('CRUD',array('grid_class'=>'xShop/Grid_Affiliate'));

		$aff_crud->setModel($afflilate_model);//,array('name'));
		
		
	}
}

		
