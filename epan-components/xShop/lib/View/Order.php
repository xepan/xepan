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
