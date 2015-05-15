<?php
namespace xShop;
class Grid_AffiliateType extends \Grid{
	function init(){
		parent::init();
	}

	function setModel($model,$fields){
		
		$m=parent::setModel($model,$fields);

		if(!$fields)
			$fields = $this->model->getActualFields();

		$this->addQuickSearch($fields,null);
		$this->addPaginator(50);
		$this->add_sno();

		return $m;

	}

}