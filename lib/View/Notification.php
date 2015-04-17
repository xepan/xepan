<?php

class View_Notification extends View {
	public $update_seen_till=false;
	function init(){
		parent::init();
		
		//Update Employee SeenTill
		if($this->update_seen_till == '1'){
			$this->api->current_employee['seen_till'] = $this->add('xCRM\Model_Activity')->setOrder('id desc')->tryLoadAny()->get('id');
			$this->api->current_employee->save();
		}

		if($_GET[$this->name]=='true'){

			$lookup_array=array(
					"xShop\\\\Order_Draft"=>array('xshop_orders','draft','xShop\Model_Order'),
					"xShop\\\\Order_Submitted"=>array('xshop_orders','submitted','xShop\Model_Order'),
					"xShop\\\\Order_Approved"=>array('xshop_orders','approved','xShop\Model_Order'),
				);

			$current_lastseen = $this->add('xCRM\Model_Activity');

			$current_lastseen->addExpression('count')->set(function($m,$q){
				return $m->add('Model_MyLastSeen')
					->addCondition('related_root_document_name',$q->getField('related_root_document_name'))
					->addCondition('seen_till','<=',$q->getField('created_at'))
					->count();
			});

			$current_lastseen->_dsql()->group('related_document_name');
			$current_lastseen->_dsql()->having('count','>',0);

			echo json_encode($current_lastseen->getRows());
			exit;
		}
	}

	function render(){
		if($_GET[$this->name]!='true'){
			$this->js(true)->_load('xnotifier')->xnotifier(array('url'=>$this->api->url(null)));
		}
		parent::render();
	}
}