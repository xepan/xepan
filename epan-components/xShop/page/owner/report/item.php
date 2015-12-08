<?PHP

class page_xShop_page_owner_report_item extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		
		$item=$this->add('xShop/Model_Item');
		$designer=$this->add('xShop/Model_MemberDetails');

		$form=$this->add('Form');
		$form->addField('autocomplete/Basic','designer')->setModel($designer);
		$form->addField('autocomplete/Basic','category')->setModel('xShop/Category');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Report');

		$grid=$this->add('xShop/Grid_Item');


		if($_GET['filter']){
			$this->app->stickyGET('filter');
			$this->app->stickyGET('designer');
			$this->app->stickyGET('category');
			$this->app->stickyGET('from_date');
			$this->app->stickyGET('to_date');
			if($_GET['from_date']){
				$item->addCondition('created_at','>',$_GET['from_date']);
			}
			if($_GET['to_date']){
				$item->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
			if($_GET['designer']){
				$item->addCondition('designer_id',$_GET['designer']);
			}
			if($_GET['category']){
				$item_j=$item->join('xshop_category_item.item_id');
				$cat_id=$item_j->addField('category_id');
				$item->addCondition($cat_id,$_GET['category']);
			}

		}else{
			$item->addCondition('id',-1);
		}

		$grid->setModel($item,array('designer','name','sku','is_publish',
									'is_party_publish','short_description',
									'created_at','is_saleable',
									'is_downloadable','is_template',
									'new','feature',
									'latest','mostviewed','is_visible_sold',
									));
		$grid->addPaginator(50);
		$grid->addSno();
		
		// if($grid->hasColumn('Details'))$grid->removeColumn('Details');
		if($grid->hasColumn('duplicate'))$grid->removeColumn('duplicate');
		// if($grid->hasColumn('price'))$grid->removeColumn('price');

		if($form->isSubmitted()){

			$grid->js()->reload(array('designer'=>$form['designer'],
									  'category'=>$form['category'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1)
								)->execute();
		}

	}
}