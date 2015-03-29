<?php

namespace xShop;

class View_Order extends \View{

	public $show_price = true;
	public $order=null;

	function init(){
		parent::init();

		if($this->order)
			$this->setModel($this->order);
	}

	function setModel($model){
		
		$application_id=$this->api->recall('xshop_application_id');
		$order_detail = $this->add('xShop/Model_OrderDetails')->addCondition('order_id',$model->id);
		
		$view=$this->add('xShop/View_OrderDetail',array('show_price'=>$this->show_price),'order_detail');
		$view->setModel($order_detail);
		
		$m = parent::setModel($model);

		$this->template->set('delivery_date',$model['delivery_date']);
		$this->template->set('priority',$model['priority']);
		$approved_activity = $this->model->searchActivity('approved');
		
		
		if(!$approved_activity instanceof \Dummy)
			$this->template->trySet('approved_date', $approved_activity['created_at'] . ' by '. $approved_activity['action_from']);
		
		$this->template->trySet('created_by_x',$this->model->ref('created_by_id')->get('name_with_designation') . ' on ' .$this->model['created_at']);
		
		if(!$this->model['termsandcondition_id'])
			$this->template->del('tandc_section');
		else
			$this->template->trySetHTML('termsandcondition_matter',$this->model->ref('termsandcondition_id')->get('terms_and_condition'));
		return $m;
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
