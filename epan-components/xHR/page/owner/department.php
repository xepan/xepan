<?php
class page_xHR_page_owner_department extends page_xHR_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Departments/Posts/ACL';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Company Departments <small> Departments, Post, ACL, Salary Templates etc</small>');
		$this->add('PageHint')->set('1. Open Left Panel 2. Create Production Phases (Departments)');

		$l=$this->api->layout->add('splitter/LayoutContainer');
		$dept_col = $l->getPane('center');
		$cat_col = $l->addPane('west',
			array(
				'size'=>					250
		,	'spacing_closed'=>			21			// wider space when closed
		,	'togglerLength_closed'=>	21			// make toggler 'square' - 21x21
		,	'togglerAlign_closed'=>	"top"		// align to top of resizer
		,	'togglerLength_open'=>		10			// NONE - using custom togglers INSIDE west-pane
		,	'togglerTip_open'=>		"Close West Pane"
		,	'togglerTip_closed'=>		"Open West Pane"
		,	'resizerTip_open'=>		"Resize West Pane"
		,	'slideTrigger_open'=>		"click" 	// default
		,	'initClosed'=>				true
		//	add 'bounce' option to default 'slide' effect
		,	'fxSettings_open'=>		array('easing'=> "easeOutBounce" )


			)
			);

		//Department
		$dept_model=$this->add('xHR/Model_Department');
		$dept_model->_dsql()->order('production_level','desc');
		$dept_crud = $cat_col->add('CRUD',array('allow_edit'=>false));
		$dept_crud->setModel($dept_model,array('name','production_level'),array('name','is_production_department'));

		if(!$dept_crud->isEditing()){
			$dept_crud->grid->addMethod('format_name',function($g,$f)use($dept_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$dept_col->js()->reload(array('hr_department_id'=>$g->model->id)).'">'.$g->current_row[$f].'</a>';

			});
			$dept_crud->grid->addFormatter('name','name');
			
			$dept_crud->grid->addMethod('format_mydelete',function($g,$f){
				if(!$g->model['is_production_department'])
					$g->current_row_html[$f]='';
			});

			$dept_crud->grid->addFormatter('delete','mydelete');
			$dept_crud->grid->removeColumn('is_production_department');
		}


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
			// $tab->addTabURL('xHR_page_owner_department_attributes','Attributes');
		}

			$tab->addTabURL('xHR_page_owner_department_post','Posts');
			$tab->addTabURL('xHR_page_owner_department_salarytemplate','Salary Structure');
			if($selected_department->isProductionPhase())
				$tab->addTabURL('xHR_page_owner_department_outsource','Out Source');
		}else{
			$dept_col->add('View_Warning')->set('Select any one Department');
		}	
	}
}