<?php

class page_xProduction_page_owner_config extends page_xProduction_page_owner_main{
	function init(){
		parent::init();
		// $tabs=$this->app->layout->add('Tabs');
		// $pro_dept=$tabs->addTab('Department');
		// $crud=$pro_dept->add('CRUD');
		// $crud->setModel('xProduction/Model_Department');

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
		$dept_model=$this->add('xProduction/Model_Department');
		$dept_crud = $cat_col->add('CRUD');
		$dept_crud->setModel($dept_model,array('name'));

		if(!$dept_crud->isEditing()){
			$dept_crud->grid->addMethod('format_name',function($g,$f)use($dept_col){
				$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$dept_col->js()->reload(array('department_id'=>$g->model->id)).'">'.$g->current_row[$f].'</a>';
			});
			$dept_crud->grid->addFormatter('name','name');
		}

		// $dept_col->add('xShop/View_Badges_ItemPage');
		if($_GET['department_id']){
			$this->api->stickyGET('department_id');
			$filter_box = $dept_col->add('View_Box')->setHTML('Department :: '.$this->add('xProduction/Model_Department')->load($_GET['department_id'])->get('name'));
			$filter_box->add('Icon',null,'Button')
            ->addComponents(array('size'=>'mega'))
            ->set('cancel-1')
            ->addStyle(array('cursor'=>'pointer'))
            ->on('click',function($js) use($filter_box,$dept_col) {
                $filter_box->api->stickyForget('department_id');
                return $filter_box->js(null,$dept_col->js()->reload())->hide()->execute();
            });

		$tab = $dept_col->add('Tabs');
			$tab->addTabURL('xProduction_page_owner_department_basic','Basic',array('department_id'));
			$tab->addTabURL('xProduction_page_owner_department_attributes','Attributes',array('department_id'));
			// $tab->addTabURL('xShop/page/owner/item_qtyandprice','Qty & Price',array('item_id'));
			// $tab->addTabURL('xShop/page/owner/item_media','Media',array('item_id'));
			// $tab->addTabURL('xShop/page/owner/item_category','Category',array('item_id'));
			// $tab->addTabURL('xShop/page/owner/item_affliate','Affiliate',array('item_id'));
			// $tab->addTabURL('xShop/page/owner/item_preview','Preview',array('item_id'));
			// $tab->addTabURL('xShop/page/owner/item_seo','SEO',array('item_id'));
			// $tab->addTabURL('xShop/page/owner/item_stock','Stock',array('item_id'));
			// $tab->addTabURL('xShop/page/owner/item_department','Deaprtment',array('item_id'));
		}else{
			$dept_col->add('View_Warning')->set('Select any one Department');
		}	

	}
}