<?php
class page_xHR_page_owner_employees extends page_xProduction_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Employee';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Employee Management <small> Manage companies employees </small>');

		$l=$this->add('splitter/LayoutContainer');
		$emp_col = $l->getPane('center');
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
		,	'initClosed'=>				false
		//	add 'bounce' option to default 'slide' effect
		,	'fxSettings_open'=>		array('easing'=> "easeOutBounce" )


			)
			);

		//Department
		$emp_model=$this->add('xHR/Model_Employee');
		$emp_crud = $cat_col->add('CRUD');
		$emp_crud->setModel($emp_model,array('name'));

		if(!$emp_crud->isEditing()){
			$emp_crud->grid->addMethod('format_name',function($g,$f)use($emp_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$emp_col->js()->reload(array('employee_id'=>$g->model->id)).'">'.$g->current_row[$f].'</a>';
			});
			$emp_crud->grid->addFormatter('name','name');
		}

		$emp_crud->grid->addQuickSearch(array('name'));
		$emp_crud->grid->addPaginator($ipp=50);


		// $emp_col->add('xShop/View_Badges_ItemPage');
		if($_GET['employee_id']){
			$this->api->stickyGET('employee_id');
			$filter_box = $emp_col->add('View_Box')->setHTML('Employee :: '.$this->add('xHR/Model_Employee')->load($_GET['employee_id'])->get('name'));
			$filter_box->add('Icon',null,'Button')
            ->addComponents(array('size'=>'mega'))
            ->set('cancel-1')
            ->addStyle(array('cursor'=>'pointer'))
            ->on('click',function($js) use($filter_box,$emp_col) {
                $filter_box->api->stickyForget('employee_id');
                return $filter_box->js(null,$emp_col->js()->reload())->hide()->execute();
            });
		$tab = $emp_col->add('Tabs');
			$tab->addTabURL('xHR_page_owner_employee_basic','Basic',array('employee_id'));
			$tab->addTabURL('xHR_page_owner_employee_qualification','Qualification',array('employee_id'));
			$tab->addTabURL('xHR_page_owner_employee_media','Media',array('employee_id'));
			$tab->addTabURL('xHR_page_owner_employee_workexperience','Work Experience',array('employee_id'));
			$tab->addTabURL('xHR_page_owner_employee_department','Department',array('employee_id'));
			// $tab->addTabURL('xHR_page_owner_employee_post','Post',array('employee_id'));
			$tab->addTabURL('xHR_page_owner_employee_account','User Account',array('employee_id'));
		}else{
			$emp_col->add('View_Warning')->set('Select any one Employees');
		}	
	}
}