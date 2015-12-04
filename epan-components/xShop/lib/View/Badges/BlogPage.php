<?php

namespace xShop;

class View_Badges_BlogPage extends \View_BadgeGroup{
	
	function init(){
		parent::init();

		$app = $this->add('xShop/Model_BlogApplication');
		$application_id = $app->id;

		$item_model = $this->add('xShop/Model_Blog');

		$this->add('View_Badge')->set(' Total Blog ')->setCount($item_model->getItemCount($application_id))->setCountSwatch('ink');
		$publish = $item_model->getPublishCount($application_id)->getOne();
		if($publish)
			$this->add('View_Badge')->set(' Publish Blog ')->setCount($publish)->setCountSwatch('green');
		
		$unactive = $this->add('xShop/Model_Blog')->getUnpublishCount($application_id)->getOne();
		if($unactive)
			$this->add('View_Badge')->set(' Unpublish Blog ')->setCount($unactive)->setCountSwatch('red');
	}
}