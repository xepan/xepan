<?php

namespace xShop;

class View_Order extends \View{
	function init(){
		parent::init();

		// $this->add('View_Info')->set('Order');
	}  

	function setModel($model){
		$application_id=$this->api->recall('xshop_application_id');
		
		$order_detail = $this->add('xShop/Model_OrderDetails')->addCondition('order_id',$model->id);
		$view=$this->add('xShop/View_OrderDetail',null,'order_detail');
		$view->setModel($order_detail);
		

		parent::setModel($model);
		$approved_activity = $this->model->searchActivity('approved');
		if(!$approved_activity instanceof \Dummy)
			$this->template->trySet('approved_date', $approved_activity['created_at'] . ' by '. $approved_activity['action_from']);
		$this->template->trySet('created_by_x',$this->model->ref('created_by_id')->get('name_with_designation') . ' on ' .$this->model['created_at']);
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		
		return array('view/xShop-Order');
	}
	
}
