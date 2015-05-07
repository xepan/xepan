<?php
class page_xHR_page_owner_department extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		
		$this->add('PageHelp',array('page'=>array('departments','department_editing_page','department_post','departments_Basic')));

		$this->app->title=$this->api->current_department['name'] .': Departments/Posts/ACL';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Company Departments <small> Departments, Post, ACL, Salary Templates etc</small>');
		

		$l=$this->add('Columns');
		$cat_col = $l->addColumn(3);
		$dept_col = $l->addColumn(9);
		
		//Department
		$dept_model=$this->add('xHR/Model_Department');
		$dept_model->getElement('production_level')->caption('Level');

		$dept_crud = $cat_col->add('CRUD',array('allow_edit'=>false,'grid_class'=>'xHR/Grid_Department'));
		$dept_crud->setModel($dept_model,array('name','production_level'),array());

		if(!$dept_crud->isEditing()){
			$dept_crud->grid->addMethod('format_name',function($g,$f)use($dept_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$dept_col->js()->reload(array('hr_department_id'=>$g->model->id)).'">'.$g->current_row[$f].'</a>';

			});
			$dept_crud->grid->addFormatter('name','name');
			
			$dept_crud->grid->addMethod('format_mydelete',function($g,$f){
				if($g->current_row['is_system']!=0)
					$g->current_row_html[$f]='';
			});

			$dept_crud->grid->addMethod('format_pl',function($g,$f){
				if($g->current_row['is_system']==1)
					$g->current_row_html[$f]='';
			});

			$dept_crud->grid->addFormatter('delete','mydelete');
			$dept_crud->grid->addFormatter('production_level','pl');
			
		}

		$dept_crud->grid->addQuickSearch(array('name','production_level'));
		$dept_crud->grid->addPaginator($ipp=50);

		// $dept_col->add('xShop/View_Badges_ItemPage');
		if($_GET['hr_department_id']){
			$this->api->stickyGET('hr_department_id');
			
			$selected_department = $this->add('xHR/Model_Department')->load($_GET['hr_department_id']);

			$filter_box = $dept_col->add('View_Box')->setHTML('Department :: '.$this->add('xHR/Model_Department')->load($_GET['hr_department_id'])->get('name'));
			$filter_box->add('Icon',null,'Button')
            ->addComponents(array('size'=>'mega'))
            ->set('cancel-1')
            ->addStyle(array('cursor'=>'pointer'))
            ->on('click',function($js) use($filter_box,$dept_col) {
                $filter_box->api->stickyForget('hr_department_id');
                return $filter_box->js(null,$dept_col->js()->reload())->hide()->execute();
            });
		$tab = $dept_col->add('Tabs');
		if($selected_department->isProductionPhase()){
			$tab->addTabURL('xHR_page_owner_department_basic','Basic');
		}

			$tab->addTabURL('xHR_page_owner_department_post','Posts');
			$tab->addTabURL('xHR_page_owner_department_salarytemplate','Salary Structure');
			$tab->addTabURL('xHR_page_owner_department_departmentemail','Department Emails');
			if($selected_department->isProductionPhase())
				$tab->addTabURL('xHR_page_owner_department_outsource','Out Source');
		}else{
			$dept_col->add('View_Warning')->set('Select any one Department');
		}

	}
}